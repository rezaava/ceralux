<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use App\Models\size_product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products($size)
    {
        $sizeObj = Size::where('name', $size)->firstOrFail(); // اگر سایز پیدا نشد 404 می‌دهد

        $productIds = size_product::where('size_id', $sizeObj->id)->pluck('product_id');
        $filtered_products = Product::whereIn('id', $productIds)->get();

        return view('products.index', compact('size', 'filtered_products'));
    }

    public function productsindex()
    {
        return redirect('/catalogs');
    }

    public function catalogs()
    {
        return view('catalogs');
    }

    public function productinfo($id)
    {
        $product = Product::findOrFail($id); // اگر محصول پیدا نشد 404 می‌دهد
        return view('products.info', compact('product'));
    }
}
