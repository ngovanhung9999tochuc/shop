<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserInfoRequest extends FormRequest
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
            'email' => 'required|email',
            'address' => 'required',
            'date_of_birth' => 'required',
            'phone' => 'required|numeric|digits:10'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Bạn chưa nhập email',
            'date_of_birth.required' => 'Bạn chưa nhập ngày sinh',
            'email.email' => 'Không đúng định dạng email',
            'address.required' => 'Bạn chưa nhập địa chỉ',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.numeric' => 'Số điện thoại phải là số',
            'phone.digits' => 'Số điện thoại phải là 10 số'
        ];
    }
}
