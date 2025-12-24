<?php

namespace App\Http\Controllers;

use App\Models\Cart_prod;
use App\Models\Carts;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Size;
use App\Models\size_product;
use Hekmatinasser\Verta\Verta;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    //

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

                $size_prod = size_product::where('id' , $cart_prod->size_prod_id)->first();
                $size = Size::where('id' , $size_prod->size_id)->first();

                $cart_prod['size_prod'] = $size_prod;
                $cart_prod['size'] = $size;
                if($cart->no_tax == 1){
                    $five = $cart->price * 0.05;
                }else{
                    $five = 0;
                }
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

    public function pdf($id){

        $five = 0;
        $finalOff= 0;
        $finalPrice= 0;
        $box_num = 0;

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
        $customer = Customer::where('id' , $cart->user_id)->first();
        

        $cart_prods = Cart_prod::where('card_id' , $cart->id)->get();
        foreach($cart_prods as $cart_prod){
                $prod = Product::where('id' , $cart_prod->prod_id)->first();
                $cart_prod['prod'] = $prod;

                $size_prod = size_product::where('id' , $cart_prod->size_prod_id)->first();
                $size = Size::where('id' , $size_prod->size_id)->first();

                $cart_prod['size_prod'] = $size_prod;
                $cart_prod['size'] = $size;

                if($cart->no_tax == 1){
                    $five = $cart->price * 0.05;
                }else{
                    $five = 0;
                }
                $subtotal = $cart->price + $five + $cart->price_rent; // مجموع قبل از تخفیف
                $finalOff = $subtotal * ($cart->off / 100);        // محاسبه تخفیف از مجموع
                $finalPrice = $subtotal - $finalOff;
                $box_num = $cart_prod->count_box_num + $box_num;
        }
        $cart['box_num'] = $box_num;

        $pdf = PDF::loadView("admin/downloadPdf" , compact('cart' , 'cart_prods' , 'date' , 'five' , 'finalPrice' , 'customer'));
        return $pdf->stream("invoice-".$cart->text_type.".pdf");

        //return view("admin.downloadPdf" , compact('cart' , 'cart_prods' , 'date' , 'five' , 'finalPrice' , 'customer'));
    }
}
