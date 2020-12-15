<?php

namespace App\Components;
use App\Models\Premission;

class PermissionRecusive
{

    private $htmlOption;
    public function __construct()
    {
        $this->htmlOption = '';
    }

    public function permissionRecusiveAdd($parent_id = 0, $subMark = '')
    {
        $data=Premission::where('parent_id',$parent_id)->get();
        foreach ($data as $key => $value) {
            $this->htmlOption.='<option value="'.$value->id.'">'.$subMark.$value->name.'</option>';
            $this->permissionRecusiveAdd($value->id,$subMark.'--');
        }
        return $this->htmlOption;
    }

    public function permissionRecusiveEdit($id,$parent_id = 0, $subMark = '')
    {
        $data=Premission::where('parent_id',$parent_id)->get();
        foreach ($data as $key => $value) {
            if (!empty($id) && $id == $value['id']) {
                $this->htmlOption.='<option selected value="'.$value->id.'">'.$subMark.$value->name.'</option>';
            }else{
                $this->htmlOption.='<option value="'.$value->id.'">'.$subMark.$value->name.'</option>';
            }
           
            $this->permissionRecusiveEdit($id,$value->id,$subMark.'--');
        }
        return $this->htmlOption;
    }
   
}
