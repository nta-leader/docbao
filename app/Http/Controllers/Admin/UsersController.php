<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Users\AuModel;
use App\Http\Requests\Admin\Users\AuaRequest;
use App\Http\Requests\Admin\Users\AueRequest;
use DB;
use Auth;

class UsersController extends Controller
{
    public function __construct(AuModel $AuModel){
        $this->AuModel=$AuModel;
    }
    public function index(){
        $objItems=$this->AuModel->getItems();
        return view('admin.users.index',compact('objItems'));
    }
    public function add(){
        return view('admin.users.add');
    }
    public function postAdd(AuaRequest $req){
        $username=$req->username;
    	$password=$req->password;
		$fullname=$req->fullname;
		$email=$req->email;
		$facebook=$req->facebook;
        $phone=$req->phone;
        $active=$req->active;
        $arItem=[
            'username'=>$username,
            'password'=>bcrypt($password),
            'fullname'=>$fullname,
            'email'=>$email,
            'facebook'=>$facebook,
            'phone'=>$phone,
            'active'=>$active,
        ];
        $this->AuModel->add($arItem);
        return redirect()->route('admin.users.index')->with(['msg'=>'Thêm thành công !']);
    }
    public function edit($id){
        $objItem=$this->AuModel->getItem($id);
        return view('admin.users.edit',compact('objItem'));
    }
    public function postEdit($id,AueRequest $req){
        $username=$req->username;
    	$password=$req->password;
		$fullname=$req->fullname;
		$email=$req->email;
		$facebook=$req->facebook;
        $phone=$req->phone;
        $active=$req->active;
        
        $arItem=[
            'fullname'=>$fullname,
            'email'=>$email,
            'facebook'=>$facebook,
            'phone'=>$phone
        ];
        $this->AuModel->edit($id,$arItem);
        return redirect()->route('admin.users.index')->with(['msg'=>'Sửa thành công !']);
    }
    public function doimk(Request $req){
        $auth=Auth::user();
        if($auth->username==$req->username){
            $check = DB::table('users')->where('username',$req->username)->update(['password'=>bcrypt($req->password)]);
            if($check==true){
                return 1;
            }else{
                return "error";
            }
        }else{
            return 0;
        }
    }
    public function active(Request $req){
        $auth=Auth::user();
        if($auth->username=='admin'){
            if($req->active=='1' && $req->id != '1'){
                DB::table('users')->where('id',$req->id)->update(['active'=>0]);
                return '<center><a onclick="active(0,'.$req->id.')" class="btn btn-danger">Khóa</a></center>';
            }elseif( $req->id != '1'){
                DB::table('users')->where('id',$req->id)->update(['active'=>1]);
                return '<center><a onclick="active(1,'.$req->id.')" class="btn btn-success">Hoạt động</a></center>';
            }else{
                return "<span style='color:red;'>Không thể khóa admin !</span>";
            }
        }else{
            return "<span style='color:red;'>Chức năng này chỉ dành cho admin !</span>";
        }
    }
    public function del($id){
        $auth=Auth::user();
        if($auth->username=='admin'){
            if($id!=1){
                $this->AuModel->del($id);
                return redirect()->back()->with(['msg'=>'Xóa thành công !']);
            }
            return redirect()->back()->with(['msg'=>'Không thể xóa admin !']);
        }else{
            return redirect()->back()->with(['msg'=>'Chức năng chỉ dành cho admin !']);
        }
    }
}
