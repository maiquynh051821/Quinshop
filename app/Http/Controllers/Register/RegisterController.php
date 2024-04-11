<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function Livewire\store;

class RegisterController extends Controller
{
    public function index()
    {
        return view(
            "register.signup",
            ["title" => "Đăng ký"]
        );
    }
    public function store()
    {
        $this->validate(request(), [
            "name" => "required|max:20",
            "email" => "required|email:filter|unique:users",
            "password" => "required|min:5|max:20|confirmed",
        ]);

            $data = request()->all();
          
            $user = new User();
            $user->name = $data["name"];
            $user->email = $data["email"];
            $user->password = bcrypt($data["password"]);
            $user->save();
            session()->flash("success", "Đăng ký tài khoản thành công !");
           return redirect()->route('login');
    }
}
