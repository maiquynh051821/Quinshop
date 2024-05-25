<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép thực hiện yêu cầu này hay không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'name' => 'required',
           'thumb' => 'required',
           'description' => 'required',//|mimes:jpg,jpeg,gif,png,svg|mime_types:image/jpeg,image/gif,image/png,image/svg+xml
           'content' => 'required',
        ];
    }
    public function messages(){
        return[
          'name.required' => 'Vui lòng nhập tên sản phẩm',
          'thumb.required' => 'Không được để trống ảnh',
          'description.required' => 'Vui lòng nhập mô tả chi tiết',
          'content.required' => 'Vui lòng nhập cách bảo quản',
        //   'thumb.mimes' => 'Tệp ảnh phải có định dạng JPG, JPEG, GIF, PNG hoặc SVG',
        ];
    }
}
