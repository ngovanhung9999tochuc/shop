<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductType;

use App\Traits\StorageImageTrait;
use App\Traits\MessageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductRepository
{

    protected $product;
    protected $productImage;
    use StorageImageTrait;
    use MessageTrait;
    public function __construct(Product $product, ProductImage $productImage)
    {
        $this->product = $product;
        $this->productImage = $productImage;
    }

    public function getAll()
    {
        return $this->product->latest()->get();
    }


    public function create($request)
    {
        try {
            DB::beginTransaction();
            $productType = ProductType::find($request->product_type);
            if ($productType->parent_id == 0) {
                return $this->infoMessage("Bạn chưa chọn danh mục");
            }
            $number_id = str_pad(count($this->product->all()), 6, "0", STR_PAD_LEFT);
            $id = $productType->productTypeParent->key_code . $productType->key_code . $number_id;

            $specifications = [
                'cpu' => $request->cpu,
                'ram' => $request->ram,
                'displayscreen' => $request->displayscreen,
                'rom_harddrive' => $request->rom_harddrive,
                'operatingsystem' => $request->operatingsystem,
            ];

            $dataProductCreate = [
                'id' => $id,
                'name' => $request->name,
                'specifications' => $specifications,
                'description' => $request->description,
                'specifications_all' => $request->specifications_all,
                'publisher' => $request->publisher,
                'user_id' => auth()->user()->id,
                'product_type_id' => $request->product_type
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'image_file', 'product', $id);
            if (!empty($dataUploadFeatureImage)) {
                $dataProductCreate['image'] = $dataUploadFeatureImage['file_path'];
            }
            $product = $this->product->create($dataProductCreate);

            // Insert data to product_images
            if ($request->hasFile('detailed_image_file')) {
                foreach ($request->detailed_image_file as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem, 'product', $id);
                    $product->productImages()->create([
                        'image' => $dataProductImageDetail['file_path']
                    ]);
                }
            }
            DB::commit();
            $request->session()->flash('message', "<script>
            let base_url = window.location.origin;
            Swal.fire({
                title: 'Thêm thành công, bạn có muốn xem sản phẩm không ?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Hủy',
                confirmButtonText: 'Chấp nhận'
            }).then((result) => {
                if (result.isConfirmed) {
                window.location=base_url+'/admin/product'
                }
            });</script>");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            $request->session()->flash('message', "<script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi hệ thống !',
                showConfirmButton: false,
                timer: 4000
            })</script>");
            return redirect()->back();
        }
    }


    public function update($request, $id)
    {

        try {
            DB::beginTransaction();
            $productType = ProductType::find($request->product_type);
            if ($productType->parent_id == 0) {
                return $this->infoMessage("Bạn chưa chọn danh mục");
            }

            $specifications = [
                'cpu' => $request->cpu,
                'ram' => $request->ram,
                'displayscreen' => $request->displayscreen,
                'rom_harddrive' => $request->rom_harddrive,
                'operatingsystem' => $request->operatingsystem,
            ];

            $dataProductUpdate = [
                'name' => $request->name,
                'specifications' => $specifications,
                'description' => $request->description,
                'specifications_all' => $request->specifications_all,
                'publisher' => $request->publisher,
                'user_id' => 1,
                'product_type_id' => $request->product_type
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'image_file', 'product', $id);
            if (!empty($dataUploadFeatureImage)) {
                $dataProductUpdate['image'] = $dataUploadFeatureImage['file_path'];
            }
            $this->product->find($id)->update($dataProductUpdate);
            $product = $this->product->find($id);


            // update data to product_images
            if ($request->hasFile('detailed_image_file')) {
                $this->productImage->where('product_id', $id)->delete();
                foreach ($request->detailed_image_file as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem, 'product', $id);
                    $product->productImages()->create([
                        'image' => $dataProductImageDetail['file_path']
                    ]);
                }
            }
            DB::commit();
            return $this->successfulMessage('sửa', 'sản phẩm');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return $this->errorMessage('sửa', 'sản phẩm');
        }
    }

    public function destroy($id)
    {
        try {
            $product = $this->product->find($id);
            $product->delete();
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
        return $this->product->where('name', 'like', '%' . $request->table_search . '%')
            ->orWhere('id', 'like', '%' . $request->table_search . '%')->paginate(10);
    }

    public function setPrice($request, $id)
    {
        try {
            DB::beginTransaction();

            $dataProductUpdate = [
                'unit_price' => $request->unit_price,
                'promotion_price' => $request->promotion_price,
            ];
            $this->product->find($id)->update($dataProductUpdate);

            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return false;
        }
    }
}
