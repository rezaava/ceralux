<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use App\Models\size_product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products($size_id)
    {
        $sizes = Size::get();
        $nameSize = Size::where('id' , $size_id)->first();

        $size_prods = size_product::where('size_id' , $nameSize->id)->pluck('product_id');

        $prods =  Product::whereIn('id' , $size_prods)->get();
        
        //return $prods;
        return view('products.index', compact('sizes' , 'nameSize' , 'prods'));
    }

    public function productsindex()
    {
        return redirect('/catalogs');
    }

    public function catalogs()
    {
        $sizes = Size::get();
        return view('catalogs' , compact('sizes'));
    }

        public function productinfo($id)
        {
            $sizes = Size::get();
            foreach($sizes as $size){
                [$width, $height] = explode('x', $size->name);

                $size['width'] = $width;
                $size['height'] = $height;
                
            }

            $size_id = size_product::where('product_id' , $id)->first();
            $size = Size::where('id' , $size_id->size_id)->first();
            
            return $size;
            
            $product = Product::findOrFail($id); // اگر محصول پیدا نشد 404 می‌دهد
            return view('products.info', compact('product' , 'sizes'));
        }
}
