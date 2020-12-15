<?php

namespace App\Http\Controllers;

use App\Components\ProductTypeRecusive;
use App\Http\Requests\ProductAddRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{

    protected $repository;
    protected $productTypeRecusive;

    public function __construct(ProductRepository $repository, ProductTypeRecusive $productTypeRecusive)
    {
        $this->repository = $repository;
        $this->productTypeRecusive = $productTypeRecusive;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->repository->getAll();
        return view('back_end.admin.product.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $htmlOption = $this->productTypeRecusive->ProductTypeRecusiveAdd();
        return view('back_end.admin.product.add', ['htmlOption' => $htmlOption]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductAddRequest $request)
    {
        $result = $this->repository->create($request);
        return redirect()->back()->with('message', $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //optional($productItem->category)->name }}
        $product = Product::find($id);
        $htmlOption = $this->productTypeRecusive->ProductTypeRecusiveEdit($product->product_type_id);
        return view('back_end.admin.product.edit', ['product' => $product, 'htmlOption' => $htmlOption]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductAddRequest $request, $id)
    {
        $result = $this->repository->update($request, $id);
        return redirect()->back()->with('message', $result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}