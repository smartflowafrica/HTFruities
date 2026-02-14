<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Add 'price' column if not exists
if (!Schema::hasColumn('carts', 'price')) {
    Schema::table('carts', function (Blueprint $table) {
        $table->double('price')->nullable()->default(0)->after('qty');
    });
    echo "Added 'price' column.\n";
} else {
    echo "'price' column already exists.\n";
}

// Add 'data' column if not exists
if (!Schema::hasColumn('carts', 'data')) {
    Schema::table('carts', function (Blueprint $table) {
        $table->text('data')->nullable()->after('price');
    });
    echo "Added 'data' column.\n";
} else {
    echo "'data' column already exists.\n";
}

echo "Done.";
