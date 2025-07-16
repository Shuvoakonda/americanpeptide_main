<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>American Peptide Co.</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
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
        /* Force table text to be dark */
        .table,
        .table th,
        .table td {
            color: #222 !important;
        }

        /* Force text-muted to be visible */
        .text-muted {
            color: #6c757d !important;
        }

        /* Force other text utilities to be visible */
        .text-secondary {
            color: #6c757d !important;
        }

        .text-body-secondary {
            color: #6c757d !important;
        }

        .wishlist-badge,
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            background-color: #00a6e7 !important;
            color: #fff !important;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 50%;
        }

        /* Reset previous navbar customizations */
        .navbar {
            background: #fff !important;
            box-shadow: none;
            border-bottom: 1px solid #eaeaea;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            font-size: 1.7rem;
            font-weight: 700;
            color: #6D6E71;
        }

        .navbar-brand img {
            height: 36px;
            width: auto;
        }

        .navbar-nav {
            flex-direction: row;
            align-items: center;
            gap: 1rem;
        }

        .navbar-nav .nav-link {
            color: #6D6E71 !important;
            font-weight: 400;
            font-size: 0.98rem;
            padding: 0;
            background: none !important;
            border: none !important;
            transition: color 0.2s;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #222 !important;
            background: none;
        }

        .navbar .icon-btn {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: #6D6E71 !important;
            font-size: 0.98rem;
            background: none;
            border: none;
            box-shadow: none;
            padding: 0 0.5rem;
            transition: color 0.2s;
            text-decoration: none;
        }

        .navbar .icon-btn i {
            font-size: 1.1rem;
            color: #6D6E71 !important;
        }

        .navbar .icon-btn span {
            display: inline;
            font-size: 0.98rem;
            color: #6D6E71;
        }

        .navbar .icon-btn:hover {
            color: #222 !important;
        }

        .navbar .search-box {
            flex: 1 1 400px;
            max-width: 420px;
            margin: 0 2rem;
            position: relative;
        }

        .navbar .search-box input[type="text"] {
            width: 100%;
            padding: 0.55rem 1.2rem 0.55rem 2.2rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            color: #6D6E71;
            background: #fff;
            outline: none;
        }

        .navbar .search-box .fa-search {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: #b0b0b0;
            font-size: 1rem;
        }

        @media (max-width: 991.98px) {
            .navbar .search-box {
                max-width: 100%;
                margin: 0.7rem 0;
            }

            .navbar-nav {
                gap: 0.7rem;
            }

            .navbar-brand img {
                height: 32px !important;
            }
        }

        /* Ensure hamburger icon is visible */
        .navbar-toggler .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(109,110,113,0.85)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
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

        .navbar .nav-link {
            font-size: 13px;
        }

        .cart-icon-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background-color: #00a6e7;
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
            background-color: #008fc7;
            /* Darker shade of primary color */
        }

        .cart-icon-link i {
            font-size: 1.5rem;
        }

        .cart-badge {
            position: absolute;
            top: 3px;
            right: 35px;
            padding: 0px 6px;
            background-color: #00a6e7;
            color: white;
            border-radius: 100%;
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

        /* Minimal hamburger icon */
        .navbar-toggler {
            border: none;
            background: none;
            padding: 0.35rem 0.7rem;
            box-shadow: none;
            outline: none;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }

        .navbar-toggler-icon {
            width: 28px;
            height: 22px;
            background: none;
            display: inline-block;
            position: relative;
            border: none;
        }

        .navbar-toggler-icon:before,
        .navbar-toggler-icon:after,
        .navbar-toggler-icon div {
            content: '';
            display: block;
            height: 3px;
            width: 100%;
            background: #6D6E71;
            border-radius: 2px;
            position: absolute;
            left: 0;
            transition: all 0.2s;
        }

        .navbar-toggler-icon:before {
            top: 0;
        }

        .navbar-toggler-icon div {
            top: 9px;
        }

        .navbar-toggler-icon:after {
            top: 18px;
        }

        .icon-btn {
            display: flex;
            align-items: center;
            color: #6D6E71 !important;
            font-size: 1.1rem;
            background: none;
            border: none;
            box-shadow: none;
            padding: 0 0.3rem;
            transition: color 0.2s;
            text-decoration: none;
        }

        .icon-btn i {
            font-size: 1.25rem;
            color: #6D6E71 !important;
        }

        /* Offcanvas mobile menu styles */
        .offcanvas .icon-btn,
        .offcanvas .icon-btn i,
        .offcanvas .icon-btn span {
            color: #6D6E71 !important;
            font-size: 1.08rem;
        }

        .offcanvas .icon-btn {
            justify-content: center;
            width: 100%;
        }

        .offcanvas .icon-btn span {
            margin-left: 0.5rem;
        }

        .offcanvas .navbar-nav .nav-link {
            color: #6D6E71 !important;
            font-size: 1.08rem;
            text-align: center;
            font-weight: 400;
            letter-spacing: 0.02em;
        }

        .offcanvas .navbar-nav {
            gap: 1.2rem;
        }

        .offcanvas .search-box input[type="text"] {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ccc;
            padding-left: 2rem;
        }

        .offcanvas .search-box {
            max-width: 320px;
            width: 100%;
        }
    </style>

    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top bg-light">
        <div class="container-fluid px-5 d-flex align-items-center justify-content-between" style="gap: 1.5rem;">
            <a class="navbar-brand d-lg-none" href="#">
                <img src="/mobil-logo.png" alt="American Peptide Mobile Logo">
            </a>
            <a class="navbar-brand d-none d-lg-flex" href="#">
                <img src="/logo.png" alt="American Peptide Logo">
            </a>
            <div class="d-lg-none d-flex align-items-center ms-auto" style="gap: 0.3rem;">
                {{-- <a class="icon-btn p-0" href="{{ route('cart.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count" class="cart-badge">0</span>
                </a> --}}
                <a class="icon-btn p-0" href="{{ route('login') }}"><i class="far fa-user"></i></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                    aria-controls="mobileMenu" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="fas fa-bars"></i>
                    </span>
                </button>
            </div>
            <form class="search-box d-none d-lg-block" action="#" method="get">
                <i class="fas fa-search"></i>
                <input type="text" name="q" placeholder="Search">
            </form>
            <div class="d-none d-lg-flex flex-grow-1 justify-content-center">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">All Peptides</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">Our Company</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>
            </div>
            <div class="d-none d-lg-flex align-items-center" style="position: relative;">
                <a class="icon-btn position-relative" href="{{ route('cart.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count" class="cart-badge position-absolute top-0 start-100 translate-middle">
                        0
                    </span>
                </a>
            </div>

            <div class="d-none d-lg-flex align-items-center dropdown">
                <a class="icon-btn dropdown-toggle" href="#" role="button" id="userDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-user"></i>
                    <span>Account</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    @guest
                        <li>
                            <a class="dropdown-item" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i> Sign in
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-2"></i> Register
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('register.wholesaler') }}">
                                <i class="fas fa-user-plus me-2"></i> Register as a Wholesaler
                            </a>
                        </li>
                    @endguest

                    @auth
                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>

        </div>
    </nav>
    <!-- Offcanvas Side Menu for Mobile -->
    <div class="offcanvas offcanvas-start bg-white" tabindex="-1" id="mobileMenu"
        aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header">
            <a class="navbar-brand" href="#">
                <img src="/mobil-logo.png" alt="American Peptide Mobile Logo" style="height:32px; width:auto;">
            </a>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column align-items-center">
            <form class="search-box mb-4 w-100" action="#" method="get" style="max-width: 320px;">
                <i class="fas fa-search"></i>
                <input type="text" name="q" placeholder="Search">
            </form>
            <ul class="navbar-nav mb-4 w-100 align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">ALL PEPTIDES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">OUR COMPANY</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">CONTACT US</a>
                </li>
            </ul>
            <div class="d-flex flex-column gap-2 w-100 align-items-center">
                <a class="icon-btn" href="{{ route('login') }}"><i class="far fa-user"></i><span
                        style="margin-left:0.5rem;">Sign in</span></a>
                <a class="icon-btn position-relative" href="{{ route('cart.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count" class="cart-badge position-absolute top-0 start-100 translate-middle">
                        0
                    </span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow-1" style="margin-top: 60px;">

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
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    document.querySelectorAll('#cart-count').forEach(el => el.textContent = data.cart_count);
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
            updateCartCount();
            setInterval(updateCartCount, 30000); // Update every 30 seconds
        });
    </script>
    @stack('scripts')
    <div id="toast-container" style="position: fixed; top: 80px; right: 20px; z-index: 9999;"></div>
    <script>
        function showToast(message, type = 'success') {
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
    </script>
    <div class="floating-cart d-lg-none" id="floatingCart">
        <a href="" class="cart-icon-link">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-badge">0</span>
        </a>
    </div>
</body>

</html>
