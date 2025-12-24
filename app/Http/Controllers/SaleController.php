<?php

namespace App\Http\Controllers;

use App\Models\Cart_prod;
use App\Models\Carts;
use App\Models\Customer;
use App\Models\Lpo;
use App\Models\Lpo_Prod;
use App\Models\Product;
use App\Models\Size;
use App\Models\size_product;
use Auth;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    //

    public function getCustomerInfo($id){
        $customer = Customer::find($id);

        if ($customer) {
            return response()->json([
                'phone' => $customer->phone ?? '',
                'address' => $customer->address ?? '',
                'no_customer' => $customer->no_customer ?? '',
            ]);
        }

        return response()->json([
            'phone' => '',
            'address' => '',
            'no_customer' => '',
        ]);
    }

    public function reqSale($id = null){

        $cart_prods = null;
        $order = null;
        $user = null;
        $meter = 0;
        $box = 0;
        $box_num = 0;
        $paper = 0 ; 
        $palet = 0;
        $priceAll = 0;
        $date = null;
        $five = 0;
        $finalPrice = 0;
        $finalOff = 0;
        $subtotal = 0;
        $lpo_prods = null;

        if($id){
            $order = Carts::find($id);
            if ($order) {
                $date = Verta::instance($order->created_at)->format('Y/m/d');
                $user = Customer::where('id' , $order->user_id)->first();
                $cart_prods = Cart_prod::where('card_id' , $order->id)->get();
                foreach($cart_prods as $cart_prod){
                    $prod = Product::where('id' , $cart_prod->prod_id)->first();
                    $cart_prod['prod'] = $prod;
                    $size_prod = size_product::where('id' , $cart_prod->size_prod_id)->first();
                    $size = Size::where('id' , $size_prod->size_id)->first();

                    $cart_prod['size_prod'] = $size_prod;
                    $cart_prod['size'] = $size;
                    
                    $meter = $cart_prod->count_all + $meter;
                    $box = $cart_prod->count_box + $box;
                    $box_num = $cart_prod->count_box_num + $box_num;
                    $paper = $cart_prod->count_paper + $paper;
                    $palet = $cart_prod->count_palet + $palet;
                    $priceAll = $cart_prod->prod->price * ($cart_prod->count_all) - ($cart_prod->prod->price * ($cart_prod->count_all)) * ($cart_prod->off/100) + $priceAll;
                    if($order->no_tax == 1){
                        $five = $priceAll * 0.05;
                    }else{
                        $five = 0;
                    }
                    $subtotal = $priceAll + $five + $order->price_rent; // مجموع قبل از تخفیف
                    $finalOff = $subtotal * ($order->off / 100);        // محاسبه تخفیف از مجموع
                    $finalPrice = $subtotal - $finalOff;  
                }
                
                $lpo = Lpo::where('status' , 1)->where('num_lpo' , $order->num_lpo)->first();
                if($lpo){
                    $lpo_prods = Lpo_Prod::where('lpo_id' , $lpo->id)->get();
                    foreach($lpo_prods as $lpo_prod){
                        $prod = Product::where('id' , $lpo_prod->prod_id)->first();
                        $lpo_prod['prod'] = $prod;
                        $size_prod = size_product::where('id' , $lpo_prod->size_prod_id)->first();
                        $size = Size::where('id' , $size_prod->size_id)->first();
                        $lpo_prod['size_prod'] = $size_prod;
                        $lpo_prod['size'] = $size;

                    }
                }else{
                    //return 'salma';
                    return redirect()->back()->with('error' , 'ابتدا LPO را ثبت کنید، سپس دوباره بازگردید.');
                }

                
                
            }
            
        }
        $prods = Product::get();
        $cuss = Customer::get();
        return view('admin.reqSale' , compact('paper' , 'box_num' , 'lpo_prods' , 'five' , 'finalPrice' , 'prods' , 'cuss' , 'order' , 'user' , 'date' , 'cart_prods' , 'meter' , 'box' , 'palet' , 'priceAll'));
    }

    public function salePost(Request $req){

        $carts = Carts::where('status' , 1)->whereNull('type')->where('num_lpo' , $req->num_lpo)->exists();

        if($carts){
            return redirect()->back()->with('error2' , 'شماره LPO تکرار میباشد و این شماره ثبت شده است.');
        }
        

        $data = $req->all();

        $rule = [
            'customer' => 'required',  
            'num_lpo' => 'required',  
        ];

        $msg = [
            'customer.required' => 'مشتری را انتخاب کنید',
            'num_lpo.required' => 'شماره LPO را وارد کنید',
        ];

        $valid = Validator::make($data, $rule, $msg);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }


        function generateVolunteerCode()
        {
            $number = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            return 'Kh' . $number;
        }

        $cart = new Carts();

        do {
            $code = generateVolunteerCode();
        } while (Carts::where('num_cart', $code)->exists());
        $cart->num_cart = $code;
        $cart->user_id = $req->customer;
        $cart->admin_id = Auth::user()->id;
        $cart->num_lpo = $req->num_lpo;
        $cart->status = '0';
        $cart->save();

        return redirect()->route('reqSale', $cart->id);
    }

    public function productAddPostCart(Request $req){

        foreach ($req->prod_id as $key => $prod_id) {
            $cart_prod = new Cart_prod();
            $cart_prod->prod_id = $prod_id;
            $size_prod = size_product::where('size_id' , $req->size_id[$key])->where('product_id' , $prod_id)->first();
            $cart_prod->size_prod_id = $size_prod->id;
            $cart_prod->card_id = $req->cart_id;
            $cart_prod->count_box = $req->count_box[$key];
            $cart_prod->count_all = $req->count_all[$key];
            $cart_prod->count_paper = $req->count_paper[$key];
            $cart_prod->count_box_num = $req->count_box_num[$key];
            $cart_prod->count_palet = $req->count_palet[$key];
            $cart_prod->off = $req->off[$key] ?? 0;
            $cart_prod->save();
        }
        return redirect()->back()->with('message' , ' محصول با موفقیت اضافه  شد!');
    }

    public function productAddOffCart(Request $req){

        $data = $req->all();

        $rule = [
            'price_rent' => 'required|numeric',  
            'all_off' => 'required|numeric',  
            'no_tax' => 'required',  
        ];

        $msg = [
            'price_rent.required' => 'مبلغ کرایه بار را وارد کنید',
            'all_off.required' => '  تخفیف کل را وارد کنید یا صفر بزنید',
            'no_tax.required' => 'نوع مالیات را انتخاب کنید.',
            'price_rent.numeric' => '  مبلغ کرایه بار را عدد وارد کنید',
            'all_off.numeric' => 'تخفیف کل  را درست وارد کنید',
        ];

        $valid = Validator::make($data, $rule, $msg);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }


        $cart = Carts::find($req->cart_id);
        $cart->off = $req->all_off;
        $cart->price_rent = $req->price_rent;
        $cart->no_tax = $req->no_tax;
        $cart->save();
        return redirect()->back()->with('message' , ' تغییرات  با موفقیت اعمال  شد!');
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
            
            $meter = $cart_prod->count_all + $meter;
            $box = $cart_prod->count_box + $box;
            $palet = $cart_prod->count_palet + $palet;
            $priceAll = $cart_prod->prod->price * ($cart_prod->count_all) - ($cart_prod->prod->price * ($cart_prod->count_all)) * ($cart_prod->off/100) + $priceAll;
        }

        $order->status = '1';
        $order->price = $priceAll;
        $order->count_meters = $meter;
        $order->count_boxs = $box;
        $order->count_palet = $palet;
        $order->save();
        return redirect('/admin/crm/reqSale/{id}')->with('message' , 'فاکتور فروش با موفقیت برای مدیر ارسال شد!');
    }
}
