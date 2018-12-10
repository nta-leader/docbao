<?php

namespace App\Model\Admin\Danhmuc;

use Illuminate\Database\Eloquent\Model;
use DB;
use Storage;

class AdModel extends Model
{
    protected $table="danhmuc";
    protected $primarKey="danhmuc_id";
    public $timestamps=false;

    public function getAll(){
        return $this->all();
    }
    public function getList_cha(){
        return $this->where('parent_id',0)->orderBy('sapxep','DESC')->get();
    }
    public function getList_con(){
        return $this->where('parent_id','!=',0)->orderBy('sapxep','DESC')->get();
    }
    public function check($tendanhmuc,$parent_id,$danhmuc_id=0){
    	if($danhmuc_id==0){
    		return $this->where('tendanhmuc',$tendanhmuc)->where('parent_id',$parent_id)->count();
    	}
    	return $this->where('danhmuc_id','!=',$danhmuc_id)->where('tendanhmuc',$tendanhmuc)->where('parent_id',$parent_id)->count();
    }
    public function add($arItem){
    	return $this->insertGetId($arItem);
    }
    public function getItem($danhmuc_id){
        return $this->where('danhmuc_id',$danhmuc_id)->first();
    }
    public function edit($danhmuc_id,$arItem){
    	return $this->where('danhmuc_id',$danhmuc_id)->update($arItem);
    }
    public function del($danhmuc_id){
        $objDanhmuc_id=DB::table("danhmuc")
        ->where("danhmuc_id",$danhmuc_id)
        ->orWhere('parent_id',$danhmuc_id)
        ->select('danhmuc_id')
        ->get();
        foreach($objDanhmuc_id as $item){
            $arId[]=$item->danhmuc_id;
        }
        $objItems = DB::table('tintuc')->whereIn('danhmuc_id',$arId)->select('hinhanh')->get();
        foreach($objItems as $item){
            if(Storage::exists("files/".$item->hinhanh)){
                Storage::delete("files/".$item->hinhanh);
            }
        }
        DB::table('tintuc')->whereIn('danhmuc_id',$arId)->delete();
        return $this->where('danhmuc_id',$danhmuc_id)->orWhere('parent_id',$danhmuc_id)->delete();
    }
    // dem cac tin tuc thuoc danh muc
    public function demTintuc($danhmuc_id){
        $objDanhmuc_id=DB::table("danhmuc")
        ->where("danhmuc_id",$danhmuc_id)
        ->orWhere('parent_id',$danhmuc_id)
        ->select('danhmuc_id')
        ->get();
        foreach($objDanhmuc_id as $item){
            $arId[]=$item->danhmuc_id;
        }
        return DB::table('tintuc')->whereIn('danhmuc_id',$arId)->count();
    }
}
