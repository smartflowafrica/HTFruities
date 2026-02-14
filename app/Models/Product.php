<?php

namespace App\Models;

use App\Scopes\ThemeCategoryScope;
use App\Scopes\ThemeProductScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id', 'added_by', 'name', 'slug', 'brand_id', 'unit_id',
        'thumbnail_image', 'gallery_images', 'product_tags',
        'short_description', 'description',
        'price', 'min_price', 'max_price',
        'discount_value', 'discount_type', 'discount_start_date', 'discount_end_date',
        'sell_target', 'stock_qty',
        'is_published', 'is_featured', 'is_trending',
        'min_purchase_qty', 'max_purchase_qty',
        'has_variation', 'has_warranty',
        'total_sale_count',
        'standard_delivery_hours', 'express_delivery_hours',
        'size_guide', 'meta_title', 'meta_description', 'meta_img',
        'reward_points', 'vedio_link',
        'created_by', 'updated_by', 'is_import',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ThemeProductScope);
    }

    public function scopeShop($query)
    {
        return $query->where('shop_id', getMyShopId());
    }

    public function scopeIsPublished($query)
    {
        return $query->where('is_published', 1);
    }

    public function scopeSlug($query, $value)
    {
        return $query->where('slug', $value);
    }

    protected $with = ['product_localizations', 'themes'];

    public function product_localizations()
    {
        return $this->hasMany(ProductLocalization::class);
    }

    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key ==  '' ? app()->getLocale() : $lang_key;
        $product_localizations = $this->product_localizations->where('lang_key', $lang_key)->first();
        return $product_localizations != null && $product_localizations->$entity ? $product_localizations->$entity : $this->$entity;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id')->withoutGlobalScope(ThemeCategoryScope::class);
    }

    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function variation_combinations()
    {
        return $this->hasMany(ProductVariationCombination::class);
    }
    public function without_variation_combinations()
    {
        $withoutVariationIds  = Variation::pluck('id')->toArray();
        return $this->hasMany(ProductVariationCombination::class)->whereIn('variation_id',$withoutVariationIds);
    }

    public function taxes()
    {
        return $this->hasMany(ProductTax::class);
    }

    public function product_taxes()
    {
        return $this->belongsToMany(Tax::class, 'product_taxes', 'product_id', 'tax_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

    public function themes()
    {
        return $this->belongsToMany(Theme::class, 'product_themes', 'product_id', 'theme_id');
    }

    public function carts()
    {
        return $this->hasManyThrough(Cart::class, ProductVariation::class, 'product_id', 'product_variation_id', 'id', 'id');
    }

    public function scopeFilters($q)
    {
        // if (!empty($filters['is_new_arrival'])) {            
        //     return $q->latest()->take(1);
        // }

        // if (!empty($filters['is_trending'])) {
        //     return $q->inRandomOrder()->take(2);
        // }

        // if (!empty($filters['is_best_selling'])) {
        //     return $q->orderBy('total_sale_count', 'DESC')->take(3);
        // }

        return $q;
    }

}
