<?php

namespace App\Http\Controllers\Docbao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Danhmuc\AdModel;
use Response;
use DB;

class IndexController extends Controller
{
    public function list_dm(AdModel $cat){
        $arItem=DB::table('danhmuc')->get();
        $responsecode = 200;
        $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );
        $json=response()->json($arItem , $responsecode, $header, JSON_UNESCAPED_UNICODE);
        return $json;
    }
    public function index($page){
        $arItem=DB::table('tintuc')->where('active',1)->select('tintuc_id','tentintuc','gioithieu','hinhanh')->skip($page*20-20)->take(20)->get();
        $responsecode = 200;
        $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );
        $json=response()->json($arItem , $responsecode, $header, JSON_UNESCAPED_UNICODE);
        return $json;
    }
    public function cat($id,$page){
        $arId=DB::table('danhmuc')->where('danhmuc_id',$id)->orWhere('parent_id',$id)->select('danhmuc_id')->get();
        $id=[0=>0];
        foreach ($arId as $value) {
            $id[]=$value->danhmuc_id;
        }
        $arItem=DB::table('tintuc')
        ->where('active',1)
        ->whereIn('danhmuc_id',$id)
        ->select('tintuc_id','tentintuc','gioithieu','hinhanh')
        ->skip($page*20-20)
        ->take(20)
        ->get();
        $responsecode = 200;
        $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );
        $json=response()->json($arItem , $responsecode, $header, JSON_UNESCAPED_UNICODE);
        return $json;
    }
    public function detail($id){
        $arItem=DB::table('tintuc')->where('active',1)->where('tintuc_id',$id)->select('tintuc_id','tentintuc','chitiet','hinhanh')->first();
        $responsecode = 200;
        $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );
        $json=response()->json($arItem , $responsecode, $header, JSON_UNESCAPED_UNICODE);
        return $json;
    }
}
