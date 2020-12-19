<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierAddRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required|numeric|digits:10'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được phép trống',
            'email.required' => 'Email không được phép trống',
            'email.email' => 'Không đúng định dạng email',
            'address.required' => 'Địa chỉ không được phép trống',
            'phone.required' => 'Số điện thoại không được phép trống',
            'phone.numeric' => 'Số điện thoại phải là số',
            'phone.digits' => 'Số điện thoại phải là 10 số'
        ];
    }
}
