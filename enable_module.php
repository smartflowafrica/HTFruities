<?php

use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

try {
    DB::table('enmart_modules')->updateOrInsert(
        ['name' => 'PaymentGateway'],
        [
            'is_default' => 1,
            'is_paid' => 0,
            'is_verified' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]
    );
    echo "PaymentGateway module enabled in database.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
