<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>American Peptide Co.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome 6 Free -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cart_checkout.css') }}">


    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

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

    @stack('styles')
    @vite('resources/js/app.js')
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span style="color: #fff;">AMERICAN</span>
                <span style="color: #ac7630;">PEPTIDES</span>
            </a>

            <!-- Offcanvas toggle button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                aria-controls="mobileMenu">
                <i class="bi bi-list" style="font-size: 2.5rem; color:#fff !important;"></i>
            </button>

            <!-- Desktop Nav (visible on lg and above) -->
            <div class="d-none d-lg-block">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home') }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('products.index') }}">PEPTIDES FOR SALE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('about') }}">ABOUT US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('contact') }}">CONTACT</a>
                    </li>
                    <li class="nav-item position-relative icon-hover">
                        <a class="nav-link" href="#">
                            <i class="fas fa-heart" style="font-size: 20px;"></i>
                            <span id="wishlist-count" class="cart-badge">0</span>
                        </a>
                    </li>
                    <li class="nav-item position-relative icon-hover">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart" style="font-size: 20px;"></i>
                            <span id="cart-count" class="cart-badge">0</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle icon-hover" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user" style="font-size: 20px;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">My Account</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>


    </nav>

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
                    <a class="nav-link text-white" href="#"><i class="fas fa-flask me-2"></i>PEPTIDES FOR
                        SALE</a>
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

    <!-- Main Content -->
    <main class="flex-grow-1" style="margin-top: 15px;">

        @yield('content')

    </main>

    <!-- Footer -->
    <footer class="core-peptides-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="footer-brand">
                        <span class="core">AMERICAN</span> <span class="peptides">PEPTIDES</span>
                    </div>

                    <div class="footer-disclaimer">
                        <p>All products are sold for research, laboratory, or analytical purposes only, and are not for
                            human consumption.</p>
                        <p>American Peptides is a chemical supplier. We are not a compounding pharmacy or chemical
                            compounding facility as defined under 503A of the Federal Food, Drug, and Cosmetic act.</p>
                        <p>The statements made within this website have not been evaluated by the US Food and Drug
                            Administration. The products we offer are not intended to diagnose, treat, cure or prevent
                            any
                            disease.</p>
                    </div>

                    <div class="footer-warning">
                        Human/Animal Consumption Prohibited: Laboratory/in-Vitro Experimental Use Only
                    </div>
                </div>

                <div class="col-md-3">
                    <h5 class="footer-links-title">Quick links</h5>
                    <ul class="footer-links">
                        <li><a href="#">Peptides for Sale</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Shipping, Returns & Refunds</a></li>
                        <li><a href="#">Privacy policy</a></li>
                        <li><a href="#">Terms and Conditions</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <h5 class="compliance-title">Now Accepting</h5>
                    <img src="{{ asset('assets/images/home/payment.png') }}" alt="Payment Methods" class="">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p class="copyright">©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        American Peptides. All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
    </script>
    <!-- Custom Scripts -->
    <script>
        // Cart count update
        function updateCartCount() {
            fetch('{{ route('cart.index') }}')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const cartCount = doc.querySelector('#cart-count');
                    if (cartCount) {
                        document.getElementById('cart-count').textContent = cartCount.textContent;
                    }
                });
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
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
    @stack('scripts')
    <div class="floating-cart d-lg-none" id="floatingCart">
        <a href="" class="cart-icon-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-badge">0</span>
        </a>
    </div>
</body>

</html>
