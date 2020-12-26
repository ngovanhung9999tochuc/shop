<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\Product;
use App\Traits\StorageImageTrait;
use App\Traits\MessageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateTime;

class BillRepository
{

    protected $bill;
    protected $product;
    use StorageImageTrait;
    use MessageTrait;
    public function __construct(Bill $bill, Product $product)
    {
        $this->bill = $bill;
        $this->product = $product;
    }

    public function getAll()
    {
        return $this->bill->latest()->paginate(10);
    }


    public function create($request)
    {
    }


    public function show($request)
    {

        try {
            DB::beginTransaction();
            $bill = $this->bill->find($request->id);
            $user = $bill->user;
            $products = $bill->products;
            DB::commit();
            return response()->json(array('success' => true, 'bill' => $bill), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }

    public function destroy($id)
    {
        try {
            $bill = $this->bill->find($id);
            $bill->delete();
            return response()->json([
                'code' => 200,
                'message' => "success",
            ], 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => "fail",
            ], 500);
        }
    }

    public function search($request)
    {
        $table_search = $request->table_search;
        if (isset($request->from) && isset($request->to)) {
            $table_search = "abc";
        }
        return $this->bill->where('id', 'like', '%' . $table_search . '%')
            ->orWhereBetween('date_order', [$request->from, $request->to])->paginate(10);
    }

    public function searchStatus($request)
    {
        return $this->bill->where('status', 'like', '%' . $request->status . '%')->paginate(10);
    }

    public function changeStatus($request)
    {
        try {
            DB::beginTransaction();
            $this->bill->find($request->id)->update([
                'status' => $request->status
            ]);
            $bill = $this->bill->find($request->id);
            DB::commit();
            return response()->json(array('success' => true, 'status' => $bill->status), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }
}
