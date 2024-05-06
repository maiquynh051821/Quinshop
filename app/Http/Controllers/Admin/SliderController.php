<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Models\Admin\Slider;
class SliderController extends Controller
{
    protected $slider;
    public function __construct(SliderService $slider)
    {
        $this->slider = $slider;
    }
    
    public function create()
    {
        return view('admin.slider.add', [
            'title' => 'Thêm Slider',
        ]);
    }
    
    #Tao slider
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url' => 'required',
        ]);
        $this->slider->insert($request);
        return redirect()->back();
    }
    #Hien thi list
    public function index()
    {
        return view('admin.slider.list', [
            'title' => 'Danh sách Slider',
            'sliders' => $this->slider->get(),
        ]);
    }
    public function show(Slider $slider)
    {
        return view('admin.slider.edit', [
            'title' => 'Chỉnh sửa Slider: ' . $slider->name,
            'slider' => $slider,
        ]);
    }

    #Cap nhat slider
    public function update(Request $request, Slider $slider)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url' => 'required',
        ]);
        $result = $this->slider->update($request,$slider);
        if($request){
            return redirect('/admin/sliders/list');
        }
        return redirect()->back();
    }

    #Xoa slider
    public function destroy(Request $request)
    {
        $result = $this->slider->delete($request);
        if($result){
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công slider',
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Không xóa thành công slider', 
        ]);
    }
}
