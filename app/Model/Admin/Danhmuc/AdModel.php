<?php

namespace App\Model\Admin\Danhmuc;

use Illuminate\Database\Eloquent\Model;

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
    public function del($id){
        return $this->where('danhmuc_id',$id)->orWhere('parent_id',$id)->delete();
    }
}
