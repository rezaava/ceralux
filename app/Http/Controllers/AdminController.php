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
        $size->meli = $req->meli_name;
        $size->save();
        return redirect()->back();
    }
    public function productAdd($id = null){

        $editProd = null;

        if($id){
            $editProd = Product::find($id);
        }
        $sizes = Size::get();
        $size_prod = size_product::where('product_id' , $id)->pluck('size_id')->toArray();
        return view('admin.product' , compact('sizes' , 'editProd' , 'size_prod'));
    }
    public function productList(){
        $prods = Product::get();
        foreach($prods as $prod){
            $prod['size_prods'] = size_product::where('product_id' , $prod->id)->pluck('size_id');
        }

        
        return view('admin.list_product' , compact('prods'));
    }

    public function productPost(Request $req){

        if($req->prod_id){
            $prod = Product::where('id' , $req->prod_id)->first();
        }else{
            $prod = new Product();
        }

        
        
        $prod->name = $req->title;
        $prod->desc = $req->desc;
        $prod->price = $req->price;
        $prod->face = $req->face;
        $prod->name_en = $req->titleEn;
        $prod->desc_en = $req->descEn;
        $prod->name_ar = $req->titleAr;
        $prod->desc_ar = $req->descAr;
        $prod->count_box = $req->count_box;
        $prod->count_meter = $req->count_meter;
        $prod->count_palet = $req->count_palet;
        $prod->count_all = $req->count_all;
        $prod->code_prod = $req->code_prod;
        $prod->count_darageh = $req->count_darageh;
        $prod->no_product = $req->no_product;
        $prod->count_paper = $req->count_paper;
        $prod->name_company = $req->name_company;
        $prod->save();

        foreach ($req->sizes as $sizeId) {
            $size_pord = new size_product();

            $size_pord->product_id = $prod->id;
            $size_pord->size_id = $sizeId;
            $size_pord->save();
        }

        if($req->prod_id){
             return redirect('/admin/product/list')->with('message' , 'محصول با موفقیت ویرایش شد!');
        }else{
             return redirect('/admin/product/add/{id}')->with('message' , 'محصول با موفقیت اضافه شد!');
        }
       

    }

    public function deleteProduct($id){
        $prod = Product::find($id);
        $prod->delete();
        return redirect('/admin/product/list')->with('message' , 'محصول با موفقیت حذف شد!');
    }

    public function catalog(){
        return view('admin.catalog');
    }
    public function setting(){
        return view('admin.setting');
    }
}
