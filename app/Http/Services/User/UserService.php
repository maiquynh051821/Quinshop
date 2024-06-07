<?php

namespace App\Http\Services\User;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public function get()
    {
        return User::orderByDesc('id')->paginate(15);
    }

    public function update($request,$user)
    {
        try{
           $data = $request->only(['name','email','role','active']);
           Log::info($data);
           if($request->filled('password')){
                $data['password'] = Hash::make($request->password);
           }
           $user->fill($data);
           Log::info($user);
           $user->save();
           Session::flash('success','Cập nhật thành công tài khoản');
        }catch(\Exception $err){
            Session::flash('error','Cập nhật không thành công');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($request)
    {
        $user = User::where('id',$request->input('id'))->first();
        if($user){
            $user->delete();
            return true;
        }
        return false;
    }
}