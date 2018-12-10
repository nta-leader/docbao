<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AueRequest extends FormRequest
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
            'fullname'=>'required',
            'email'=>'required | email | unique:users,email,'.$req->id.'|max:100',
            'facebook'=>'required|max:200|unique:users,facebook,'.$req->id.'|regex:/(?:http:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-]*)/',
            'phone'=>'required | min:10 | max:10 | unique:users,phone,'.$req->id.'',
        ];
    }
    public function messages()
    {
        return [
            'username.required'=>'Vui lòng nhập tài khoản !',
            'username.unique'=>'Tài khoản đã có người sử dụng !',
            'username.min'=>'Tài khoản tối thiểu 5 kí tự !',
            'username.max'=>'Tài khoản tối đa 50 kí tự !',
            'username.regex'=>'Tài khoản phải viết liền không đấu, không chứa ký tự đặc biệt và không bắt đầu bằng chữ số !',
            'password.required'=>'Vui lòng nhập mật khẩu',
            'password.min'=>'Mật khẩu tối thiểu 6 ký tự',
            'rpassword.required'=>'Vui lòng nhập mật khẩu',
            'rpassword.same'=>'Mật khẩu không khớp !',
            'fullname.required'=>'Vui lòng nhập họ tên',
            'email.required'=>'Vui lòng nhập email !',
            'email.email'=>'Vui lòng nhập đúng định dạng email !',
            'email.unique'=>'Email đã có người sử dụng !',
            'facebook.required'=>'Vui lòng nhập link facebook !',
            'facebook.regex'=>'Vui lòng nhập đúng định dạng link facebook !',
            'facebook.unique'=>'Link facebook đã có người sử dụng !',
            'phone.required'=>'Vui lòng nhập số điện thoại !',
            'phone.min'=>'Số điện thoại phải là 10 số !',
            'phone.max'=>'Số điện thoại phải là 10 số !',
            'phone.unique'=>'Số điện thoại đã có người sử dụng !',
            'active.required'=>'Vui lòng chọn trạng thái !'
        ];
    }
}
