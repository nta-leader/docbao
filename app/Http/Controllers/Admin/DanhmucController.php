<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Danhmuc\AdModel;

class DanhmucController extends Controller
{
    public function __construct(AdModel $AdModel){
        $this->AdModel=$AdModel;
    }
    public function index(){
        $objDanhmuccha=$this->AdModel->getList_cha();
		$objDanhmuccon=$this->AdModel->getList_con();
		$danhmucall=$this->AdModel->getAll();
		$soluong[]="";
		foreach ($danhmucall as $key => $value) {
			$soluong[$value->danhmuc_id]=rand(1,100);
		}
        return view('admin.danhmuc.index',compact('objDanhmuccha','objDanhmuccon','soluong'));
    }
    public function add(Request $req){
    	$parent_id=$req->parent_id;
    	$tendanhmuc=$req->tendanhmuc;
    	$sapxep=$req->sapxep;
    	$count=$this->AdModel->check($tendanhmuc,$parent_id);
    	if($count > 0){
			return view('admin.danhmuc.msg');
    	}
    	$arItem=[
    		'tendanhmuc'=>$tendanhmuc,
    		'sapxep'=>$sapxep,
    		'parent_id'=>$parent_id
    	];
    	$req->session()->flash('msg','Thêm thành công !');
    	$req->session()->flash('url',route('admin.danhmuc.index'));
    	$this->AdModel->add($arItem);
    	return view('admin.danhmuc.msg');
	}
	public function edit(Request $req){
		$danhmuc_id=$req->danhmuc_id;
		$objItem=$this->AdModel->getItem($danhmuc_id);
		return view('admin.danhmuc.edit',compact('objItem'));
	}
	public function postEdit(Request $req){
		$danhmuc_id=$req->danhmuc_id;
		$parent_id=$req->parent_id;
    	$tendanhmuc=$req->tendanhmuc;
    	$sapxep=$req->sapxep;
    	$count=$this->AdModel->check($tendanhmuc,$parent_id,$danhmuc_id);
    	if($count > 0){
			return view('admin.danhmuc.msg');
    	}
    	$arItem=[
    		'tendanhmuc'=>$tendanhmuc,
    		'sapxep'=>$sapxep,
    		'parent_id'=>$parent_id
    	];
    	$req->session()->flash('msg','Sửa thành công !');
    	$req->session()->flash('url',route('admin.danhmuc.index'));
    	$this->AdModel->edit($danhmuc_id,$arItem);
    	return view('admin.danhmuc.msg');
	}
	public function del($id,Request $req){
		if($this->AdModel->del($id)){
			return redirect()->back()->with(['msg'=>'Xóa thành công !']);
		}else{
			return redirect()->back();
		}
	}
}
