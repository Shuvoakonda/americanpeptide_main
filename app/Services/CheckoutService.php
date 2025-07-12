<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\User;
use App\Models\Coupon;
use App\Facades\Cart;
use App\Services\OrderEmailService;
use App\Services\PayPalService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;
use Carbon\Carbon;

class CheckoutService
{
    protected $stripe;
    protected $paypalService;

    public function __construct()
    {
        // Initialize payment gateways
        $this->initializePaymentGateways();
    }

    /**
     * Initialize payment gateways
     */
    protected function initializePaymentGateways()
    {
        // Stripe initialization
        if (config('services.stripe.secret_key')) {
            $this->stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        }

        // PayPal initialization
        $this->paypalService = new PayPalService();
    }

    /**
     * Process complete checkout
     * 
     * @param array $checkoutData
     * @param string $paymentMethod
     * @return array
     */
    public function processCheckout($checkoutData, $paymentMethod = 'stripe')
    {
        try {
            DB::beginTransaction();

            // 1. Validate cart and checkout data
            $validation = $this->validateCheckout($checkoutData);
            if (!$validation['valid']) {
                return $validation;
            }

            // 2. Create order
            $order = $this->createOrder($checkoutData);

            // 3. Process payment
            $paymentResult = $this->processPayment($order, $checkoutData, $paymentMethod);
            if (!$paymentResult['success']) {
                DB::rollBack();
                return $paymentResult;
            }

            // 4. Update order with payment info
            if ($paymentMethod === 'stripe' && $paymentResult['success']) {
                $this->updateOrderPaymentInfo($order, [
                    'payment_id' => $paymentResult['payment_id'] ?? null,
                    'payment_status' => Order::PAYMENT_PAID
                ]);
            } elseif (isset($paymentResult['redirect_required']) && $paymentResult['redirect_required']) {
                $this->updateOrderPaymentInfo($order, $paymentResult);
            }

            // 5. Clear cart (only if not PayPal redirect)
            if (!isset($paymentResult['redirect_required']) || !$paymentResult['redirect_required']) {
                Cart::clear();
                // 6. Send confirmation emails
                $this->sendConfirmationEmails($order);
            }

            DB::commit();

            

            return [
                'success' => true,
                'order_id' => $order->id,
                'redirect_required' => $paymentResult['redirect_required'] ?? false,
                'redirect_url' => $paymentResult['approval_url'] ?? null,
                'order_number' => 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                'payment_id' => $paymentResult['payment_id'] ?? null,
                'message' => 'Order placed successfully!'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage(), [
                'user_id' => Auth::check() ? Auth::id() : null,
                'checkout_data' => $checkoutData,
                'payment_method' => $paymentMethod
            ]);

            return [
                'success' => false,
                'message' => 'Checkout failed. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ];
        }
    }

    /**
     * Validate checkout data and cart
     * 
     * @param array $checkoutData
     * @return array
     */
    protected function validateCheckout($checkoutData)
    {
        // Check if cart has items
        if (!Cart::hasItems()) {
            return [
                'valid' => false,
                'message' => 'Your cart is empty.'
            ];
        }

        // Validate required fields
        $requiredFields = [
            'billing_address' => ['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'state', 'zip', 'country'],
            'shipping_address' => ['first_name', 'last_name', 'address', 'city', 'state', 'zip', 'country']
        ];

        foreach ($requiredFields as $section => $fields) {
            if (!isset($checkoutData[$section])) {
                return [
                    'valid' => false,
                    'message' => ucfirst($section) . ' information is required.'
                ];
            }

            foreach ($fields as $field) {
                if (empty($checkoutData[$section][$field])) {
                    return [
                        'valid' => false,
                        'message' => ucfirst($field) . ' is required in ' . str_replace('_', ' ', $section) . '.'
                    ];
                }
            }
        }

        // Validate email format
        if (!filter_var($checkoutData['billing_address']['email'], FILTER_VALIDATE_EMAIL)) {
            return [
                'valid' => false,
                'message' => 'Please enter a valid email address.'
            ];
        }

        // Check stock availability
        $stockCheck = $this->checkStockAvailability();
        if (!$stockCheck['available']) {
            return [
                'valid' => false,
                'message' => $stockCheck['message']
            ];
        }

        // Validate coupon if provided
        if (!empty($checkoutData['coupon_code'])) {
            $couponValidation = $this->validateCoupon($checkoutData['coupon_code']);
            if (!$couponValidation['valid']) {
                return $couponValidation;
            }
        }

        return ['valid' => true];
    }

    /**
     * Check stock availability for all cart items
     * 
     * @return array
     */
    protected function checkStockAvailability()
    {
        $items = Cart::getItems();
        
        // Debug logging to see cart structure
        Log::info('Cart items structure:', [
            'items_count' => count($items),
            'items' => $items,
            'cart_summary' => Cart::getSummary()
        ]);

        foreach ($items as $item) {
            $product = \App\Models\Product::find($item['product_id']);

            if (!$product) {
                return [
                    'available' => false,
                    'message' => 'Product not found: ' . ($item['product_name'] ?? 'Unknown Product')
                ];
            }

            // Check stock for products with variants
            // Check for variant_info or variant key
            $variantInfo = $item['variant_info'] ?? $item['variant'] ?? null;
            
            if ($product->has_variants && !empty($variantInfo)) {
                $variantStockCheck = $this->checkVariantStockAvailability($product, $variantInfo, $item['quantity']);
                if (!$variantStockCheck['available']) {
                    return [
                        'available' => false,
                        'message' => $variantStockCheck['message']
                    ];
                }
            } else {
                // Check main product stock
                if ($product->track_quantity && $product->stock < $item['quantity']) {
                    return [
                        'available' => false,
                        'message' => 'Insufficient stock for ' . ($item['product_name'] ?? $product->name) . '. Available: ' . $product->stock
                    ];
                }
            }
        }

        return ['available' => true];
    }

    /**
     * Check stock availability for product variants
     * 
     * @param Product $product
     * @param array $variantInfo
     * @param int $quantity
     * @return array
     */
    protected function checkVariantStockAvailability($product, $variantInfo, $quantity)
    {
        if (empty($product->variants) || !is_array($product->variants)) {
            return [
                'available' => false,
                'message' => 'Product variant not found: ' . $product->name
            ];
        }

        foreach ($product->variants as $variant) {
            if ($this->variantMatches($variant, $variantInfo)) {
                $availableStock = $variant['stock'] ?? 0;

                if ($availableStock < $quantity) {
                    return [
                        'available' => false,
                        'message' => 'Insufficient stock for ' . $product->name . ' variant. Available: ' . $availableStock
                    ];
                }

                return ['available' => true];
            }
        }

        return [
            'available' => false,
            'message' => 'Product variant not found: ' . $product->name
        ];
    }

    /**
     * Validate coupon code
     * 
     * @param string $couponCode
     * @return array
     */
    protected function validateCoupon($couponCode)
    {
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', Carbon::now());
            })
            ->where(function ($query) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', Carbon::now());
            })
            ->first();

        if (!$coupon) {
            return [
                'valid' => false,
                'message' => 'Invalid or expired coupon code.'
            ];
        }

        // Check usage limits
        if ($coupon->max_uses && $coupon->used >= $coupon->max_uses) {
            return [
                'valid' => false,
                'message' => 'Coupon usage limit exceeded.'
            ];
        }

        // Check minimum order amount
        if ($coupon->min_order && Cart::getSubtotal() < $coupon->min_order) {
            return [
                'valid' => false,
                'message' => 'Minimum order amount of $' . number_format($coupon->min_order, 2) . ' required for this coupon.'
            ];
        }

        return [
            'valid' => true,
            'coupon' => $coupon
        ];
    }

    /**
     * Create order from checkout data
     * 
     * @param array $checkoutData
     * @return Order
     */
    protected function createOrder($checkoutData)
    {
        $cart = Cart::getSummary();

        // Prepare addresses
        $billingAddress = [
            'first_name' => $checkoutData['billing_address']['first_name'],
            'last_name' => $checkoutData['billing_address']['last_name'],
            'email' => $checkoutData['billing_address']['email'],
            'phone' => $checkoutData['billing_address']['phone'],
            'address' => $checkoutData['billing_address']['address'],
            'city' => $checkoutData['billing_address']['city'],
            'state' => $checkoutData['billing_address']['state'],
            'zip' => $checkoutData['billing_address']['zip'],
            'country' => $checkoutData['billing_address']['country']
        ];

        $shippingAddress = [
            'first_name' => $checkoutData['shipping_address']['first_name'],
            'last_name' => $checkoutData['shipping_address']['last_name'],
            'address' => $checkoutData['shipping_address']['address'],
            'city' => $checkoutData['shipping_address']['city'],
            'state' => $checkoutData['shipping_address']['state'],
            'zip' => $checkoutData['shipping_address']['zip'],
            'country' => $checkoutData['shipping_address']['country']
        ];

        // Get coupon information
        $coupon = Cart::getCoupon();
        $couponId = null;
        $couponCode = null;

        if ($coupon) {
            // Handle both model instance and array
            if (is_object($coupon)) {
                $couponId = $coupon->id;
                $couponCode = $coupon->code;
            } else {
                // If it's an array (from database JSON), get the coupon from database
                $couponCode = $coupon['code'] ?? null;
                if ($couponCode) {
                    $couponModel = \App\Models\Coupon::where('code', $couponCode)->first();
                    $couponId = $couponModel ? $couponModel->id : null;
                }
            }
        }

        // Create order
        $order = Order::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'status' => 'pending',
            'payment_method' => $checkoutData['payment_method'] ?? 'stripe',
            'payment_status' => 'pending',
            'subtotal' => $cart['subtotal'],
            'tax_amount' => $cart['tax'],
            'shipping_amount' => $cart['shipping'],
            'discount_amount' => $cart['discount'],
            'total' => $cart['total'],
            'currency' => 'USD',
            'shipping_address' => $shippingAddress,
            'billing_address' => $billingAddress,
            'notes' => $checkoutData['notes'] ?? null,
            'shipping_method' => null, // Will be set by admin
            'tracking' => null, // Will be set by admin
            'coupon_id' => $couponId,
            'coupon_code' => $couponCode,
        ]);

        // Create order lines
        $this->createOrderLines($order, $cart['items']);

        // Create order discount if coupon is applied
        if ($cart['discount'] > 0) {
            $this->createOrderDiscount($order, $cart['discount'], $couponCode);
        }

        return $order;
    }

    /**
     * Create order lines from cart items
     * 
     * @param Order $order
     * @param array $items
     */
    protected function createOrderLines($order, $items)
    {
        foreach ($items as $item) {
            // Handle variant info - check for both variant_info and variant keys
            $variantInfo = $item['variant_info'] ?? $item['variant'] ?? null;
            
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'sku' => $item['sku'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
                'variant_info' => $variantInfo,
                'notes' => $item['notes'] ?? null,
            ]);

            // Reduce product quantity if tracking is enabled
            $this->reduceProductQuantity($item);
        }
    }

    /**
     * Reduce product quantity after order creation
     * 
     * @param array $item
     */
    protected function reduceProductQuantity($item)
    {
        $product = \App\Models\Product::find($item['product_id']);

        if (!$product) {
            Log::warning('Product not found when reducing quantity', ['product_id' => $item['product_id']]);
            return;
        }

        // Only reduce quantity if tracking is enabled
        if (!$product->track_quantity) {
            return;
        }

        $quantityToReduce = $item['quantity'];

        // If product has variants and variant info is provided
        $variantInfo = $item['variant_info'] ?? $item['variant'] ?? null;
        if ($product->has_variants && !empty($variantInfo)) {
            $this->reduceVariantQuantity($product, $variantInfo, $quantityToReduce);
        } else {
            // Reduce main product stock
            $this->reduceMainProductQuantity($product, $quantityToReduce);
        }
    }

    /**
     * Reduce quantity for product variants
     * 
     * @param Product $product
     * @param array $variantInfo
     * @param int $quantity
     */
    protected function reduceVariantQuantity($product, $variantInfo, $quantity)
    {
        if (empty($product->variants) || !is_array($product->variants)) {
            Log::warning('Product has variants but no variant data found', ['product_id' => $product->id]);
            return;
        }

        // Get the variants array and work with a copy
        $variants = $product->variants;
        $variantFound = false;

        // Find the specific variant and reduce its quantity
        Log::info('Looking for variant match:', [
            'product_id' => $product->id,
            'variant_info' => $variantInfo,
            'available_variants' => $variants
        ]);
        
        foreach ($variants as $index => $variant) {
            $matches = $this->variantMatches($variant, $variantInfo);
            Log::info('Variant match check:', [
                'variant' => $variant,
                'variant_info' => $variantInfo,
                'matches' => $matches
            ]);
            
            if ($matches) {
                $currentStock = $variant['stock'] ?? 0;
                $newStock = max(0, $currentStock - $quantity);

                // Update the variant stock in our copy
                $variants[$index]['stock'] = $newStock;
                $variantFound = true;

                Log::info('Reduced variant quantity', [
                    'product_id' => $product->id,
                    'variant_info' => $variantInfo,
                    'quantity_reduced' => $quantity,
                    'new_stock' => $newStock
                ]);
                break;
            }
        }

        if ($variantFound) {
            // Update the product with the modified variants array
            $product->update(['variants' => $variants]);
        } else {
            Log::warning('Variant not found when reducing quantity', [
                'product_id' => $product->id,
                'variant_info' => $variantInfo
            ]);
        }
    }

    /**
     * Reduce quantity for main product (no variants)
     * 
     * @param Product $product
     * @param int $quantity
     */
    protected function reduceMainProductQuantity($product, $quantity)
    {
        $currentStock = $product->stock ?? 0;
        $newStock = max(0, $currentStock - $quantity);

        $product->update(['stock' => $newStock]);

        Log::info('Reduced main product quantity', [
            'product_id' => $product->id,
            'quantity_reduced' => $quantity,
            'new_stock' => $newStock
        ]);
    }

    /**
     * Check if variant matches the ordered variant info
     * 
     * @param array $variant
     * @param array $variantInfo
     * @return bool
     */
    protected function variantMatches($variant, $variantInfo)
    {
        // Ensure both are arrays
        if (!is_array($variant) || !is_array($variantInfo)) {
            return false;
        }

        // Check if SKU matches (most reliable identifier)
        if (isset($variantInfo['sku']) && isset($variant['sku'])) {
            return $variant['sku'] === $variantInfo['sku'];
        }

        // Check if variant ID matches (if provided)
        if (isset($variantInfo['variant_id']) && isset($variant['id'])) {
            return $variant['id'] == $variantInfo['variant_id'];
        }

        // Check if all variant options match
        if (isset($variant['options']) && isset($variantInfo['options'])) {
            foreach ($variantInfo['options'] as $optionName => $optionValue) {
                if (
                    !isset($variant['options'][$optionName]) ||
                    $variant['options'][$optionName] !== $optionValue
                ) {
                    return false;
                }
            }
            return true; // All options matched
        }

        // Check if attributes match (for backward compatibility)
        if (isset($variant['attributes']) && isset($variantInfo['attributes'])) {
            foreach ($variantInfo['attributes'] as $attrName => $attrValue) {
                if (
                    !isset($variant['attributes'][$attrName]) ||
                    $variant['attributes'][$attrName] !== $attrValue
                ) {
                    return false;
                }
            }
            return true; // All attributes matched
        }

        // If variantInfo has attributes but variant has options, try to match
        if (isset($variantInfo['attributes']) && isset($variant['options'])) {
            foreach ($variantInfo['attributes'] as $attrName => $attrValue) {
                if (
                    !isset($variant['options'][$attrName]) ||
                    $variant['options'][$attrName] !== $attrValue
                ) {
                    return false;
                }
            }
            return true; // All attributes matched with options
        }

        return false;
    }

    /**
     * Create order discount record
     * 
     * @param Order $order
     * @param float $amount
     * @param string|null $couponCode
     */
    protected function createOrderDiscount($order, $amount, $couponCode = null)
    {
        \App\Models\OrderDiscount::create([
            'order_id' => $order->id,
            'amount' => $amount,
            'type' => 'coupon',
            'reason' => $couponCode ? "Coupon: {$couponCode}" : 'Discount applied',
            'applied_by' => Auth::check() ? Auth::id() : null,
        ]);

        // Increment coupon usage count if coupon was used
        if ($couponCode) {
            $this->incrementCouponUsage($couponCode);
        }
    }

    /**
     * Increment coupon usage count
     * 
     * @param string $couponCode
     */
    protected function incrementCouponUsage($couponCode)
    {
        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon) {
            $coupon->increment('used');

            Log::info('Coupon usage incremented', [
                'coupon_code' => $couponCode,
                'new_usage_count' => $coupon->fresh()->used
            ]);
        } else {
            Log::warning('Coupon not found when incrementing usage', [
                'coupon_code' => $couponCode
            ]);
        }
    }

    /**
     * Generate unique order number
     * 
     * @return string
     */
    protected function generateOrderNumber()
    {
        // Use the order ID as the order number since we don't have order_number field
        return 'ORD-' . str_pad(Order::max('id') + 1, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Process payment
     * 
     * @param Order $order
     * @param array $checkoutData
     * @param string $paymentMethod
     * @return array
     */
    protected function processPayment($order, $checkoutData, $paymentMethod)
    {
        switch ($paymentMethod) {
            case 'stripe':
                return $this->processStripePayment($order, $checkoutData);

            case 'paypal':
                return $this->processPayPalPayment($order, $checkoutData);

            default:
                return [
                    'success' => false,
                    'message' => 'Unsupported payment method.'
                ];
        }
    }

    /**
     * Process Stripe payment
     * 
     * @param Order $order
     * @param array $checkoutData
     * @return array
     */
    protected function processStripePayment($order, $checkoutData)
    {
        try {
            if (!$this->stripe) {
                return [
                    'success' => false,
                    'message' => 'Stripe is not configured.'
                ];
            }

            // Create payment intent
            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => (int)($order->total * 100), // Convert to cents
                'currency' => 'usd',
                'payment_method' => $checkoutData['payment_token'], // This is now a PaymentMethod ID
                'payment_method_types' => ['card'], // Only allow card payments
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('checkout.confirmation', $order->id), // Fallback return URL
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                    'customer_email' => $checkoutData['billing_address']['email']
                ]
            ]);

            if ($paymentIntent->status === 'succeeded') {
                return [
                    'success' => true,
                    'payment_id' => $paymentIntent->id,
                    'payment_status' => 'succeeded'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Payment failed: ' . $paymentIntent->last_payment_error?->message ?? 'Unknown error'
                ];
            }
        } catch (\Stripe\Exception\CardException $e) {
            return [
                'success' => false,
                'message' => 'Card error: ' . $e->getMessage()
            ];
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return [
                'success' => false,
                'message' => 'Invalid request: ' . $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Payment processing failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process PayPal payment
     * 
     * @param Order $order
     * @param array $checkoutData
     * @return array
     */
    protected function processPayPalPayment($order, $checkoutData)
    {
        try {
            if (!$this->paypalService || !$this->paypalService->isConfigured()) {
                return [
                    'success' => false,
                    'message' => 'PayPal is not configured.'
                ];
            }

            // Prepare order data for PayPal
            $orderData = [
                'total' => $order->total,
                'order_id' => $order->id,
                'order_number' => 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT)
            ];

            // Create PayPal payment
            $result = $this->paypalService->createPayment($orderData);

            Log::info('PayPal payment result:', $result);

            if ($result['success']) {
                // Store PayPal payment ID in session for later execution
                // Store PayPal order ID in session for callback
                session(['paypal_order_id' => $order->id]);

                Log::info('PayPal payment created successfully, redirecting to: ' . $result['approval_url']);

                return [
                    'success' => true,
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'payment_id' => $result['payment_id'],
                    'approval_url' => $result['approval_url'],
                    'payment_status' => 'pending',
                    'redirect_required' => true
                ];
            } else {
                Log::error('PayPal payment creation failed:', $result);
                return $result;
            }
        } catch (Exception $e) {
            Log::error('PayPal payment processing failed: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'checkout_data' => $checkoutData
            ]);

            return [
                'success' => false,
                'message' => 'PayPal payment failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update order with payment information
     * 
     * @param Order $order
     * @param array $paymentResult
     */
    protected function updateOrderPaymentInfo($order, $paymentResult)
    {
        $order->update([
            'payment_intent_id' => $paymentResult['payment_id'] ?? null,
            'payment_status' => $paymentResult['payment_status'] ?? Order::PAYMENT_PAID,
            'status' => Order::STATUS_CONFIRMED
        ]);
    }

    /**
     * Send confirmation emails
     * 
     * @param Order $order
     */
    protected function sendConfirmationEmails($order)
    {
        try {
            $emailService = new OrderEmailService();
            $results = $emailService->sendNewOrderEmails($order);

            Log::info('Order confirmation emails sent', [
                'order_id' => $order->id,
                'results' => $results
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send order confirmation emails', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get checkout summary
     * 
     * @return array
     */
    public function getCheckoutSummary()
    {
        return [
            'items' => Cart::getItems(),
            'subtotal' => Cart::getSubtotal(),
            'tax' => Cart::getTax(),
            'shipping' => Cart::getShipping(),
            'discount' => Cart::getDiscount(),
            'total' => Cart::getTotal(),
            'item_count' => Cart::getItemCount(),
            'coupon' => Cart::getCoupon()
        ];
    }

    /**
     * Validate and apply coupon
     * 
     * @param string $couponCode
     * @return array
     */
    public function applyCoupon($couponCode)
    {
        $validation = $this->validateCoupon($couponCode);

        if ($validation['valid']) {
            $result = Cart::applyCoupon($couponCode);
            return [
                'success' => true,
                'message' => 'Coupon applied successfully!',
                'discount' => Cart::getDiscount(),
                'total' => Cart::getTotal()
            ];
        }

        return [
            'success' => false,
            'message' => $validation['message']
        ];
    }

    /**
     * Remove applied coupon
     * 
     * @return array
     */
    public function removeCoupon()
    {
        Cart::removeCoupon();

        return [
            'success' => true,
            'message' => 'Coupon removed.',
            'discount' => Cart::getDiscount(),
            'total' => Cart::getTotal()
        ];
    }

    /**
     * Get available shipping methods for admin
     * 
     * @return array
     */
    public function getAdminShippingMethods()
    {
        return [
            [
                'id' => 'standard',
                'name' => 'Standard Shipping',
                'price' => 5.00,
                'delivery_time' => '3-5 business days'
            ],
            [
                'id' => 'express',
                'name' => 'Express Shipping',
                'price' => 15.00,
                'delivery_time' => '1-2 business days'
            ],
            [
                'id' => 'overnight',
                'name' => 'Overnight Shipping',
                'price' => 25.00,
                'delivery_time' => 'Next business day'
            ],
            [
                'id' => 'free',
                'name' => 'Free Shipping',
                'price' => 0.00,
                'delivery_time' => '5-7 business days'
            ]
        ];
    }

    /**
     * Get available payment methods
     * 
     * @return array
     */
    public function getPaymentMethods()
    {
        $methods = [];

        if (config('services.stripe.secret_key')) {
            $methods[] = [
                'id' => 'stripe',
                'name' => 'Credit Card',
                'icon' => 'credit-card',
                'description' => 'Pay with Visa, Mastercard, American Express'
            ];
        }

        if ($this->paypalService && $this->paypalService->isConfigured()) {
            $methods[] = [
                'id' => 'paypal',
                'name' => 'PayPal',
                'icon' => 'paypal',
                'description' => 'Pay with your PayPal account'
            ];
        }

        return $methods;
    }
}
