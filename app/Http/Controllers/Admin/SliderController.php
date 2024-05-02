<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Menu\SliderService;
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
}
