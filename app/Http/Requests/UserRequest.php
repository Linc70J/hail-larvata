<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|between:3,25' . Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
        ];
    }

    public function messages()
    {
        return [
            'avatar.dimensions' => '圖片的解析度不夠，長和寬需要 200px 以上',
            'name.between' => '用戶名稱必須介於 3 - 25 个字符之間。',
            'name.required' => '用戶名稱不能為空。',
        ];
    }
}
