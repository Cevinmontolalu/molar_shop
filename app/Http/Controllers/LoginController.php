<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Alert;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Session;

class LoginController extends Controller
{
    public function login(){
        return view('pages.login');
    }
    public function login_admin(Request $req){
        $validate = Validator::make($req->all(),[
            'email'=>'required',
            'password'=>'required'
        ]);
        if($validate->fails()){
            Alert::warning('Gagal','Login Gagal silahkan coba lagi');
            return redirect('login')->withErrors('validate error : ',$validate->errors())->withInput();
        }
        $credentials = $req->only('email','password');
        if(Auth::attempt($credentials)){
            Alert::success('Login Sukses','Login Berhasil');
            return redirect('dashboard')->withSuccess('Login Berhasil');
        }else{
            Alert::error('Gagal','Login Gagal');
            return back()->withErrors(['email'=>'data tidak ditemukan, silahkan periksa kembali!'])->withInput(['email']);
        }
        
    }
    public function logout_admin(){
        Auth::logout();
        Session::flush();
        return redirect('login');
    }
}
