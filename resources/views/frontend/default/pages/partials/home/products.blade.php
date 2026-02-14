<section class="pt-80 pb-100">
    <div class="container">
        <div class="row justify-content-center justify-content-xl-between g-4">
            <div class="col-xl-12">
                <div class="row g-4">
                    {{-- <div class="col-lg-6">
                        <div class="product-listing-box bg-white rounded-2">
                            <div class="d-flex align-items-center justify-content-between gap-3 mb-5 flex-wrap">
                                <h4 class="mb-0">{{ localize('New Products') }}</h4>
                                <a href="{{ route('products.index') }}"
                                    class="explore-btn text-secondary fw-bold">{{ localize('View More') }}<span
                                        class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                            </div>

                            @foreach (\App\Models\Product::isPublished()->latest()->take(12)->get() as $product)
                                <div class="mb-3">

                                    @include(
                                        'frontend.default.pages.partials.products.horizontal-product-card',
                                        [
                                            'product' => $product,
                                        ]
                                    )
                                </div>
                            @endforeach

                            <div class="mt-4 text-center">
                                <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
                                    {{ localize('View All Products') }}
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-12">
                        <div class="product-listing-box bg-white rounded-2 p-4">
                            <div class="d-flex align-items-center justify-content-between gap-3 mb-5 flex-wrap">
                                <h4 class="mb-0">{{ localize('Best Selling') }}</h4>
                                <a href="{{ route('products.index') }}"
                                    class="explore-btn text-secondary fw-bold">{{ localize('All Products') }}<span
                                        class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                            </div>
                            @php
                                $best_selling_products = getSetting('best_selling_products') != null ? json_decode(getSetting('best_selling_products')) : [];
                                $products = \App\Models\Product::whereIn('id', $best_selling_products)->get();
                            @endphp

                            <div class="row g-4 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-1">
                                @foreach ($products as $product)
                                    <div class="col">
                                        @include(
                                            'frontend.default.pages.partials.products.vertical-product-card',
                                            [
                                                'product' => $product,
                                            ]
                                        )
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-5 text-center">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                                    {{ localize('View All Best Selling') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-3 d-none d-xl-block">
                <a href="{{ getSetting('best_selling_banner_link') }}" class=""><img
                        src="{{ uploadedAsset(getSetting('best_selling_banner')) }}" alt=""
                        class="img-fluid rounded-2 d-flex flex-column h-100 object-fit-cover"></a>
            </div> --}}
        </div>
    </div>
</section>
