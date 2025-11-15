<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function aboutus()
    {
        return view('aboutus');
    }
    
    public function contact()
    {
        return view('contact');
    }


    public function search() {
        return view('search');
    }



    public function sellagents() {
        return view('sellagents');
    }

    public function blog() {
        return view('blog');
    }
    public function viewblog() {
        return view('viewblog');
    }
}
