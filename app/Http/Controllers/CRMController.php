<?php

namespace App\Http\Controllers;

use App\Models\Cart_prod;
use App\Models\Carts;
use App\Models\Customer;
use App\Models\Lpo;
use App\Models\Lpo_Prod;
use App\Models\Product;
use App\Models\Request as ModelsRequest;
use App\Models\Size;
use App\Models\size_product;
use App\Models\SubCheck;
use App\Models\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
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

    public function listInvocie(){
        $user = null;
        $carts = Carts::whereIn('status' , [1,2,3])->get();
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

    public function request(){

        $carts = Carts::whereNull('type')->where('status' ,'>', 0)->get();
        foreach($carts as $cart){
            
            $meter = 0;
            $box = 0;
            $paper = 0;
            $priceAll = 0;

            $date = Verta::instance($cart->created_at)->format('Y/m/d');
            $user = User::where('id' , $cart->admin_id)->first();
            $cart_prods = Cart_prod::where('card_id' , $cart->id)->get();
            $cart['date'] = $date;
            $cart['user'] = $user;
            $cart['cart_prods'] = $cart_prods;

            if ($cart->date_admin) {
            
                $date_admin = Carbon::parse($cart->date_admin);
                $now = Carbon::now();
            
                if ($date_admin->diffInDays($now) <= 10) {
                    $cart['dayReq'] = verta($date_admin)->formatDifference();
                } else {
                    $cart['dayReq'] = verta($date_admin)->format('Y/m/d H:i');
                }
            
            } else {
            
                // وقتی هنوز پاسخ داده نشده
                $cart['dayReq'] = '-';
            }

            
            foreach($cart->cart_prods as $cart_prod){
                $prod = Product::where('id' , $cart_prod->prod_id)->first();
                $cart_prod['prod'] = $prod;

                $size_prod = size_product::where('id' , $cart_prod->size_prod_id)->first();
                $size = Size::where('id' , $size_prod->size_id)->first();
                $cart_prod['size_prod'] = $size_prod;
                $cart_prod['size'] = $size;
                
                $meter = $cart_prod->count_all + $meter;
                $box = $cart_prod->count_box_num + $box;
                $paper = $cart_prod->count_paper + $paper;
                //$palet = $cart_prod->count_palet + $palet;
                $priceAll = ($cart_prod->count_all) * $prod->price + $priceAll;
            }
            $cart['price'] = $priceAll ;
        }

        return view('admin.request' , compact('carts' , 'box' , 'paper'));
    }

    public function requestPostYes($id){

        $cart = Carts::where('id' , $id)->first();
        $cart_prods = Cart_prod::where('card_id' , $cart->id)->get();
        foreach($cart_prods as $cart_prod){

            $product = size_product::where('id' , $cart_prod->size_prod_id)->first();
            $product-> count_box = $product->count_box - $cart_prod->count_box;
            $product->count_palet = ((int) $product->count_palet) - ((int) $cart_prod->count_palet);
            $product->count_all = $product->count_all - $cart_prod->count_all;
            $product->save();

            }
        $cart->status = '2';
        $cart->date_admin = Carbon::now();
        $cart->save();
        return redirect()->back()->with('message' , ' درخواست با موفقیت تایید  شد!');
    }

    public function requestPostNo($id){

        $cart = Carts::where('id' , $id)->first();
        $cart->status = '3';
        $cart->date_admin = Carbon::now();
        $cart->save();
        return redirect()->back()->with('message' , ' درخواست با موفقیت رد  شد!');
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

    

    public function leave(){
        return view('admin.leave');
    }

    public function sample(){
        return view('admin.sample');
    }

    public function break(){
        return view('admin.break');
    }

}
