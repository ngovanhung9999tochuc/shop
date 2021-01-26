<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->composer('front_end.parials.mainmenu', function ($view) {

            //menu
            $ul = '';
            $menus = ProductType::where('parent_id', 0)->orderBy('id', 'asc')->limit(4)->get();
            $ul .= '<ul>';
            foreach ($menus as $menu) {
                $childrens = ProductType::where('parent_id', $menu->id)->orderBy('id', 'asc')->get();
                $ul .= '<li><a href="' . route('typeproduct', [$menu->key_code, $menu->id]) . '">' . $menu->name . '</a>';
                $ul .= '<ul>';
                foreach ($childrens as  $children) {
                    $ul .= '<li><a href="' . route('typeproduct', [$children->key_code, $children->id]) . '">' . $children->name . '</a>';
                }
                $ul .= '</ul>';
                $ul .= '</li>';
            }
            $ul .= '</ul>';
              
           
            //cart

            $oldCart = Session('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            $dataCart = [
                'items' => $cart->items,
                'totalPrice' => $cart->totalPrice,
                'totalQty' => $cart->totalQty
            ];
            $view->with(['htmlMenu' => $ul, 'dataCart' => $dataCart]);
        });
    }
}
