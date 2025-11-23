<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CRMController extends Controller
{
    //
    public function addProd(){
        return view('admin.addProd');
    }

    public function reqProd(){
        return view('admin.reqProd');
    }

    public function reqSale(){
        return view('admin.reqSale');
    }
}
