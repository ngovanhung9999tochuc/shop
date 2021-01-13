<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    ///storage/product/DTSS000001/IFcdwv88mgjB3PNJ9Aly.png
    ///storage/product/DTSS000001/v1pYBeKGHiFFxyt1F9fW.jpg
    protected $repository;

    public function __construct(UserRepository $repository)
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
        $roles = $this->repository->getRoles();
        $users = $this->repository->getAll();
        return view('back_end.admin.user.index', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
       $result=$this->repository->show($request);
       echo json_encode($result);
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

    public function updateRole(Request $request)
    {
        $this->repository->updateRole($request);
    }

    public function search(Request $request)
    {
        $roles = $this->repository->getRoles();
        $users = $this->repository->search($request);
        return view('back_end.admin.user.index', ['users' => $users, 'roles' => $roles]);
    }

    public function updateInfo(UpdateUserInfoRequest $request)
    {
       return $this->repository->updateInfo($request);
    }
    public function updatePassword(Request $request)
    {
       return $this->repository->updatePassword($request);
    }

    public function updateImageUser(Request $request)
    {
       return $this->repository->updateImageUser($request);
    }
}
