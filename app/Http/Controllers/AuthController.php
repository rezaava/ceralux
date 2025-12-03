<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login(){
        return view('auth.index');
    }

    public function loginPost(Request $req){

        $user = User::where('name' , $req->username)->first();

        if(!$user){
            $user = new User();
            $user->name = $req->username;
            $user->password = bcrypt($req->password);
            $user->save();
            // $user->addRole('user');
            Auth::login($user);
            return redirect('/admin/dashboard')->with('message', 'ورود با موفقیت انجام شد خوش آمدید !');

        }
        if(Hash::check($req->password , $user->password)){
            Auth::login($user);
            return redirect('/admin/dashboard')->with('message', 'ورود با موفقیت انجام شد خوش آمدید !');
        }else{
            return redirect()->back()->with('error', 'رمز عبور یا نام کاربری اشتباه است!')->withInput();
            $limit_time = $limit_time + 1;
        }





    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
