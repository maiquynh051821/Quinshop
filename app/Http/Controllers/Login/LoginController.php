<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class LoginController extends Controller
{
    //
    public function index()
    {
        return view("login.login", [
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
            $user = Auth::user();
            $role = $user->role;
            if($role === 'admin'){
                return redirect()->route("admin");
            }elseif($role === 'user'){
                return redirect()->route("user");
         }
         }
        
     
   return redirect()->back()->withErrors("Email hoặc password không chính xác !");
}
}