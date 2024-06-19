<?php

namespace App\Http\Controllers;
use App\Models\Admin\Menu;
use App\Models\Admin\Product;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $title = 'Trang quản lý';
        $menu = Menu::all();
        $sumMenu = $menu->count();
        $product = Product::all();
        $sumProduct = $product->count();

        $user = User::where('role','user')->get();
        $sumUser = $user->count();

        $customer = Customer::all();
        $sumCustomer = $customer->count();
        return view('admin.dashboard',compact('title','sumMenu','sumProduct','sumUser','sumCustomer'));
    }
}
