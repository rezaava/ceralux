<?php

namespace App\Http\Controllers;

use App\Models\Cart_prod;
use App\Models\Carts;
use App\Models\Customer;
use App\Models\Lpo;
use App\Models\Lpo_Prod;
use App\Models\Product;
use App\Models\Request as ModelsRequest;
use App\Models\SubCheck;
use App\Models\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

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
        $paper = 0;
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
                    
                    $meter = $cart_prod->count_box * $prod->count_meter + $meter;
                    $box = $cart_prod->count_box + $box;
                    $palet = $cart_prod->count_palet + $palet;
                    $paper = $cart_prod->prod->count_paper + $paper;
                    $priceAll = $cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter) - ($cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter)) * ($cart_prod->off/100) + $priceAll;
                    $five = $priceAll * 0.05;
                    $subtotal = $priceAll + $five + $order->price_rent; // مجموع قبل از تخفیف
                    $finalOff = $subtotal * ($order->off / 100);        // محاسبه تخفیف از مجموع
                    $finalPrice = $subtotal - $finalOff;  
                }

                $lpo = Lpo::where('num_lpo' , $order->num_lpo)->first();
                $lpo_prods = Lpo_Prod::where('lpo_id' , $lpo->id)->get();
                foreach($lpo_prods as $lpo_prod){
                    $prod = Product::where('id' , $lpo_prod->prod_id)->first();
                    $lpo_prod['prod'] = $prod;
                }
                
                
            }
            
        }
        $prods = Product::get();
        $cuss = Customer::get();
        return view('admin.reqSale' , compact('lpo_prods' , 'five' , 'finalPrice' , 'paper' , 'prods' , 'cuss' , 'order' , 'user' , 'date' , 'cart_prods' , 'meter' , 'box' , 'palet' , 'priceAll'));
    }

    public function salePost(Request $req){

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
        $cart->num_lpo = $req->num_lpo;
        $cart->status = '0';
        $cart->save();

        return redirect()->route('reqSale', $cart->id);
    }

    public function productAddPostCart(Request $req){

        // $data = $req->all();

        // $rule = [
        //     'product' => 'required',  
        //     'count_box' => 'required|numeric',  
        //     'count_palet' => 'nullable|numeric',  
        //     'off' => 'nullable|numeric',  
        // ];

        // $msg = [
        //     'product.required' => 'طرح را انتخاب کنید',
        //     'count_box.required' => 'تعداد کارتن را وارد کنید',
        //     // 'count_palet.required' => 'تعداد پالت را وارد کنید',

        //     'count_box.numeric' => 'تعداد کارتن را عدد وارد کنید',
        //     'count_palet.numeric' => 'تعداد پالت را عدد وارد کنید',
        //     'count_palet.numeric' => 'لطفا تخفیف  را درست وارد کنید',
        // ];

        // $valid = Validator::make($data, $rule, $msg);

        // if ($valid->fails()) {
        //     return redirect()->back()->withErrors($valid)->withInput();
        // }

        

        foreach ($req->prod_id as $key => $prod_id) {
            $cart_prod = new Cart_prod();
            $cart_prod->prod_id = $prod_id;
            $cart_prod->card_id = $req->cart_id;
            $cart_prod->count_box = $req->count_box[$key];
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
            'all_off' => 'nullable|numeric',  
        ];

        $msg = [
            'price_rent.required' => 'مبلغ کرایه بار را وارد کنید',
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
            
            $meter = $cart_prod->count_box * $prod->count_meter + $meter;
            $box = $cart_prod->count_box + $box;
            $palet = $cart_prod->count_palet + $palet;
            $priceAll = $cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter) - ($cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter)) * ($cart_prod->off/100) + $priceAll;
        }

        $order->status = '1';
        $order->price = $priceAll;
        $order->count_meters = $meter;
        $order->count_boxs = $box;
        $order->count_palet = $palet;
        $order->save();
        return redirect('/admin/crm/reqSale/{id}')->with('message' , 'فاکتور با موفقیت ثبت شد!');
    }

    public function reqSaleF($id = null){

        $cart_prods = null;
        $order = null;
        $user = null;
        $meter = 0;
        $box = 0;
        $palet = 0;
        $paper = 0;
        $priceAll = 0;
        $date = null;
        $five = 0;
        $finalPrice = 0;
        $finalOff = 0;
        $subtotal = 0;

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
                    $paper = $cart_prod->prod->count_paper + $paper;
                    $priceAll = $cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter) - ($cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter)) * ($cart_prod->off/100) + $priceAll;
                    $five = $priceAll * 0.05;
                    $subtotal = $priceAll + $five + $order->price_rent; // مجموع قبل از تخفیف
                    $finalOff = $subtotal * ($order->off / 100);        // محاسبه تخفیف از مجموع
                    $finalPrice = $subtotal - $finalOff;  
                }
                 
            }
            
        }
        $prods = Product::get();
        $cuss = Customer::get();
        return view('admin.reqSaleF' , compact('five' , 'finalPrice' , 'paper' , 'prods' , 'cuss' , 'order' , 'user' , 'date' , 'cart_prods' , 'meter' , 'box' , 'palet' , 'priceAll'));
    }

    public function salePostF(Request $req){

        $data = $req->all();

        $rule = [
            'customer' => 'required',  
        ];

        $msg = [
            'customer.required' => 'مشتری را انتخاب کنید',
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
        $cart->status = '0';
        $cart->save();

        return redirect()->route('reqSalef', $cart->id);
    }

    public function productAddPostCartF(Request $req){

        $data = $req->all();

        $rule = [
            'prod_id' => 'required',  
            'count_box' => 'required|numeric',  
            'count_palet' => 'nullable|numeric',  
            'off' => 'nullable|numeric',  
        ];

        $msg = [
            'prod_id.required' => 'طرح را انتخاب کنید',
            'count_box.required' => 'تعداد کارتن را وارد کنید',
            // 'count_palet.required' => 'تعداد پالت را وارد کنید',

            'count_box.numeric' => 'تعداد کارتن را عدد وارد کنید',
            'count_palet.numeric' => 'تعداد پالت را عدد وارد کنید',
            'count_palet.numeric' => 'لطفا تخفیف  را درست وارد کنید',
        ];

        $valid = Validator::make($data, $rule, $msg);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        
        $cart_prod = new Cart_prod();
        $cart_prod->prod_id = $req->prod_id;
        $cart_prod->card_id = $req->cart_id;
        $cart_prod->count_box = $req->count_box;
        $cart_prod->count_palet = $req->count_palet;
        $cart_prod->off = $req->off;
        $cart_prod->save();
        
        return redirect()->back()->with('message' , ' محصول با موفقیت اضافه  شد!');
    }

    public function productAddOffCartF(Request $req){

        $data = $req->all();

        $rule = [
            'price_rent' => 'required|numeric',  
            'all_off' => 'nullable|numeric',  
        ];

        $msg = [
            'price_rent.required' => 'مبلغ کرایه بار را وارد کنید',
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
        $cart->save();
        return redirect()->back()->with('message' , ' تغییرات  با موفقیت اعمال  شد!');
    }

    public function salePayPostF(Request $req){

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
            $priceAll = $cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter) - ($cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter)) * ($cart_prod->off/100) + $priceAll;
        }


        $order->status = '1';
        $order->price = $priceAll;
        $order->count_meters = $meter;
        $order->count_boxs = $box;
        $order->count_palet = $palet;
        $order->save();
        return redirect('/admin/crm/reqSaleF/{id}')->with('message' , 'فاکتور با موفقیت ثبت شد!');
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

        $data = $req->all();

        $rule = [
            'no_customer' => 'required',  
            'name' => 'required|string',  
            'phone' => 'required|numeric',  
            'address' => 'required',  
        ];

        $msg = [
            'no_customer.required' => 'نوع مشتری را انتخاب کنید',

            'address.required' => ' آدرس مشتری را وارد کنید',

            'name.required' => ' اسم مشتری را وارد کنید',
            'name.string' => ' اسم مشتری را درست وارد  کنید',

            'phone.required' => '   شماره موبایل مشتری  وارد کنید',
            'phone.numeric' => 'شماره موبایل مشتری به عدد میباشد.',
        ];

        $valid = Validator::make($data, $rule, $msg);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        if($req->customer_id){
            $customer = Customer::where('id' , $req->customer_id)->first();
        }else{
            $customer = new Customer();
        }

        $customer->name = $req->name;
        $customer->phone = $req->phone;
        $customer->address = $req->address;
        $customer->no_customer = $req->no_customer;
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
                'no_customer' => $customer->no_customer ?? '',
            ]);
        }

        return response()->json([
            'phone' => '',
            'address' => '',
            'no_customer' => '',
        ]);
    }

    public function listInvocie(){
        $user = null;
        $carts = Carts::where('status' , 1)->get();
        foreach($carts as $cart){
            $date = Verta::instance($cart->created_at)->format('Y/m/d');
            $user = Customer::where('id' , $cart->user_id)->first();
            $cart['date'] = $date;
            $cart['user'] = $user;

            switch($cart->type){
                case 'buy':
                    $cart->text_type = 'خرید';
                    break;
                default:
                    $cart->text_type = 'فروش';
                    break;
            }
        }
        return view('admin.list_invocie' , compact('carts'));
    }

    public function showInvocie($id){
        $five = 0;
        $finalOff= 0;
        $finalPrice= 0;

        $cart = Carts::findOrFail($id);

        switch($cart->type){
            case 'buy':
                $cart->text_type = 'خرید';
                $date = $cart->date;
                break;
            default:
                $cart->text_type = 'فروش';
                $date = Verta::instance($cart->created_at)->format('Y/m/d');
                break;
        }
        $user = Customer::where('id' , $cart->user_id)->first();
        

        $cart_prods = Cart_prod::where('card_id' , $cart->id)->get();
        foreach($cart_prods as $cart_prod){
                $prod = Product::where('id' , $cart_prod->prod_id)->first();
                $cart_prod['prod'] = $prod;

                $five = $cart->price * 0.05;
                $subtotal = $cart->price + $five + $cart->price_rent; // مجموع قبل از تخفیف
                $finalOff = $subtotal * ($cart->off / 100);        // محاسبه تخفیف از مجموع
                $finalPrice = $subtotal - $finalOff; 
        }

        // $cart_prods = null;
        // $order = null;
        // $user = null;
        // $meter = 0;
        // $box = 0;
        // $palet = 0;
        // $paper = 0;
        // $priceAll = 0;
        // $date = null;
        // $five = 0;
        // $finalPrice = 0;
        // $finalOff = 0;
        // $subtotal = 0;

        // if($id){
        //     $order = Carts::find($id);
        //     if ($order) {
        //         $date = Verta::instance($order->created_at)->format('Y/m/d');
        //         $user = Customer::where('id' , $order->user_id)->first();
        //         $cart_prods = Cart_prod::where('card_id' , $order->id)->get();
        //         foreach($cart_prods as $cart_prod){
        //             $prod = Product::where('id' , $cart_prod->prod_id)->first();
        //             $cart_prod['prod'] = $prod;
                    
        //             $meter = $cart_prod->count_box * $prod->count_meter + $meter;
        //             $box = $cart_prod->count_box + $box;
        //             $palet = $cart_prod->count_palet + $palet;
        //             $paper = $cart_prod->prod->count_paper + $paper;
        //             $priceAll = $cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter) - ($cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter)) * ($cart_prod->off/100) + $priceAll;
        //             $five = $priceAll * 0.05;اتنن
        //             $subtotal = $priceAll + $five + $order->price_rent; // مجموع قبل از تخفیف
        //             $finalOff = $subtotal * ($order->off / 100);        // محاسبه تخفیف از مجموع
        //             $finalPrice = $subtotal - $finalOff;  

        return view('admin.showImvocie' , compact('cart' , 'cart_prods' , 'date' , 'five' , 'finalPrice' , 'user'));
    }

    public function request(){
        $meter = 0;
        $box = 0;
        $palet = 0;
        $priceAll = 0;

        $carts = Carts::get();
        foreach($carts as $cart){
            $date = Verta::instance($cart->created_at)->format('Y/m/d');
            $user = Customer::where('id' , $cart->user_id)->first();
            $cart_prods = Cart_prod::where('card_id' , $cart->id)->get();
            foreach($cart_prods as $cart_prod){
                $prod = Product::where('id' , $cart_prod->prod_id)->first();
                $cart_prod['prod'] = $prod;
                
                $meter = $cart_prod->count_box * $prod->count_meter + $meter;
                $box = $cart_prod->count_box + $box;
                $palet = $cart_prod->count_palet + $palet;
                $priceAll = ($cart_prod->count_box * $prod->count_meter) * $prod->price + $priceAll;
            }
        }
        $reqs = ModelsRequest::get();
        foreach($reqs as $req){
            $date2 = Verta::instance($req->created_at)->format('Y/m/d');
            $user2 = Customer::where('id' , $req->user_id)->first();
            $prod = Product::where('id' , $req->prod_id)->first();
            $req['prod'] = $prod;
        }
        return view('admin.request' , compact('carts' , 'cart_prods' , 'reqs' , 'user' , 'date' , 'user2' , 'date2' , 'box' , 'priceAll' , 'meter' , 'palet'));
    }

    public function requestPost(Request $req){

        $request = new ModelsRequest();
        $request->user_id = '2';
        $request->prod_id = $req->prod_id;
        $request->count_box = $req->count_box;
        $request->count_all = $req->count_all;
        $request->count_meter = $req->count_meter;
        $request->count_palet = $req->count_palet;
        $request->save();
        return redirect()->back()->with('message' , ' درخواست با موفقیت ارسال  شد!');
    }

    public function submit($id = null){

        $editCheck = null;

        if($id){
            $editCheck = SubCheck::where('id' , $id)->first();
        }
        return view('admin.submit' , compact('editCheck'));
    }

    public function submitList(){
        $checks = SubCheck::get();
        return view('admin.listCheck' , compact('checks'));
    }

    public function submitPost(Request $req){

        $data = $req->all();

        $rules = [
            'check_date'   => 'required',
            'name_user'    => 'required|string|max:100',
            'phone_user'   => 'required|digits:11',
            'name_bank'    => 'required|string',
            'name_branch'  => 'required|string',
            'code_branch'  => 'required|numeric',
            'check_serial' => 'required|string',
            'check_num'    => 'required|numeric',
            'check_price'  => 'required|numeric',
            'name_account' => 'required|string|max:100',
            'num_account'  => 'required|numeric',
            'num_invocie'  => 'nullable|string|max:50',
            'desc'         => 'nullable|string',
        ];

        $messages = [
            'check_date.required'   => 'تاریخ چک را وارد کنید',
        
            'name_user.required'    => 'نام صاحب چک را وارد کنید',
        
            'phone_user.required'   => 'شماره همراه را وارد کنید',
            'phone_user.digits'     => 'شماره همراه باید 11 رقم باشد',
        
            'name_bank.required'    => 'نام بانک را وارد کنید',
            'name_branch.required'  => 'نام شعبه را وارد کنید',
        
            'code_branch.required'  => 'کد شعبه را وارد کنید',
            'code_branch.numeric'   => 'کد شعبه باید عدد باشد',
        
            'check_serial.required' => 'سریال چک را وارد کنید',
        
            'check_num.required'    => 'شماره چک را وارد کنید',
            'check_num.numeric'     => 'شماره چک باید عدد باشد',
        
            'check_price.required'  => 'مبلغ چک را وارد کنید',
            'check_price.numeric'   => 'مبلغ چک باید عدد باشد',
        
            'name_account.required' => 'نام صاحب حساب را وارد کنید',
        
            'num_account.required'  => 'شماره حساب را وارد کنید',
            'num_account.numeric'   => 'شماره حساب باید عدد باشد',
        
            'num_invocie.max'       => 'شماره فاکتور بیش از حد طولانی است',
            'desc.max'              => 'توضیحات نمی‌تواند بیشتر از ۵۰۰ کاراکتر باشد',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        if($req->check_id){
            $check =SubCheck::where('id' , $req->check_id)->first();
        }else{
            $check = new SubCheck();
        }

        
        $check->check_date = $req->check_date;
        $check->name_user = $req->name_user;
        $check->phone_user = $req->phone_user;
        $check->name_bank = $req->name_bank;
        $check->name_branch = $req->name_branch;
        $check->code_branch = $req->code_branch;
        $check->check_serial = $req->check_serial;
        $check->check_num = $req->check_num;
        $check->check_price = $req->check_price;
        $check->name_account = $req->name_account;
        $check->num_account = $req->num_account;
        $check-> num_invocie = $req->num_invocie;
        $check->desc = $req->desc;
        $check->save();
        
        
        if($req->check_id){
            return redirect('/admin/financial/submit/show/list')->with('message' , 'چک با موفقیت ویرایش شد!');
        }else{
            return redirect('/admin/financial/submit/{id}')->with('message' , 'چک با موفقیت اضافه شد!');
        }
    }

    public function received(){
        return view('admin.received');
    }

    public function pay(){
        return view('admin.pay');
    }

    public function list(){
        return view('admin.list');
    }

    public function settingPost(Request  $req){
        $user = User::where('id' , $req->user_id)->first();
        $user->dispaly_name = $req->name_dispaly;
        $user->save();
        return redirect()->back();
    }

    public function buy($id  = null){

        $meter = 0;
        $box = 0;
        $palet = 0;
        $priceAll = 0;
        $cart = null;

        if($id){
            $cart = Carts::where('id' , $id)->where('type' , 'buy')->first();
            $cart_prods = Cart_prod::where('card_id' , $id)->get();
            foreach($cart_prods as $cart_prod){
                $prod = Product::where('id' , $cart_prod->prod_id)->first();
                $cart_prod['prod'] = $prod;

                $meter = $cart_prod->count_box * $prod->count_meter + $meter;
                $box = $cart_prod->count_box + $box;
                $palet = $cart_prod->count_palet + $palet;
                $priceAll = ($cart_prod->count_box * $prod->count_meter) * $prod->price + $priceAll;
            }
        }
        $prods = Product::get();
        return view('admin.buy' , compact('prods' , 'cart' , 'cart_prods' , 'meter' , 'box' , 'palet' , 'priceAll'));
    }
    public function buyAjax($id){

        $product = Product::find($id);

        if ($product) {
            return response()->json([
                'count_meter' => $product->count_meter ?? '',
                'count_box' => $product->count_box ?? '',
            ]);
        }

        return response()->json([
            'count_meter' => '',
            'count_box' => '',
        ]);
    }

    public function buyaddProd(Request $req){
        $data = $req->all();

        $rules = [
            'prod_id'   => 'required',
            'count_palet'    => 'required|numeric',
            'count_box'  => 'required|numeric',
        ];

        $messages = [
            'prod_id.required'   => 'یک محصول را انتخاب کنید',

            'count_palet.required'   => 'تعدا پالت را وارد کنید',
            'count_palet.numeric'   => 'تعداد پالت باید عدد باشد',

            'count_box.required'   => 'تعداد کارتن را وارد کنید',
            'count_box.numeric'   => ' تعداد کارتن عدد باشد',
        
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = Product::where('id' , $req->prod_id)->first();
        $product-> box = $product->box + $req->count_box;
        $product->count_palet = ((int) $product->count_palet) + ((int) $req->count_palet);
        $product->count_all = $product->count_all + $req->count_all;
        $product->save();

        $cart_prod = new Cart_prod();
        $cart_prod->prod_id = $req->prod_id;
        $cart_prod->card_id = $req->cart_id;
        $cart_prod->count_all = $req->count_all;
        $cart_prod->count_box = $req->count_box;
        $cart_prod->count_palet = $req->count_palet;
        $cart_prod->save();
        return redirect()->back()->with('message' , 'محصول با موفقیت اضافه شد');
    }

    public function buyAddToCart(Request $req){

        function convertPersianNumber($string)
        {
            if ($string === null) return null;
        
            $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            $arabic  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            $english = ['0','1','2','3','4','5','6','7','8','9'];
        
            $string = str_replace($persian, $english, $string);
            $string = str_replace($arabic,  $english, $string);
        
            // تبدیل کاما فارسی اعشاری
            $string = str_replace(['،', ','], '.', $string);
        
            return $string;
        }

        $req->merge([
            'date_buy'        => convertPersianNumber($req->date_buy),
            'code_buy'    => convertPersianNumber($req->code_buy),
        ]);

        $data = $req->all();

        $rules = [
            'date_buy'   => 'required',
            'code_buy'    => 'required|string',
        ];

        $messages = [
            'date_buy.required'   => 'تاریخ فاکتور را وارد کنید',
        
            'code_buy.required'    => '  شماره فاکتور را وارد کنید',
            'code_buy.string'    => '  شماره فاکتور را درست  وارد کنید',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $cart = new Carts();

        $cart->num_cart = $req->code_buy;
        $cart->date = $req->date_buy;
        $cart->user_id = Auth::user()->id;
        $cart->status = '0';
        $cart->type = 'buy';
        $cart->save();

        return redirect()->route('buy' , $cart->id);
    }

    public function finalCartBuy(Request $req){

        $meter = 0;
        $box = 0;
        $palet = 0;
        $priceAll = 0;

        $cart = Carts::where('id' , $req->cart_id)->first();

        $cart_prods = Cart_prod::where('card_id' , $cart->id)->get();
            foreach($cart_prods as $cart_prod){
                $prod = Product::where('id' , $cart_prod->prod_id)->first();
                $cart_prod['prod'] = $prod;

                $meter = $cart_prod->count_box * $prod->count_meter + $meter;
                $box = $cart_prod->count_box + $box;
                $palet = $cart_prod->count_palet + $palet;
                $priceAll = ($cart_prod->count_box * $prod->count_meter) * $prod->price + $priceAll;
            }
        $cart->status = '1';
        $cart->price = $priceAll;
        $cart->count_meters = $meter;
        $cart->count_boxs = $box;
        $cart->count_palet = $palet;
        $cart->save();

        return redirect('/admin/crm/buy/add/{id}')->with('message' , 'فاکتور خرید با موفقیت ثبت شد!');
    }

    public function leave(){
        return view('admin.leave');
    }

    public function sample(){
        return view('admin.sample');
    }

    public function break(){
        return view('admin.break');
    }

    public function lpo($id = null){
        $lpo = null;
        $date = null;
         $meter = 0;
        $box = 0;
        $palet = 0;
        $priceAll = 0;
        $lpo_prods = null;
        $prods = null;

        if($id){
            $lpo = Lpo::where('id' , $id)->first();
            if($lpo){
                $date = Verta::instance($lpo->created_at)->format('Y/m/d');
                $prods = Product::get();
                $lpo_prods = Lpo_Prod::where('lpo_id' , $lpo->id)->get();
                foreach($lpo_prods as $lpo_prod){
                    $prod = Product::where('id' , $lpo_prod->prod_id)->first();
                    $lpo_prod['prod'] = $prod;

                    $meter = $lpo_prod->count_box * $prod->count_meter + $meter;
                    $box = $lpo_prod->count_box + $box;
                    $palet = $lpo_prod->count_palet + $palet;
                    $priceAll = ($lpo_prod->count_box * $prod->count_meter) * $prod->price + $priceAll;


                }
            }
        }
        // return $date;
        $customers = Customer::get();
        return view('admin.lpo' , compact('customers' , 'lpo' , 'date' , 'prods' , 'lpo_prods' , 'priceAll' , 'meter' , 'box' , 'palet'));
    }

    public function lpoAddCart(Request $req){

        $data = $req->all();

        $rules = [
            'num_lpo'    => 'required|string',
            'customer_id'    => 'required',
        ];

        $messages = [
            'num_lpo.required'    => '  شماره lpo را وارد کنید',
            'num_lpo.string'    => '  شماره lpo را درست  وارد کنید',

            'customer_id.required'    => 'مشتری را انتخاب کنید',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $lpo = new Lpo();
        $lpo->customer_id = $req->customer_id;
        $lpo->num_lpo = $req->num_lpo;
        $lpo->status = '0';
        $lpo->save();
        return redirect()->route('lpo' , $lpo->id);
    }

    public function lpoAddCartProd(Request $req){

        $data = $req->all();

        $rules = [
            'prod_id'   => 'required',
            'count_all'    => 'required|numeric',
            'count_box'  => 'required|numeric',
        ];

        $messages = [
            'prod_id.required'   => 'یک محصول را انتخاب کنید',

            'count_all.required'   => 'تعدا پالت را وارد کنید',
            'count_all.numeric'   => 'تعداد پالت باید عدد باشد',

            'count_box.required'   => 'تعداد کارتن را وارد کنید',
            'count_box.numeric'   => ' تعداد کارتن عدد باشد',
        
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $product = Product::where('id' , $req->prod_id)->first();
        if($req->count_all > $product->count_all){
            return redirect()->back()->with('error' , 'مقدار درخواستی بیش‌تر از موجودی انبار است. لطفاً ابتدا موجودی محصول را افزایش دهید.');
        }else{
            $lpo_prod = new Lpo_Prod();
            $lpo_prod->lpo_id = $req->lpo_id;
            $lpo_prod->prod_id = $req->prod_id;
            $lpo_prod->count_box = $req->count_box;
            $lpo_prod->count_palet = $req->count_palet;
            $lpo_prod->count_all = $req->count_all;
            $lpo_prod->save();
            return redirect()->route('lpo' , $req->lpo_id);
        }
        
        
    }

    public function lpoFinal(Request $req){

        $meter = 0;
        $box = 0;
        $palet = 0;
        $priceAll = 0;

        $lpo = Lpo::where('id' , $req->lpo_id)->first();

        $lpo_prods = Lpo_Prod::where('lpo_id' , $lpo->id)->get();
            foreach($lpo_prods as $lpo_prod){
                $prod = Product::where('id' , $lpo_prod->prod_id)->first();
                $lpo_prod['prod'] = $prod;
                $meter = $lpo_prod->count_box * $prod->count_meter + $meter;
                $box = $lpo_prod->count_box + $box;
                $palet = $lpo_prod->count_palet + $palet;
                $priceAll = ($lpo_prod->count_box * $prod->count_meter) * $prod->price + $priceAll;
            }
        
        $lpo->count_box = $box;
        $lpo->count_palet= $palet;
        $lpo->count_all = $meter;
        $lpo->price = $priceAll;
        $lpo->status = '1';
        $lpo->save();

        return redirect('/admin/crm/lpo/add/{id}')->with('message' , ' LPO با موفقیت ثبت شد!');
    }
}
