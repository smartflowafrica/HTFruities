@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Home') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('meta')
    <meta property="og:title" content="{{ getSetting('system_title') }} - Fresh & Organic" />
    <meta property="og:description" content="Order fresh customized parfaits, organic fruits, and healthy juices delivered to your doorstep." />
    <meta property="og:image" content="{{ uploadedAsset(getSetting('global_meta_image')) }}" />
    <meta property="og:url" content="{{ route('home') }}" />
    <meta property="og:type" content="website" />
@endsection

@section('contents')
    {{--
        ORIGINAL DEFAULT ORDER (for reverting):
        hero → category → featuredProducts → trendingProducts → banners
        → bestDeals → bannersTwo → feedback → products → customProductsSection → blogs
    --}}

    <!--hero section start-->
    @include('frontend.default.pages.partials.home.hero')
    <!--hero section end-->

    <!--stats section start-->
    @include('frontend.default.pages.partials.home.stats')
    <!--stats section end-->

    <!--featured products start-->
    @include('frontend.default.pages.partials.home.featuredProducts')
    <!--featured products end-->

    <!--category section start-->
    @include('frontend.default.pages.partials.home.category')
    <!--category section end-->

    <!--feedback section start-->
    @include('frontend.default.pages.partials.home.feedback')
    <!--feedback section end-->

    <!--trending products start-->
    @include('frontend.default.pages.partials.home.trendingProducts')
    <!--trending products end-->

    <!--banner section start-->
    @include('frontend.default.pages.partials.home.banners')
    <!--banner section end-->

    <!--best deals section start-->
    @include('frontend.default.pages.partials.home.bestDeals')
    <!--best deals section end-->

    <!--products listing start-->
    @include('frontend.default.pages.partials.home.products')
    <!--products listing end-->

    @if (getSetting('enable_custom_product_section') == 1)
        <!-- start -->
        @include('frontend.default.pages.partials.home.customProductsSection')
        <!-- end -->
    @endif

    {{-- DISABLED: Banner 2 (redundant with Banner 1) --}}
    {{-- @include('frontend.default.pages.partials.home.bannersTwo') --}}

    {{-- DISABLED: Blogs (enable when blog content is active) --}}
    {{-- @include('frontend.default.pages.partials.home.blogs', ['blogs' => $blogs]) --}}
@endsection



