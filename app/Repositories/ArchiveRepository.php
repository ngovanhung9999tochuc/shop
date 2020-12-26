<?php

namespace App\Repositories;

use App\Traits\StorageImageTrait;
use App\Traits\MessageTrait;
use Illuminate\Support\Facades\DB;
use App\Components\ProductTypeRecusive;

class ArchiveRepository
{
    protected $productTypeRecusive;
    use StorageImageTrait;
    use MessageTrait;
    public function __construct(ProductTypeRecusive $productTypeRecusive)
    {

        $this->productTypeRecusive = $productTypeRecusive;
    }

    public function getAll()
    {
        $archive_bill_in = DB::select('SELECT BID.product_id,P.name,SUM(BID.quantity) as quantity,SUM(BID.quantity)*BID.original_price as total_original_price ,SUM(BID.quantity)*P.unit_price AS total_unit_price  FROM bill_in_details AS BID JOIN products AS P ON BID.product_id=P.id GROUP BY BID.product_id,P.name');
        $archive_bill = DB::select('SELECT BD.product_id,SUM(BD.quantity) AS quantity FROM bill_details AS BD , bills AS B WHERE BD.bill_id=B.id GROUP BY BD.product_id,B.status HAVING B.status=3 OR B.status=2');
        $archive_bill = collect($archive_bill);

        foreach ($archive_bill_in as  $bill_in) {
            if ($archive_bill->contains('product_id', $bill_in->product_id)) {
                $a_unit_price = $bill_in->total_unit_price / $bill_in->quantity;
                $a_original_price = $bill_in->total_original_price / $bill_in->quantity;
                $quantity_bill = 0;
                foreach ($archive_bill as $bill) {
                    if ($bill->product_id == $bill_in->product_id) {
                        $quantity_bill = $bill->quantity;
                    }
                }
                $bill_in->quantity = $bill_in->quantity - $quantity_bill;
                $bill_in->total_original_price = $bill_in->total_original_price - $quantity_bill * $a_original_price;
                $bill_in->total_unit_price = $bill_in->total_unit_price - $quantity_bill * $a_unit_price;
            }
        }
        $quantity_product = count($archive_bill_in);
        $inventory = 0;
        $total_original_price = 0;
        $total_unit_price = 0;
        foreach ($archive_bill_in as  $bill_in) {
            $inventory += $bill_in->quantity;
        }

        foreach ($archive_bill_in as  $bill_in) {
            $total_original_price += $bill_in->total_original_price;
        }

        foreach ($archive_bill_in as  $bill_in) {
            $total_unit_price += $bill_in->total_unit_price;
        }
        $htmlOption = $this->productTypeRecusive->productTypeRecusiveArchive();
        return [
            'quantity_product' => $quantity_product,
            'inventory' => $inventory,
            'total_original_price' => $total_original_price,
            'total_unit_price' => $total_unit_price,
            'archive' => $archive_bill_in,
            'htmlOption' => $htmlOption
        ];
    }


    public function searchProductType($request)
    {
        $archive_bill_in = DB::select('SELECT BID.product_id,P.name,SUM(BID.quantity) as quantity,SUM(BID.quantity)*BID.original_price as total_original_price ,SUM(BID.quantity)*P.unit_price AS total_unit_price  FROM bill_in_details AS BID JOIN products AS P ON BID.product_id=P.id GROUP BY BID.product_id,P.name');
        $archive_bill_in_search = DB::select('SELECT BID.product_id,P.name,SUM(BID.quantity) as quantity,SUM(BID.quantity)*BID.original_price as total_original_price ,SUM(BID.quantity)*P.unit_price AS total_unit_price  FROM bill_in_details AS BID JOIN products AS P ON BID.product_id=P.id JOIN product_types AS PT ON PT.id=P.product_type_id GROUP BY BID.product_id,P.name,PT.id HAVING PT.id= ?', [$request->product_type]);
        $archive_bill = DB::select('SELECT BD.product_id,SUM(BD.quantity) AS quantity FROM bill_details AS BD , bills AS B WHERE BD.bill_id=B.id GROUP BY BD.product_id,B.status HAVING B.status=3 OR B.status=2');
        $archive_bill = collect($archive_bill);

        foreach ($archive_bill_in as  $bill_in) {
            if ($archive_bill->contains('product_id', $bill_in->product_id)) {
                $a_unit_price = $bill_in->total_unit_price / $bill_in->quantity;
                $a_original_price = $bill_in->total_original_price / $bill_in->quantity;
                $quantity_bill = 0;
                foreach ($archive_bill as $bill) {
                    if ($bill->product_id == $bill_in->product_id) {
                        $quantity_bill = $bill->quantity;
                    }
                }
                $bill_in->quantity = $bill_in->quantity - $quantity_bill;
                $bill_in->total_original_price = $bill_in->total_original_price - $quantity_bill * $a_original_price;
                $bill_in->total_unit_price = $bill_in->total_unit_price - $quantity_bill * $a_unit_price;
            }
        }
        $quantity_product = count($archive_bill_in);
        $inventory = 0;
        $total_original_price = 0;
        $total_unit_price = 0;
        foreach ($archive_bill_in as  $bill_in) {
            $inventory += $bill_in->quantity;
        }

        foreach ($archive_bill_in as  $bill_in) {
            $total_original_price += $bill_in->total_original_price;
        }

        foreach ($archive_bill_in as  $bill_in) {
            $total_unit_price += $bill_in->total_unit_price;
        }
        $htmlOption = $this->productTypeRecusive->productTypeRecusiveArchive();

        //

        foreach ($archive_bill_in_search as  $bill_in) {
            if ($archive_bill->contains('product_id', $bill_in->product_id)) {
                $a_unit_price = $bill_in->total_unit_price / $bill_in->quantity;
                $a_original_price = $bill_in->total_original_price / $bill_in->quantity;
                $quantity_bill = 0;
                foreach ($archive_bill as $bill) {
                    if ($bill->product_id == $bill_in->product_id) {
                        $quantity_bill = $bill->quantity;
                    }
                }
                $bill_in->quantity = $bill_in->quantity - $quantity_bill;
                $bill_in->total_original_price = $bill_in->total_original_price - $quantity_bill * $a_original_price;
                $bill_in->total_unit_price = $bill_in->total_unit_price - $quantity_bill * $a_unit_price;
            }
        }

        return [
            'quantity_product' => $quantity_product,
            'inventory' => $inventory,
            'total_original_price' => $total_original_price,
            'total_unit_price' => $total_unit_price,
            'archive' => $archive_bill_in_search,
            'htmlOption' => $htmlOption
        ];
    }

//SELECT BID.product_id,P.name,SUM(BID.quantity) as quantity,SUM(BID.quantity)*BID.original_price as total_original_price ,SUM(BID.quantity)*P.unit_price AS total_unit_price  FROM bill_in_details AS BID JOIN products AS P ON BID.product_id=P.id GROUP BY BID.product_id,P.name HAVING BID.product_id LIKE '%a%'
    public function search($request)
    {
        $archive_bill_in = DB::select('SELECT BID.product_id,P.name,SUM(BID.quantity) as quantity,SUM(BID.quantity)*BID.original_price as total_original_price ,SUM(BID.quantity)*P.unit_price AS total_unit_price  FROM bill_in_details AS BID JOIN products AS P ON BID.product_id=P.id GROUP BY BID.product_id,P.name');
        $archive_bill_in_search = DB::select("SELECT BID.product_id,P.name,SUM(BID.quantity) as quantity,SUM(BID.quantity)*BID.original_price as total_original_price ,SUM(BID.quantity)*P.unit_price AS total_unit_price  FROM bill_in_details AS BID JOIN products AS P ON BID.product_id=P.id GROUP BY BID.product_id,P.name HAVING BID.product_id LIKE '%".$request->product_id."%'");
        $archive_bill = DB::select('SELECT BD.product_id,SUM(BD.quantity) AS quantity FROM bill_details AS BD , bills AS B WHERE BD.bill_id=B.id GROUP BY BD.product_id,B.status HAVING B.status=3 OR B.status=2');
        $archive_bill = collect($archive_bill);

        foreach ($archive_bill_in as  $bill_in) {
            if ($archive_bill->contains('product_id', $bill_in->product_id)) {
                $a_unit_price = $bill_in->total_unit_price / $bill_in->quantity;
                $a_original_price = $bill_in->total_original_price / $bill_in->quantity;
                $quantity_bill = 0;
                foreach ($archive_bill as $bill) {
                    if ($bill->product_id == $bill_in->product_id) {
                        $quantity_bill = $bill->quantity;
                    }
                }
                $bill_in->quantity = $bill_in->quantity - $quantity_bill;
                $bill_in->total_original_price = $bill_in->total_original_price - $quantity_bill * $a_original_price;
                $bill_in->total_unit_price = $bill_in->total_unit_price - $quantity_bill * $a_unit_price;
            }
        }
        $quantity_product = count($archive_bill_in);
        $inventory = 0;
        $total_original_price = 0;
        $total_unit_price = 0;
        foreach ($archive_bill_in as  $bill_in) {
            $inventory += $bill_in->quantity;
        }

        foreach ($archive_bill_in as  $bill_in) {
            $total_original_price += $bill_in->total_original_price;
        }

        foreach ($archive_bill_in as  $bill_in) {
            $total_unit_price += $bill_in->total_unit_price;
        }
        $htmlOption = $this->productTypeRecusive->productTypeRecusiveArchive();

        //

        foreach ($archive_bill_in_search as  $bill_in) {
            if ($archive_bill->contains('product_id', $bill_in->product_id)) {
                $a_unit_price = $bill_in->total_unit_price / $bill_in->quantity;
                $a_original_price = $bill_in->total_original_price / $bill_in->quantity;
                $quantity_bill = 0;
                foreach ($archive_bill as $bill) {
                    if ($bill->product_id == $bill_in->product_id) {
                        $quantity_bill = $bill->quantity;
                    }
                }
                $bill_in->quantity = $bill_in->quantity - $quantity_bill;
                $bill_in->total_original_price = $bill_in->total_original_price - $quantity_bill * $a_original_price;
                $bill_in->total_unit_price = $bill_in->total_unit_price - $quantity_bill * $a_unit_price;
            }
        }

        return [
            'quantity_product' => $quantity_product,
            'inventory' => $inventory,
            'total_original_price' => $total_original_price,
            'total_unit_price' => $total_unit_price,
            'archive' => $archive_bill_in_search,
            'htmlOption' => $htmlOption
        ];
    }
}
