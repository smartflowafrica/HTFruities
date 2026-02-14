<section class="pt-8 pb-100 bg-white position-relative overflow-hidden z-1 trending-products-area">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/garlic.png') }}" alt="garlic"
        class="position-absolute garlic z--1" data-parallax='{"y": 100}'>
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/carrot.png') }}" alt="carrot"
        class="position-absolute carrot z--1" data-parallax='{"y": -100}'>
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/mashrom.png') }}" alt="mashrom"
        class="position-absolute mashrom z--1" data-parallax='{"x": 100}'>
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-xl-5">
                <div class="section-title text-center text-xl-start">
                    <h3 class="mb-0">{{ localize('Our Collection') }}</h3>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="text-center text-xl-end mt-4 mt-xl-0">
                    <a href="{{ route('products.index') }}" class="explore-btn text-secondary fw-bold">
                        {{ localize('View All Products') }}
                        <span class="ms-2"><i class="fas fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center g-4 mt-5">

            @php
                // Fetch latest 12 published items
                $products = \App\Models\Product::isPublished()->latest()->take(12)->get();
            @endphp

            @foreach ($products as $product)
                <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6">
                    @include('frontend.default.pages.partials.products.trending-product-card', [
                        'product' => $product,
                    ])
                </div>
            @endforeach
        </div>
    </div>
</section>
