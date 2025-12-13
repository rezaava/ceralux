<?php

namespace App\Http\Controllers;

use App\Models\Cart_prod;
use App\Models\Carts;
use App\Models\Product;
use App\Models\Size;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class SiteController extends Controller
{
    public function index()
    {
        $sizes = Size::get();
        return view('home' , compact('sizes'));
    }

    public function aboutus()
    {
        $sizes = Size::get();
        return view('aboutus' , compact('sizes'));
    }
    
    public function contact()
    {
        $sizes = Size::get();
        return view('contact' , compact('sizes'));
    }


    public function search() {
        $sizes = Size::get();
        return view('search' , compact('sizes'));
    }



    public function sellagents() {
        $sizes = Size::get();
        return view('sellagents' , compact('sizes'));
    }

    public function blog() {
        $sizes = Size::get();
        return view('blog' , compact('sizes'));
    }
    public function viewblog() {
        $sizes = Size::get();
        return view('viewblog' , compact('sizes'));
    }

    public function pdf($id){

        $cart = Carts::where('id' , $id)->first();

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
        

        $cart_prods = Cart_prod::where('card_id' , $cart->id)->get();
        foreach($cart_prods as $cart_prod){
                $prod = Product::where('id' , $cart_prod->prod_id)->first();
                $cart_prod['prod'] = $prod;
        }
        //return $cart
        $pdf = PDF::loadView("admin/downloadPdf" , compact('cart' , 'cart_prods' , 'date'));
        return $pdf->stream("invoice-".$cart->text_type.".pdf");
    }
}
