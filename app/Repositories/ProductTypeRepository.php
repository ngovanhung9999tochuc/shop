<?php

namespace App\Repositories;

use App\Models\ProductType;

use App\Traits\StorageImageTrait;
use App\Traits\MessageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Components\ProductTypeRecusive;
use Illuminate\Support\Facades\Validator;

class ProductTypeRepository
{

    protected $productType;
    protected $productTypeRecusive;
    use StorageImageTrait;
    use MessageTrait;
    public function __construct(ProductType $productType, ProductTypeRecusive $productTypeRecusive)
    {
        $this->productType = $productType;
        $this->productTypeRecusive = $productTypeRecusive;
    }

    public function getAll()
    {
        return $this->productType->latest()->paginate(10);
    }


    public function create($request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'name' => 'required',
                'image_file' => 'mimes:jpg,jpeg,png,gif|max:10240',
                'key_code' => 'required|size:2|unique:product_types|regex:/^[a-zA-Z]+$/'
            ];
            $messages = [
                'name.required' => 'Tên không được phép trống',
                'image_file.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
                'image_file.max' => 'Hình thẻ giới hạn dung lượng không quá 10M',
                'key_code.required' => 'Mã không được phép trống',
                'key_code.size' => 'Mã không được phép nhiều hơn 2 ký tự',
                'key_code.unique' => 'Mã không được phép trùng lặp',
                'key_code.regex' => 'Mã phải là ký tự'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }

            $dataProductTypeCreate = [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'key_code' => strtoupper($request->key_code)
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'image_file', 'producttype', 'type');
            if (!empty($dataUploadFeatureImage)) {
                $dataProductTypeCreate['icon'] = $dataUploadFeatureImage['file_path'];
            }
            $id = $this->productType->create($dataProductTypeCreate)->id;
            $productType = $this->productType->find($id);
            $productType->productTypeParent;
            DB::commit();
            return response()->json(array('success' => true, 'productType' => $productType), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }


    public function update($request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'name' => 'required',
                'image_file' => 'mimes:jpg,jpeg,png,gif|max:10240',
                'key_code' => 'required|size:2|regex:/^[a-zA-Z]+$/'
            ];
            $messages = [
                'name.required' => 'Tên không được phép trống',
                'image_file.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
                'image_file.max' => 'Hình thẻ giới hạn dung lượng không quá 10M',
                'key_code.required' => 'Mã không được phép trống',
                'key_code.size' => 'Mã không được phép nhiều hơn 2 ký tự',
                'key_code.regex' => 'Mã phải là ký tự'
                
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }

            $dataProductTypeUpdate = [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'key_code' => strtoupper($request->key_code)
            ];
            $p = $this->productType->find($request->id);
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'image_file', 'producttype', 'type');
            if (!empty($dataUploadFeatureImage)) {
                $dataProductTypeUpdate['icon'] = $dataUploadFeatureImage['file_path'];
                ///storage/producttype/type/t1lVlYwIifyl5qPtfPCo.jpg
                $filename = str_replace('/storage/producttype/type/', '', $p->icon);
                // remove old image
                unlink(storage_path('app/public/producttype/type/' . $filename));
            }
            $p->update($dataProductTypeUpdate);
            $productType = $this->productType->find($request->id);
            $productType->productTypeParent;
            DB::commit();
            return response()->json(array('success' => true, 'productType' => $productType), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
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

    public function getParent()
    {
        try {
            DB::beginTransaction();
            $htmlOption = '<option value="0">Không có thuộc loại</option>';
            $htmlOption .= $this->productTypeRecusive->ProductTypeLoopAdd();
            DB::commit();
            return response()->json(array('success' => true, 'htmlOption' => $htmlOption), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }

    public function edit($request)
    {
        try {
            DB::beginTransaction();
            $productType = $this->productType::find($request->id);
            $htmlOption = '<option value="0">Không có thuộc loại</option>';
            $htmlOption .= $this->productTypeRecusive->ProductTypeLoopEdit($productType->parent_id);
            DB::commit();
            return response()->json(array('success' => true, 'htmlOption' => $htmlOption, 'productType' => $productType), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }
}
