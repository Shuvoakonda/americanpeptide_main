@extends('frontend.layouts.app')

@section('title', $product->name . ' - MyShop')

@section('content')

    <section class="container text-dark">
        <div class="breadcrumb">
            <a class="me-1" href="{{ route('home') }}">Home</a> /
            <a class="me-1 ms-1" href="{{ route('products.index', ['category' => $product->category->slug ?? '']) }}">
                {{ $product->category->name ?? 'Category' }}
            </a>
            /
            <a class="ms-1" href="#">{{ $product->name }}</a>
        </div>
        <div class="product-container">
            <div class="product-image">

                <img src="{{ $product->image_url ?? '/assets/images/wp-content/uploads/2024/05/ABP-7-10mg-600x600.jpg' }}"
                    alt="{{ $product->name }}">
            </div>

            @php
                $variants = $product->variants ?? [];
                $firstVariant = $variants[0] ?? null;
            @endphp
            <div class="product-details">
                <div class="product-name">
                    <h3 id="product-variation-name" class="product-card-details_title">
                        <a href="">{{ $firstVariant['name'] ?? $product->name }}</a>
                    </h3>
                </div>
                <div class="price" id="product-variation-price">
                    ${{ isset($firstVariant['price']['retailer']['unit_price']) ? number_format($firstVariant['price']['retailer']['unit_price'], 2) : number_format($product->price ?? 0, 2) }}
                </div>
                <div class="info-row">
                    <div class="info-label">SKU:</div>
                    <div class="info-value text-dark" id="product-variation-sku">{{ $firstVariant['sku'] ?? $product->sku }}
                    </div>
                </div>
                @if (!empty($variants))
                    <div class="info-row">
                        <div class="info-label">Strength:</div>
                        <div class="info-value">
                            <select id="variation-selector" class="form-select text-dark">
                                @foreach ($variants as $i => $variant)
                                    <option value="{{ $i }}" data-name="{{ $variant['name'] ?? '' }}"
                                        data-price="{{ $variant['price']['retailer']['unit_price'] ?? 0 }}"
                                        data-sku="{{ $variant['sku'] ?? '' }}"
                                        @if ($i === 0) selected @endif>
                                        {{ collect($variant['attributes'] ?? [])->firstWhere('name', 'Strength')['value'] ?? ($variant['name'] ?? 'Variant') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                <div class="product-info">
                    <div class="info-row">
                        <div class="info-label">Size:</div>
                        <div class="info-value text-dark">{{ $product->size ?? '1mg' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Contents:</div>
                        <div class="info-value text-dark">{{ $product->name }} </div>
                    </div>

                </div>



                <form id="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="variant_index" id="selected-variant-index" value="0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="pro-quantity-selector m-0">
                            <div class="pro-quantity-label">Quantity:</div>
                            <div class="pro-quantity-controls d-flex align-items-center">
                                <button class=" minus btn btn-secondary" type="button">-</button>
                                <input type="number" class="pro-quantity-input form-control text-dark mx-2" value="1"
                                    min="1" style="width: 70px;"
                                    max="{{ $product->track_quantity ? $product->getStock() : 999 }}">
                                <button class="plus btn btn-secondary" type="button">+</button>
                            </div>
                        </div>
                        <button type="submit"
                            class="add-cart btn btn-secondary text-light "{{ $product->track_quantity && $product->getStock() <= 0 ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-cart me-2"></i> Add To Cart</button>

                    </div>
                </form>
                <div id="add-to-cart-message" class="mt-2"></div>
                <ul class="nav nav-tabs border-bottom mb-4 text-dark" id="productTab" role="tablist">
                    <li class="nav-item text-dark" role="presentation">
                        <button class="nav-link active text-dark" style="background-color:#00505E !important" id="desc-tab"
                            data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                            Description
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content border p-4 rounded" id="productTabContent" style="background-color: #fff;">

                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <h3 class="mb-3">{{ $product->name }}</h3>
                        <p>{!! nl2br(e($product->description)) !!}</p>
                    </div>

                </div>
            </div>
        </div>

    </section>


    <section class="container py-5">
        <div class="text-center mb-4">
            <h2 class="section-title">Related Product</h2>
        </div>
        @if ($relatedProducts->count() > 0)
            <div class="row px-5 mt-5">
                @foreach ($relatedProducts as $relatedProduct)
                    <!-- Product 1 -->
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-5">
                        <x-product.product :product="$relatedProduct" />
                    </div>
                @endforeach

            </div>
        @endif
    </section>


@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const minusBtn = document.querySelector('.btn.minus');
            const plusBtn = document.querySelector('.btn.plus');
            const quantityInput = document.querySelector('.pro-quantity-input');
            const addToCartBtn = document.querySelector('.add-cart');
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variationSelector = document.getElementById('variation-selector');
            const nameEl = document.getElementById('product-variation-name').querySelector('a');
            const priceEl = document.getElementById('product-variation-price');
            const skuEl = document.getElementById('product-variation-sku');
            const hiddenVariantIndex = document.getElementById('selected-variant-index');

            if (variationSelector) {
                variationSelector.addEventListener('change', function() {
                    const selected = variationSelector.options[variationSelector.selectedIndex];
                    nameEl.textContent = selected.dataset.name;
                    priceEl.textContent = '$' + parseFloat(selected.dataset.price).toFixed(2);
                    skuEl.textContent = selected.dataset.sku;
                    hiddenVariantIndex.value = selected.value;
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('add-to-cart-form');
            const quantityInput = form.querySelector('.pro-quantity-input');
            const variantIndexInput = document.getElementById('selected-variant-index');
            const messageDiv = document.getElementById('add-to-cart-message');
            const cartCountEls = document.querySelectorAll('#cart-count, .cart-badge');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const quantity = parseInt(quantityInput.value);
                const variantIndex = variantIndexInput ? variantIndexInput.value : null;
                const formData = new FormData();
                formData.append('product_id', {{ $product->id }});
                formData.append('quantity', quantity);
                @if (!empty($variants))
                    formData.append('variant', JSON.stringify(@json($variants)[variantIndex]));
                @endif
                formData.append('_token', form.querySelector('input[name="_token"]').value);
                fetch("{{ route('cart.add', $product->id) }}", {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message, 'success');
                            cartCountEls.forEach(el => el.textContent = data.cart_count);
                        } else {
                            showToast(data.message || 'Failed to add to cart.', 'danger');
                        }
                    })
                    .catch(() => {
                        showToast('Failed to add to cart.', 'danger');
                    });
            });
        });
    </script>
@endpush
