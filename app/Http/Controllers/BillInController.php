<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillInAddRequest;
use App\Models\Supplier;
use App\Repositories\BillInRepository;
use Illuminate\Http\Request;

class BillInController extends Controller
{


    protected $repository;

    public function __construct(BillInRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bill_ins = $this->repository->getAll();
        return view('back_end.admin.bill_in.index', ['bill_ins' => $bill_ins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back_end.admin.bill_in.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillInAddRequest $request)
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
    public function show(Request $request)
    {
        return $this->repository->show($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
        $bill_ins = $this->repository->search($request);
        return view('back_end.admin.bill_in.index', ['bill_ins' => $bill_ins]);
    }

    public function searchProducts(Request $request)
    {
        $result = $this->repository->searchProducts($request);
        echo json_encode($result);
    }

    public function getSuppliers(Request $request)
    {
        return $this->repository->getSuppliers();
    }
}
