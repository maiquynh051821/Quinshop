<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Menu\SliderService;
class SliderController extends Controller
{
    protected $slider;
    public function __construct(SliderService $slider){
        $this->slider = $slider;
    }
    public function create()
    {
        return view('admin.slider.add',[
            'title' => 'Thêm Slider',
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'thumb' => 'required',
            'url' => 'required',
        ]);
        $this->slider->insert($request);
        return redirect()->back();
    }
}
