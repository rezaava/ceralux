<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Role;
use App\Models\Size;
use App\Models\size_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('admin.dashborad');
    }
    public function size()
    {
        $sizes = Size::get();
        return view('admin.size', compact('sizes'));
    }
    public function sizePost(Request $req)
    {


        $data = $req->all();

        $rule = [
            'size_name' => 'required|string',
            'meli_name' => 'required|numeric',
        ];

        $msg = [
            'size_name.required' => 'سایز الزامی است',
            'size_name.string' => 'سایز متن باشد',
            'meli_name.required' => 'ضخامت الزامی است',
            'meli_name.integer' => 'ضخامت عدد وارد شود ',
        ];

        $valid = Validator::make($data, $rule, $msg);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }


        $size = new Size();
        $size->name = $req->size_name;
        $size->meli = $req->meli_name;
        $size->save();
        return redirect()->back();
    }
    public function productAdd($id = null)
    {

        $editProd = null;

        if ($id) {
            $editProd = Product::find($id);
        }
        $sizes = Size::get();
        $size_prod = size_product::where('product_id', $id)->pluck('size_id')->toArray();
        return view('admin.product', compact('sizes', 'editProd', 'size_prod'));
    }
    public function productList()
    {
        $prods = Product::get();
        foreach ($prods as $prod) {
            $prod['size_prods'] = size_product::where('product_id', $prod->id)->pluck('size_id');
        }


        return view('admin.list_product', compact('prods'));
    }

    public function productPost(Request $req)
    {   

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


        Log::info($req);

        $req->merge([
            'price'        => convertPersianNumber($req->price),
            'price_buy'    => convertPersianNumber($req->price_buy),
            'count_box'    => convertPersianNumber($req->count_box),
            'count_meter'  => convertPersianNumber($req->count_meter),
            'count_meli'   => convertPersianNumber($req->count_meli),
            'count_all'    => convertPersianNumber($req->count_all),
            'count_darageh'=> convertPersianNumber($req->count_darageh),
            'no_product'   => convertPersianNumber($req->no_product),
            'count_paper'  => convertPersianNumber($req->count_paper),
        ]);

        $data = $req->all();

        $rule = [

            'title'         => 'required|string|max:255',

            'price'         => 'required|numeric',
            'price_buy'         => 'required|numeric',

            'face'          => 'required|string',

            'count_box'     => 'required|numeric',
            'count_meter'   => 'required|numeric',
            'count_meli'   => 'required|numeric',
            'count_all'     => 'required|numeric',

            'code_prod'     => 'required|string',

            'count_darageh' => 'required|integer',

            'no_product'    => 'required',

            'count_paper'   => 'required|integer',

            'name_company'  => 'required|string',
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'exists:sizes,id',
        ];


        $msg = [

            // title
            'title.required'    => 'نام طرح محصول الزامی است.',
            'title.string'      => 'نام طرح باید متن باشد.',
            'title.max'         => 'نام طرح نباید بیشتر از ۲۵۵ کاراکتر باشد.',

            // desc


            // price
            'price.numeric'     => 'قیمت فروش باید عدد باشد.',
            'price.required'     => 'قیمت فروش الزامی است.',

            'price_buy.numeric'     => 'قیمت خرید باید عدد باشد.',
            'price_buy.required'     => 'قیمت خرید الزامی است.',

            // face
            'face.required'       => 'face الزامی است.',

            // counts
            'count_box.numeric'     => 'تعداد در جعبه باید عدد باشد.',
            'count_box.required'     => 'تعداد جعبه الزامی است',
            'count_meter.numeric'   => 'متراژ  باید عدد باشد.',
            'count_meter.required'   => 'متراژ الزامی است.',
            'count_meli.numeric'   => 'تعداد در پالت باید عدد باشد.',
            'count_meli.required'   => 'تعداد در پالت الزامی است.',
            'count_all.numeric'     => 'متراژ کل باید عدد باشد.',
            'count_all.required'     => 'متراژ کل الزامی است.',

            // code
            'code_prod.string'      => 'کد محصول باید متن باشد.',
            'code_prod.required'         => 'کد محصول الزامی است.',

            'count_darageh.integer' => ' درجه باید عدد باشد.',
            'count_darageh.required' => ' درجه الزامی است.',

            'no_product.integer'    => 'نوع محصول باید عدد باشد.',
            'no_product.required'    => 'نوع محصول الزامی است.',

            'count_paper.integer'   => 'تعداد برگ باید عدد باشد.',
            'count_paper.required'   => 'تعداد برگ الزامی است.',

            'name_company.string'   => 'نام شرکت باید متن باشد.',
            'name_company.required'      => 'نام شرکت الزامی است.',
            
            'sizes.required' => 'حداقل یک سایز باید انتخاب شود.',
            'sizes.min' => 'حداقل یک سایز باید انتخاب شود.',
        ];


        $valid = Validator::make($data, $rule, $msg);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }



        if ($req->prod_id) {
            $prod = Product::where('id', $req->prod_id)->first();
        } else {
            $prod = new Product();
        }



        $prod->name = $req->title;
        $prod->desc = $req->desc;
        $prod->price = $req->price;
        $prod->price_buy = $req->price_buy;
        $prod->face = $req->face;
        $prod->name_en = $req->titleEn;
        $prod->desc_en = $req->descEn;
        $prod->name_ar = $req->titleAr;
        $prod->desc_ar = $req->descAr;
        $prod->count_box = $req->count_box;
        $prod->count_meter = $req->count_meter;
        $prod->count_meli = $req->count_meli;
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

        if ($req->prod_id) {
            return redirect('/admin/product/list')->with('message', 'محصول با موفقیت ویرایش شد!');
        } else {
            return redirect('/admin/product/add/{id}')->with('message', 'محصول با موفقیت اضافه شد!');
        }
    }

    public function deleteProduct($id)
    {
        $prod = Product::find($id);
        $prod->delete();
        return redirect('/admin/product/list')->with('message', 'محصول با موفقیت حذف شد!');
    }

    public function catalog()
    {
        return view('admin.catalog');
    }
    public function setting()
    {
        return view('admin.setting');
    }

    public function addAdmin(){
        $admin = new Role();

        $admin->name = 'adminSocialMedia';
        $admin->display_name = 'ادمین تولید محتوا';
        $admin->save();

        $admin = new Role();

        $admin->name = 'manager';
        $admin->display_name = 'مدیر';
        $admin->save();
    }
}
