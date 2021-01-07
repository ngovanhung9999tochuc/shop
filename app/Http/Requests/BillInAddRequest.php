<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillInAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_id' => 'required',
            'input_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'supplier_id.required' => 'Nhà cung cấp không được phép trống',
            'input_date.required' => 'Ngày nhập không được phép trống',
        ];
    }
}
