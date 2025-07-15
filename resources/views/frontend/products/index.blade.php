@extends('frontend.layouts.app')

@section('title', 'Shop - Eterna Reads')
<style>
    .corepepbgimage {
        background-image: url("{{ asset('assets/images/banner/shop-banner.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-color: transparent;
    }

    .et_pb_section.et_pb_section_0>.et_pb_background_pattern {
        background-image: url(data:image/svg+xml;base64,PHN2ZyAgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjA0KSIgaGVpZ2h0PSIyNnB4IiB3aWR0aD0iMjAwcHgiIHZpZXdCb3g9IjAgMCAyMDAgMjYiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTMzLjc3LDBDMjUuMDksMy44MSwxNC41Nyw2LjUsMCw2LjVWMFpNMjAwLDYuNVYwSDE2Ni4yM0MxNzQuOTEsMy44MSwxODUuNDMsNi41LDIwMCw2LjVaTTEzMy43NywwSDEwMGMyNCwwLDM1Ljc5LDcuNjQsNDguMjMsMTUuNzNhMTI1LDEyNSwwLDAsMCwxOCwxMC4yN0gyMDBjLTI0LDAtMzUuNzktNy42NC00OC4yMy0xNS43M0ExMjUsMTI1LDAsMCwwLDEzMy43NywwWk0xMDAsMEg2Ni4yM2ExMjUsMTI1LDAsMCwwLTE4LDEwLjI3QzM1Ljc5LDE4LjM2LDI0LDI2LDAsMjZIMzMuNzdhMTI1LDEyNSwwLDAsMCwxOC0xMC4yN0M2NC4yMSw3LjY0LDc2LDAsMTAwLDBaTTY2LjIzLDI2aDY3LjU0Yy04LjY4LTMuODEtMTkuMi02LjUtMzMuNzctNi41Uzc0LjkxLDIyLjE5LDY2LjIzLDI2WiIvPjwvc3ZnPg==);
        background-size: 80px auto;
    }

    .et_pb_background_pattern {
        bottom: 0;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        background-position: 0 0;
        background-repeat: repeat;
    }

    .product-filters {
        display: flex;
        justify-content: center;
        gap: 30px;
        padding: 20px;
        align-items: center;
    }

    .filter-column {
        position: relative;
        cursor: pointer;
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 4px;
        background-color: #fff;
        border: 1px solid #ddd;
    }

    .filter-header:hover {
        border-color: #aaa;
    }

    .arrow {
        font-size: 12px;
        transition: transform 0.2s;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        min-width: 200px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
        z-index: 1;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .filter-column:hover .dropdown-content {
        display: block;
    }

    .filter-column:hover .arrow {
        transform: rotate(180deg);
    }

    .filter-option {
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
    }

    .filter-option:hover {
        background-color: #f5f5f5;
    }

    .filter-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-checkbox input {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .product-filters {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .dropdown-content {
            position: static;
            box-shadow: none;
            width: 100%;
        }
    }
</style>
@section('content')

    <div class="et_pb_section et_pb_section_0 corepepbgimage et_pb_with_background et_section_regular">
        <span class="et_pb_background_pattern"></span>
        <div class="et_pb_row et_pb_row_0">
            <div class="et_pb_column et_pb_column_1_2 et_pb_column_0  et_pb_css_mix_blend_mode_passthrough">
                <div
                    class="et_pb_module et_pb_text et_pb_text_0 gradient-overlay-home-banner  et_pb_text_align_left et_pb_bg_layout_light">
                    <div class="et_pb_text_inner">
                        <h1 style="font-size: 4.5rem !important;">Research Peptides For Sale</h1>
                    </div>
                </div>

            </div>
            <div class="et_pb_column et_pb_column_1_2 et_pb_column_1  et_pb_css_mix_blend_mode_passthrough et-last-child">
                <div class="et_pb_module et_pb_image et_pb_image_0">
                    <span class="et_pb_image_wrap "><img src="{{ asset('assets/images/home/home-pt.webp') }}"
                            class="wp-image-84149" /></span>
                </div>
            </div>
        </div>
    </div>


    <section class="container-fluid">
        <div class="product-filters">
            <!-- Price Filter -->
            <div class="filter-column">
                <div class="filter-header">
                    <span>Price</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="dropdown-content">
                    <div class="filter-option">$0 - $50</div>
                    <div class="filter-option">$50 - $100</div>
                    <div class="filter-option">$100 - $200</div>
                    <div class="filter-option">$200+</div>
                </div>
            </div>

            <!-- Categories Filter -->
            <div class="filter-column">
                <div class="filter-header">
                    <span>Categories</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="dropdown-content">
                    <div class="filter-option">✔ Peptides (97)</div>
                    <div class="filter-option">Blends (13)</div>
                    <div class="filter-option">Vitamins (24)</div>
                    <div class="filter-option">Minerals (8)</div>
                </div>
            </div>

            <!-- On Sale Filter -->
            <div class="filter-checkbox">
                <input type="checkbox" id="on-sale">
                <label for="on-sale">On Sale</label>
            </div>

            <!-- In Stock Filter -->
            <div class="filter-checkbox">
                <input type="checkbox" id="in-stock">
                <label for="in-stock">In Stock</label>
            </div>
        </div>
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

        <div class="container">
            
            <!-- Products Grid (4 per row) -->
            <div class="row px-5">
                @foreach ($products as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 mb-5">
                    <x-product.product :product="$product" />
                </div>
                @endforeach
                
            </div>

        </div>
    </section>
    @push('scripts')
    @endpush
@endsection
