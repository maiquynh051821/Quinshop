<?php

namespace App\Providers;

use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\MenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Footer;
use App\Models\Admin\SiteInfo;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('user.header', MenuComposer::class);
        View::composer('*', function ($view) {
            $cartCount = $this->countProductsInCart(); // Gọi hàm để đếm số lượng sản phẩm trong giỏ hàng
            $view->with('cartCount', $cartCount);
            $likeCount = $this->countLike();
            $view->with('likeCount', $likeCount);
        });
        View::composer(['user.footer'], function ($view) {
            $footers =$this->getFooter();
            $view->with('footers',$footers);
        });
        View::composer(['admin.sidebar','user.header','user.footer'], function ($view) {
            $infoSites =$this->getInfo();
            $view->with('infoSites',$infoSites);
        });
       
    }

    // Dem so san pham trong gio hang
    private function countProductsInCart()
    {
        $carts = Session::get('carts', []);
        $totalQuantity = count($carts);

        return $totalQuantity;
    }
    private function countLike()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đang xác thực
        if ($user) {
            $likeCount = $user->favoriteProducts()->count(); // Đếm số lượng sản phẩm được thích của người dùng
            return $likeCount;
        } else {
            return 0; // Trả về 0 nếu không có người dùng nào đang xác thực
        }
    }
    private function getFooter()
    {
        
        $footers = Footer::where('active',1)->get();
        return $footers;
    }
    private function getInfo()
    {
        $infoSites = SiteInfo::get();
        return $infoSites;
    }
}