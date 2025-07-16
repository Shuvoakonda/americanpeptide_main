@extends('frontend.layouts.app')

@section('title', $product->name . ' - American Peptides')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('products.index', ['category' => $product->category->slug ?? '']) }}" class="text-decoration-none">
                    {{ $product->category->name ?? 'Products' }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-images">
                <div class="main-image-container mb-3">
                    <img id="main-product-image" 
                         src="{{ $product->image_url ?? '/assets/images/wp-content/uploads/2024/05/ABP-7-10mg-600x600.jpg' }}"
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 500px; width: 100%; object-fit: contain;">
                </div>
                
                @if (!empty($variants))
                <div class="variant-thumbnails d-flex gap-2 flex-wrap">
                    @foreach ($variants as $i => $variant)
                        <div class="variant-thumbnail {{ $i === 0 ? 'active' : '' }}" 
                             data-variant-index="{{ $i }}"
                             data-image="{{ $variant['image_url'] ?? $product->image_url ?? '/assets/images/wp-content/uploads/2024/05/ABP-7-10mg-600x600.jpg' }}">
                            <img src="{{ $variant['image_url'] ?? $product->image_url ?? '/assets/images/wp-content/uploads/2024/05/ABP-7-10mg-600x600.jpg' }}" 
                                 alt="{{ $variant['name'] ?? 'Variant' }}" 
                                 class="img-fluid rounded" 
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="product-details">
                <!-- Product Name -->
                <h1 id="product-variation-name" class="h2 mb-3 text-primary">
                    {{ $firstVariant['name'] ?? $product->name }}
                </h1>

                <!-- Price -->
                <div class="price mb-4">
                    <span class="h3 text-success fw-bold" id="product-variation-price">
                        ${{ isset($firstVariant['price']['retailer']['unit_price']) ? number_format($firstVariant['price']['retailer']['unit_price'], 2) : number_format($product->price ?? 0, 2) }}
                    </span>
                </div>

                <!-- Product Info -->
                <div class="product-info mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <strong class="text-muted">SKU:</strong>
                                <span id="product-variation-sku" class="ms-2">{{ $firstVariant['sku'] ?? $product->sku }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <strong class="text-muted">Size:</strong>
                                <span class="ms-2">{{ $product->size ?? '1mg' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-item mb-3">
                        <strong class="text-muted">Contents:</strong>
                        <span class="ms-2">{{ $product->name }}</span>
                    </div>

                    @if (!empty($variants))
                    <div class="info-item mb-4">
                        <strong class="text-muted d-block mb-2">Strength:</strong>
                        <select id="variation-selector" class="form-select">
                            @foreach ($variants as $i => $variant)
                                <option value="{{ $i }}" 
                                        data-name="{{ $variant['name'] ?? '' }}"
                                        data-price="{{ $variant['price']['retailer']['unit_price'] ?? 0 }}"
                                        data-sku="{{ $variant['sku'] ?? '' }}"
                                        data-image="{{ $variant['image_url'] ?? $product->image_url ?? '/assets/images/wp-content/uploads/2024/05/ABP-7-10mg-600x600.jpg' }}"
                                        @if ($i === 0) selected @endif>
                                    {{ collect($variant['attributes'] ?? [])->firstWhere('name', 'Strength')['value'] ?? ($variant['name'] ?? 'Variant') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                <!-- Add to Cart Form -->
                <form id="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="post" class="mb-4">
                    @csrf
                    <input type="hidden" name="variant_index" id="selected-variant-index" value="0">
                    
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Quantity:</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary minus" type="button">-</button>
                                <input type="number" 
                                       class="form-control text-center pro-quantity-input" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->track_quantity ? $product->getStock() : 999 }}">
                                <button class="btn btn-outline-secondary plus" type="button">+</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" 
                                    class="btn btn-primary w-100 add-cart" 
                                    {{ $product->track_quantity && $product->getStock() <= 0 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-cart me-2"></i> 
                                Add To Cart
                            </button>
                        </div>
                    </div>
                </form>

                <div id="add-to-cart-message" class="mb-4"></div>

                <!-- Stock Status -->
                @if($product->track_quantity)
                    <div class="stock-status mb-4">
                        @if($product->getStock() > 0)
                            <span class="badge bg-success">In Stock ({{ $product->getStock() }} available)</span>
                        @else
                            <span class="badge bg-danger">Out of Stock</span>
                        @endif
                    </div>
                @endif

                <!-- Product Description -->
                <div class="product-description">
                    <h4 class="mb-3">Description</h4>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{!! nl2br(e($product->description)) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if ($relatedProducts->count() > 0)
<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Related Products</h2>
        <p class="text-muted">You might also be interested in these products</p>
    </div>
    
    <div class="row">
        @foreach ($relatedProducts as $relatedProduct)
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <x-product.product :product="$relatedProduct" />
            </div>
        @endforeach
    </div>
</section>
@endif

@endsection

@push('styles')
<style>
.product-images {
    position: relative;
}

.variant-thumbnails {
    border-top: 1px solid #dee2e6;
    padding-top: 1rem;
}

.variant-thumbnail {
    border: 2px solid transparent;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.variant-thumbnail.active {
    border-color: #00687a;
    box-shadow: 0 0 0 2px rgba(0, 104, 122, 0.2);
}

.variant-thumbnail:hover {
    border-color: #00687a;
    transform: scale(1.05);
}

.product-details {
    padding: 0 1rem;
}

.info-item {
    display: flex;
    align-items: center;
}

.price {
    padding: 0.5rem 0;
}

.stock-status {
    padding: 0.5rem 0;
}

.product-description .card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.section-title {
    color: #00687a;
    font-weight: 600;
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #00687a, #00a3cc);
    border-radius: 2px;
}

@media (max-width: 768px) {
    .product-details {
        padding: 0;
        margin-top: 2rem;
    }
    
    .variant-thumbnails {
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const minusBtn = document.querySelector('.minus');
    const plusBtn = document.querySelector('.plus');
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

// Variation selector with thumbnail update
document.addEventListener('DOMContentLoaded', function() {
    const variationSelector = document.getElementById('variation-selector');
    const nameEl = document.getElementById('product-variation-name');
    const priceEl = document.getElementById('product-variation-price');
    const skuEl = document.getElementById('product-variation-sku');
    const hiddenVariantIndex = document.getElementById('selected-variant-index');
    const mainImage = document.getElementById('main-product-image');
    const variantThumbnails = document.querySelectorAll('.variant-thumbnail');

    if (variationSelector) {
        variationSelector.addEventListener('change', function() {
            const selected = variationSelector.options[variationSelector.selectedIndex];
            const variantIndex = selected.value;
            
            // Update product details
            nameEl.textContent = selected.dataset.name;
            priceEl.textContent = '$' + parseFloat(selected.dataset.price).toFixed(2);
            skuEl.textContent = selected.dataset.sku;
            hiddenVariantIndex.value = variantIndex;
            
            // Update main image
            if (selected.dataset.image) {
                mainImage.src = selected.dataset.image;
                mainImage.alt = selected.dataset.name;
            }
            
            // Update thumbnail active state
            variantThumbnails.forEach((thumb, index) => {
                if (index == variantIndex) {
                    thumb.classList.add('active');
                } else {
                    thumb.classList.remove('active');
                }
            });
        });
    }
    
    // Thumbnail click functionality
    variantThumbnails.forEach((thumb, index) => {
        thumb.addEventListener('click', function() {
            // Update selector
            if (variationSelector) {
                variationSelector.selectedIndex = index;
                variationSelector.dispatchEvent(new Event('change'));
            }
            
            // Update active state
            variantThumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });
});

// Add to cart form submission
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
