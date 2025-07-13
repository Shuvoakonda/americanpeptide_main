@extends('frontend.layouts.app')

@section('title', 'Shopping Cart - MyShop')

@section('content')
    <div class="container p-5">
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
                            <table class="table">
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
                                    <tr>
                                        <td data-label="Product">
                                            <div class="d-flex align-items-center">
                                                <img src="/assets/images/product/ABP-7-10mg-300x300.jpg.webp"
                                                    class="img-fluid rounded-3 me-3" alt="Product">
                                                <div>
                                                    <h6 class="mb-0">Premium Leather Wallet</h6>
                                                    <p class="mb-0 text-muted">SKU: 12345</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle price" data-label="Price">$49.99</td>
                                        <td class="align-middle" data-label="Quantity">
                                            <div class="input-group quantity-selector">
                                                <button class="btn btn-outline-secondary minus-btn"
                                                    type="button">-</button>
                                                <input type="text" class="form-control text-center quantity-input"
                                                    value="1">
                                                <button class="btn btn-outline-secondary plus-btn" type="button">+</button>
                                            </div>
                                        </td>
                                        <td class="align-middle price" data-label="Total">$49.99</td>
                                        <td class="align-middle" data-label="Remove">
                                            <button class="btn btn-sm btn-outline-danger remove-btn">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td data-label="Product">
                                            <div class="d-flex align-items-center">
                                                <img src="/assets/images/product/ABP-7-10mg-300x300.jpg.webp"
                                                    class="img-fluid rounded-3 me-3" alt="Product">
                                                <div>
                                                    <h6 class="mb-0">Wireless Earbuds</h6>
                                                    <p class="mb-0 text-muted">SKU: 67890</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle price" data-label="Price">$29.99</td>
                                        <td class="align-middle" data-label="Quantity">
                                            <div class="input-group quantity-selector">
                                                <button class="btn btn-outline-secondary minus-btn"
                                                    type="button">-</button>
                                                <input type="text" class="form-control text-center quantity-input"
                                                    value="2">
                                                <button class="btn btn-outline-secondary plus-btn" type="button">+</button>
                                            </div>
                                        </td>
                                        <td class="align-middle price" data-label="Total">$59.98</td>
                                        <td class="align-middle" data-label="Remove">
                                            <button class="btn btn-sm btn-outline-danger remove-btn">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between pt-2">
                            <button class="btn btn-light">Continue Shopping</button>
                            <button class="btn btn-warning">Update Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Coupon Code -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Discount Code</h5>
                        <p class="card-text text-muted">Apply promo code for instant savings</p>

                        <div class="coupon-container">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="couponCode" placeholder="Enter promo code">
                                <button class="btn btn-primary" id="applyCoupon">Apply</button>
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
                                <span class="price">$109.97</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-2">
                                Shipping
                                <span>Free</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-2 mb-3">
                                <div>
                                    <strong>Discount</strong>
                                    <small class="text-success d-none" id="discountLabel">(SUMMER10)</small>
                                </div>
                                <span class="text-success" id="discountAmount">$0.00</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3 pt-3">
                                <div>
                                    <strong>Total</strong>
                                    <small class="text-muted d-block">Includes tax</small>
                                </div>
                                <span><strong class="price" id="totalAmount">$109.97</strong></span>
                            </li>
                        </ul>

                        <button class="btn btn-primary btn-lg w-100 mt-3" href={{ route('checkout.index') }}>
                            <i class="bi bi-lock-fill me-2"></i>Proceed to Checkout
                        </button>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
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
                // Quantity selectors
                document.querySelectorAll('.plus-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const input = this.parentNode.querySelector('.quantity-input');
                        input.value = parseInt(input.value) + 1;
                        updateCartTotals();
                    });
                });

                document.querySelectorAll('.minus-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const input = this.parentNode.querySelector('.quantity-input');
                        if (parseInt(input.value) > 1) {
                            input.value = parseInt(input.value) - 1;
                            updateCartTotals();
                        }
                    });
                });

                // Remove items
                document.querySelectorAll('.remove-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const row = this.closest('tr');
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.remove();
                            updateCartTotals();
                            showToast('Item removed from cart');
                        }, 300);
                    });
                });

                // Coupon system
                const applyCouponBtn = document.getElementById('applyCoupon');
                const couponMessage = document.getElementById('couponMessage');
                const couponOptions = document.querySelectorAll('.coupon-option');



                // Select coupon from dropdown
                couponOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        // Remove active class from all options
                        couponOptions.forEach(opt => opt.classList.remove('active'));

                        // Add active class to selected option
                        this.classList.add('active');

                        // Set coupon code in input
                        document.getElementById('couponCode').value = this.dataset.code;


                    });
                });

                // Apply coupon
                if (applyCouponBtn) {
                    applyCouponBtn.addEventListener('click', function() {
                        const couponCode = document.getElementById('couponCode').value.trim();
                        couponMessage.classList.remove('d-none');

                        // Validate coupon
                        if (couponCode) {
                            couponMessage.textContent = 'Coupon applied successfully!';
                            couponMessage.className = 'alert alert-success';
                            document.getElementById('discountLabel').classList.remove('d-none');
                        } else {
                            couponMessage.textContent =
                                'Invalid coupon code. Try one of our available coupons.';
                            couponMessage.className = 'alert alert-danger';
                            document.getElementById('discountLabel').classList.add('d-none');
                            removeDiscount();
                        }

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

                function showToast(message) {
                    // In a real app, you would use a proper toast notification
                    console.log(message);
                }
            });
        </script>
    @endpush
@endsection
