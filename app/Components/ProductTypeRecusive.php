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

    public function productTypeAdd($parent_id = 0, $subMark = '')
    {
        $data = ProductType::where('parent_id', $parent_id)->get();
        foreach ($data as $key => $value) {
            $this->htmlOption .= '<option  value="' . $value->key_code . '">' . $subMark . $value->name . '</option>';
            $this->productTypeAdd($value->id, $subMark . '-- ');
        }
        return $this->htmlOption;
    }
    public function productTypeEdit($key_code, $parent_id = 0, $subMark = '')
    {
        $data = ProductType::where('parent_id', $parent_id)->get();
        foreach ($data as $key => $value) {
            if (!empty($key_code) && $key_code == $value['key_code']) {
                $this->htmlOption .= '<option  selected value="' . $value->key_code . '">' . $subMark . $value->name . '</option>';
            } else {
                $this->htmlOption .= '<option  value="' . $value->key_code . '">' . $subMark . $value->name . '</option>';
            }

            $this->productTypeEdit($key_code, $value->id, $subMark . '-- ');
        }
        return $this->htmlOption;
    }




    public function ProductTypeRecusiveAdd($parent_id = 0, $subMark = '')
    {
        $data = ProductType::where('parent_id', $parent_id)->get();
        foreach ($data as $key => $value) {
            $check = '';
            if ($value->parent_id == 0) {
                $check = 'disabled';
            }
            $this->htmlOption .= '<option ' . $check . ' value="' . $value->id . '">' . $subMark . $value->name . '</option>';
            $this->ProductTypeRecusiveAdd($value->id, $subMark . '-- ');
        }
        return $this->htmlOption;
    }

    public function productTypeRecusiveArchive($parent_id = 0, $subMark = '')
    {
        $data = ProductType::where('parent_id', $parent_id)->get();
        foreach ($data as $key => $value) {
            $check = '';
            if ($value->parent_id == 0) {
                $check = 'disabled';
            }
            $this->htmlOption .= '<option ' . $check . ' value="' . $value->id . '">' . $subMark . $value->name . '</option>';
            $this->productTypeRecusiveArchive($value->id, $subMark . '-- ');
        }
        return $this->htmlOption;
    }
    //disabled
    public function ProductTypeRecusiveEdit($id, $parent_id = 0, $subMark = '')
    {
        $data = ProductType::where('parent_id', $parent_id)->get();
        foreach ($data as $key => $value) {
            $check = '';
            if ($value->parent_id == 0) {
                $check = 'disabled';
            }
            if (!empty($id) && $id == $value['id']) {
                $this->htmlOption .= '<option ' . $check . ' selected value="' . $value->id . '">' . $subMark . $value->name . '</option>';
            } else {
                $this->htmlOption .= '<option ' . $check . ' value="' . $value->id . '">' . $subMark . $value->name . '</option>';
            }

            $this->ProductTypeRecusiveEdit($id, $value->id, $subMark . '-- ');
        }
        return $this->htmlOption;
    }


    public function ProductTypeLoopAdd($parent_id = 0)
    {
        $data = ProductType::where('parent_id', $parent_id)->get();
        foreach ($data as $key => $value) {
            $this->htmlOption .= '<option value="' . $value->id . '">' . $value->name . '</option>';
        }
        return $this->htmlOption;
    }


    public function ProductTypeLoopEdit($id, $parent_id = 0)
    {
        $data = ProductType::where('parent_id', $parent_id)->get();
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
