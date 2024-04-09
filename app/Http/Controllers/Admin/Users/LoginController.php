<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view("admin.users.login", [
            "title" => "Login Quin-Shop",
        ]);
    }
    //Ham xu ly du lieu gui tu form dang nhap
    public function store(Request $request)
    {
       //Kiem tra du lieu dau vao
       $this->validate($request, [
        "email"=> "required|email:filter",
        "password"=> "required"
       ]);
   //Kiem tra thong tin dang nhap co khop voi du lieu trong DB hay khong 
    if(Auth::attempt([
        "email"=> $request->email,
        "password"=>$request->password],
         $request->remember)){
            return redirect() ->route("admin");
         }
   return redirect()->back()->withErrors("Email hoặc password không chính xác !");
}
}