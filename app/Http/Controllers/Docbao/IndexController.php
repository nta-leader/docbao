<?php

namespace App\Http\Controllers\Docbao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use DB;

class IndexController extends Controller
{
    public function index(){
        $arItem=DB::table('tintuc')->get()->toArray();
        /*$arItem=[
            "0"=>[
                "id"=>"1",
                "name"=>"thời sự",
                "dmc"=>[
                    "id"=>"2",
                    "name"=>"trong nước"
                ]
            ],
            "1"=>[
                "id"=>"1",
                "name"=>"thời sự",
                "dmc"=>""
            ],   
        ];*/
        $responsecode = 200;
        $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );
        $json=response()->json($arItem , $responsecode, $header, JSON_UNESCAPED_UNICODE);
        return $json;
    }
}
