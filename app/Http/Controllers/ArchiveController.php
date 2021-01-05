<?php

namespace App\Http\Controllers;

use App\Repositories\ArchiveRepository;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{

    protected $repository;

    public function __construct(ArchiveRepository $repository)
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
        $archives = $this->repository->getAll();
        return view('back_end.admin.archive.index', ['archives' => $archives]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchProductType(Request $request)
    {
        $archives = $this->repository->searchProductType($request);
        return view('back_end.admin.archive.index', ['archives' => $archives]);
    }

    public function search(Request $request)
    {
        $archives = $this->repository->search($request);
        return view('back_end.admin.archive.index', ['archives' => $archives]);
    }
}
