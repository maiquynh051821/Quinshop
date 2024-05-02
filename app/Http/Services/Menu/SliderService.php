<?php

namespace App\Http\Services\Menu;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\Menu;
use App\Models\Admin\Slider;

class SliderService
{
    #Them slider
    public function insert($request)
    {
        try {
            #$request->except('_token') ; // Bo token
            Slider::create($request->input());
            Session::flash('success', 'Thêm Slider mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Slider mới không thành công');
            Log::info($err->getMessage());
            return false;
        }

        return true;
    }

    #Hien thi list slider
    public function get()
    {
        return Slider::orderByDesc('id')->paginate(10);
    }

    #Update slider
    public function update($request, $slider)
    {
        try{
            $slider->fill($request->input());
            $slider->save();
            Session::flash('success','Cập nhật Slider thành công');
        }catch(\Exception $err){
            Session::flash('error','Cập nhật Slider không thành công');
            Log::info($err->getMessage()); //Ghi loi ra log
            return false;
        }

        return true;
    }
}
