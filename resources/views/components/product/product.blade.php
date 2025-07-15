@props(['product'])
<article class="text-center p-4">
    <!-- Product Image -->
    <div style="display: flex; justify-content: center; align-items: center; height: 170px;">
        <a href="{{ route('products.show', $product) }}">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" height="300"
                style=" contain; display: block; margin: 0 auto;" loading="lazy" />
        </a>
    </div>
    <!-- Product Name -->
    <div style="margin-top: 30px; font-size: 1rem; font-weight: 500; color: #222;">
        {{ $product->name }}
    </div>
    <!-- Price -->
    @php
        $firstVariant = is_array($product->variants) && count($product->variants) > 0 ? $product->variants[0] : null;
        $price = $firstVariant['price']['retailer']['unit_price'] ?? null;
    @endphp
    <div style="color: #0099cc; font-size: 1.1rem; font-weight: bold; margin-top: 2px;">
        @if ($price)
            ${{ number_format($price, 2) }}
        @else
            $XX
        @endif
    </div>
</article>
