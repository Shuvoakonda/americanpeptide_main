@props(['product'])
<div class="product-card-premium h-100 d-flex flex-column position-relative">
    <!-- Category Badge -->
    @if($product->category && $product->category->name == 'Gift Boxes')
        <span class="badge badge-premium position-absolute top-0 start-0 m-3"><i class="bi bi-gift me-1"></i>Gift Box</span>
    @elseif($product->category && $product->category->name == 'Audiobooks')
        <span class="badge badge-premium bg-info text-white position-absolute top-0 start-0 m-3"><i class="bi bi-headphones me-1"></i>Audiobook</span>
    @endif
    <!-- Product Image -->
    <div class="premium-image-wrapper d-flex align-items-center justify-content-center bg-white rounded-top-4" style="width:100%;height:220px;overflow:hidden;">
       <a href="{{ route('products.show', $product) }}">
           <img src="{{ $product->image_url }}" class="premium-product-image" alt="{{ $product->name }}" style="max-width:100%;max-height:100%;object-fit:contain;display:block;">
       </a>
    </div>
    <!-- Card Body -->
    <div class="premium-card-body flex-grow-1 d-flex flex-column justify-content-between p-4 bg-white rounded-bottom-4">
        <div>
            <!-- Category Only -->
            <div class="d-flex align-items-center mb-2" style="gap: 0.75rem;">
                @if($product->category)
                    <span class="text-muted small d-flex align-items-center" style="font-family: 'Playfair Display', serif; letter-spacing: 0.02em;">
                        <i class="bi bi-journal-bookmark me-1" style="color: var(--secondary-color);"></i>
                        {{ $product->category->name }}
                    </span>
                @endif
            </div>
            <h5 class="premium-title mb-2"><a class="text-decoration-none" style="color: var(--primary-color);" href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h5>
            <p class="premium-desc text-muted mb-3">{{ Str::limit($product->description, 80) }}</p>
        </div>
        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
                @php
                    $minPrice = $product->getMinPrice();
                    $maxPrice = $product->getMaxPrice();
                @endphp
                <span class="premium-price">
                    @if($minPrice == $maxPrice)
                        ${{ number_format($minPrice, 2) }}
                    @else
                        ${{ number_format($minPrice, 2) }} - ${{ number_format($maxPrice, 2) }}
                    @endif
                </span>
            </div>
            <a href="{{ route('products.show', $product) }}" class="btn btn-premium btn-add-to-cart w-100 py-2">
                <i class="bi bi-sliders me-2"></i> Select Options
            </a>
        </div>
    </div>
</div> 