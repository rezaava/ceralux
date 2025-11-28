<?php

namespace App\Http\Controllers;

use App\Models\Cart_prod;
use App\Models\Carts;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Hekmatinasser\Verta\Verta;
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

    public function reqSale($id = null){

        $cart_prods = null;
        $order = null;
        $user = null;
        $meter = 0;
        $box = 0;
        $palet = 0;
        $priceAll = 0;
        $date = null;

        if($id){
            $order = Carts::find($id);
            if ($order) {
                $date = Verta::instance($order->created_at)->format('Y/m/d');
                $user = Customer::where('id' , $order->user_id)->first();
                $cart_prods = Cart_prod::where('card_id' , $order->id)->get();
                foreach($cart_prods as $cart_prod){
                    $prod = Product::where('id' , $cart_prod->prod_id)->first();
                    $cart_prod['prod'] = $prod;
                    
                    $meter = $cart_prod->count_box * $prod->count_meter + $meter;
                    $box = $cart_prod->count_box + $box;
                    $palet = $cart_prod->count_palet + $palet;
                    $priceAll = ($cart_prod->count_box * $prod->count_meter) * $prod->price + $priceAll;
                }
                
            }
            
        }
        //return $prod;
        $prods = Product::get();
        $cuss = Customer::get();
        return view('admin.reqSale' , compact('prods' , 'cuss' , 'order' , 'user' , 'date' , 'cart_prods' , 'meter' , 'box' , 'palet' , 'priceAll'));
    }

    public function salePost(Request $req){

        function generateVolunteerCode()
        {
            $number = str_pad(mt_rand(0, 99999999), 6, '0', STR_PAD_LEFT);
            return 'Kh' . $number;
        }

        $cart = new Carts();

        do {
            $code = generateVolunteerCode();
        } while (Carts::where('code_cart', $code)->exists());
        $cart->code_cart = $code;
        $cart->user_id = $req->customer;
        $cart->status = '0';
        $cart->num_cart = $req->num_cart;
        $cart->save();

        return redirect()->route('reqSale', $cart->id);
    }

    public function productAddPostCart(Request $req){

        $cart_prod = new Cart_prod();
        $cart_prod->prod_id = $req->product;
        $cart_prod->card_id = $req->cart_id;
        $cart_prod->count_box = $req->count_box;
        // $cart_prod->count_meter = $req->count_meter;
        // $cart_prod->count_all = $req->count_all;
        $cart_prod->count_palet = $req->count_palet;
        $cart_prod->save();
        return redirect()->back()->with('message' , ' محصول با موفقیت اضافه  شد!');
    }

    public function salePayPost(Request $req){

        $meter = 0;
        $box = 0;
        $palet = 0;
        $priceAll = 0;

        $order = Carts::find($req->cart_id);

        $cart_prods = Cart_prod::where('card_id' , $order->id)->get();
        foreach($cart_prods as $cart_prod){
            $prod = Product::where('id' , $cart_prod->prod_id)->first();
            $cart_prod['prod'] = $prod;
            
            $meter = $cart_prod->count_box * $prod->count_meter + $meter;
            $box = $cart_prod->count_box + $box;
            $palet = $cart_prod->count_palet + $palet;
            $priceAll = ($cart_prod->count_box * $prod->count_meter) * $prod->price + $priceAll;
        }

        $order->status = '1';
        $order->price = $priceAll;
        $order->count_meters = $meter;
        $order->count_boxs = $box;
        $order->save();
        return redirect('/admin/crm/reqSale/{id}');
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

    public function listInvocie(){

        return view('admin.list_invocie');
    }

    public function request(){

        return view('admin.request');
    }

}
