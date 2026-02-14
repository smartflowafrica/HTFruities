<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

try {
    $product = DB::table('products')->where('id', 53)->first();
    if ($product) {
        echo "Product Found:\n";
        echo "ID: " . $product->id . "\n";
        echo "Name: " . $product->name . "\n";
        echo "Slug: " . $product->slug . "\n";
        echo "Shop ID: " . $product->shop_id . "\n";
        echo "Is Published: " . $product->is_published . "\n";
        // Check soft delete
        echo "Deleted At: " . ($product->deleted_at ?? 'NULL') . "\n";
    } else {
        echo "Product ID 53 NOT FOUND in DB.\n";
    }

    $variation = DB::table('product_variations')->where('product_id', 53)->first();
     if ($variation) {
        echo "Variation Found:\n";
        echo "ID: " . $variation->id . "\n";
    } else {
        echo "Variation NOT FOUND for Product 53.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
