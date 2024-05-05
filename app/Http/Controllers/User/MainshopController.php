<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Menu\SliderService;
class MainshopController extends Controller
{
    protected $slider;
    public function __construct(SliderService $slider){
        $this->slider = $slider;
    }
    public function index()
    {
        return view('user.main',[
            'title' => 'Quin shop',
            'sliders'=> $this->slider->show(),
            
        ]);
    }
}
