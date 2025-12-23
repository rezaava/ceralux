<?php

namespace App\Http\Controllers;

use App\Models\Cart_prod;
use App\Models\Carts;
use App\Models\Product;
use App\Models\Size;
use App\Models\size_product;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BuyController extends Controller
{
    //

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
                $size_prod = size_product::where('id' , $cart_prod->size_prod_id)->first();
                $size = Size::where('id' , $size_prod->size_id)->first();
                $cart_prod['prod'] = $prod;
                $cart_prod['meter'] = $size_prod;
                $cart_prod['size'] = $size;

                $meter = $cart_prod->count_all + $meter;
                $box = $cart_prod->count_box + $box;
                $palet = $cart_prod->count_palet + $palet;
                $priceAll = ($cart_prod->count_all) * $prod->price + $priceAll;
            }
        }
        $prods = Product::get();
        return view('admin.buy' , compact('prods' , 'cart' , 'cart_prods' , 'meter' , 'box' , 'palet' , 'priceAll'));
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
        $cart->admin_id = Auth::user()->id;
        $cart->status = '0';
        $cart->type = 'buy';
        $cart->save();

        return redirect()->route('buy' , $cart->id);
    }

    public function buyAjax($id){

        $product = Product::find($id);

        if ($product) {
            $sizes = size_product::where('product_id' , $id)->get();
            foreach($sizes as $size){
                $size['name'] = Size::where('id' , $size->size_id)->first()->name;
            }
            return response()->json([
                'sizes' => $sizes ?? '',
            ]);
        }

        return response()->json([
            'sizes' => '',
        ]);
    }

    public function buyAjax2($sizeId , $id){

        $size_prod = size_product::where('id'  ,$sizeId)->first();
        $prod = Product::where('id' , $id)->first();

        if ($size_prod) {
            return response()->json([
                'count_meter' => $size_prod->box_meter ?? '',
                'count_box' => $prod->count_box ?? '',
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
            'size_id'   => 'required',
            'no_price'          => 'required',
            'count_palet'    => 'required|numeric',
            'count_box'  => 'required|numeric',
        ];

        $messages = [
            'prod_id.required'   => 'یک محصول را انتخاب کنید',
            'size_id.required'   => 'سایز محصول  را انتخاب کنید',
            'no_price.required'       => 'نوع ارز را انتخاب کنید  .',

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

        $cart = Carts::where('id' , $req->cart_id)->first();
        $cart->no_price = $req->no_price;
        $cart->save();

        $cart_prod = new Cart_prod();
        $cart_prod->prod_id = $req->prod_id;
        $cart_prod->card_id = $req->cart_id;
        $cart_prod->count_all = $req->count_all;
        $cart_prod->size_prod_id = $req->size_id;
        $cart_prod->count_box = $req->count_box;
        $cart_prod->count_palet = $req->count_palet;
        $cart_prod->save();
        return redirect()->back()->with('message' , 'محصول با موفقیت اضافه شد');
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
}
