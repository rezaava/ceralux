<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use App\Models\size_product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function dashboard(){
        return view('admin.dashborad');
    }
    public function size(){
        $sizes = Size::get();
        return view('admin.size' , compact('sizes'));
    }
    public function sizePost(Request $req){
        $size = new Size();
        $size->name = $req->size_name;
        $size->save();
        return redirect()->back();
    }
    public function productAdd(){
        $sizes = Size::get();
        return view('admin.product' , compact('sizes'));
    }
    public function productList(){
        $prods = Product::get();
        foreach($prods as $prod){
            $prod['size_prods'] = size_product::where('product_id' , $prod->id)->pluck('size_id');
        }

        
        return view('admin.list_product' , compact('prods'));
    }

    public function productPost(Request $req){

        $prod = new Product();
        
        $prod->name = $req->title;
        $prod->desc = $req->desc;
        $prod->price = $req->price;
        $prod->save();

        foreach ($req->sizes as $sizeId) {
            $size_pord = new size_product();

            $size_pord->product_id = $prod->id;
            $size_pord->size_id = $sizeId;
            $size_pord->save();
        }

        return redirect()->back()->with('message' , 'محصول با موفقیت اضافه شد!');

    }

    public function catalog(){
        return view('admin.catalog');
    }
    public function setting(){
        return view('admin.setting');
    }
}
