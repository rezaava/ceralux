<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use App\Models\Product_Image;
use App\Models\Size;
use App\Models\size_product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products($size_id)
    {
        $sizes = Size::get();
        $nameSize = Size::where('id', $size_id)->first();

        $size_prods = size_product::where('size_id', $nameSize->id)->pluck('product_id');

        $prods =  Product::whereIn('id', $size_prods)->get();
        foreach($prods as $prod){
            $img = Product_Image::where('product_id' , $prod->id)->where('type' , 1)->first();
            $prod['img'] = $img;
        }

        //return $prods;
        return view('products.index', compact('sizes', 'nameSize', 'prods'));
    }

    public function productsindex()
    {
        return redirect('/catalogs');
    }

    public function catalogs()
    {
        $sizes = Size::get();
        return view('catalogs', compact('sizes'));
    }

    public function productinfo($size_id, $id)
    {

        $size_prods = size_product::where('product_id', $id)->get();

        foreach ($size_prods as $size_prod) {
            $sizes2 = Size::where('id', $size_prod->size_id)->first();
            [$width, $height] = explode('x', $sizes2->name);

            $width = (int)$width;
            $height = (int)$height;

            $size_prod['width'] = $width;
            $size_prod['height'] = $height;
            $size_prod['size'] = $sizes2;
        }
       
        $size_prods = $size_prods->unique(function ($item) {
            return $item->width . '-' . $item->height;
        })->values();
        
        $size_prods = $size_prods->sortByDesc(function ($item) {
            return $item->width * $item->height;
        })->values();

        $sizes = Size::get();

        $imgs = Product_Image::where('product_id', $id)->whereBetween('type', [4, 9])->get();
        $imgLeft = Product_Image::where('product_id', $id)->where('type' , 3)->first();
        $imgRight = Product_Image::where('product_id', $id)->where('type' , 2)->first();
        $size = Size::where('id', $size_id)->first();
        
        $product = Product::findOrFail($id); // اگر محصول پیدا نشد 404 می‌دهد
        return view('products.info', compact('product', 'size_prods', 'imgs', 'size', 'sizes' , 'imgLeft' , 'imgRight'));
    }

    public function showImg($id)
    {
        $prod = Product::where('id', $id)->first();
        $imgs = Product_Image::where('product_id', $id)->get();
        return view('admin.add_image', compact('prod', 'imgs'));
    }
    public function addImg(Request $req , $prod_id)
    {

        $img = new Product_Image();
        $img->product_id = $prod_id;

        if ($req->hasFile('img')) {

            $file= $req->file('img');
            $file_name=time() . "." . $file->getClientOriginalExtension();
            $destination_path='files/img';
            $file->move($destination_path, $file_name);
            $img->img_url=$destination_path. '/' .$file_name;
        }
        $img->save();
        return redirect()->back();
    }
    public function deleteImg($id)
    {
        $img = Product_Image::findOrFail($id);

        $img->delete();

        return redirect()->back()->with('success', 'عکس با موفقیت حذف شد.');
    }
}
