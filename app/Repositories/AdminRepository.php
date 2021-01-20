<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\Product;
use App\Models\User;
use App\Models\Visitor;
use App\Traits\StorageImageTrait;
use App\Traits\MessageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateTime;

class AdminRepository
{

    public function __construct()
    {
    }

    public function getAll()
    {
        $totalBillNew = Bill::where('status', 0)->get();
        $totalProduct = Product::all();
        $totalUser = User::all();
        $totalVisitor = Visitor::all();
        $productViews = Product::limit(10)->orderBy('product_view', 'DESC')->get();
        $sellingProducts = DB::select("SELECT BD.product_id,P.name,SUM(BD.quantity) AS quantity FROM bill_details AS BD JOIN products AS P ON P.id=BD.product_id GROUP BY BD.product_id,P.name ORDER BY SUM(BD.quantity) DESC LIMIT 10");
        return ['totalBillNew' => count($totalBillNew), 'totalProduct' => count($totalProduct), 'totalUser' => count($totalUser), 'totalVisitor' => count($totalVisitor), 'productViews' => $productViews, 'sellingProducts' => $sellingProducts];
    }

    public function getAccessibleFor15Days()
    {
        try {
            $chart_data = [];

            $seconds = strtotime(date('Y-m-d'));

            $getVisitor = DB::select('SELECT V.date_visitors ,COUNT(V.id) AS quantity FROM visitors AS V GROUP BY V.date_visitors');
            $visitors = collect($getVisitor);
            for ($i = 14; $i >= 0; $i--) {
                $date = date("Y-m-d", $seconds - $i * 86400);
                if ($visitors->contains('date_visitors', $date)) {
                    foreach ($visitors as $visitor) {
                        if ($visitor->date_visitors == $date) {
                            $chart_data[] = array(
                                'period' => $visitor->date_visitors,
                                'order' => $visitor->quantity,
                            );
                        }
                    }
                } else {
                    $chart_data[] = array(
                        'period' => $date,
                        'order' => 0,
                    );
                }
            }
            return response()->json($chart_data, 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => "fail",
            ], 500);
        }
    }

    public function getAccessible($request)
    {
        try {
            $chart_data = [];
            $data = $request->all();
            $fromDate = $data['fromDate'];
            $toDate = $data['toDate'];
            $secondsFrom = strtotime($fromDate);
            $secondsTo = strtotime($toDate);
            $getVisitor = DB::select("SELECT V.date_visitors ,COUNT(V.id) AS quantity FROM visitors AS V  GROUP BY V.date_visitors HAVING  V.date_visitors   >= '" . $fromDate . "' AND V.date_visitors <= '" . $toDate . "'");
            $visitors = collect($getVisitor);
            for ($i = $secondsFrom; $i <  $secondsTo; $i += 86400) {
                $date = date("Y-m-d", $i);
                if ($visitors->contains('date_visitors', $date)) {
                    foreach ($visitors as $visitor) {
                        if ($visitor->date_visitors == $date) {
                            $chart_data[] = array(
                                'period' => $visitor->date_visitors,
                                'order' => $visitor->quantity,
                            );
                        }
                    }
                } else {
                    $chart_data[] = array(
                        'period' => $date,
                        'order' => 0,
                    );
                }
            }
            return response()->json($chart_data, 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => "fail",
            ], 500);
        }
    }


    public function show($request)
    {
    }

    public function destroy($id)
    {
    }

    public function search($request)
    {
    }
}
