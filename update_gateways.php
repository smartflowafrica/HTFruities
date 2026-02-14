<?php

use Illuminate\Support\Facades\DB;
use Modules\PaymentGateway\Entities\PaymentGateway;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

try {
    // Disable all
    PaymentGateway::query()->update(['is_active' => 0, 'is_show' => 0]);

    // Enable Paystack and COD
    PaymentGateway::whereIn('gateway', ['paystack', 'Cash_on_Delivery'])->update(['is_active' => 1, 'is_show' => 1]);

    echo "Payment gateways updated. Only Paystack and COD are active.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
