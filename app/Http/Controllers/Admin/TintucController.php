<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Tintuc\AtModel;
use App\Model\Admin\Danhmuc\AdModel;
use App\Http\Requests\Admin\Tintuc\AtRequest;
use App\Http\Requests\Admin\Tintuc\AteRequest;
use Response;
use Storage;

class TintucController extends Controller
{
    public function __construct(AtModel $AtModel,AdModel $AdModel){
        $this->AtModel=$AtModel;
        $this->AdModel=$AdModel;
    }
    public function index(){
        $objItems=$this->AtModel->getAll();
        return view('admin.tintuc.index',compact('objItems'));
    }
    public function add(){
        $objDanhmuccha=$this->AdModel->getList_cha();
		$objDanhmuccon=$this->AdModel->getList_con();
        return view('admin.tintuc.add',compact('objDanhmuccha','objDanhmuccon'));
    }
    public function postAdd(AtRequest $req){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date=date('H:i d/m/Y');

        $path=$req->file('hinhanh')->store('files');
        $duoiFile=explode('.',$path);
        $duoiFile=end($duoiFile);
        $hinhanh='hinhanh-'.time().'.'.$duoiFile;
        Storage::move($path,"files/{$hinhanh}");
        $arItem=[
            "tentintuc"=>trim($req->tentintuc),
            "danhmuc_id"=>trim($req->danhmuc_id),
            "hinhanh"=>$hinhanh,
            "gioithieu"=>trim($req->gioithieu),
            "chitiet"=>trim($req->chitiet),
            "ngaytao"=>$date,
            "luotxem"=>0,
            "active"=>trim($req->active)
        ];
        $this->AtModel->add($arItem);
        return redirect()->back()->with(['msg'=>'Thêm tin tức thành công !']);
    }
    public function edit($tintuc_id){
        $objDanhmuccha=$this->AdModel->getList_cha();
		$objDanhmuccon=$this->AdModel->getList_con();
        $objItem=$this->AtModel->getItem($tintuc_id);
        return view('admin.tintuc.edit',compact('objDanhmuccha','objDanhmuccon','objItem'));
    }
    public function postEdit(AteRequest $req){
        $tintuc_id=$req->tintuc_id;
        $hinhanh=$req->hinhanh;
        if($req->hasFile('hinhanhmoi')){
            $this->validate($req,
                [
                    "hinhanhmoi"=>"image | max:10240",
                ],
                [
                    "hinhanhmoi.image"=>"Chọn file đúng định dạng hình ảnh !",
                    "hinhanhmoi.max"=>"Kích thước file quá lớn( Chọn file nhỏ hơn 10MB ) !",
                ]
            );
            if(Storage::exists('files/'.$hinhanh)){
                Storage::delete('files/'.$hinhanh);
            }
            $path=$req->file('hinhanhmoi')->store('files');
            $duoiFile=explode('.',$path);
            $duoiFile=end($duoiFile);
            $hinhanh='hinhanh-'.time().'.'.$duoiFile;
            Storage::move($path,"files/{$hinhanh}");
        }
        $arItem=[
            "tentintuc"=>trim($req->tentintuc),
            "danhmuc_id"=>trim($req->danhmuc_id),
            "hinhanh"=>$hinhanh,
            "gioithieu"=>trim($req->gioithieu),
            "chitiet"=>trim($req->chitiet),
            "active"=>trim($req->active)
        ];
        $this->AtModel->edit($tintuc_id,$arItem);
        return redirect()->back()->with(['msg'=>'Sửa tin tức thành công !']);
    }
    public function del($tintuc_id){
        $this->AtModel->del($tintuc_id);
        return redirect()->back()->with(['msg'=>'Xóa thành công !']);
    }
}
