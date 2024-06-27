<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\User\UserService;
use App\Models\User;
class UserController extends Controller
{

    protected $user;
    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    // Lay danh sach tai khoan
    public function index()
    {
        return view("admin.user.list",[
            "title" => "Danh sách người dùng",
            'users' => $this->user->get(),
        ]);
    }

    // Chinh sua thong tin tai khoan
    public function show(User $user)
    {
        return view("admin.user.edit",[
            "title" => "Chỉnh sửa tài khoản: " . $user->name,
            'user' => $user,
        ]);
    }

    //Luu thong tin tai khoan

    public function update(Request $request,User $user)
    {
        $request->validate([
            "name" => "required|max:20",
            "email" => "required|email:filter|unique:users,email,".$user->id,
            'role' => 'required|string',
            'active' => 'required|integer',
            "password" => "nullable|min:5|max:20|confirmed",
        ]);
        $result = $this->user->update($request,$user);
        if($result){
            return redirect('admin/users/list');
        }
        return redirect()->back();
    }

    // Xoa tai khoan
    public function destroy(Request $request)
    {
        $result = $this->user->delete($request);
        if($result){
            return response()->json([
                'error'=>false,
                'message'=> 'Xóa thành công tài khoản',
            ]);
        }
        return response()->json(['error'=>true]);
    }

    public function search(Request $request){
        $name_user = $request->input('name_user');
        $user = User::where('name', 'like', '%'.$name_user.'%')->paginate(10);
        return view("admin.user.list",[
            "title" => "Danh sách người dùng",
            'users' => $user,
        ]);
    }
    
}
