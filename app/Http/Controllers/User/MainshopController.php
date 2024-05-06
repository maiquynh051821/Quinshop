<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\Product\ProductService;

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
            'title' => 'Quin shop',
            'sliders'=> $this->slider->show(),
            'products' =>$this->product->get(),
        ]);
    }
}
