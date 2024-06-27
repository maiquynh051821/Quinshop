<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Models\Admin\Slider;
use Illuminate\Support\Facades\File;
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
        $data = $request->all();
        $slider = new Slider();
        $slider->name = $data['name'];
        $slider->url = $data['url'];
        $slider->sort_by = $data['sort_by'];
        $slider->active = $data['active'];
        $slider->name = $data['name'];
        $path_upload = 'uploads/sliders/';
        if (!File::exists(public_path($path_upload))) {
            File::makeDirectory(public_path($path_upload), 0755, true);
        }
        if ($request->hasFile('file_img')) {
            $file = $request->file('file_img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($path_upload), $filename);
            $slider->thumb = $path_upload . $filename;
        }
        $slider->save();
        return redirect()->back()->with('success', 'Thêm mới slider  thành công');
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
    public function update(Request $request)
    {
        $data = $request->all();
        $slider = Slider::where('id',$data['id'])->first();
        $slider->name = $data['name'];
        $slider->url = $data['url'];
        $slider->sort_by = $data['sort_by'];
        $slider->active = $data['active'];
        $slider->name = $data['name'];
        $path_upload = 'uploads/sliders/';
        if (!File::exists(public_path($path_upload))) {
            File::makeDirectory(public_path($path_upload), 0755, true);
        }
        if ($request->hasFile('file_img')) {
            $file = $request->file('file_img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($path_upload), $filename);
            $slider->thumb = $path_upload . $filename;
        }
        $slider->save();
        return redirect()->back()->with('success', 'Chỉnh sửa slider  thành công');
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
