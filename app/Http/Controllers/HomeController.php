<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\ProductType;
use App\Repositories\HomeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{


    protected $repository;

    public function __construct(HomeRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHome()
    {
        $products = $this->repository->getHome();
        //dd($products['newProducts'][0]->specifications);
        return view('front_end.page.home', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPageTypeProduct($type, $id)
    {
        if ($type == '11') {
            switch ($id) {
                case 1:
                    return redirect()->route('home');
                    break;
                case 10:
                    return redirect()->route('home');
                    break;
                default:
                    return redirect()->route('home');
            }
        } else {

            return view('front_end.page.products', $this->repository->getPageTypeProduct($type, $id));
        }
    }

    public function getTypeProduct($id)
    {
        return view('front_end.page.products', $this->repository->getTypeProduct($id));
    }

    public function getProductDetail($id)
    {
        return view('front_end.page.single_product', $this->repository->getProductDetail($id));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function enterAnOrder(OrderRequest $request)
    {
        return  $this->repository->enterAnOrder($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrder()
    {
        $cart = $this->repository->getOrder();
        return view('front_end.page.cart', $cart);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function getProfile()
    {
        return view('front_end.page.profile');
    }

    public function getBillProduct(Request $request)
    {
        return  $this->repository->getBillProduct($request);
    }
}
