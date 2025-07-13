@extends('frontend.layouts.app')

@section('title', 'Checkout - MyShop')

@section('content')
    <div class="container p-5" id="checkout">
        <div class="cart-header-wrapper mb-4">
            <div class="d-flex align-items-center position-relative">
                <h2 class="mb-0 pe-4 d-flex align-items-center">
                    <span class="cart-icon me-2">
                        <!-- SVG icon same as before -->
                    </span>
                    <span class="position-relative">
                        <span class="title-text">Checkout</span>
                        <span class="title-underline"></span>
                    </span>
                </h2>

                <div class="ms-auto step-indicator">
                    <div class="steps">
                        <div class="step completed" data-step="1">
                            <div class="step-circle">
                                <i class="bi bi-check"></i>
                            </div>
                            <div class="step-label d-none d-sm-inline">Cart</div>
                        </div>
                        <div class="step-connector active"></div>
                        <div class="step active" data-step="2">
                            <div class="step-circle">2</div>
                            <div class="step-label d-none d-sm-inline">Checkout</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Billing Information -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Billing Information</h5>

                        <form id="checkoutForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                                <small class="text-muted">We'll send your receipt here</small>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Street Address</label>
                                <input type="text" class="form-control" id="address" required>
                            </div>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select" id="country" required>
                                        <option value="">Choose...</option>
                                        <option>United States</option>
                                        <option>Canada</option>
                                        <option>United Kingdom</option>
                                        <option>Australia</option>
                                        <option>Germany</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="state" class="form-label">State/Province</label>
                                    <select class="form-select" id="state" required>
                                        <option value="">Choose...</option>
                                        <option>California</option>
                                        <option>New York</option>
                                        <option>Texas</option>
                                        <option>Ontario</option>
                                        <option>London</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="zip" class="form-label">ZIP/Postal Code</label>
                                    <input type="text" class="form-control" id="zip" required>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3">Payment Method</h5>

                            <div class="payment-method active" id="creditCardMethod">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" checked>
                                <label class="form-check-label" for="creditCard">
                                    Credit/Debit Card
                                </label>
                                <div class="payment-icons">
                                    <img src="https://via.placeholder.com/40x25?text=Visa" alt="Visa"
                                        class="payment-icon me-1">
                                    <img src="https://via.placeholder.com/40x25?text=MC" alt="Mastercard"
                                        class="payment-icon me-1">
                                    <img src="https://via.placeholder.com/40x25?text=Amex" alt="Amex"
                                        class="payment-icon">
                                </div>
                            </div>

                            <div class="payment-method" id="paypalMethod">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="paypal">
                                <label class="form-check-label" for="paypal">
                                    PayPal
                                </label>
                                <img src="https://via.placeholder.com/60x25?text=PayPal" alt="PayPal"
                                    class="payment-icon">
                            </div>

                            <div class="payment-method" id="bankTransferMethod">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer">
                                <label class="form-check-label" for="bankTransfer">
                                    Bank Transfer
                                </label>
                                <img src="https://via.placeholder.com/60x25?text=Bank" alt="Bank Transfer"
                                    class="payment-icon">
                            </div>

                            <div id="creditCardForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="cc-name" class="form-label">Name on Card</label>
                                        <input type="text" class="form-control" id="cc-name"
                                            placeholder="Full Name">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cc-number" class="form-label">Card Number</label>
                                        <input type="text" class="form-control" id="cc-number"
                                            placeholder="1234 5678 9012 3456">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="cc-expiration" class="form-label">Expiration Date</label>
                                        <input type="text" class="form-control" id="cc-expiration"
                                            placeholder="MM/YY">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="cc-cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cc-cvv" placeholder="123">
                                        <small class="text-muted">3 digits on back of card</small>
                                    </div>
                                    <div class="col-md-4 mb-3 d-flex align-items-end">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="saveCard">
                                            <label class="form-check-label small" for="saveCard">
                                                Save for next time
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="termsAgreement" required>
                                <label class="form-check-label" for="termsAgreement">
                                    I agree to the <a href="#" class="text-primary">Terms of Service</a> and <a
                                        href="#" class="text-primary">Privacy Policy</a>
                                </label>
                            </div>

                            <button class="btn btn-primary btn-lg w-100 py-3" type="submit">
                                <i class="bi bi-lock-fill me-2"></i>Complete Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Order Summary</h5>

                        <ul class="list-group list-group-flush mb-3">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-2">
                                <div>
                                    Premium Leather Wallet
                                    <div class="text-muted small">Qty: 1</div>
                                </div>
                                <span>$49.99</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-2">
                                <div>
                                    Wireless Earbuds
                                    <div class="text-muted small">Qty: 2</div>
                                </div>
                                <span>$59.98</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-2">
                                Shipping
                                <span>Free</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-2 mb-3">
                                <div>
                                    <strong>Discount</strong>
                                    <small class="text-success" id="checkoutDiscountLabel">(SUMMER10)</small>
                                </div>
                                <span class="text-success" id="checkoutDiscountAmount">-$10.00</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3 pt-3">
                                <div>
                                    <strong>Total</strong>
                                    <div class="text-muted small">Includes tax where applicable</div>
                                </div>
                                <span><strong class="total-amount" id="checkoutTotalAmount">$99.97</strong></span>
                            </li>
                        </ul>

                        <div class="card mb-3 border-success">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <span class="text-success">Coupon Applied</span>
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger" id="removeCoupon">Remove</button>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">SUMMER10 - 10% off your order</small>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 bg-light">
                            <div class="card-body py-3">
                                <div class="d-flex">
                                    <i class="bi bi-shield-check text-muted me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h6 class="mb-1">Secure Checkout</h6>
                                        <small class="text-muted">Your information is protected by 256-bit SSL
                                            encryption</small>
                                    </div>
                                </div>
                            </div>
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
                // Payment method selection
                const paymentMethods = document.querySelectorAll('.payment-method');

                paymentMethods.forEach(method => {
                    method.addEventListener('click', function() {
                        // Remove active class from all methods
                        paymentMethods.forEach(m => m.classList.remove('active'));

                        // Add active class to clicked method
                        this.classList.add('active');

                        // Check the corresponding radio button
                        const radio = this.querySelector('input[type="radio"]');
                        radio.checked = true;

                        // Show/hide credit card form
                        if (radio.id === 'creditCard') {
                            document.getElementById('creditCardForm').style.display = 'block';
                        } else {
                            document.getElementById('creditCardForm').style.display = 'none';
                        }
                    });
                });

                // Remove coupon
                const removeCouponBtn = document.getElementById('removeCoupon');
                if (removeCouponBtn) {
                    removeCouponBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        // In a real app, this would update the order total
                        document.getElementById('checkoutDiscountAmount').textContent = '$0.00';
                        document.getElementById('checkoutDiscountLabel').classList.add('d-none');

                        // Update total
                        const subtotal = 109.97;
                        document.getElementById('checkoutTotalAmount').textContent = '$' + subtotal.toFixed(2);

                        // Hide coupon card
                        this.closest('.card').style.display = 'none';
                    });
                }

                // Form submission
                const checkoutForm = document.getElementById('checkoutForm');
                if (checkoutForm) {
                    checkoutForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        // Validate form
                        let isValid = true;
                        const requiredFields = this.querySelectorAll('[required]');

                        requiredFields.forEach(field => {
                            if (!field.value.trim()) {
                                isValid = false;
                                field.classList.add('is-invalid');
                            } else {
                                field.classList.remove('is-invalid');
                            }
                        });

                        if (!isValid) {
                            alert('Please fill in all required fields');
                            return;
                        }

                        // Validate terms agreement
                        if (!document.getElementById('termsAgreement').checked) {
                            alert('You must agree to the terms and conditions');
                            return;
                        }

                        // In a real app, you would process the payment here
                        alert('Order placed successfully!');
                        // window.location.href = '/order-confirmation';
                    });
                }

                // Credit card input formatting
                const ccNumber = document.getElementById('cc-number');
                if (ccNumber) {
                    ccNumber.addEventListener('input', function(e) {
                        let value = this.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                        let formatted = '';

                        for (let i = 0; i < value.length; i++) {
                            if (i > 0 && i % 4 === 0) {
                                formatted += ' ';
                            }
                            formatted += value[i];
                        }

                        this.value = formatted.substring(0, 19);
                    });
                }

                // Expiration date formatting
                const ccExpiration = document.getElementById('cc-expiration');
                if (ccExpiration) {
                    ccExpiration.addEventListener('input', function(e) {
                        let value = this.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                        let formatted = '';

                        for (let i = 0; i < value.length; i++) {
                            if (i === 2) {
                                formatted += '/';
                            }
                            formatted += value[i];
                        }

                        this.value = formatted.substring(0, 5);
                    });
                }
            });
        </script>
    @endpush
@endsection
