<?php

namespace App\Repositories;

use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoleRepository
{

    protected $role;
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function getAll()
    {
        
    }


    public function create($request)
    {
       
    }


    public function update($request)
    {
        
    }

    public function destroy($id)
    {
       
    }

    public function search($request)
    {
       
    }
}
