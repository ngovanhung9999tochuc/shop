<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\Product;
use App\Models\User;
use App\Traits\StorageImageTrait;
use App\Traits\MessageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateTime;

class AdminRepository
{

    public function __construct()
    {
    }

    public function getAll()
    {
        $totalBillNew = Bill::where('status', 0)->get();
        $totalProduct = Product::all();
        $totalUser = User::all();
        return ['totalBillNew' => count($totalBillNew), 'totalProduct' => count($totalProduct), 'totalUser' => count($totalUser)];
    }

    public function create($request)
    {
    }


    public function show($request)
    {
    }

    public function destroy($id)
    {
    }

    public function search($request)
    {
    }
}
