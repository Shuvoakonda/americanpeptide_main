@extends('frontend.layouts.app')

@section('title', 'American Peptides - Home')

<style>
    .corepepbgimage {
        background-image: url("{{ asset('assets/images/home/gradient_home_first.png') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-color: transparent;
    }

    .et_pb_background_pattern {
        background-image: url(data:image/svg+xml;base64,PHN2ZyAgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA0KSIgaGVpZ2h0PSIyNnB4IiB3aWR0aD0iMjAwcHgiIHZpZXdCb3g9IjAgMCAyMDAgMjYiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTMzLjc3LDBDMjUuMDksMy44MSwxNC41Nyw2LjUsMCw2LjVWMFpNMjAwLDYuNVYwSDE2Ni4yM0MxNzQuOTEsMy44MSwxODUuNDMsNi41LDIwMCw2LjVaTTEzMy43NywwSDEwMGMyNCwwLDM1Ljc5LDcuNjQsNDguMjMsMTUuNzNhMTI1LDEyNSwwLDAsMCwxOCwxMC4yN0gyMDBjLTI0LDAtMzUuNzktNy42NC00OC4yMy0xNS43M0ExMjUsMTI1LDAsMCwwLDEzMy43NywwWk0xMDAsMEg2Ni4yM2ExMjUsMTI1LDAsMCwwLTE4LDEwLjI3QzM1Ljc5LDE4LjM2LDI0LDI2LDAsMjZIMzMuNzdhMTI1LDEyNSwwLDAsMCwxOC0xMC4yN0M2NC4yMSw3LjY0LDc2LDAsMTAwLDBaTTY2LjIzLDI2aDY3LjU0Yy04LjY4LTMuODEtMTkuMi02LjUtMzMuNzctNi41Uzc0LjkxLDIyLjE5LDY2LjIzLDI2WiIvPjwvc3ZnPg==);
        background-size: 80px auto;
    }

    .product-cat {
        background-image: url('{{ asset('assets/images/home/section-4-bg_02-scaled-2-1.webp') }}') !important;
        position: relative;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 80px 0;
    }

    .peptides-hero {
        background-image: url('{{ asset('assets/images/home/homepage-shop-now-bg.png') }}');
        background-size: contain;
        /* Changed from cover to contain */
        background-position: center;
        background-repeat: no-repeat;
        background-color: #ffffff;
        /* Fallback color */
        height: 779px;
        position: relative;
    }
</style>
@section('content')

    <section class="">
        <div class="et_pb_section et_pb_section_0 corepepbgimage et_pb_with_background et_section_regular">
            <span class="et_pb_background_pattern"></span>
            <div class="et_pb_row et_pb_row_0">
                <div class="et_pb_column et_pb_column_1_2 et_pb_column_0  et_pb_css_mix_blend_mode_passthrough">
                    <div
                        class="et_pb_module et_pb_text et_pb_text_0 gradient-overlay-home-banner  et_pb_text_align_left et_pb_bg_layout_light">
                        <div class="et_pb_text_inner">
                            <h1>Highest Quality<br />Peptides For Sale</h1>
                        </div>
                    </div>
                    <div class="et_pb_module et_pb_text et_pb_text_1  et_pb_text_align_left et_pb_bg_layout_light">
                        <div class="et_pb_text_inner">
                            <p>We are proud to carry the highest quality peptides and
                                peptide blends in the research industry.</p>
                        </div>
                    </div>
                    <div class="et_pb_button_module_wrapper et_pb_button_0_wrapper  et_pb_module ">
                        <a class="et_pb_button et_pb_button_0 et_pb_bg_layout_light" href="#">BUY
                            PEPTIDES</a>
                    </div>
                </div>
                <div
                    class="et_pb_column et_pb_column_1_2 et_pb_column_1  et_pb_css_mix_blend_mode_passthrough et-last-child">
                    <div class="et_pb_module et_pb_image et_pb_image_0">
                        <span class="et_pb_image_wrap "><img src="{{ asset('assets/images/home/home-pt.webp') }}"
                                class="wp-image-84149" /></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="feature-strip py-5 text-white">
            <div class="row text-center ">
                <div class="col-md-4 mb-4 px-4">
                    <img src="/assets/images/home/plane.png" alt="Free Delivery" style="height:50px;">
                    <h5 class="mt-3 text-uppercase" style="color: #d6a754;">Free Delivery</h5>
                    <p class="mb-0" style="color: #aca9a5;">Any purchase of $200 or more qualifies for free delivery
                        within the USA.</p>
                </div>

                <div class="col-md-4 mb-4 px-4">
                    <img src="/assets/images/home/medal.png" alt="Quality Peptides" style="height:50px;">
                    <h5 class="mt-3 text-uppercase" style="color: #d6a754;">Highest Quality Peptides</h5>
                    <p class="mb-0" style="color: #aca9a5;">Our products are scientifically-formulated and produced in
                        cGMP facilities.</p>
                </div>

                <div class="col-md-4 mb-4 px-4">
                    <img src="/assets/images/home/headset.png" alt="Online Support" style="height:50px;">
                    <h5 class="mt-3 text-uppercase" style="color: #d6a754;">Online Support</h5>
                    <p class="mb-0" style="color: #aca9a5;">Have questions? We can help. Email us or connect via our
                        <a href="#" class="text-warning">Contact</a> page.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid mt-5">
        <div class="text-center mb-4">
            <h2 class="section-title">Research Peptides For Sale</h2>
        </div>

        <!-- Filters & Sorting Row -->
        <div class="d-flex justify-content-between align-items-center mb-4 px-5">
            <p class="woocommerce-result-count mb-0">Showing all 99 results</p>
            <form class="woocommerce-ordering">
                <select name="orderby" class="orderby p-1" aria-label="Shop order">
                    <option value="popularity">Sort by popularity</option>
                    <option value="date">Sort by latest</option>
                    <option value="price">Sort by price: low to high</option>
                    <option value="price-desc">Sort by price: high to low</option>
                    <option value="title" selected>Sort by title (A-Z)</option>
                    <option value="title-desc">Sort by title (Z-A)</option>
                </select>
                <input type="hidden" name="paged" value="1" />
            </form>
        </div>

        <!-- Products Grid (4 per row) -->
        <div class="row px-5">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-5">
                    <x-product.product :product="$product" />
                </div>
            @endforeach
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-5">
                    <x-product.product-2 :product="$product" />
                </div>
            @endforeach

            @foreach ($products as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-5">
                    <x-product.product-3 :product="$product" />
                </div>
            @endforeach

        </div>

    </section>

    <section class="content mt-5">
        <div class="product-cat">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-evenly">
                    <div class="cat_type">
                        <img src="{{ asset('assets/images/home/pep.svg') }}" alt="Peptides Icon" />
                        <a class="pep_btn" href="#">PEPTIDES</a>
                    </div>

                    <div class="cat_type">
                        <img src="{{ asset('assets/images/home/pep_blend.svg') }}" alt="Peptide Blends Icon" />
                        <a class="blend_btn" href="#">PEPTIDE BLENDS</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content mt-5 mb-5">
        <div class="peptides-hero">
            <div class="hero-container">
                <div class="text-content">
                    <div class="main-heading">
                        <h2>Highest Quality<br>Peptides For Sale</h2>
                    </div>
                    <div class="description-text">
                        <p>Welcome to Core Peptides. We are proud to carry the highest quality peptides and peptide
                            blends
                            in the research industry. All of our peptides have gone through rigorous quality control
                            procedures to ensure our clients are receiving the best quality peptides available. We offer
                            custom peptides for sale online.</p>
                    </div>
                </div>
                <div class="shop-now-wrapper">
                    <a href="#" class="shop-now-button">SHOP NOW</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content mt-2">
        <div class="newsletter-section py-5">
            <div class="container">
                <div class="newsletter-container">
                    <div class="text-center">
                        <h2 class="newsletter-title">SUBSCRIBE TO OUR NEWSLETTER</h2>
                        <p class="newsletter-subtitle">
                            ENJOY PROMOTIONS AND DISCOUNTS
                        </p>

                        <form action="" method="POST" class="newsletter-form row justify-content-center gy-3 mt-4">
                            @csrf
                            <div class="col-md-3">
                                <input type="text" name="first_name" class="form-control newsletter-input"
                                    placeholder="First Name" required>
                            </div>

                            <div class="col-md-3">
                                <input type="email" name="email" class="form-control newsletter-input"
                                    placeholder="Email Address" required>
                            </div>

                            <div class="col-md-3">
                                <input type="tel" name="phone" class="form-control newsletter-input"
                                    placeholder="Contact Number" required>
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn newsletter-btn w-100">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function addToCart(productId) {
            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart count
                        updateCartCount();

                        // Show success message
                        const alert = document.createElement('div');
                        alert.className =
                            'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                        alert.style.zIndex = '9999';
                        alert.innerHTML = `
                <i class="bi bi-check-circle me-2"></i>
                Product added to cart successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
                        document.body.appendChild(alert);

                        // Auto-remove after 3 seconds
                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.remove();
                            }
                        }, 3000);
                    } else {
                        // Show error message
                        const alert = document.createElement('div');
                        alert.className =
                            'alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                        alert.style.zIndex = '9999';
                        alert.innerHTML = `
                <i class="bi bi-exclamation-triangle me-2"></i>
                ${data.message || 'Error adding product to cart'}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
                        document.body.appendChild(alert);

                        // Auto-remove after 3 seconds
                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.remove();
                            }
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Show error message
                    const alert = document.createElement('div');
                    alert.className =
                        'alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                    alert.style.zIndex = '9999';
                    alert.innerHTML = `
            <i class="bi bi-exclamation-triangle me-2"></i>
            Error adding product to cart
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
                    document.body.appendChild(alert);

                    // Auto-remove after 3 seconds
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 3000);
                });
        }
    </script>
@endsection
