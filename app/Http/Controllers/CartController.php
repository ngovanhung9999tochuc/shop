<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    protected $repository;

    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addItemToCart(Request $request)
    {
        return $this->repository->addItemToCart($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeQuantityItemToCart(Request $request)
    {
        return $this->repository->changeQuantityItemToCart($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function deleteItemToCart(Request $request)
    {
        return $this->repository->deleteItemToCart($request);
    }
}
