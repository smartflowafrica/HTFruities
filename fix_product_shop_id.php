<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Get valid shop ID
$firstShop = DB::table('shops')->first();
if (!$firstShop) {
    echo "No shops exist! Creating one...\n";
    $shopId = DB::table('shops')->insertGetId([
         'user_id' => 1,
         'name' => 'Default Shop',
         'slug' => 'default-shop',
         'created_at' => now(),
         'updated_at' => now(),
    ]);
} else {
    $shopId = $firstShop->id;
}

echo "Using Shop ID: $shopId\n";

// Update Product
$updated = DB::table('products')->where('id', 53)->update(['shop_id' => $shopId]);

echo "Updated rows: $updated\n";
echo "Done.";
