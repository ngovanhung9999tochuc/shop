<?php

namespace App\Repositories;

use App\Models\ProductType;

use App\Traits\StorageImageTrait;
use App\Traits\MessageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductTypeRepository
{

    protected $productType;
    use StorageImageTrait;
    use MessageTrait;
    public function __construct(ProductType $productType)
    {
        $this->productType = $productType;
    }

    public function getAll()
    {
        return $this->productType->latest()->paginate(10);
    }


    public function create($request)
    {
        try {
            DB::beginTransaction();
            $dataProductTypeCreate = [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'key_code' => strtoupper($request->key_code)
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'image_file', 'producttype', 'type');
            if (!empty($dataUploadFeatureImage)) {
                $dataProductTypeCreate['icon'] = $dataUploadFeatureImage['file_path'];
            }
            $this->productType->create($dataProductTypeCreate);
            DB::commit();
            return $this->successfulMessage('thêm', 'loại sản phẩm');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return $this->errorMessage('thêm', 'loại sản phẩm');
        }
    }


    public function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $dataProductTypeCreate = [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'key_code' => strtoupper($request->key_code)
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'image_file', 'producttype', 'type');
            if (!empty($dataUploadFeatureImage)) {
                $dataProductTypeCreate['icon'] = $dataUploadFeatureImage['file_path'];
            }
            $this->productType->find($id)->update($dataProductTypeCreate);
            DB::commit();
            return $this->successfulMessage('sửa', 'loại sản phẩm');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return $this->errorMessage('sửa', 'loại sản phẩm');
        }
    }

    public function destroy($id)
    {
        try {
            $productType = $this->productType->find($id);
            $productType->delete();
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
        return $this->productType->where('name', 'like', '%' . $request->table_search . '%')
            ->orWhere('id', 'like', '%' . $request->table_search . '%')->paginate(10);
    }
}
