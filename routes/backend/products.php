<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Products\TaxesController;
use App\Http\Controllers\Backend\Products\UnitsController;
use App\Http\Controllers\Backend\Products\BrandsController;
use App\Http\Controllers\Backend\Products\ProductsController;
use App\Http\Controllers\Backend\Products\CategoriesController;
use App\Http\Controllers\Backend\Products\VariationsController;
use App\Http\Controllers\Backend\Products\VariationValuesController;

# products
Route::get('/', [ProductsController::class, 'index'])->name('admin.products.index');
Route::get('/add-product', [ProductsController::class, 'create'])->name('admin.products.create');
Route::post('/product', [ProductsController::class, 'store'])->name('admin.products.store');
Route::get('/update-product/{id}', [ProductsController::class, 'edit'])->name('admin.products.edit');
Route::post('/update-product', [ProductsController::class, 'update'])->name('admin.products.update');
Route::post('/update-featured-product', [ProductsController::class, 'updateFeatured'])->name('admin.products.updateFeatureStatus');
Route::post('/update-published-product', [ProductsController::class, 'updatePublishedStatus'])->name('admin.products.updatePublishedStatus');

Route::post('/update-is-featured-product', [ProductsController::class, 'updateIsFeatured'])
    ->name('admin.products.isFeatured');

Route::post('/delete-all-products', [ProductsController::class, 'deleteAll'])->name('admin.products.deleteAll');
Route::get('/delete-product/{id}', [ProductsController::class, 'delete'])->name('admin.products.delete');
Route::get('products/export/', [ProductsController::class, 'export'])->name('admin.products.export');
Route::post('products/import/', [ProductsController::class, 'import'])->name('admin.products.import');

# categories
Route::get('/category', [CategoriesController::class, 'index'])->name('admin.categories.index');
Route::get('/add-category', [CategoriesController::class, 'create'])->name('admin.categories.create');
Route::post('/category', [CategoriesController::class, 'store'])->name('admin.categories.store');
Route::get('/update-category/{id}', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
Route::post('/update-category', [CategoriesController::class, 'update'])->name('admin.categories.update');
Route::post('/update-feature-category', [CategoriesController::class, 'updateFeatured'])->name('admin.categories.updateFeatureStatus');
Route::post('/update-top-category', [CategoriesController::class, 'updateTop'])->name('admin.categories.updateTopStatus');
Route::get('/products/delete-category/{id}', [CategoriesController::class, 'delete'])->name('admin.categories.delete');

# variations
Route::get('/variations', [VariationsController::class, 'index'])->name('admin.variations.index');
Route::post('/variation', [VariationsController::class, 'store'])->name('admin.variations.store');
Route::get('/variations/edit/{id}', [VariationsController::class, 'edit'])->name('admin.variations.edit');
Route::post('/variations/update', [VariationsController::class, 'update'])->name('admin.variations.update');
Route::post('/variations/update-status', [VariationsController::class, 'updateStatus'])->name('admin.variations.updateStatus');
Route::get('/variations/delete/{id}', [VariationsController::class, 'delete'])->name('admin.variations.delete');

# variation values
Route::get('/variations/{id}', [VariationValuesController::class, 'index'])->name('admin.variationValues.index');
Route::post('/variation-values', [VariationValuesController::class, 'store'])->name('admin.variationValues.store');
Route::get('/variations-values/edit/{id}', [VariationValuesController::class, 'edit'])->name('admin.variationValues.edit');
Route::post('/variations-values/update', [VariationValuesController::class, 'update'])->name('admin.variationValues.update');
Route::post('/variations-values/update-status', [VariationValuesController::class, 'updateStatus'])->name('admin.variationValues.updateStatus');
Route::get('/variations-values/delete/{id}', [VariationValuesController::class, 'delete'])->name('admin.variationValues.delete');

# brands
Route::get('/brands', [BrandsController::class, 'index'])->name('admin.brands.index');
Route::post('/brand', [BrandsController::class, 'store'])->name('admin.brands.store');
Route::get('/brands/edit/{id}', [BrandsController::class, 'edit'])->name('admin.brands.edit');
Route::post('/brands/update-brand', [BrandsController::class, 'update'])->name('admin.brands.update');
Route::post('/brands/update-status', [BrandsController::class, 'updateStatus'])->name('admin.brands.updateStatus');
Route::get('/brands/delete/{id}', [BrandsController::class, 'delete'])->name('admin.brands.delete');

# units
Route::get('/units', [UnitsController::class, 'index'])->name('admin.units.index');
Route::post('/unit', [UnitsController::class, 'store'])->name('admin.units.store');
Route::get('/units/edit/{id}', [UnitsController::class, 'edit'])->name('admin.units.edit');
Route::post('/units/update-unit', [UnitsController::class, 'update'])->name('admin.units.update');
Route::post('/units/update-status', [UnitsController::class, 'updateStatus'])->name('admin.units.updateStatus');
Route::get('/units/delete/{id}', [UnitsController::class, 'delete'])->name('admin.units.delete');

# taxes
Route::get('/taxes', [TaxesController::class, 'index'])->name('admin.taxes.index');
Route::post('/tax', [TaxesController::class, 'store'])->name('admin.taxes.store');
Route::get('/taxes/edit/{id}', [TaxesController::class, 'edit'])->name('admin.taxes.edit');
Route::post('/taxes/update', [TaxesController::class, 'update'])->name('admin.taxes.update');
Route::post('/taxes/update-status', [TaxesController::class, 'updateStatus'])->name('admin.taxes.updateStatus');
Route::get('/taxes/delete/{id}', [TaxesController::class, 'delete'])->name('admin.taxes.delete');
