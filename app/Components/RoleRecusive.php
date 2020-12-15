<?php

namespace app\Components;

use app\Models\Permission;
use App\Models\Premission;

class RoleRecusive
{

    private $htmlOption;
    public function __construct()
    {
        $this->htmlOption = '';
    }

    public function roleRecusiveAdd($parent_id, $marginLeft = 10)
    {
        $data = Premission::where('parent_id', $parent_id)->get();
        foreach ($data as $key => $value) {
            $this->htmlOption .= '<div class="row" style="margin-left: ' . $marginLeft . 'px;">
            <Label>
                <input type="checkbox" class="checkbox_childrent" name="permission_id[]" value="' . $value->id . '" />
            </Label>
           <b style="margin-left: 5px;">' . $value->name . '</b>
            </div>';
            $this->roleRecusiveAdd($value->id, $marginLeft + 30);
        }
        return $this->htmlOption;
    }

    public function roleRecusiveEdit($permissonsChildrent, $parent_id, $marginLeft = 10)
    {
        $data = Premission::where('parent_id', $parent_id)->get();
        foreach ($data as $key => $value) {
            $check='';
            if(in_array($value->id,$permissonsChildrent)){
                $check='checked';
            }
            $this->htmlOption .= '<div class="row" style="margin-left: ' . $marginLeft . 'px;">';
            $this->htmlOption .='<Label>';
            $this->htmlOption .= '<input type="checkbox"  class="checkbox_childrent" '.$check.' name="permission_id[]" value="' . $value->id . '" />';
            $this->htmlOption .='</Label>';
            $this->htmlOption .='<b style="margin-left: 5px;">' . $value->name . '</b>';
            $this->htmlOption .='</div>';
            $this->roleRecusiveEdit($permissonsChildrent, $value->id, $marginLeft + 30);
        }
        return $this->htmlOption;
    }
}
