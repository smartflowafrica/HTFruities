<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Deliverymen\DeliverymenController;

# deliveryman crud
Route::get('/', [DeliverymenController::class, 'index'])->name('admin.deliverymen.index');
Route::get('/add-delivery-man', [DeliverymenController::class, 'create'])->name('admin.deliverymen.create');
Route::post('/add-delivery-man', [DeliverymenController::class, 'store'])->name('admin.deliverymen.store');
Route::get('/update-delivery-man/{id}', [DeliverymenController::class, 'edit'])->name('admin.deliverymen.edit');
Route::post('/update-delivery-man/{id}', [DeliverymenController::class, 'update'])->name('admin.deliverymen.update');
Route::get('/delete-delivery-man/{id}', [DeliverymenController::class, 'delete'])->name('admin.deliverymen.delete');

Route::get('/delivery-man/cancel-request', [DeliverymenController::class, 'cancelRequest'])->name('admin.deliverymen.cancel-request');

Route::get('payout-history', [DeliverymenController::class, 'payoutHistory'])->name('admin.deliverymen.payout.history');

Route::post('payout-request-accept/{payout}', [DeliverymenController::class, 'acceptPayout'])->name('admin.deliverymen.payout.accept');
Route::post('payout-request-reject/{payout}', [DeliverymenController::class, 'rejectPayout'])->name('admin.deliverymen.payout.reject');

Route::get('deliverman-configuraton', [DeliverymenController::class, 'configuration'])->name('admin.deliveryman.config');
Route::post('deliverman-configuraton', [DeliverymenController::class, 'configurationUpdate']);

Route::get('payroll-list', [DeliverymenController::class, 'payrollList'])->name('admin.deliveryman.payroll.list');
Route::get('generate-payroll', [DeliverymenController::class, 'payroll'])->name('admin.deliveryman.payroll');

Route::get('payroll/edit/{payroll}', [DeliverymenController::class, 'payrollEdit'])->name('admin.deliveryman.payroll.edit');
Route::post('payroll/edit/{payroll}', [DeliverymenController::class, 'payrollUpdate']);

Route::post('payroll/change-status', [DeliverymenController::class, 'payrollChangeStatus'])->name('admin.deliveryman.payroll.changeStatus');

Route::post('generate-payroll', [DeliverymenController::class, 'payrollStore']);
Route::get('get-salary', [DeliverymenController::class, 'getSalary'])->name('admin.deliveryman.get-salary');
