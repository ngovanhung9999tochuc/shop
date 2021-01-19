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
        return $this->bill->latest()->get();
    }


    public function create($request)
    {
    }


    public function show($request)
    {

        try {
            $archive_bill_in_search = DB::select('SELECT BID.product_id,P.name,SUM(BID.quantity) as quantity,SUM(BID.quantity)*BID.original_price as total_original_price ,SUM(BID.quantity)*P.unit_price AS total_unit_price  FROM bill_in_details AS BID JOIN products AS P ON BID.product_id=P.id WHERE BID.product_id IN (SELECT product_id  FROM bill_details WHERE bill_id=' . $request->id . ')  GROUP BY BID.product_id,P.name');
            $archive_bill = DB::select('SELECT BD.product_id,SUM(BD.quantity) AS quantity FROM bill_details AS BD , bills AS B WHERE BD.bill_id=B.id GROUP BY BD.product_id,B.status HAVING B.status=3 OR B.status=2');
            $archive_bill = collect($archive_bill);
            foreach ($archive_bill_in_search as  $bill_in) {
                if ($archive_bill->contains('product_id', $bill_in->product_id)) {
                    $a_unit_price = $bill_in->total_unit_price / $bill_in->quantity;
                    $a_original_price = $bill_in->total_original_price / $bill_in->quantity;
                    $quantity_bill = 0;
                    foreach ($archive_bill as $bill) {
                        if ($bill->product_id == $bill_in->product_id) {
                            $quantity_bill += $bill->quantity;
                        }
                    }
                    $bill_in->quantity = $bill_in->quantity - $quantity_bill;
                    $bill_in->total_original_price = $bill_in->total_original_price - $quantity_bill * $a_original_price;
                    $bill_in->total_unit_price = $bill_in->total_unit_price - $quantity_bill * $a_unit_price;
                }
            }
            $inventorys = [];
            foreach ($archive_bill_in_search as  $archive_bill_in) {
                $inventorys[$archive_bill_in->product_id]['quantity'] = $archive_bill_in->quantity;
            }

            $bill = Bill::find($request->id);
            $products = $bill->products;
            $user = $bill->user;
            $data = [];
            foreach ($products as  $product) {
                $data[$product->id]['id'] = $product->id;
                $data[$product->id]['name'] = $product->name;
                $data[$product->id]['image'] = $product->image;
                $data[$product->id]['unit_price'] = $product->pivot->unit_price;
                $data[$product->id]['quantityRequired'] = $product->pivot->quantity;
                $data[$product->id]['quantityInventory'] = $inventorys[$product->id]['quantity'];
            }

            return response()->json(array('success' => true, 'bill' => $bill, 'dataProduct' => $data), 200);
        } catch (Exception $exception) {
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
            ->orWhereBetween('date_order', [$request->from, $request->to])->get();
    }

    public function searchStatus($request)
    {
        return $this->bill->where('status', 'like', '%' . $request->status . '%')->get();
    }

    public function changeStatus($request)
    {
        try {
            $billStatus = Bill::find($request->id);
            if ($billStatus->status == 0) {
                $archive_bill_in_search = DB::select('SELECT BID.product_id,P.name,SUM(BID.quantity) as quantity,SUM(BID.quantity)*BID.original_price as total_original_price ,SUM(BID.quantity)*P.unit_price AS total_unit_price  FROM bill_in_details AS BID JOIN products AS P ON BID.product_id=P.id WHERE BID.product_id IN (SELECT product_id  FROM bill_details WHERE bill_id=' . $request->id . ')  GROUP BY BID.product_id,P.name');
                $archive_bill = DB::select('SELECT BD.product_id,SUM(BD.quantity) AS quantity FROM bill_details AS BD , bills AS B WHERE BD.bill_id=B.id GROUP BY BD.product_id,B.status HAVING B.status=3 OR B.status=2');
                $archive_bill = collect($archive_bill);
                foreach ($archive_bill_in_search as  $bill_in) {
                    if ($archive_bill->contains('product_id', $bill_in->product_id)) {
                        $a_unit_price = $bill_in->total_unit_price / $bill_in->quantity;
                        $a_original_price = $bill_in->total_original_price / $bill_in->quantity;
                        $quantity_bill = 0;
                        foreach ($archive_bill as $bill) {
                            if ($bill->product_id == $bill_in->product_id) {
                                $quantity_bill += $bill->quantity;
                            }
                        }
                        $bill_in->quantity = $bill_in->quantity - $quantity_bill;
                        $bill_in->total_original_price = $bill_in->total_original_price - $quantity_bill * $a_original_price;
                        $bill_in->total_unit_price = $bill_in->total_unit_price - $quantity_bill * $a_unit_price;
                    }
                }
                $inventorys = [];
                foreach ($archive_bill_in_search as  $archive_bill_in) {
                    $inventorys[$archive_bill_in->product_id]['quantity'] = $archive_bill_in->quantity;
                }
                $bill = Bill::find($request->id);
                $products = $bill->products;
                $data = [];
                foreach ($products as  $product) {
                    if ($inventorys[$product->id]['quantity'] - $product->pivot->quantity < 0) {
                        $data[$product->id]['id'] = $product->id;
                        $data[$product->id]['name'] = $product->name;
                        $data[$product->id]['image'] = $product->image;
                        $data[$product->id]['quantityRequired'] = $product->pivot->quantity;
                        $data[$product->id]['quantityInventory'] = $inventorys[$product->id]['quantity'];
                    }
                }
                if (count($data) == 0) {
                    $bill->status = $request->status;
                    $bill->save();
                    $b = Bill::find($request->id);
                    return response()->json(array('success' => true, 'status' => $b->status), 200);
                } else {
                    return response()->json(array('success' => false, 'inventorys' => $data), 200);
                }
            } else if ($request->status == 3) {
                $billStatus->status = $request->status;
                $billStatus->complete_order = date('y-m-d');
                $billStatus->save();
                return response()->json(array('success' => true, 'status' => $billStatus->status), 200);
            } else {
                $billStatus->status = $request->status;
                $billStatus->save();
                return response()->json(array('success' => true, 'status' => $billStatus->status), 200);
            }
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }
}
