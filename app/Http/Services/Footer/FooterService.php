<?php

namespace App\Http\Services\Footer;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Footer;

class FooterService
{
    public function create($data)
    {
        try {
            Footer::create($data);
            Session::flash('success', 'Thêm footer thành công ');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm footer không thành công');
            Log::info($err->getMessage()); //Ghi log loi
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $footer = Footer::findOrFail($id);
            $footer->update($data);
            Session::flash('success', 'Cập nhật footer thành công');
            return $footer;
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật footer không thành công');
            Log::info($err->getMessage());
            return false;
        }
    }
    
    public function delete($request)
    {
        $footer = Footer::where('id',$request->input('id'))->first();// Kiem tra ton tai khong 
        if($footer){
            $footer->delete();
            return true;
        }
        return false;
    }

    public function getAll()
    {
        return Footer::all();
    }

    public function getById($id)
    {
        return Footer::findOrFail($id);
    }
}