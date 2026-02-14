<?php

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Str;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

try {
    // 1. Get or Create Shop ID (Raw SQL)
    $shop = DB::table('shops')->first();
    if (!$shop) {
        echo "No shop found. Creating Default Shop...\n";
        $shopId = DB::table('shops')->insertGetId([
            'user_id' => 1,
            'name' => 'Default Shop',
            'slug' => 'default-shop',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    } else {
        $shopId = $shop->id;
    }

    // 2. Get Unit ID (Optional)
    $unit = DB::table('units')->first();
    $unitId = $unit ? $unit->id : null;
    
    // Create unit if null
    if (!$unitId) {
         $unitId = DB::table('units')->insertGetId([
            'name' => 'Piece',
            'slug' => 'pc',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // 3. Get Brand ID (Optional)
    $brand = DB::table('brands')->first();
    $brandId = $brand ? $brand->id : null;

    // 4. Create Product (Raw SQL)
    // Check if exists first
    $existing = DB::table('products')->where('slug', 'custom-parfait')->first();
    
    if ($existing) {
        $productId = $existing->id;
        echo "Product already exists. ID: $productId\n";
    } else {
        $productId = DB::table('products')->insertGetId([
            'name' => 'Custom Parfait',
            'slug' => 'custom-parfait',
            'shop_id' => $shopId,
            'unit_id' => $unitId,
            'brand_id' => $brandId,
            'short_description' => 'Build your own parfait!',
            'description' => 'Custom Parfait created via builder.',
            'min_price' => 0,
            'max_price' => 0,
            'stock_qty' => 1000,
            'has_variation' => 1,
            'is_published' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "Created Product ID: $productId\n";
    }

    // 5. Create Default Variation (Raw SQL)
    $varCount = DB::table('product_variations')->where('product_id', $productId)->count();
    
    if ($varCount == 0) {
        $variationId = DB::table('product_variations')->insertGetId([
            'product_id' => $productId,
            'sku' => 'PARFAIT-CUSTOM-' . time(),
            'price' => 0,
            // 'stock_qty' => 1000, // Column does not exist in migration!
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "Created Variation ID: $variationId\n";
    } else {
        echo "Variation exists.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
