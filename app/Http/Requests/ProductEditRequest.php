<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductEditRequest extends FormRequest
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
            'name' => 'required|regex:/(^[\pL0-9 ]+$)/u',
            'cpu' => 'required',
            'ram' => 'required',
            'displayscreen' => 'required',
            'rom_harddrive' => 'required',
            'operatingsystem' => 'required',
            'publisher' => 'required',
            'image_file' => 'mimes:jpg,jpeg,png,gif|max:10240',
            'detailed_image_file'=>'mimes:jpg,jpeg,png,gif|max:10240',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Tên sản phẩm không được phép có ký tự đặc biệt',
            'name.required' => 'Tên sản phẩm không được phép trống',
            'cpu.required' => 'CPU không được phép trống',
            'ram.required' => 'RAM không được phép trống',
            'displayscreen.required' => 'Màn hình không được phép trống',
            'rom_harddrive.required' => 'Bộ nhớ trong/Ổ cứng không được phép trống',
            'operatingsystem.required' => 'Hệ điều hành không được phép trống',
            'publisher.required' => 'Nhà sản xuất không được phép trống',
            'image_file.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
            'image_file.max' => 'Hình thẻ giới hạn dung lượng không quá 10M',
            'detailed_image_file.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
            'detailed_image_file.max' => 'Hình thẻ giới hạn dung lượng không quá 10M',
        ];
    }
}
