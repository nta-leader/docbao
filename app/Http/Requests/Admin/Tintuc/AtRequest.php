<?php

namespace App\Http\Requests\Admin\Tintuc;

use Illuminate\Foundation\Http\FormRequest;

class AtRequest extends FormRequest
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
            "tentintuc"=>"required | min:4 | max:255 | unique:tintuc,tentintuc",
            "danhmuc_id"=>"required",
            "hinhanh"=>"required | image",
            "gioithieu"=>"required",
            "chitiet"=>"required"
        ];
    }
    public function messages()
    {
        return [
            "tentintuc.required"=>"Vui lòng nhập tên tin tức !",
            "tentintuc.min"=>"Tên tin tức tối thiểu 4 ký tự !",
            "tentintuc.max"=>"Tên tin tức tối đa 255 ký tự !",
            "tentintuc.unique"=>"Tên tin tức đã tồn tại !",
            "danhmuc_id.required"=>"Vui lòng chọn danh mục !",
            "hinhanh.required"=>"Vui lòng chọn 1 hình ảnh !",
            "hinhanh.image"=>"Chọn file đúng định dạng hình ảnh !",
            "gioithieu.required"=>"Vui lòng nhập giới thiệu !",
            "chitiet.required"=>"Vui lòng nhập chi tiết !"
        ];
    }
}
