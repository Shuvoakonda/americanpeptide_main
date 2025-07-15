@extends('frontend.layouts.app')

@section('title', 'Shopping Cart - MyShop')

@section('content')
    <div class="container text-dark p-5">
        <div class="cart-header-wrapper mb-4">
            <div class="d-flex align-items-center position-relative">
                <h2 class="mb-0 pe-4 d-flex align-items-center">
                    <span class="cart-icon me-2">
                        <!-- SVG icon same as before -->
                    </span>
                    <span class="position-relative">
                        <span class="title-text">Your Shopping Cart</span>
                        <span class="title-underline"></span>
                    </span>
                </h2>

                <div class="ms-auto step-indicator">
                    <div class="steps">
                        <div class="step active" data-step="1">
                            <div class="step-circle">1</div>
                            <div class="step-label d-none d-sm-inline">Cart</div>
                        </div>
                        <div class="step-connector"></div>
                        <div class="step" data-step="2">
                            <div class="step-circle">2</div>
                            <div class="step-label d-none d-sm-inline">Checkout</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cartItems as $item)
                                    <tr>
                                        <td data-label="Product">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item['image_url'] ?? '/assets/images/product/placeholder.png' }}"
                                                    class="img-fluid rounded-3 me-3" alt="Product">
                                                <div>
                                                    <h6 class="mb-0 text-dark">{{ $item['product_name'] }}</h6>
                                                    <p class="mb-0 text-dark">SKU: {{ $item['sku'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle price text-danger" data-label="Price">${{ number_format($item['price'], 2) }}</td>
                                        <td class="align-middle" data-label="Quantity">
                                            <div class="input-group quantity-selector">
                                                <button class="btn btn-secondary minus-btn" type="button">-</button>
                                                <input type="text" class="form-control text-dark text-center quantity-input" value="{{ $item['quantity'] }}">
                                                <button class="btn btn-secondary plus-btn" type="button">+</button>
                                            </div>
                                        </td>
                                        <td class="align-middle price" data-label="Total">${{ number_format($item['total'], 2) }}</td>
                                        <td class="align-middle" data-label="Remove">
                                            <button class="btn btn-sm btn-outline-danger remove-btn">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Your cart is empty.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between pt-2">
                            <a href="{{ route('products.index') }}" class="btn btn-light">Continue Shopping</a>
                        </div>
                    </div>
                </div>

                <!-- Coupon Code -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Discount Code</h5>
                        <p class="card-text text-dark">Apply promo code for instant savings</p>

                        <div class="coupon-container">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="couponCode" placeholder="Enter promo code">
                                <button class="btn btn-apply-coupon btn-secondary" id="applyCoupon">Apply</button>
                            </div>
                            <div id="appliedCouponArea" class="mb-2" style="display:none;">
                                <span id="appliedCouponLabel" class="badge bg-success"></span>
                                <button class="btn btn-remove-coupon" id="removeCoupon" title="Remove coupon">&times;</button>
                            </div>
                            <div id="couponMessage" class="d-none alert mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Order Summary</h5>

                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-2">
                                Subtotal
                                <span class="price">${{ number_format($subtotal, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-2">
                                Shipping
                                <span>Free</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-2 mb-3">
                                <div>
                                    <strong>Discount</strong>
                                    <small class="text-success d-none" id="discountLabel">(<span id="appliedCouponCode"></span>)</small>
                                </div>
                                <span class="text-success" id="discountAmount">${{ number_format($discount, 2) }}</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3 pt-3">
                                <div>
                                    <strong>Total</strong>
                                    <small class="text-dark d-block">Includes tax</small>
                                </div>
                                <span><strong class="price" id="totalAmount">${{ number_format($total, 2) }}</strong></span>
                            </li>
                        </ul>

                        @if(count($cartItems) > 0)
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100 mt-3" id="checkout-btn" style="background-color: #00a6e7; border-color: #00a6e7; transition: all 0.3s ease;">
                                <i class="bi bi-lock-fill me-2"></i>Proceed to Checkout
                            </a>
                        @else
                            <button class="btn btn-secondary btn-lg w-100 mt-3" disabled id="checkout-btn">
                                <i class="bi bi-lock-fill me-2"></i>Cart is Empty
                            </button>
                        @endif
                        
                        <div class="text-center mt-3">
                            <small class="text-dark">
                                <i class="bi bi-shield-check me-1"></i>Secure checkout
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3">We Accept</h6>
                        <div class="d-flex justify-content-between">
                            <img src="https://via.placeholder.com/40x25?text=Visa" alt="Visa" class="img-fluid">
                            <img src="https://via.placeholder.com/40x25?text=MC" alt="Mastercard" class="img-fluid">
                            <img src="https://via.placeholder.com/40x25?text=Amex" alt="Amex" class="img-fluid">
                            <img src="https://via.placeholder.com/40x25?text=PayPal" alt="PayPal" class="img-fluid">
                            <img src="https://via.placeholder.com/40x25?text=Apple" alt="Apple Pay" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Animation for step indicator
                const steps = document.querySelectorAll('.step');
                steps.forEach(step => {
                    step.addEventListener('mouseenter', function() {
                        if (!this.classList.contains('active')) {
                            this.querySelector('.step-circle').style.transform = 'scale(1.1)';
                        }
                    });
                    step.addEventListener('mouseleave', function() {
                        this.querySelector('.step-circle').style.transform = 'scale(1)';
                    });
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Quantity selectors (AJAX)
                document.querySelectorAll('.quantity-selector').forEach(function(selector) {
                    const minusBtn = selector.querySelector('.minus-btn');
                    const plusBtn = selector.querySelector('.plus-btn');
                    const input = selector.querySelector('.quantity-input');
                    const row = selector.closest('tr');
                    const sku = row.querySelector('p.mb-0.text-dark').textContent.replace('SKU: ', '').trim();
                    const productName = row.querySelector('h6.mb-0').textContent.trim();
                    // Find item_id by matching SKU and product name in cartItems
                    let itemId = null;
                    @foreach($cartItems as $key => $item)
                        if ('{{ $item['sku'] }}' === sku && '{{ $item['product_name'] }}' === productName) {
                            itemId = @json($key);
                        }
                    @endforeach
                    function updateQuantity(newQty) {
                        fetch("{{ route('cart.update') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({
                                item_id: itemId,
                                quantity: newQty
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                input.value = newQty;
                                row.querySelector('td.price:last-child').textContent = '$' + parseFloat(data.item_total).toFixed(2);
                                document.querySelectorAll('#cart-count').forEach(el => el.textContent = data.cart_count);
                                // Update summary
                                document.querySelector('.list-group-item:first-child span').textContent = '$' + parseFloat(data.subtotal).toFixed(2);
                                document.getElementById('discountAmount').textContent = '$' + parseFloat(data.discount).toFixed(2);
                                document.getElementById('totalAmount').textContent = '$' + parseFloat(data.total).toFixed(2);
                                showToast('Cart updated!', 'success');
                            }
                        });
                    }
                    minusBtn.addEventListener('click', function() {
                        let val = parseInt(input.value);
                        if (val > 1) {
                            updateQuantity(val - 1);
                        }
                    });
                    plusBtn.addEventListener('click', function() {
                        let val = parseInt(input.value);
                        updateQuantity(val + 1);
                    });
                });
                // Remove item (AJAX)
                document.querySelectorAll('.remove-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const row = btn.closest('tr');
                        const sku = row.querySelector('p.mb-0.text-dark').textContent.replace('SKU: ', '').trim();
                        const productName = row.querySelector('h6.mb-0').textContent.trim();
                        let itemId = null;
                        @foreach($cartItems as $key => $item)
                            if ('{{ $item['sku'] }}' === sku && '{{ $item['product_name'] }}' === productName) {
                                itemId = @json($key);
                            }
                        @endforeach
                        fetch("{{ route('cart.remove') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({
                                item_id: itemId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                row.remove();
                                document.querySelectorAll('#cart-count').forEach(el => el.textContent = data.cart_count);
                                document.querySelector('.list-group-item:first-child span').textContent = '$' + parseFloat(data.subtotal).toFixed(2);
                                document.getElementById('discountAmount').textContent = '$' + parseFloat(data.discount).toFixed(2);
                                document.getElementById('totalAmount').textContent = '$' + parseFloat(data.total).toFixed(2);
                                showToast('Item removed from cart!', 'success');
                                updateCheckoutButtonState();
                            }
                        });
                    });
                });

                // Coupon system
                const applyCouponBtn = document.getElementById('applyCoupon');
                const removeCouponBtn = document.getElementById('removeCoupon');
                const couponMessage = document.getElementById('couponMessage');
                const couponCodeInput = document.getElementById('couponCode');
                const appliedCouponArea = document.getElementById('appliedCouponArea');
                const appliedCouponLabel = document.getElementById('appliedCouponLabel');
                const appliedCouponCode = document.getElementById('appliedCouponCode');
                const discountLabel = document.getElementById('discountLabel');
                // Show applied coupon if present (server-side render)
                @if(isset($cart) && isset($cart['coupons']) && count($cart['coupons']))
                    const couponKeys = Object.keys(@json($cart['coupons']));
                    if (couponKeys.length > 0) {
                        appliedCouponArea.style.display = '';
                        appliedCouponLabel.textContent = couponKeys[0];
                        appliedCouponCode.textContent = couponKeys[0];
                        discountLabel.classList.remove('d-none');
                    }
                @endif
                if (applyCouponBtn) {
                    applyCouponBtn.addEventListener('click', function() {
                        const code = couponCodeInput.value.trim();
                        if (!code) return;
                        fetch("{{ route('cart.apply-coupon') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({ coupon_code: code })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Coupon applied!', 'success');
                                appliedCouponArea.style.display = '';
                                appliedCouponLabel.textContent = code;
                                appliedCouponCode.textContent = code;
                                discountLabel.classList.remove('d-none');
                                document.getElementById('discountAmount').textContent = '$' + parseFloat(data.discount).toFixed(2);
                                document.getElementById('totalAmount').textContent = '$' + parseFloat(data.total).toFixed(2);
                                couponMessage.classList.add('d-none');
                            } else {
                                showToast(data.message || 'Invalid coupon.', 'danger');
                                couponMessage.textContent = data.message || 'Invalid coupon.';
                                couponMessage.className = 'alert alert-danger mt-3';
                                couponMessage.classList.remove('d-none');
                            }
                        })
                        .catch(() => {
                            showToast('Failed to apply coupon.', 'danger');
                            couponMessage.textContent = 'Failed to apply coupon.';
                            couponMessage.className = 'alert alert-danger mt-3';
                            couponMessage.classList.remove('d-none');
                        });
                    });
                }
                if (removeCouponBtn) {
                    removeCouponBtn.addEventListener('click', function() {
                        fetch("{{ route('cart.remove-coupon') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Coupon removed.', 'success');
                                appliedCouponArea.style.display = 'none';
                                discountLabel.classList.add('d-none');
                                document.getElementById('discountAmount').textContent = '$' + parseFloat(data.discount).toFixed(2);
                                document.getElementById('totalAmount').textContent = '$' + parseFloat(data.total).toFixed(2);
                                couponMessage.classList.add('d-none');
                            } else {
                                showToast(data.message || 'Failed to remove coupon.', 'danger');
                                couponMessage.textContent = data.message || 'Failed to remove coupon.';
                                couponMessage.className = 'alert alert-danger mt-3';
                                couponMessage.classList.remove('d-none');
                            }
                        })
                        .catch(() => {
                            showToast('Failed to remove coupon.', 'danger');
                            couponMessage.textContent = 'Failed to remove coupon.';
                            couponMessage.className = 'alert alert-danger mt-3';
                            couponMessage.classList.remove('d-none');
                        });
                    });
                }


                function updateCartTotals() {
                    // Calculate subtotal based on items
                    let subtotal = 0;
                    document.querySelectorAll('tbody tr').forEach(row => {
                        const price = parseFloat(row.querySelector('.price').textContent.replace('$', ''));
                        const quantity = parseInt(row.querySelector('.quantity-input').value);
                        const total = price * quantity;
                        row.querySelector('td:nth-child(4)').textContent = '$' + total.toFixed(2);
                        subtotal += total;
                    });

                    // Get current discount
                    const discount = parseFloat(document.getElementById('discountAmount').textContent.replace('$',
                        '') || 0);
                    const total = subtotal - discount;

                    // Update display
                    document.querySelector('.list-group-item:first-child span').textContent = '$' + subtotal
                        .toFixed(2);
                    document.getElementById('totalAmount').textContent = '$' + total.toFixed(2);
                }

                function applyDiscount(percent) {
                    const subtotalText = document.querySelector('.list-group-item:first-child span').textContent;
                    const subtotal = parseFloat(subtotalText.replace('$', ''));
                    const discountAmount = (subtotal * percent / 100).toFixed(2);

                    document.getElementById('discountAmount').textContent = '$' + discountAmount;
                    updateCartTotals();
                }

                function removeDiscount() {
                    document.getElementById('discountAmount').textContent = '$0.00';
                    updateCartTotals();
                }

                function showToast(message, type) {
                    const container = document.getElementById('toast-container');
                    if (!container) return;
                    
                    const toast = document.createElement('div');
                    toast.className = `alert alert-${type}`;
                    toast.style.minWidth = '200px';
                    toast.style.marginBottom = '10px';
                    toast.innerHTML = message;
                    container.appendChild(toast);
                    
                    setTimeout(() => {
                        toast.classList.add('fade');
                        setTimeout(() => toast.remove(), 500);
                    }, 2500);
                }

                // Update checkout button state based on cart items
                function updateCheckoutButtonState() {
                    const cartRows = document.querySelectorAll('tbody tr');
                    const checkoutBtn = document.getElementById('checkout-btn');
                    
                    if (cartRows.length === 0 || (cartRows.length === 1 && cartRows[0].querySelector('td').colSpan === 5)) {
                        // Cart is empty
                        if (checkoutBtn) {
                            checkoutBtn.style.pointerEvents = 'none';
                            checkoutBtn.style.opacity = '0.6';
                            checkoutBtn.innerHTML = '<i class="bi bi-lock-fill me-2"></i>Cart is Empty';
                            checkoutBtn.disabled = true;
                        }
                    } else {
                        // Cart has items
                        if (checkoutBtn) {
                            checkoutBtn.style.pointerEvents = 'auto';
                            checkoutBtn.style.opacity = '1';
                            checkoutBtn.innerHTML = '<i class="bi bi-lock-fill me-2"></i>Proceed to Checkout';
                            checkoutBtn.disabled = false;
                        }
                    }
                }

                // Call update function on page load
                updateCheckoutButtonState();

                // Add click handler for checkout button
                const checkoutBtn = document.getElementById('checkout-btn');
                if (checkoutBtn) {
                    checkoutBtn.addEventListener('click', function(e) {
                        const cartRows = document.querySelectorAll('tbody tr');
                        if (cartRows.length === 0 || (cartRows.length === 1 && cartRows[0].querySelector('td').colSpan === 5)) {
                            e.preventDefault();
                            showToast('Your cart is empty. Please add items before checkout.', 'warning');
                        }
                    });

                    // Add hover effect
                    checkoutBtn.addEventListener('mouseenter', function() {
                        if (!this.disabled) {
                            this.style.backgroundColor = '#008fc7';
                            this.style.borderColor = '#008fc7';
                            this.style.transform = 'translateY(-2px)';
                        }
                    });

                    checkoutBtn.addEventListener('mouseleave', function() {
                        if (!this.disabled) {
                            this.style.backgroundColor = '#00a6e7';
                            this.style.borderColor = '#00a6e7';
                            this.style.transform = 'translateY(0)';
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
