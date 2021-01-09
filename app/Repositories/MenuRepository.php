<?php

namespace App\Repositories;

use App\Components\MenuRecusive;
use App\Models\Menu;
use App\Traits\StorageImageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Components\ProductTypeRecusive;

class MenuRepository
{

    protected $menu;
    protected $menuRecusive;
    protected $productTypeRecusive;
    use StorageImageTrait;
    public function __construct(Menu $menu, MenuRecusive $menuRecusive, ProductTypeRecusive $productTypeRecusive)
    {
        $this->menu = $menu;
        $this->menuRecusive = $menuRecusive;
        $this->productTypeRecusive = $productTypeRecusive;
    }

    public function getAll()
    {
        return $this->menu->latest()->paginate(10);
    }


    public function create($request)
    {
        try {
            DB::beginTransaction();
            $rules = [
                'name' => 'required',
            ];
            $messages = [
                'name.required' => 'Tên không được phép trống',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }

            $dataMenuCreate = [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'product_type_link' => $request->product_type_link
            ];

            $id = $this->menu->create($dataMenuCreate)->id;
            $menu = $this->menu->find($id);
            $menu->menuParent;
            DB::commit();
            return response()->json(array('success' => true, 'menu' => $menu), 200);
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
            ];
            $messages = [
                'name.required' => 'Tên không được phép trống',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }

            $dataMenuUpdate = [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'product_type_link' => $request->product_type_link
            ];

            $this->menu->find($request->id)->update($dataMenuUpdate);
            $menu = $this->menu->find($request->id);
            $menu->menuParent;
            DB::commit();
            return response()->json(array('success' => true, 'menu' => $menu), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }

    }

    public function destroy($id)
    {
        try {
            $menu = $this->menu->find($id);
            $menu->delete();
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
        return $this->menu->where('name', 'like', '%' . $request->table_search . '%')
            ->orWhere('id', 'like', '%' . $request->table_search . '%')->paginate(10);
    }

    public function getParent()
    {
        try {
           
            $option_parents = '<option value="0">Không thuộc menu</option>';
            $option_parents .= $this->menuRecusive->menuLoopAdd();
            $option_product_type = '<option value="11">Không liên kết loại sản phẩm</option>';
            $option_product_type .= $this->productTypeRecusive->productTypeAdd();
            return response()->json(array('success' => true, 'optionParents' => $option_parents, 'optionProductType' => $option_product_type), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }

    public function edit($request)
    {
        try {
            DB::beginTransaction();
            $menu = $this->menu::find($request->id);
            $option_parents = '<option value="0">Không thuộc menu</option>';
            $option_parents .= $this->menuRecusive->menuLoopEdit($menu->parent_id);
            $option_product_type = '<option value="11">Không liên kết loại sản phẩm</option>';
            $option_product_type .= $this->productTypeRecusive->productTypeEdit($menu->product_type_link);
            DB::commit();
            return response()->json(array('success' => true, 'menu' => $menu, 'optionParents' => $option_parents, 'optionProductType' => $option_product_type), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }
}
