<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Lpo;
use App\Models\Lpo_Prod;
use App\Models\Product;
use App\Models\Size;
use App\Models\size_product;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LpoController extends Controller
{
    //

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
                    $size_prod = size_product::where('id' , $lpo_prod->size_prod_id)->first();
                    $size = Size::where('id' , $size_prod->size_id)->first();
                    $lpo_prod['size_prod'] = $size_prod;
                    $lpo_prod['size'] = $size;

                    $meter = $lpo_prod->count_all + $meter;
                    $box = $lpo_prod->count_box + $box;
                    $palet = $lpo_prod->count_palet + $palet;
                    $priceAll = ($lpo_prod->count_all) * $prod->price + $priceAll;


                }
            }
        }
        // return $date;
        $customers = Customer::get();
        return view('admin.lpo' , compact('customers' , 'lpo' , 'date' , 'prods' , 'lpo_prods' , 'priceAll' , 'meter' , 'box' , 'palet'));
    }

    public function lpoAjax($id){

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

    public function lpoAjax2($sizeId , $id , $inputAll){

        $size_prod = size_product::where('id'  ,$sizeId)->first();
        $prod = Product::where('id' , $id)->first();

        $size = Size::where('id' , $size_prod->size_id)->first();
        [$width, $height] = explode('x' , $size->name);

        $boxInPalet = $prod->count_box;
        $meterInBox = $size_prod->box_meter;
        $meter = ($width/100) * ($height/100);
        $meterPalet = $boxInPalet * $meterInBox;


        $start = $inputAll /  $meter; 
        $allCount = ceil($start) * $meter;
        $allBox = floor($allCount / $meterInBox);
        $allPalet = floor($allBox / $boxInPalet);
        $num_box = $allBox - ($allPalet * $boxInPalet);
        $metrajepalletha=($meterPalet * $allPalet);
        $metrajecartonha =($num_box * $meterInBox);
        $meterOver = round($allCount  -  $metrajepalletha - $metrajecartonha , 2);
        $paper = round($meterOver / $meter);

        Log::info(' متراژ هر کارتن '.$meterInBox);
        Log::info('متراژ پالت'.$meterPalet);
        Log::info('تعداد جعبه در پالت'.$boxInPalet);
        Log::info('متر هر کاشی'.$meter);
        Log::info('مقدار اولیه'.$start);
        Log::info('مقدار کل با ناخالصی'.$allCount);
        Log::info('تعداد کل کارتن'.$allBox);
        Log::info('تعداد کل پالت'.$allPalet);
        Log::info('تعداد خرد کارتن'.$num_box);
        Log::info('تعداد  متراژ پالت ها'.$metrajepalletha);
        Log::info('تعداد  کارتن ها متراژ'.$metrajecartonha);
        Log::info('تعداد باقی مانده '.$meterOver);
        Log::info('تعداد برگ '.$paper);

        if ($size_prod && $inputAll) {
            return response()->json([
                'count_box' => $allBox ?? '',
                'count_palet' => $allPalet ?? '',
                'count_paper' => $paper ?? '', 
                'count_num_box' => $num_box  ?? '', 
            ]);
        }

        return response()->json([
             'count_box' => '',
                'count_palet' => '',
                'count_paper' => '', 
                'count_num_box' =>  '', 
        ]);
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

            'count_all.required'   => 'متراژ کل  را وارد کنید',
            'count_all.numeric'   => 'متراژکل  باید عدد باشد',

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
            $lpo_prod->size_prod_id = $req->size_id;
            $lpo_prod->save();
            return redirect()->route('lpo' , $req->lpo_id);
        }
        
        
    }

    public function imgLpo(Request $req){

        $img = Lpo::where('id' , $req->lpo_id)->first();
        if ($req->hasFile('img')) {

            $file= $req->file('img');
            $file_name=time() . "." . $file->getClientOriginalExtension();
            $destination_path='files/lpo';
            $file->move($destination_path, $file_name);
            $img->img=$destination_path. '/' .$file_name;
        }
        $img->save();
        return redirect()->back();
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
                $meter = $lpo_prod->count_all + $meter;
                $box = $lpo_prod->count_box + $box;
                $palet = $lpo_prod->count_palet + $palet;
                $priceAll = ($lpo_prod->count_all) * $prod->price + $priceAll;
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
