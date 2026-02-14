<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Logistics\CitiesController;
use App\Http\Controllers\Backend\Logistics\StatesController;
use App\Http\Controllers\Backend\Logistics\CountriesController;
use App\Http\Controllers\Backend\Logistics\LogisticsController;
use App\Http\Controllers\Backend\Logistics\LogisticZonesController;

# logistics
Route::get('/', [LogisticsController::class, 'index'])->name('admin.logistics.index');
Route::get('/add-logistic', [LogisticsController::class, 'create'])->name('admin.logistics.create');
Route::post('/add-logistic', [LogisticsController::class, 'store'])->name('admin.logistics.store');
Route::get('/update-logistic/{id}', [LogisticsController::class, 'edit'])->name('admin.logistics.edit');
Route::post('/update-logistic', [LogisticsController::class, 'update'])->name('admin.logistics.update');
Route::post('/update-status', [LogisticsController::class, 'updateStatus'])->name('admin.logistics.updateStatus');
Route::get('/delete-logistic/{id}', [LogisticsController::class, 'delete'])->name('admin.logistics.delete');

# shipping zones
Route::get('/zones', [LogisticZonesController::class, 'index'])->name('admin.logisticZones.index');
Route::get('/add-zone', [LogisticZonesController::class, 'create'])->name('admin.logisticZones.create');
Route::post('/add-zone', [LogisticZonesController::class, 'store'])->name('admin.logisticZones.store');
Route::get('/update-zone/{id}', [LogisticZonesController::class, 'edit'])->name('admin.logisticZones.edit');
Route::post('/update-zone', [LogisticZonesController::class, 'update'])->name('admin.logisticZones.update');
Route::get('/delete-zone/{id}', [LogisticZonesController::class, 'delete'])->name('admin.logisticZones.delete');
Route::post('/logistic-cities', [LogisticZonesController::class, 'getLogisticCities'])->name('admin.logisticZones.getLogisticCities');

# countries
Route::get('/countries', [CountriesController::class, 'index'])->name('admin.countries.index');
Route::post('/update-country-status', [CountriesController::class, 'updateStatus'])->name('admin.countries.updateStatus');

# states
Route::get('/states', [StatesController::class, 'index'])->name('admin.states.index');
Route::get('/add-state', [StatesController::class, 'create'])->name('admin.states.create');
Route::post('/add-state', [StatesController::class, 'store'])->name('admin.states.store');
Route::get('/update-state/{id}', [StatesController::class, 'edit'])->name('admin.states.edit');
Route::post('/update-state', [StatesController::class, 'update'])->name('admin.states.update');
Route::post('/update-state-status', [StatesController::class, 'updateStatus'])->name('admin.states.updateStatus');

# cities
Route::get('/cities', [CitiesController::class, 'index'])->name('admin.cities.index');
Route::get('/add-city', [CitiesController::class, 'create'])->name('admin.cities.create');
Route::post('/add-city', [CitiesController::class, 'store'])->name('admin.cities.store');
Route::get('/update-city/{id}', [CitiesController::class, 'edit'])->name('admin.cities.edit');
Route::post('/update-city', [CitiesController::class, 'update'])->name('admin.cities.update');
Route::post('/update-city-status', [CitiesController::class, 'updateStatus'])->name('admin.cities.updateStatus');
