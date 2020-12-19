<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Traits\StorageImageTrait;
use App\Traits\MessageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierRepository
{

    protected $supplier;
    use StorageImageTrait;
    use MessageTrait;
    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    public function getAll()
    {
        return $this->supplier->latest()->paginate(10);
    }


    public function create($request)
    {
        try {
            DB::beginTransaction();
            $dataSupplierCreate = [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone
            ];

            $this->supplier->create($dataSupplierCreate);
            DB::commit();
            return $this->successfulMessage('thêm', 'nhà cung ứng');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return $this->errorMessage('thêm', 'nhà cung ứng');
        }
    }


    public function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $dataSupplierUpdate = [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone
            ];

            $this->supplier->find($id)->update($dataSupplierUpdate);
            DB::commit();
            return $this->successfulMessage('sửa', 'nhà cung ứng');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return $this->errorMessage('sửa', 'nhà cung ứng');
        }
    }

    public function destroy($id)
    {
        try {
            $supplier = $this->supplier->find($id);
            $supplier->delete();
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
        return $this->supplier->where('name', 'like', '%' . $request->table_search . '%')
            ->orWhere('id', 'like', '%' . $request->table_search . '%')->paginate(10);
    }
}
