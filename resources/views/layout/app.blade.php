<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>American Peptide Co.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome 6 Free -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cart_checkout.css') }}">

    <style>
        .wishlist-badge,
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            background-color: #ac7630;
            color: #fff;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 50%;
        }


        /* Floating Cart Styles */
        .floating-cart {
            position: fixed;
            bottom: 50px;
            right: 30px;
            z-index: 999;
            display: none;
            /* Hidden by default */
        }

        /* Show only on mobile and tablet (Bootstrap lg breakpoint and below) */
        @media (max-width: 991.98px) {
            .floating-cart {
                display: block;
            }
        }

        .cart-icon-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            position: relative;
        }

        .cart-icon-link:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            background-color: #9a6829;
            /* Darker shade of primary color */
        }

        .cart-icon-link i {
            font-size: 1.5rem;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }

        /* Flying animation */
        @keyframes flyToCart {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.5);
                opacity: 0.7;
            }

            100% {
                transform: scale(0);
                opacity: 0;
            }
        }

        .fly-animation {
            animation: flyToCart 0.8s ease-out forwards;
        }
    </style>
    @yield('styles')

</head>

<body>

    <x-layout.header />
    <!-- Offcanvas Side Menu for Mobile -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileMenu"
        aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileMenuLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body position-relative mt-auto">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home') }}"><i class="fas fa-home me-2"></i>HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('products') }}"><i
                            class="fas fa-flask me-2"></i>PEPTIDES FOR SALE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('about') }}"><i
                            class="fas fa-info-circle me-2"></i>ABOUT US</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('contact') }}"><i
                            class="fas fa-envelope me-2"></i>CONTACT</a>
                </li>
                <li>
                    <hr class="dropdown-divider bg-secondary">
                </li>
                <li class="nav-item">

                    <a class="nav-link text-white" href="#"><i class="fas fa-sign-in-alt me-2"></i>Login</a>
                </li>
                <li class="nav-item">

                    <a class="nav-link text-white" href="#"><i class="fas fa-user-plus me-2"></i> Register</a>
                </li>
                <li class="nav-item">

                    <a class="nav-link text-white" href="#"><i class="fas fa-user me-2"></i> My Account</a>
                </li>
            </ul>

        </div>

    </div>
    <main class="" style="margin-top: 60px;">
        {{ $slot }}
    </main>

    <x-layout.footer />

    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 id="cartOffcanvasLabel" class="mb-0 fw-semibold">
                <span role="button" data-bs-dismiss="offcanvas" aria-label="Close" class="me-2 text-dark">
                    <i class="fas fa-arrow-left"></i>
                </span>
                Your Cart
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-4 bg-light">

            <!-- Cart Item -->
            <div class="card mb-3 shadow-sm border-0">
                <div class="card-body d-flex align-items-center p-3">
                    <img src="/assets/images/product/ABP-7-10mg-300x300.jpg.webp" class="rounded me-3"
                        style="width: 60px; height: 60px; object-fit: cover;" alt="Product 2">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">ACE-031 10mg</h6>
                        <div class="text-muted small">Qty: 2</div>
                        <div class="text-dark fw-semibold">$120.00</div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger ms-2"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>

            <!-- Cart Item -->
            <div class="card mb-3 shadow-sm border-0">
                <div class="card-body d-flex align-items-center p-3">
                    <img src="/assets/images/product/ABP-7-10mg-300x300.jpg.webp" class="rounded me-3"
                        style="width: 60px; height: 60px; object-fit: cover;" alt="Product 2">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">BPC-157 5mg</h6>
                        <div class="text-muted small">Qty: 1</div>
                        <div class="text-dark fw-semibold">$45.00</div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger ms-2"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>

            <!-- Cart Item -->
            <div class="card mb-3 shadow-sm border-0">
                <div class="card-body d-flex align-items-center p-3">
                    <img src="/assets/images/product/ABP-7-10mg-300x300.jpg.webp" class="rounded me-3"
                        style="width: 60px; height: 60px;" alt="Product 2">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">TB-500 2mg</h6>
                        <div class="text-muted small">Qty: 3</div>
                        <div class="text-dark fw-semibold">$90.00</div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger ms-2"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>

            <!-- Total and Checkout -->
            <div class="border-top pt-3 mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-5">$255.00</span>
                </div>
                <a href="{{ route('cart') }}" class="btn btn-primary btn-lg w-100 mt-3">
                    <i class="fas fa-credit-card me-2"></i> Proceed to Cart Page ->
                </a>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-outline-danger').forEach(button => {
                button.addEventListener('click', function() {
                    // Confirm before removing
                    if (confirm('Are you sure you want to remove this item?')) {
                        const card = this.closest('.card');

                        // Animation
                        card.style.transition = 'all 0.3s ease';
                        card.style.opacity = '0';
                        card.style.height = '0';
                        card.style.margin = '0';
                        card.style.padding = '0';
                        card.style.overflow = 'hidden';

                        // Remove after animation
                        setTimeout(() => {
                            card.remove();
                            updateCartTotal();

                            // Optional: Update cart counter in navbar
                            const cartCount = document.querySelector('.cart-count');
                            if (cartCount) {
                                const currentCount = parseInt(cartCount.textContent) || 0;
                                cartCount.textContent = currentCount - 1;
                            }
                        }, 300);
                    }
                });
            });

            function updateCartTotal() {
                // 1. Get all remaining items
                const items = document.querySelectorAll('.card');
                let total = 0;

                // 2. Calculate new total
                items.forEach(item => {
                    const priceText = item.querySelector('.fw-semibold').textContent;
                    const price = parseFloat(priceText.replace('$', ''));
                    const qtyText = item.querySelector('.small').textContent;
                    const qty = parseInt(qtyText.replace('Qty: ', ''));
                    total += price * qty;
                });

                // 3. Update total display (adjust selector as needed)
                const totalElement = document.querySelector('.cart-total');
                if (totalElement) {
                    totalElement.textContent = '$' + total.toFixed(2);
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const floatingCart = document.getElementById('floatingCart');
            const cartIconLink = document.querySelector('.cart-icon-link');

            // Click handler for flying animation
            cartIconLink.addEventListener('click', function(e) {
                // Only animate if going to cart page (not already on it)
                if (!window.location.pathname.includes('cart')) {
                    e.preventDefault();
                    const cartIcon = this.querySelector('i');
                    const clone = cartIcon.cloneNode(true);

                    // Style the clone for animation
                    clone.style.position = 'fixed';
                    clone.style.color = 'var(--primary-color)';
                    clone.style.fontSize = '2rem';
                    clone.style.zIndex = '1000';
                    clone.style.pointerEvents = 'none';

                    // Position the clone
                    const rect = cartIcon.getBoundingClientRect();
                    clone.style.top = `${rect.top}px`;
                    clone.style.left = `${rect.left}px`;
                    document.body.appendChild(clone);

                    // Add fly animation
                    clone.classList.add('fly-animation');

                    // Navigate after animation completes
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 800);
                }
            });

            // Update cart badge count (replace with your actual cart count)
            function updateCartCount() {
                fetch('/api/cart-count') // Replace with your actual endpoint
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('.cart-badge').textContent = data.count;
                    })
                    .catch(() => {
                        document.querySelector('.cart-badge').textContent = '0';
                    });
            }

            // Initialize and update periodically
            updateCartCount();
            setInterval(updateCartCount, 30000); // Update every 30 seconds
        });
    </script>
    <div class="floating-cart d-lg-none" id="floatingCart">
        <a href="{{ route('cart') }}" class="cart-icon-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-badge">0</span>
        </a>
    </div>
</body>


</html>
