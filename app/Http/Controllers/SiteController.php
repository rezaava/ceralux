<?php

namespace App\Http\Controllers;

use App\Models\Cart_prod;
use App\Models\Carts;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Size;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;


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

}
