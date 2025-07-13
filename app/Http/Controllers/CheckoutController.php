<?php

namespace App\Http\Controllers;

use App\Facades\Checkout;
use App\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        // Check if cart has items
        if (!Cart::hasItems()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cart = Cart::getSummary();
        $paymentMethods = Checkout::getPaymentMethods();
        
        // Convert to simple array for view
        $paymentMethodsArray = [];
        foreach ($paymentMethods as $method) {
            $paymentMethodsArray[$method['id']] = $method['name'];
        }
        
        // Get user data if logged in
        $user = Auth::user();
        
        // If user is logged in, prepare name parts for form fields
        if ($user) {
            $nameParts = explode(' ', $user->name, 2);
            $user->first_name = $nameParts[0] ?? '';
            $user->last_name = $nameParts[1] ?? '';
        }

        return view('frontend.checkout.index', compact('cart', 'paymentMethodsArray', 'user'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {

     
        // Validate request
        $request->validate([
            'billing_address.first_name' => 'required|string|max:255',
            'billing_address.last_name' => 'required|string|max:255',
            'billing_address.email' => 'required|email',
            'billing_address.phone' => 'required|string|max:20',
            'billing_address.address' => 'required|string|max:500',
            'billing_address.city' => 'required|string|max:255',
            'billing_address.state' => 'required|string|max:255',
            'billing_address.zip' => 'required|string|max:20',
            'billing_address.country' => 'required|string|max:255',
            'shipping_address.first_name' => 'required|string|max:255',
            'shipping_address.last_name' => 'required|string|max:255',
            'shipping_address.address' => 'required|string|max:500',
            'shipping_address.city' => 'required|string|max:255',
            'shipping_address.state' => 'required|string|max:255',
            'shipping_address.zip' => 'required|string|max:20',
            'shipping_address.country' => 'required|string|max:255',
            'payment_method' => 'required|string|in:stripe,paypal',
            'payment_token' => 'required|string',
            'coupon_code' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            // Prepare checkout data
            $checkoutData = $request->all();

         
            // Process checkout
            $result = Checkout::processCheckout($checkoutData, $request->payment_method);

            // Ensure result has the expected structure
            if (!is_array($result) || !isset($result['success'])) {
                Log::error('Invalid checkout result structure', [
                    'result' => $result,
                    'user_id' => Auth::id(),
                    'request_data' => $request->all()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Checkout processing failed due to invalid response.'
                ], 500);
            }

            if ($result['success']) {
                Log::info('Checkout successful', [
                    'order_id' => $result['order_id'] ?? 'unknown',
                    'order_number' => $result['order_number'] ?? 'unknown',
                    'user_id' => Auth::id()
                ]);

                // Check if PayPal redirect is required
                if (isset($result['redirect_required']) && $result['redirect_required']) {
                    return response()->json([
                        'success' => true,
                        'order_id' => $result['order_id'] ?? null,
                        'order_number' => $result['order_number'] ?? null,
                        'message' => $result['message'] ?? 'Order placed successfully!',
                        'redirect_required' => true,
                        'redirect_url' => $result['redirect_url'] ?? null
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'order_id' => $result['order_id'] ?? null,
                    'order_number' => $result['order_number'] ?? null,
                    'message' => $result['message'] ?? 'Order placed successfully!',
                    'redirect_url' => route('checkout.confirmation', $result['order_id'] ?? 0)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Checkout failed. Please try again.'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.'
            ], 500);
        }
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);

        $result = Checkout::applyCoupon($request->coupon_code);

        // Ensure result has the expected structure
        if (!is_array($result) || !isset($result['success'])) {
            Log::error('Invalid coupon result structure', [
                'result' => $result,
                'coupon_code' => $request->coupon_code
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Coupon processing failed due to invalid response.'
            ], 500);
        }

        return response()->json($result);
    }

    /**
     * Remove applied coupon
     */
    public function removeCoupon()
    {
        $result = Checkout::removeCoupon();
        
        // Ensure result has the expected structure
        if (!is_array($result) || !isset($result['success'])) {
            Log::error('Invalid remove coupon result structure', [
                'result' => $result
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Coupon removal failed due to invalid response.'
            ], 500);
        }

        return response()->json($result);
    }

    /**
     * Get checkout summary (AJAX)
     */
    public function getSummary()
    {
        $summary = Checkout::getCheckoutSummary();
        return response()->json($summary);
    }

    /**
     * Get shipping methods (admin only)
     */
    public function getShippingMethods()
    {
        $methods = Checkout::getAdminShippingMethods();
        return response()->json($methods);
    }

    /**
     * Get payment methods
     */
    public function getPaymentMethods()
    {
        $methods = Checkout::getPaymentMethods();
        return response()->json($methods);
    }

    /**
     * Show order confirmation
     */
    public function confirmation($orderId)
    {
        $order = \App\Models\Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->with('lines')
            ->firstOrFail();

        return view('frontend.checkout.confirmation', compact('order'));
    }

    /**
     * Show order details
     */
    public function orderDetails($orderId)
    {
        $order = \App\Models\Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->with('lines.product')
            ->firstOrFail();

        return view('frontend.checkout.order-details', compact('order'));
    }

    /**
     * Download invoice
     */
    public function downloadInvoice($orderId)
    {
        $order = \App\Models\Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->with('lines.product')
            ->firstOrFail();

        // Generate PDF invoice
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('orders.print-invoice', compact('order'));
        
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }

    /**
     * Test checkout (for development)
     */
    public function testCheckout()
    {
        // Only allow in development
        if (!app()->environment('local')) {
            abort(404);
        }

        // Add test products to cart
        Cart::clear();
        Cart::add(1, 2); // Add product ID 1, quantity 2

        $testData = [
            'billing_address' => [
                'first_name' => 'Test',
                'last_name' => 'User',
                'email' => 'test@example.com',
                'phone' => '+1234567890',
                'address' => '123 Test St',
                'city' => 'Test City',
                'state' => 'TS',
                'zip' => '12345',
                'country' => 'US'
            ],
            'shipping_address' => [
                'first_name' => 'Test',
                'last_name' => 'User',
                'address' => '123 Test St',
                'city' => 'Test City',
                'state' => 'TS',
                'zip' => '12345',
                'country' => 'US'
            ],
            'payment_method' => 'stripe',
            'payment_token' => 'pm_card_visa', // Test token
            'notes' => 'Test order'
        ];

        $result = Checkout::processCheckout($testData, 'stripe');

        return response()->json($result);
    }
} 