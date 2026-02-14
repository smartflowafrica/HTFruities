<?php

use Illuminate\Support\Facades\DB;
use App\Models\SystemSetting;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

try {
    // Enable COD
    SystemSetting::updateOrCreate(['entity' => 'enable_cod'], ['value' => 1]);

    // Disable Wallet (optional, but requested "only paystack and cod")
    SystemSetting::updateOrCreate(['entity' => 'enable_wallet_checkout'], ['value' => 0]);

    echo "System settings updated: COD enabled, Wallet disabled.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
