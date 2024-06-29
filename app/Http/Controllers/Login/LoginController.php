<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view("login.login", [
            "title" => "Login Quin-Shop",
        ]);
    }

    public function forget_password()
    {
        return view("login.forget_pass", [
            "title" => "Login Quin-Shop",
        ]);
    }

    public function check_email(Request $request)
    {
        $userName = $request->email;
        $user = User::where('email',$userName)->first();
        if ($user && $user->google_id == null) {
            $code = rand(100000, 999999);
            session(['code' => $code]);
            $dataMail = ['code' => $code];
            Mail::send('login.mail_code', $dataMail, function ($email) use ($userName) {
                $email->to($userName);
                $email->subject('Thông báo Shop Quin');
            });
           return view('login.view_code',compact('userName'));
        }elseif($user && $user->google_id != null){
            return redirect()->back()->with('error','Tài khoản này đã được đăng nhập bằng google nên không cần mật khẩu');
        } else {
            return redirect()->back()->with('error','Email của bạn chưa được đăng kí');
        }
    }

    public function reset_password(Request $request){
        $userName = $request->userName;
        $passWord = $request->password;
        $user = User::where('email',$userName)->first();
        $user->password = bcrypt($passWord);
        $user->save();
        return redirect()->route('login')->with('success','Bạn đã thay đổi mật khẩu thành công');
    }
    //Ham xu ly du lieu gui tu form dang nhap
    public function store(Request $request)
    {
        //Kiem tra du lieu dau vao
        $this->validate($request, [
            "email" => "required|email:filter",
            "password" => "required"
        ]);

        //Kiem tra thong tin dang nhap co khop voi du lieu trong DB hay khong 
        if (Auth::attempt(
            [
                "email" => $request->email,
                "password" => $request->password
            ],
            $request->remember
        )) {

            //Kiem tra ghi nho dang nhap hay khong, luu phien dang nhap trong 1d = 12*60*60s
            if ($request->remember) {
                setcookie("email", $request->email, time() + 86400,);
                setcookie("password", $request->password, time() + 86400,);
            } else {
                setcookie("email", "", time() - 3600);
                setcookie("password", "", time() - 3600);
            }
            //Phan quyen login : admin-user
            $user = Auth::user();
            if ($user->active == 1) {
                $role = $user->role;
                if ($role === 'admin') {
                    return redirect()->route("dashboard");
                } elseif ($role === 'user') {
                    return redirect()->route("user");
                }
            } else {
                Auth::logout();
                return redirect()->back()->withErrors("Tài khoản của bạn đang bị khóa ");
            }
        }


        return redirect()->back()->withErrors("Email hoặc password không chính xác !");
    }
}