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
        return $this->supplier->latest()->get();
    }


    public function create($request)
    {
        try {
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
            return response()->json(array('success' => true, 'supplier' => $supplier), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }


    public function update($request)
    {
        try {
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
            return response()->json(array('success' => true, 'supplier' => $supplier), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }

    public function destroy($id)
    {
        try {
            $supplier = Supplier::find($id);
            $anchor = true;
            $message = '';
            $data = [];
            $bills = $supplier->billIns;
            if (count($bills) != 0) {
                $count = count($bills);
                $anchor = false;
                $message = 'Bạn không thể xóa, nhà cung cấp hiện tại đang có ' . $count . ' phiếu nhập kho';
                foreach ($bills as  $bill) {
                    $data[$bill->id]['id'] = $bill->id;
                    $data[$bill->id]['input_date'] = date("Y/m/d", strtotime($bill->input_date));
                    $data[$bill->id]['user_name'] = $bill->user->name;
                }
            }
            
            if ($anchor) {
                $supplier->delete();
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
        return $this->supplier->where('name', 'like', '%' . $request->table_search . '%')
            ->orWhere('id', 'like', '%' . $request->table_search . '%')->get();
    }
}
