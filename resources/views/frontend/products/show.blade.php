@extends('frontend.layouts.app')

@section('title', $product->name . ' - MyShop')

@section('content')

    <section class="container">
        <div class="breadcrumb">
            <a class="me-1" href="{{ route('home') }}">Home</a> /
            <a class="me-1 ms-1"
                href="{{ route('products.index', ['category' => $product->category_id]) }}">{{ $product->category->name ?? 'Category' }}</a>
            /
            <a class="ms-1" href="#">{{ $product->name }}</a>
        </div>
        <div class="product-container">
            <div class="product-image">

                <img src="/assets/images/wp-content/uploads/2024/05/ABP-7-10mg-600x600.jpg" alt="ABP-7 Peptide (10mg)"
                    alt="{{ $product->name }}">
            </div>

            <div class="product-details">
                <div class="product-name">
                    <h3 id="" class="product-card-details_title">
                        <a href="">{{ $product->name }}</a>
                    </h3>
                </div>
                <div class="price">{{ $product->price }}</div>

                <div class="product-info">
                    <div class="info-row">
                        <div class="info-label">Size:</div>
                        <div class="info-value">1mg</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Contents:</div>
                        <div class="info-value">{{ $product->name }} ({{ $product->weight }}mg)</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Form:</div>
                        <div class="info-value">Lyophilized powder</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Purity:</div>
                        <div class="info-value">&gt;99%</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">SKU:</div>
                        <div class="info-value">{{ $product->sku }}</div>
                    </div>
                </div>

                <div class="shipping-notice mt-2">
                    FREE Shipping on $200+ orders
                </div>
                <table class="discount-table">
                    <thead>
                        <tr>
                            <th>Quantity</th>
                            <th>Discount</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>5 - 8</td>
                            <td>5%</td>
                            <td>$164.35</td>
                        </tr>
                        <tr>
                            <td>9 +</td>
                            <td>10%</td>
                            <td>$155.70</td>
                        </tr>
                    </tbody>
                </table>
                <form id="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="post">
                    @csrf
                    <div class="pro-quantity-selector">
                        <div class="pro-quantity-label">Quantity:</div>
                        <div class="pro-quantity-controls d-flex align-items-center">
                            <button class="pro-quantity-btn minus btn btn-outline-secondary" type="button">-</button>
                            <input type="number" class="pro-quantity-input form-control mx-2" value="1" min="1"
                                style="width: 70px;" max="{{ $product->track_quantity ? $product->getStock() : 999 }}">
                            <button class="pro-quantity-btn plus btn btn-outline-secondary" type="button">+</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-evenly align-items-center">
                        <button type="submit"
                            class="add-to-cart zoom-in"{{ $product->track_quantity && $product->getStock() <= 0 ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-cart me-2"></i> Add To Cart</button>
                        <a class="favourite" id="add-to-wishlist" data-product-id="101">
                            <i class="fas fa-heart"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs border-bottom mb-4" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#description"
                    type="button" role="tab">
                    Description
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="coa-tab" data-bs-toggle="tab" data-bs-target="#coa" type="button"
                    role="tab">
                    Certificate of Analysis
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="hplc-tab" data-bs-toggle="tab" data-bs-target="#hplc" type="button"
                    role="tab">
                    HPLC
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="mass-tab" data-bs-toggle="tab" data-bs-target="#mass" type="button"
                    role="tab">
                    Mass Spectrometry
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content border p-4 rounded" id="productTabContent" style="background-color: #fff;">

            <!-- Description Tab -->
            <div class="tab-pane fade show active" id="description" role="tabpanel">
                <h3 class="mb-3">{{ $product->name }}</h3>
                <p>
                    ACE-031 peptide, also known as ActRIIB-IgG1 peptide, appears to be a myostatin inhibitor...
                    <br><br>
                    <strong>Chemical Makeup</strong><br>
                    Molecular Formula: C3649H5688N982O1062S58 <br>
                    Molecular Weight: 77,489.82 g/mol
                </p>

                <h5 class="mt-4">Research and Clinical Studies</h5>
                <p>
                    In clinical trials, {{ $product->description }} showed significant increases in lean muscle mass...
                </p>
            </div>

            <!-- Certificate of Analysis Tab -->
            <div class="tab-pane fade" id="coa" role="tabpanel">
                <div class="tab-pane-body">
                    <img src="/assets/images/product/pro_ifo.jpg" alt="ABP-7 Peptide (10mg)">
                </div>
            </div>

            <!-- HPLC Tab -->
            <div class="tab-pane fade" id="hplc" role="tabpanel">
                <h4>High Performance Liquid Chromatography (HPLC)</h4>
                <p>Graphical HPLC data or description of purity and testing.</p>
            </div>

            <!-- Mass Spectrometry Tab -->
            <div class="tab-pane fade" id="mass" role="tabpanel">
                <h4>Mass Spectrometry</h4>
                <p>Mass spec results and analysis of peptide molecular structure.</p>
            </div>

        </div>
    </section>


    <section class="container py-5">
        <div class="text-center mb-4">
            <h2 class="section-title">Related Product</h2>
        </div>
        @if ($relatedProducts->count() > 0)
            <div class="row px-5">
                @foreach ($relatedProducts as $relatedProduct)
                    <!-- Product 1 -->
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-5">
                        <x-product.product />
                    </div>
                @endforeach

            </div>
        @endif
    </section>


@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const minusBtn = document.querySelector('.pro-quantity-btn.minus');
            const plusBtn = document.querySelector('.pro-quantity-btn.plus');
            const quantityInput = document.querySelector('.pro-quantity-input');
            const addToCartBtn = document.querySelector('.add-to-cart');
            const cartCount = document.getElementById('cart-count');

            // Quantity controls
            minusBtn?.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            plusBtn?.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });

            // Input validation
            quantityInput?.addEventListener('change', function() {
                if (this.value < 1) {
                    this.value = 1;
                }
            });

            // Add to cart functionality
            addToCartBtn?.addEventListener('click', function() {
                const quantity = parseInt(quantityInput.value);
                cartCount.textContent = quantity;
                alert(`Added ${quantity} item(s) to cart!`);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wishlistBtn = document.getElementById('add-to-wishlist');
            const wishlistCount = document.getElementById('wishlist-count');
            const productId = wishlistBtn.dataset.productId;

            // Get existing wishlist from localStorage or initialize
            let wishlist = JSON.parse(localStorage.getItem('wishlistItems')) || [];

            // Set count in navbar
            wishlistCount.textContent = wishlist.length;

            // If this product is already in wishlist, show selected
            if (wishlist.includes(productId)) {
                wishlistBtn.classList.add('selected');
            }

            wishlistBtn.addEventListener('click', function(e) {
                e.preventDefault();

                const index = wishlist.indexOf(productId);
                if (index === -1) {
                    // Add to wishlist
                    wishlist.push(productId);
                    wishlistBtn.classList.add('selected');
                } else {
                    // Remove from wishlist
                    wishlist.splice(index, 1);
                    wishlistBtn.classList.remove('selected');
                }

                // Save back to localStorage
                localStorage.setItem('wishlistItems', JSON.stringify(wishlist));

                // Update count
                wishlistCount.textContent = wishlist.length;
            });
        });
    </script>
@endpush
