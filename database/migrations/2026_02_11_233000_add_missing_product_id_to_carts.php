<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (!Schema::hasColumn('carts', 'product_id')) {
                $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (Schema::hasColumn('carts', 'product_id')) {
                // Drop foreign key first if it exists, tough to know exact name without querying
                // usually carts_product_id_foreign
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
        });
    }
};
