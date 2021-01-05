<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Repositories\BillRepository;
use Illuminate\Http\Request;

class BillController extends Controller
{

    protected $repository;

    public function __construct(BillRepository $repository)
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

        $bills = $this->repository->getAll();
        return view('back_end.admin.bill.index', ['bills' => $bills]);
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

        $bills = $this->repository->search($request);
        return view('back_end.admin.bill.index', ['bills' => $bills]);
    }

    public function searchStatus(Request $request)
    {
        $bills = $this->repository->searchStatus($request);
        return view('back_end.admin.bill.index', ['bills' => $bills]);
    }

    public function changeStatus(Request $request)
    {
        return $this->repository->changeStatus($request);
    }
}
