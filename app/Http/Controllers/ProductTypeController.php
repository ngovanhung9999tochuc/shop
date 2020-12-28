<?php

namespace App\Http\Controllers;

use App\Components\ProductTypeRecusive;
use App\Http\Requests\ProductTypeAddRequest;
use App\Models\ProductType;
use App\Repositories\ProductTypeRepository;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    protected $repository;
    protected $productTypeRecusive;

    public function __construct(ProductTypeRepository $repository, ProductTypeRecusive $productTypeRecusive)
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
        $productTypes = $this->repository->getAll();
        return view('back_end.admin.producttype.index', ['productTypes' => $productTypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $htmlOption = $this->productTypeRecusive->ProductTypeLoopAdd();
        return view('back_end.admin.producttype.add', ['htmlOption' => $htmlOption]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->repository->create($request);
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
    public function edit(Request $request)
    {
       return $this->repository->edit($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $this->repository->update($request);
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

    public function search(Request $request)
    {
        $productTypes = $this->repository->search($request);
        return view('back_end.admin.producttype.index', ['productTypes' => $productTypes]);
    }

    public function getParent(Request $request)
    {
        return $this->repository->getParent();
    }
}
