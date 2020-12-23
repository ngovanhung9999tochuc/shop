<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Traits\StorageImageTrait;
use App\Traits\MessageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            //Validate request
            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'phone' => 'required|numeric|digits:10'
            ];
            $messages = [
                'name.required' => 'Tên không được phép trống',
                'email.required' => 'Email không được phép trống',
                'email.email' => 'Không đúng định dạng email',
                'address.required' => 'Địa chỉ không được phép trống',
                'phone.required' => 'Số điện thoại không được phép trống',
                'phone.numeric' => 'Số điện thoại phải là số',
                'phone.digits' => 'Số điện thoại phải là 10 số'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }
            //create supplier
            $dataSupplierCreate = [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone
            ];

            $id = $this->supplier->create($dataSupplierCreate)->id;
            $supplier = $this->supplier->find($id);
            DB::commit();
            return response()->json(array('success' => true, 'supplier' => $supplier), 200);
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
                'email' => 'required|email',
                'address' => 'required',
                'phone' => 'required|numeric|digits:10'
            ];
            $messages = [
                'name.required' => 'Tên không được phép trống',
                'email.required' => 'Email không được phép trống',
                'email.email' => 'Không đúng định dạng email',
                'address.required' => 'Địa chỉ không được phép trống',
                'phone.required' => 'Số điện thoại không được phép trống',
                'phone.numeric' => 'Số điện thoại phải là số',
                'phone.digits' => 'Số điện thoại phải là 10 số'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }

            $dataSupplierUpdate = [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone
            ];
            $this->supplier->find($request->id)->update($dataSupplierUpdate);
            $supplier = $this->supplier->find($request->id);
            DB::commit();
            return response()->json(array('success' => true, 'supplier' => $supplier), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
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
