<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Orders\OrdersController;
use App\Http\Controllers\Backend\Refunds\RefundsController;
use App\Http\Controllers\Backend\Reports\ReportsController;
use App\Http\Controllers\Backend\Orders\ParfaitOrdersController;

# orders
Route::group(['prefix' => 'orders'], function () {
    Route::get('/', [OrdersController::class, 'index'])->name('admin.orders.index');
    Route::post('/bulk-delete', [OrdersController::class, 'bulkDelete'])->name('admin.orders.bulkDelete');
    Route::get('/parfait', [ParfaitOrdersController::class, 'index'])->name('admin.orders.parfait');
    Route::get('/{id}', [OrdersController::class, 'show'])->name('admin.orders.show');
    Route::post('/assign-deliveryman', [OrdersController::class, 'assignDeliveryman'])->name('admin.orders.assignDeliveryman');
    Route::post('/update-payment-status', [OrdersController::class, 'updatePaymentStatus'])->name('admin.orders.update_payment_status');
    Route::post('/update-delivery-status', [OrdersController::class, 'updateDeliveryStatus'])->name('admin.orders.update_delivery_status');
    Route::get('/invoice-download/{id}', [OrdersController::class, 'downloadInvoice'])->name('admin.orders.downloadInvoice');
    Route::get('/invoice-print/{id}', [OrdersController::class, 'printInvoice'])->name('admin.orders.printInvoice');
});

# refunds
Route::group(['prefix' => 'refunds'], function () {
    Route::get('/', [RefundsController::class, 'configurations'])->name('admin.refund.configurations');
    Route::get('/requests', [RefundsController::class, 'requests'])->name('admin.refund.requests');
    Route::get('/approve/{id}', [RefundsController::class, 'approve'])->name('admin.refund.approve');
    Route::post('/reject/{id}', [RefundsController::class, 'reject'])->name('admin.refund.reject');

    Route::get('/refunded', [RefundsController::class, 'refunded'])->name('admin.refund.refunded');
    Route::get('/rejected', [RefundsController::class, 'rejected'])->name('admin.refund.rejected');
});

# reports
Route::group(['prefix' => 'reports'], function () {
    Route::get('/product-sales', [ReportsController::class, 'index'])->name('admin.reports.sales');
    Route::get('/orders', [ReportsController::class, 'orders'])->name('admin.reports.orders');
    Route::get('/category-wise-sales', [ReportsController::class, 'categoryWise'])->name('admin.reports.categorySales');
    Route::get('/sales-amount-report', [ReportsController::class, 'amountWise'])->name('admin.reports.salesAmount');
    Route::get('/delivery-status-report', [ReportsController::class, 'deliveryStatus'])->name('admin.reports.deliveryStatus');
});
