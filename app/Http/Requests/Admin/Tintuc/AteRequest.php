<?php

namespace App\Http\Requests\Admin\Tintuc;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AteRequest extends FormRequest
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
    public function rules(Request $req)
    {
        return [
            "tentintuc"=>"required | min:4 | max:255 | unique:tintuc,tentintuc,{$req->tintuc_id},tintuc_id",
            "danhmuc_id"=>"required",
            "gioithieu"=>"required",
            "chitiet"=>"required",
            "active"=>"required"
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
            "gioithieu.required"=>"Vui lòng nhập giới thiệu !",
            "chitiet.required"=>"Vui lòng nhập chi tiết !",
            "active.required"=>"Vui lòng chọn trạng thái !"
        ];
    }
}