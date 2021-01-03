<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
            $ul = '';
            $menus = Menu::where('parent_id', 0)->orderBy('id', 'asc')->get();
            $ul .= '<ul>';
            foreach ($menus as $menu) {
                $childrens = Menu::where('parent_id', $menu->id)->orderBy('id', 'asc')->get();
                $ul .= '<li><a href="' . route('typeproduct', [$menu->product_type_link, $menu->id]) . '">' . $menu->name . '</a>';
                $ul .= '<ul>';
                foreach ($childrens as  $children) {
                    $ul .= '<li><a href="' . route('typeproduct', [$children->product_type_link, $children->id]) . '">' . $children->name . '</a>';
                }
                $ul .= '</ul>';
                $ul .= '</li>';
            }
            $ul .= '</ul>';
            $view->with('htmlMenu', $ul);
        });
    }
}
