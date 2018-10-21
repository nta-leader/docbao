<?php

namespace App\Model\Admin\Tintuc;

use Illuminate\Database\Eloquent\Model;
use DB;
use Storage;

class AtModel extends Model
{
    protected $table="tintuc";
    protected $primarKey="tintuc_id";
    public $timestamps=false;

    public function getAll(){
        return DB::table("tintuc as tt")
            ->leftjoin("danhmuc as dm","tt.danhmuc_id","=","dm.danhmuc_id")
            ->select("tt.tintuc_id","tt.tentintuc","tt.gioithieu","tt.ngaytao","tt.active","tt.hinhanh","tt.luotxem","tt.nguon","dm.tendanhmuc")
            ->orderBy('tt.tintuc_id','DESC')
            ->paginate(getenv('PAGE_ADMIN'));
    }
    public function add($arItem){
        return $this->insertGetId($arItem);
    }
    public function getItem($tintuc_id){
        return $this->where('tintuc_id',$tintuc_id)->first();
    }
    public function edit($tintuc_id,$arItem){
        return $this->where('tintuc_id',$tintuc_id)->update($arItem);
    }
    public function del($arId){
        foreach($arId as $tintuc_id){
            $hinhanh=$this->getItem($tintuc_id)->hinhanh;
            if(Storage::exists('files/'.$hinhanh)){
                Storage::delete('files/'.$hinhanh);
            }
        }
        return $this->whereIn('tintuc_id',$arId)->delete();
    }
    public function check($name){
        $count = DB::table('tintuc')->where('code',$name)->count();
        if($count > 0){
            return false;
        }else{
            return true;
        }
    }

    //RSS
    public function getRss(){
        return DB::table('rss')->get();
    }
    public function getItemrss($id){
        return DB::table('rss')->where('rss_id',$id)->first();
    }
    public function addrss($arItem){
        return DB::table('rss')->insertGetId($arItem);
    }
    public function delrss($id){
        $objItems=$this->getTintucrss($id);
        $arTintucrss_id[]='0';
        foreach($objItems as $objItem){
            $arTintucrss_id[]=$objItem->id;
        }
        
        $this->delTintucrss($arTintucrss_id);
        return DB::table('rss')->where('rss_id',$id)->delete();
    }

    //Tintuc_rss
    public function getTintucrss($id){
        return DB::table('tintuc_rss as t')->leftjoin('rss as r','t.rss_id','=','r.rss_id')->where('t.rss_id',$id)->orderBy('id','DESC')->paginate(getenv('PAGE_ADMIN'));
    }
    public function getItemtintucrss($id){
        return DB::table('tintuc_rss as t')->leftjoin('rss as r','t.rss_id','=','r.rss_id')->where('t.id',$id)->first();
    }
    public function addTintucrss($arItem){
        return DB::table('tintuc_rss')->insertGetId($arItem);
    }
    public function delTintucrss($arId){
        foreach($arId as $id){
            $objItem=DB::table('tintuc_rss')->where('id',$id)->first();
            if($objItem != null && $objItem->active == '1' && Storage::exists('files/'.$objItem->picture)){
                Storage::delete('files/'.$objItem->picture);
            }
        }
        return DB::table('tintuc_rss')->whereIn('id',$arId)->delete();
    }
    public function check_rss($name){
        $count = DB::table('tintuc_rss')->where('name',$name)->count();
        if($count > 0){
            return false;
        }else{
            return true;
        }
    }
    public function tintucrss_update($id){
        return DB::table('tintuc_rss')->where('id',$id)->update(['active'=>1]);
    }
}