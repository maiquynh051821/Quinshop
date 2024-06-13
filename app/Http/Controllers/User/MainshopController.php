<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\Product\ProductService;
use App\Models\Admin\Footer;

class MainshopController extends Controller
{
    protected $slider;
    protected $product;
    public function __construct(SliderService $slider, ProductService $product){
        $this->slider = $slider;
        $this->product = $product;
    }
    public function index()
    {
        return view('user.home',[
            'title' => 'Quin-shop',
            'sliders'=> $this->slider->show(),
            'products' =>$this->product->get(),
        ]);
        
    }
    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0);
        $result = $this->product->get($page);
        //Kiem tra xem co dong nao duoc tra ve tu CSDL khong
        if (count($result) != 0) {
            //Tao 1 doan html bang cach render view 'user.products.list' voi du liệu san phẩm dc truyen vào mảng ['products' => $result]
            $html = view('user.products.list', ['products' => $result ])->render();
            //Tra ve phan hoi JSON chua HTML cua danh sach san pham
            return response()->json([ 'html' => $html ]);
        }
            //Tra ve JSON trống nếu không có sản phẩm nào được tìm thấy
        return response()->json(['html' => '' ]);
    }
    
    public function footerContent($id){
        $footer = Footer::findOrFail($id);
        return view('user.info.footerContent', [
            'title'=> $footer->name,
            'footer' => $footer,
        ]);
    }
}