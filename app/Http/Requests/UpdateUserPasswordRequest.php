<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
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
            'password_new' => 'required|min:6|max:30',
            'password_old' => 'required',
            'repassword_new' => 'required|same:password_new'
        ];
    }

    public function messages()
    {
        return  [
            'password_new.required' => 'Bạn chưa nhập mật khẩu mới',
            'password_new.min' => 'Mật khẩu mới không ít hơn 6 ký tự',
            'password_new.max' => 'Mật khẩu mới không lớn hơn 30 ký tự',
            'password_old.required' => 'Bạn chưa nhập mật khẩu cũ',
            'repassword_new.required' => 'Bạn chưa nhập mật khẩu mới lần 2',
            'repassword_new.same' => 'Mật khẩu không khớp'
        ];
    }
}
