<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function dashboard(){
        return view('admin.dashborad');
    }
    public function size(){
        return view('admin.size');
    }
    public function product(){
        return view('admin.product');
    }
    public function catalog(){
        return view('admin.catalog');
    }
    public function setting(){
        return view('admin.setting');
    }
}
