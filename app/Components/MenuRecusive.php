<?php

namespace App\Components;

use App\Models\Menu;

class MenuRecusive
{

    private $htmlOption;
    public function __construct()
    {
        $this->htmlOption = '';
    }

    public function menuLoopAdd($parent_id = 0)
    {
        $data = Menu::where('parent_id', $parent_id)->get();
        foreach ($data as $key => $value) {
            $this->htmlOption .= '<option value="' . $value->id . '">' . $value->name . '</option>';
        }
        return $this->htmlOption;
    }


    public function  menuLoopEdit($id, $parent_id = 0)
    {
        $data = Menu::where('parent_id', $parent_id)->get();
        foreach ($data as $key => $value) {
            if (!empty($id) && $id == $value['id']) {
                $this->htmlOption .= '<option selected value="' . $value->id . '">' . $value->name . '</option>';
            } else {
                $this->htmlOption .= '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        }
        return $this->htmlOption;
    }
}
