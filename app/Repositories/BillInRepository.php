<?php

namespace App\Repositories;

use App\Models\BillIn;
use App\Models\Product;
use App\Models\Supplier;
use App\Traits\StorageImageTrait;
use App\Traits\MessageTrait;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateTime;

class BillInRepository
{

    protected $bill_in;
    protected $product;
    use StorageImageTrait;
    use MessageTrait;
    public function __construct(BillIn $bill_in, Product $product)
    {
        $this->bill_in = $bill_in;
        $this->product = $product;
    }

    public function getAll()
    {
        return $this->bill_in->latest()->paginate(10);
    }


    public function create($request)
    {
        //dd(empty((array)json_decode($request->data_product_bill)));
        //$myFormatForView = date("m/d/y g:i A", $time);
        //dd($request->all());

        try {
            DB::beginTransaction();
            if (empty((array)json_decode($request->data_product_bill))) {
                return $this->infoMessage("Lưu không thành công, phiếu không có sản phẩm nào !");
            }
            $bill_in_detail = [];
            $date = new DateTime($request->input_date);
            $input_date = $date->format("Y-m-d H:i:s");
            $total_price = preg_replace("/[^0-9]/", "", $request->total_price);
            $product_bill_data = (array)json_decode($request->data_product_bill);
            foreach ($product_bill_data as $key => $product_bill) {
                $bill_in_detail[$product_bill->id]['quantity'] = $product_bill->quantity;
                $bill_in_detail[$product_bill->id]['original_price'] = $product_bill->original_price;
            }

            $data_bill_in_create = [
                'supplier_id' => $request->supplier_id,
                'input_date' => $input_date,
                'total_price' => $total_price,
                'quantity' => $request->quantity,
                'user_id' => 1
            ];
            $bill_in = $this->bill_in->create($data_bill_in_create);
            $bill_in->products()->attach($bill_in_detail);
            DB::commit();
            return $this->successfulMessage('lưu', 'phiếu nhập thành công');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return $this->errorMessage('lưu', 'phiếu nhập thành công');
        }
    }


    public function show($request)
    {
        try {
            DB::beginTransaction();
            $bill_in = $this->bill_in->find($request->id);
            $products = $bill_in->products;
            DB::commit();
            return response()->json(array('success' => true, 'bill' => $bill_in), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }

    public function destroy($id)
    {
        try {
            $bill_in = $this->bill_in->find($id);
            $bill_in->delete();
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
        return $this->bill_in->Where('id', 'like', '%' . $request->table_search . '%')->paginate(10);
    }

    public function searchProducts($request)
    {
        $result = [];
        if ($request->table_search != '') {
            $products = $this->product->where('name', 'like', '%' . $request->table_search . '%')
                ->orWhere('id', 'like', '%' . $request->table_search . '%')->get();
            $i = 0;
            foreach ($products as $key => $value) {
                $result[$i]['id'] = $value->id;
                $result[$i]['name'] = $value->name;
                $i++;
            }
        }
        return $result;
    }
    public function getSuppliers()
    {
        $suppliers = Supplier::all();
        return response()->json(array('success' => true, 'suppliers' => $suppliers), 200);
    }
}
