<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
        $cuss = Customer::get();
        return view('admin.reqSale' , compact('prods' , 'cuss'));
    }

    public function listUser(){
        $customers = Customer::get();
        return view('admin.list_user' , compact('customers'));
    }

    public function addUser($id=null){

        $editCus = null;
        if($id){
            $editCus = Customer::find($id);
        }
        return view('admin.add_user' , compact('editCus'));
    }

    public function addUserPost(Request $req){
        if($req->customer_id){
            $customer = Customer::where('id' , $req->customer_id)->first();
        }else{
            $customer = new Customer();
        }

        $customer->name = $req->name;
        $customer->phone = $req->phone;
        $customer->address = $req->address;
        $customer->save();
        
        if($req->customer_id){
             return redirect('/admin/user/list')->with('message' , 'مشتری با موفقیت ویرایش شد!');
        }else{
             return redirect('/admin/user/add/{id}')->with('message' , 'مشتری با موفقیت اضافه شد!');
        }
    }

    public function addUserDelete($id){
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->back()->with('message' , 'مشتری با موفیقت حذف شد!');
    }

    public function getCustomerInfo($id){
    $customer = Customer::find($id);

    if ($customer) {
        return response()->json([
            'phone' => $customer->phone ?? '',
            'address' => $customer->address ?? '',
        ]);
    }

    return response()->json([
        'phone' => '',
        'address' => '',
    ]);
    }

}
