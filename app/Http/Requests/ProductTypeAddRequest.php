<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductTypeAddRequest extends FormRequest
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
            'image_file' => 'mimes:jpg,jpeg,png,gif|max:10240',
            'key_code' => 'required|size:2'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được phép trống',
            'image_file.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
            'image_file.max' => 'Hình thẻ giới hạn dung lượng không quá 10M',
            'key_code.required' => 'Mã không được phép trống',
            'key_code.size' => 'Mã không được phép nhiều hơn 2 ký tự',
        ];
    }
}
