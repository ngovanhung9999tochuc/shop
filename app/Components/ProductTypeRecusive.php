<?php

namespace App\Components;
use App\Models\ProductType;

class ProductTypeRecusive
{

    private $htmlOption;
    public function __construct()
    {
        $this->htmlOption = '';
    }

    public function ProductTypeRecusiveAdd($parent_id = 0, $subMark = '')
    {
        $data=ProductType::where('parent_id',$parent_id)->get();
        foreach ($data as $key => $value) {
            $this->htmlOption.='<option value="'.$value->id.'">'.$subMark.$value->name.'</option>';
            $this->ProductTypeRecusiveAdd($value->id,$subMark.'-- ');
        }
        return $this->htmlOption;
    }

    public function ProductTypeRecusiveEdit($id,$parent_id = 0, $subMark = '')
    {
        $data=ProductType::where('parent_id',$parent_id)->get();
        foreach ($data as $key => $value) {
            if (!empty($id) && $id == $value['id']) {
                $this->htmlOption.='<option selected value="'.$value->id.'">'.$subMark.$value->name.'</option>';
            }else{
                $this->htmlOption.='<option value="'.$value->id.'">'.$subMark.$value->name.'</option>';
            }
           
            $this->ProductTypeRecusiveEdit($id,$value->id,$subMark.'-- ');
        }
        return $this->htmlOption;
    }
   
}
