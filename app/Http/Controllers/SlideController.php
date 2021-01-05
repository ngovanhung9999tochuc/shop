<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Repositories\SlideRepository;
use Illuminate\Http\Request;

class SlideController extends Controller
{

    protected $repository;

    public function __construct(SlideRepository $repository)
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
        $slides = $this->repository->getAll();
        return view('back_end.admin.slide.index', ['slides' => $slides]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $slide = Slide::find($request->id);
        return json_encode((object) array('slide' => $slide));
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
        $slides = $this->repository->search($request);
        return view('back_end.admin.slide.index', ['slides' => $slides]);
    }
}
