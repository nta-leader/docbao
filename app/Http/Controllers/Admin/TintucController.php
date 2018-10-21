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
            "nguon"=>route('docbao.index'),
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
    public function del($tintuc_id,Request $req){
        if($tintuc_id==0){
            $arId=$req->arId;
            if($arId==null){
                return redirect()->back()->with(['msg'=>'Vui lòng chọn các tin trước khi xóa !']);
            }
        }else{
            $arId[0]=$tintuc_id;
        }
        $this->AtModel->del($arId);
        return redirect()->back()->with(['msg'=>'Xóa thành công !']);
    }
    public function active(Request $req){
        if($req->active==1){
            $arItem=['active'=>0];
        }else{
            $arItem=['active'=>1];
        }
        $this->AtModel->edit($req->tintuc_id,$arItem);
        return view('admin.tintuc.active',compact('req'));
    }
    //phan rss
    public function rss($id){
        $objDanhmuccha=$this->AdModel->getList_cha();
		$objDanhmuccon=$this->AdModel->getList_con();
        $objRss=$this->AtModel->getRss();
        $objItems=$this->AtModel->getTintucrss($id);
        return view('admin.tintuc.rss.index',compact('id','objRss','objItems','objDanhmuccha','objDanhmuccon'));
    }
    public function addrss(Request $req){
        $this->validate($req,
            [
                'link'=>'required | unique:rss,link'
            ],
            [
                'link.required'=>'Vui lòng nhập link rss !',
                'link.unique'=>"Link rss đã tồn tại !"
            ]
        );
        $arItem=['link'=>trim($req->link)];
        $this->AtModel->addrss($arItem);
        return redirect()->back()->with(['msg'=>'Thêm thành công !']);
    }
    public function rssdel($id){
        $this->AtModel->delrss($id);
        return redirect()->back()->with(['msg'=>'Xóa thành công !']);
    }
    //pham tintuc_rss
    public function update($id){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date=date('H:i d/m/Y');
        $link=$this->AtModel->getItemrss($id);
        if($link != null){
            $link=$link->link;
        }else{
            return redirect()->route('admin.tintuc.rss',['id'=>0]);
        }
        $html= file_get_html($link);
        $tins = $html->find("div.clearfix div.mt3");
        $i=0;
        foreach ($tins as $t) {
            $a = $t->find("a",0);
            //lay tieu de
            $tentintuc=$a->attr["title"];
            if($this->AtModel->check_rss($tentintuc)==false){
                continue;
            }
            //lay duong dan detail
            $href=$a->href;
            //lay hinh anh
            $img=$a->find("img",0)->src;
            $picture=basename($img);
            $arP=explode('.',$picture);
            $duoiP=end($arP);
            if($duoiP == 'jpg' || $duoiP == 'png' || $duoiP == 'jpeg' || $duoiP == 'jpf'){
                $u=$_SERVER['DOCUMENT_ROOT'].'/storage/app/files/'.$picture;
                file_put_contents($u, file_get_contents($img));
            }
            //lay gioi thieu
            $goithieu=$t->find("div.mr1 div",0)->plaintext;
            //lay detail
            $html_detail=file_get_html("https://dantri.com.vn/".$href);
            $detail=$html_detail->find("div.detail-content",0);
            
            $arItem=[
                'name'=>$tentintuc,
                'rss_id'=>$id,
                'picture'=>$picture,
                'preview'=>$goithieu,
                'detail'=>$detail,
                'active'=>0,
                'date'=>$date
            ];
            $this->AtModel->addTintucrss($arItem);
            $i++;
        }
        return redirect()->back()->with(['msg'=>'Có '.$i.'tin mới !']);
    }
    public function move_tintuc(Request $req){
        $id=$req->tintuc_rss_id;
        $danhmuc_id=$req->danhmuc_id;
        $objItem=$this->AtModel->getItemtintucrss($id);
        $arItem=[
            "tentintuc"=>$objItem->name,
            "danhmuc_id"=>$danhmuc_id,
            "hinhanh"=>$objItem->picture,
            "gioithieu"=>$objItem->preview,
            "chitiet"=>$objItem->detail,
            "ngaytao"=>$objItem->date,
            "luotxem"=>0,
            "nguon"=>$objItem->link,
            "code"=>$objItem->name,
            "active"=>0
        ];
        if($this->AtModel->check($objItem->name)==true){
            $this->AtModel->add($arItem);
            $this->AtModel->tintucrss_update($id);
            return "<a class='btn btn-success'>Thành công !</a>";
        }else{
            $this->AtModel->tintucrss_update($id);
            return "<a class='btn btn-danger'>Tin này đã có</a>";
        }
    }
    public function tintucrssdel($id,Request $req){
        if($id==0){
            $arId=$req->arId;
            if($arId==null){
                return redirect()->back()->with(['msg'=>'Vui lòng chọn các tin trước khi xóa !']);
            }
        }else{
            $arId[0]=$id;
        }
        $this->AtModel->delTintucrss($arId);
        return redirect()->back()->with(['msg'=>'Xóa thành công !']);
    }
}
