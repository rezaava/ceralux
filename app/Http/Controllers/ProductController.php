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

        public function productinfo($size_id,$id)
        {
            $sizes = Size::get();
            foreach($sizes as $size){
                [$width, $height] = explode('x', $size->name);

                $size['width'] = $width;
                $size['height'] = $height;
                
            }


            
            $imgs = Product_Image::where('product_id' , $id)->get();
            $size = Size::where('id' , $size_id)->first();
            
            $product = Product::findOrFail($id); // اگر محصول پیدا نشد 404 می‌دهد
            return view('products.info', compact('product' , 'sizes' , 'imgs' , 'size'));
        }

        public function showImg($id){
            $prod = Product::where('id' , $id)->first();
            $imgs = Product_Image::where('product_id' , $id)->get();
            return view('admin.add_image' , compact('prod','imgs'));
        }
        public function addImg(Request $req,$prod_id){
         
            $img =new Product_Image();
            $img->product_id=$prod_id;
            $img->img_name=$req->img_name;
            $img->type=$req->type_img;
            if ($req->hasFile('img_file')) {

                $file = $req->file('img_file');
            
                $file_name = $img->img_name . time() . '.' . $file->getClientOriginalExtension();
            
                $address = 'files/products';
                $file->move(public_path($address), $file_name);
            
                $img->img_url = $address . '/' . $file_name;
            }
            
            $img->save();
            return back();
        }
        public function deleteImg($id)
        {
            $img = Product_Image::findOrFail($id);
        
            $img->delete();
        
            return redirect()->back()->with('success', 'عکس با موفقیت حذف شد.');
        }
        
}
