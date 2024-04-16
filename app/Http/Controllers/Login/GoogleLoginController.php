<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        $user = Socialite::driver('google')->user();

        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu dựa trên google_id
        $existingUser = User::where('google_id', $user->id)->first();

        if ($existingUser) {
            // Đăng nhập người dùng đã tồn tại
            auth()->login($existingUser, true);
        } else {
            // Kiểm tra xem địa chỉ email đã tồn tại trong cơ sở dữ liệu hay chưa
            $existingEmailUser = User::where('email', $user->email)->first();

            if ($existingEmailUser) {
                // Hiển thị thông báo lỗi
                return redirect()->route('login')->with('error', 'Địa chỉ email đã được sử dụng. Vui lòng đăng nhập bằng email hoặc tạo một tài khoản mới.');
            } else {
                // Tạo một người dùng mới
                $newUser = new User();
                $newUser->name = $user->name;
                $newUser->email = $user->email;
                $newUser->google_id = $user->id;
                $newUser->password = ''; // Không cần phải tạo mật khẩu ngẫu nhiên vì người dùng đã đăng nhập bằng Google
                $newUser->save();

                // Đăng nhập người dùng mới
                auth()->login($newUser, true);
            }
        }

        // Redirect đến URL được yêu cầu bởi người dùng
        $user = Auth::user();
        $role = $user->role;
        if ($role === 'admin') {
            return redirect()->route("admin");
        } elseif ($role === 'user') {
            return redirect()->route("user");
        }
        return redirect()->route("login")->with("error","Lỗi không đăng nhập được bằng google!");
    }
}
