@props(['product'])
<article class="product-card" aria-labelledby="product-title-61189">
    <!-- Product Image with Lazy Loading -->
    <figure class="product-card__image">
        <a href="{{ route('products.show', $product) }}" tabindex="-1">
            <img src="/assets/images/wp-content/uploads/2024/05/Sermorelin-Ipamorelin-5-5MG.jpg"
                alt="{{ $product->name }}" width="300" height="300" loading="lazy" class="product-card__thumbnail" />
        </a>
        <!-- Optional: Badges (Sale/Out of Stock) -->
        <span class="product-card__badge" data-badge="sale">Sale!</span>
    </figure>

    <!-- Product Details -->
    <div class="product-card__body">
        @if ($product->category)
            <span class="small d-flex align-items-center"
                style="font-family: 'Playfair Display', serif; letter-spacing: 0.02em;">
                <i class="bi bi-journal-bookmark me-1" style="color: var(--secondary-color);"></i>
                {{ $product->category->name }}
            </span>
        @endif
        @if ($product->brand)
            <h3 id="product-title-61189" class="product-card__title">
                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
            </h3>
        @endif

        <!-- Price -->
        <div class="product-card__price" aria-label="Price">
            @if (method_exists($product, 'hasVariants') && $product->hasVariants())
                <span class="product-card__price-amount">${{ number_format($product->price, 2) }}</span>
                <del class="product-card__price-old"
                    aria-hidden="true">${{ number_format($product->compare_at_price, 2) }}</del>
            @endif
        </div>

        <!-- Add to Cart (Optional) -->
        {{-- <button class="product-card__add-to-cart" aria-label="Add ABP-7 to cart">
            Add to Cart
        </button> --}}
    </div>
</article>
