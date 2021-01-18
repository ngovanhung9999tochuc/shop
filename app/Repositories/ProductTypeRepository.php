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
        return $this->productType->latest()->get();
    }


    public function create($request)
    {
        try {
            $rules = [
                'name' => 'required|unique:product_types|regex:/(^[\pL0-9 ]+$)/u',
                'image_file' => 'mimes:jpg,jpeg,png,gif|max:10240',
            ];
            $messages = [
                'name.regex' => 'Tên danh mục không được phép có ký tự đặc biệt',
                'name.required' => 'Tên danh mục không được phép trống',
                'name.unique' => 'Tên danh mục đã được sử dụng',
                'image_file.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
                'image_file.max' => 'Hình thẻ giới hạn dung lượng không quá 10M',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }

            $random = '';
            for ($i = 0; $i < 1000000; $i++) {
                $randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 2);
                $randomletter = strtoupper($randomletter);
                $count = DB::select('SELECT * FROM product_types WHERE key_code=?', [$randomletter]);
                if (count($count) == 0) {
                    $random = $randomletter;
                    break;
                }
            }
            if ($random != '') {
                $dataProductTypeCreate = [
                    'name' => $request->name,
                    'parent_id' => $request->parent_id,
                    'key_code' => $random
                ];
                $dataUploadFeatureImage = $this->storageTraitUpload($request, 'image_file', 'producttype', 'type');
                if (!empty($dataUploadFeatureImage)) {
                    $dataProductTypeCreate['icon'] = $dataUploadFeatureImage['file_path'];
                }
                $id = $this->productType->create($dataProductTypeCreate)->id;
                $productType = $this->productType->find($id);
                $productType->productTypeParent;
                return response()->json(array('success' => true, 'productType' => $productType), 200);
            } else {
                return response()->json(array('success' => false), 200);
            }
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }


    public function update($request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'name' => 'required|regex:/(^[\pL0-9 ]+$)/u',
                'image_file' => 'mimes:jpg,jpeg,png,gif|max:10240',
            ];
            $messages = [
                'name.regex' => 'Tên danh mục không được phép có ký tự đặc biệt',
                'name.required' => 'Tên danh mục không được phép trống',
                'image_file.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
                'image_file.max' => 'Hình thẻ giới hạn dung lượng không quá 10M',

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

            $anchor = true;
            $message = '';
            $type = ProductType::find($id);
            $data = [];
            if ($type->parent_id == 0) {
                $types = $type->productTypeChildrents;
                if (count($types) != 0) {
                    $count = count($types);
                    $anchor = false;
                    $message = 'Bạn không thể xóa, danh mục hiện tại đang có ' . $count . ' danh mục con';
                    foreach ($types as  $type) {
                        $data[$type->id]['id'] = $type->id;
                        $data[$type->id]['name'] = $type->name;
                    }
                }
            } else {
                $products = $type->products;
                if (count($products) != 0) {
                    $count = count($products);
                    $anchor = false;
                    $message = 'Bạn không thể xóa, danh mục hiện tại đang có ' . $count . ' sản phẩm';
                    foreach ($products as  $product) {
                        $data[$product->id]['id'] = $product->id;
                        $data[$product->id]['name'] = $product->name;
                    }
                }
            }
            if ($anchor) {
                $type->delete();
                return response()->json([
                    'code' => 200,
                    'message' => "success",
                ], 200);
            } else {
                return response()->json([
                    'code' => 500,
                    'message' => $message,
                    'data' => $data
                ], 200);
            }
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
            $htmlOption = '<option value="0">Không có danh mục cha</option>';
            $htmlOption .= $this->productTypeRecusive->ProductTypeLoopAdd();
            return response()->json(array('success' => true, 'htmlOption' => $htmlOption), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }

    public function edit($request)
    {
        try {
            DB::beginTransaction();
            $productType = $this->productType::find($request->id);
            $htmlOption = '<option value="0">Không có danh mục cha</option>';
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
