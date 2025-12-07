<?php

namespace App\Http\Controllers;

use App\Models\Cart_prod;
use App\Models\Carts;
use App\Models\Customer;
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

        $data = $req->all();

        $rule = [
            'product' => 'required',  
            'count_box' => 'required|numeric',  
            'count_palet' => 'required|numeric',  
        ];

        $msg = [
            'product.required' => 'طرح را انتخاب کنید',
            'count_box.required' => 'تعداد کارتن را وارد کنید',
            'count_palet.required' => 'تعداد پالت را وارد کنید',

            'count_box.numeric' => 'تعداد کارتن را عدد وارد کنید',
            'count_palet.numeric' => 'تعداد پالت را عدد وارد کنید',
        ];

        $valid = Validator::make($data, $rule, $msg);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }


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
        return redirect('/admin/crm/reqSale/{id}')->with('message' , 'فاکتور با موفقیت ثبت شد!');
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
        $carts = Carts::where('status' , 1)->get();
        foreach($carts as $cart){
            $date = Verta::instance($cart->created_at)->format('Y/m/d');
            $user = Customer::where('id' , $cart->user_id)->first();
            $cart['date'] = $date;
        }
        return view('admin.list_invocie' , compact('carts' , 'user'));
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

        $cart = null;
        if($id){
            $cart = Carts::where('id' , $id)->where('type' , 'buy')->first();
            $cart_prods = Cart_prod::where('card_id' , $id)->get();
        }
        $prods = Product::get();
        return view('admin.buy' , compact('prods' , 'cart' , 'cart_prods'));
    }

    public function buyaddProd(Request $req){
        $cart_prod = new Cart_prod();
        $cart_prod->prod_id = $req->prod_id;
        $cart_prod->card_id = $req->cart_id;
        $cart_prod->count_box = $req->count_box;
        $cart_prod->count_palet = $req->count_palet;
        $cart_prod->save();
        return redirect()->back();
    }

    public function buyAddToCart(Request $req){
        
        $cart = new Carts();

        $cart->num_cart = $req->code_buy;
        $cart->date = $req->date_buy;
        $cart->user_id = Auth::user()->id;
        $cart->status = '0';
        $cart->type = 'buy';
        $cart->save();

        return redirect()->route('buy' , $cart->id);
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

        public function lpo(){
        return view('admin.lpo');
    }
}
