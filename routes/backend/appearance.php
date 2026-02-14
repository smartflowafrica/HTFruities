<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\Appearance\HeroController;
use App\Http\Controllers\Backend\Appearance\FooterController;
use App\Http\Controllers\Backend\Appearance\HeaderController;
use App\Http\Controllers\Backend\Appearance\AboutUsPageController;
use App\Http\Controllers\Backend\Appearance\ProductsPageController;
use App\Http\Controllers\Backend\Appearance\TopCategoriesController;
use App\Http\Controllers\Backend\Appearance\ClientFeedbackController;
use App\Http\Controllers\Backend\Appearance\BannerSectionOneController;
use App\Http\Controllers\Backend\Appearance\BannerSectionTwoController;
use App\Http\Controllers\Backend\Appearance\BestDealProductsController;
use App\Http\Controllers\Backend\Appearance\FeaturedProductsController;
use App\Http\Controllers\Backend\Appearance\BestSellingProductsController;
use App\Http\Controllers\Backend\Appearance\TopTrendingProductsController;
use App\Http\Controllers\Backend\Appearance\ParfaitOptionController;

# parfait settings (Dynamic Options)
Route::get('/homepage/parfait', [ParfaitOptionController::class, 'index'])->name('admin.appearance.parfait.index');
Route::post('/homepage/parfait/store', [ParfaitOptionController::class, 'store'])->name('admin.appearance.parfait.store');
Route::post('/homepage/parfait/update', [ParfaitOptionController::class, 'update'])->name('admin.appearance.parfait.update');
Route::get('/homepage/parfait/delete/{id}', [ParfaitOptionController::class, 'delete'])->name('admin.appearance.parfait.delete');

# homepage - hero
Route::get('/homepage/hero', [HeroController::class, 'hero'])->name('admin.appearance.homepage.hero');
Route::post('/homepage/hero', [HeroController::class, 'storeHero'])->name('admin.appearance.homepage.storeHero');
Route::get('/homepage/hero/edit/{id}', [HeroController::class, 'edit'])->name('admin.appearance.homepage.editHero');
Route::post('/homepage/hero/update', [HeroController::class, 'update'])->name('admin.appearance.homepage.updateHero');
Route::get('/homepage/hero/delete/{id}', [HeroController::class, 'delete'])->name('admin.appearance.homepage.deleteHero');

# homepage - top category
Route::get('/homepage/top-category', [TopCategoriesController::class, 'index'])->name('admin.appearance.homepage.topCategories');

# homepage - featured products
Route::get('/homepage/featured-products', [FeaturedProductsController::class, 'index'])->name('admin.appearance.homepage.featuredProducts');

# homepage - top trending products
Route::get('/homepage/trending-products', [TopTrendingProductsController::class, 'index'])->name('admin.appearance.homepage.topTrendingProducts');
Route::post('/homepage/get-products-for-trending', [TopTrendingProductsController::class, 'getProducts'])->name('admin.appearance.homepage.getProducts');

# homepage - banner section one
Route::get('/homepage/banner-section-one', [BannerSectionOneController::class, 'index'])->name('admin.appearance.homepage.bannerOne');
Route::post('/homepage/banner-section-one', [BannerSectionOneController::class, 'storeBannerOne'])->name('admin.appearance.homepage.storeBannerOne');
Route::get('/homepage/banner-section-one/edit/{id}', [BannerSectionOneController::class, 'edit'])->name('admin.appearance.homepage.editBannerOne');
Route::post('/homepage/banner-section-one/update', [BannerSectionOneController::class, 'update'])->name('admin.appearance.homepage.updateBannerOne');
Route::get('/homepage/banner-section-one/delete/{id}', [BannerSectionOneController::class, 'delete'])->name('admin.appearance.homepage.deleteBannerOne');

# homepage - best deals products
Route::get('/homepage/best-deal-products', [BestDealProductsController::class, 'index'])->name('admin.appearance.homepage.bestDeals');

# homepage - banner section two
Route::get('/homepage/banner-section-two', [BannerSectionTwoController::class, 'index'])->name('admin.appearance.homepage.bannerTwo');

# client feedback
Route::get('/homepage/client-feedback', [ClientFeedbackController::class, 'index'])->name('admin.appearance.homepage.clientFeedback');
Route::post('/homepage/client-feedback', [ClientFeedbackController::class, 'store'])->name('admin.appearance.homepage.storeClientFeedback');
Route::get('/homepage/client-feedback/edit/{id}', [ClientFeedbackController::class, 'edit'])->name('admin.appearance.homepage.editClientFeedback');
Route::post('/homepage/client-feedback/update', [ClientFeedbackController::class, 'update'])->name('admin.appearance.homepage.updateClientFeedback');
Route::get('/homepage/client-feedback/delete/{id}', [ClientFeedbackController::class, 'delete'])->name('admin.appearance.homepage.deleteClientFeedback');

# homepage - best selling products
Route::get('/homepage/best-selling-products', [BestSellingProductsController::class, 'index'])->name('admin.appearance.homepage.bestSelling');

# homepage - custom products section
Route::get('/homepage/custom-products-section', [BestSellingProductsController::class, 'customProductsSection'])->name('admin.appearance.homepage.customProductsSection');

# products - listing
Route::get('/homepage/products', [ProductsPageController::class, 'index'])->name('admin.appearance.products.index');

# products - details
Route::get('/homepage/products-details', [ProductsPageController::class, 'details'])->name('admin.appearance.products.details');
Route::post('/homepage/products-details', [ProductsPageController::class, 'storeWidget'])->name('admin.appearance.products.details.storeWidget');
Route::get('/homepage/products-details/edit/{id}', [ProductsPageController::class, 'edit'])->name('admin.appearance.products.details.editWidget');
Route::post('/homepage/products-details/update', [ProductsPageController::class, 'update'])->name('admin.appearance.products.details.updateWidget');
Route::get('/homepage/products-details/delete/{id}', [ProductsPageController::class, 'delete'])->name('admin.appearance.products.details.deleteWidget');

# about us - intro
Route::get('/about-us', [AboutUsPageController::class, 'index'])->name('admin.appearance.about-us.index');

# about us - popular brands
Route::get('/about-us/popular-brands', [AboutUsPageController::class, 'popularBrands'])->name('admin.appearance.about-us.popularBrands');

# about us - features
Route::get('/about-us/features', [AboutUsPageController::class, 'features'])->name('admin.appearance.about-us.features');
Route::post('/about-us/features', [AboutUsPageController::class, 'storeFeatures'])->name('admin.appearance.about-us.storeFeatures');
Route::get('/about-us/features/edit/{id}', [AboutUsPageController::class, 'edit'])->name('admin.appearance.about-us.editFeatures');
Route::post('/about-us/features/update', [AboutUsPageController::class, 'update'])->name('admin.appearance.about-us.updateFeatures');
Route::get('/about-us/features/delete/{id}', [AboutUsPageController::class, 'delete'])->name('admin.appearance.about-us.deleteFeatures');

# about us - why choose us
Route::get('/about-us/why-choose-us', [AboutUsPageController::class, 'whyChooseUs'])->name('admin.appearance.about-us.whyChooseUs');
Route::post('/about-us/why-choose-us', [AboutUsPageController::class, 'storeWhyChooseUs'])->name('admin.appearance.about-us.storeWhyChooseUs');
Route::get('/about-us/why-choose-us/edit/{id}', [AboutUsPageController::class, 'editWhyChooseUs'])->name('admin.appearance.about-us.editWhyChooseUs');
Route::post('/about-us/why-choose-us/update', [AboutUsPageController::class, 'updateWhyChooseUs'])->name('admin.appearance.about-us.updateWhyChooseUs');
Route::get('/about-us/why-choose-us/delete/{id}', [AboutUsPageController::class, 'deleteWhyChooseUs'])->name('admin.appearance.about-us.deleteWhyChooseUs');

# header
Route::get('/header', [HeaderController::class, 'index'])->name('admin.appearance.header');

# footer
Route::get('/footer', [FooterController::class, 'index'])->name('admin.appearance.footer');

# theme
Route::get('/appearance/theme', [SettingsController::class, 'theme'])->name('admin.appearance.theme');
Route::post('/appearance/theme', [SettingsController::class, 'themeUpdate'])->name('admin.appearance.themeUpdate');

#fonts for invoice
Route::get('/appearance/fonts', [SettingsController::class, 'fonts'])->name('admin.appearance.fonts');
Route::post('/appearance/fonts', [SettingsController::class, 'fontsUpdate']);
