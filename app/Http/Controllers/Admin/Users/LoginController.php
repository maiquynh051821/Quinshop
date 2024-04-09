<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view("admin.users.login", [
            "title" => "Login Quin-Shop",
        ]);
    }
    public function store(Request $request)
    {
       $this->validate($request, [
        "email"=> "required|email:filter",
        "password"=> "required"
       ]);
    }
}
