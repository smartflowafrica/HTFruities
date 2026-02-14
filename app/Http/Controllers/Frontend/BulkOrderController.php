<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Auth;

class BulkOrderController extends Controller
{
    # bulk order page
    public function index(Request $request)
    {
        $searchKey = null;
        $products = Product::isPublished();

        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->category_id && $request->category_id != null) {
            $product_category_product_ids = \App\Models\ProductCategory::where('category_id', $request->category_id)->pluck('product_id');
            $products = $products->whereIn('id', $product_category_product_ids);
        }

        $products = $products->latest()->paginate(50);

        $categories = \App\Models\Category::all();

        return view('frontend.default.pages.bulkOrder.index', [
            'products'   => $products,
            'searchKey'  => $searchKey,
            'categories' => $categories,
        ]);
    }

    # bulk add to cart
    public function bulkAddToCart(Request $request)
    {
        $items = $request->items;
        session(['is_bulk_order' => true]);

        if (empty($items) || !is_array($items)) {
            return response()->json([
                'success' => false,
                'message' => localize('No items selected'),
                'alert'   => 'warning',
            ]);
        }

        $addedCount = 0;
        $lastMessage = '';

        foreach ($items as $item) {
            $productVariation = ProductVariation::where('id', $item['product_variation_id'])->first();

            if (is_null($productVariation)) {
                continue;
            }

            $cart = null;
            $quantity = max(1, (int) $item['quantity']);

            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::user()->id)
                    ->where('location_id', session('stock_location_id'))
                    ->where('product_variation_id', $productVariation->id)
                    ->first();
            } else {
                $cart = Cart::where('guest_user_id', (int) $_COOKIE['guest_user_id'])
                    ->where('location_id', session('stock_location_id'))
                    ->where('product_variation_id', $productVariation->id)
                    ->first();
            }

            if (is_null($cart)) {
                $product = $productVariation->product;
                $cart = new Cart;
                $cart->product_variation_id = $productVariation->id;
                $cart->product_id = $product->id;

                if ($quantity > $product->max_purchase_qty) {
                    $cart->qty = (int) $product->max_purchase_qty;
                } else {
                    $cart->qty = $quantity;
                }

                $cart->location_id = session('stock_location_id');

                if (Auth::check()) {
                    $cart->user_id = Auth::user()->id;
                } else {
                    $cart->guest_user_id = (int) $_COOKIE['guest_user_id'];
                }

                $cart->save();
                $addedCount++;
            } else {
                $product = $cart->product_variation->product;
                if ($product->max_purchase_qty > $cart->qty) {
                    $cart->qty += $quantity;
                    if ($cart->qty > $product->max_purchase_qty) {
                        $cart->qty = $product->max_purchase_qty;
                    }
                    $cart->save();
                    $addedCount++;
                }
            }
        }

        // remove coupon
        removeCoupon();

        // get updated cart info
        $carts = null;
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::user()->id)->where('location_id', session('stock_location_id'))->get();
        } else {
            $carts = Cart::where('guest_user_id', (int) $_COOKIE['guest_user_id'])->where('location_id', session('stock_location_id'))->get();
        }

        return [
            'success'        => true,
            'message'        => $addedCount . ' ' . localize('product(s) added to your cart'),
            'alert'          => 'success',
            'carts'          => getRender('pages.partials.carts.cart-listing', ['carts' => $carts]),
            'navCarts'       => getRender('pages.partials.carts.cart-navbar', ['carts' => $carts]),
            'cartCount'      => count($carts),
            'subTotal'       => formatPrice(getSubTotal($carts, false)),
            'couponDiscount' => formatPrice(getCouponDiscount(getSubTotal($carts, false), '')),
        ];
    }
}
