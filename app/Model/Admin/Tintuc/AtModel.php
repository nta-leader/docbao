<?php

namespace App\Model\Admin\Tintuc;

use Illuminate\Database\Eloquent\Model;
use DB;

class AtModel extends Model
{
    protected $table="tintuc";
    protected $primarKey="tintuc_id";
    public $timestamps=false;

    public function getAll(){
        return DB::table("tintuc as tt")->leftjoin("danhmuc as dm","tt.danhmuc_id","=","dm.danhmuc_id")->select("tt.tintuc_id","tt.tentintuc","tt.gioithieu","tt.ngaytao","tt.active","tt.hinhanh","dm.tendanhmuc")->orderBy('tt.tintuc_id','DESC')->paginate(getenv('PAGE_ADMIN'));
    }
}