<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CRMController extends Controller
{
    //
    public function addProd(){
        $prods = Product::get();
        return view('admin.addProd' , compact('prods'));
    }

    public function addProdPost(Request $req){
        $prod = Product::where('id' , $req->prod_id)->first();
        $prod->count_box = $prod->count_box + $req->box;
        // $prod->count_meter = $prod->count_meter + $req->meter;
        $prod->count_palet = $prod->count_palet + $req->palet;
        $prod->count_all = $prod->count_all + $req->all;
        $prod->save();
        return redirect()->back()->with('message' , 'افزایش محصول با موفقیت انجام  شد!');
    }

    public function reqProd(){
        $prods = Product::get();
        return view('admin.reqProd' , compact('prods'));
    }

    public function reqSale(){
        $prods = Product::get();
        return view('admin.reqSale' , compact('prods'));
    }
}
