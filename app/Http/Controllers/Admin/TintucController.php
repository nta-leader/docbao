<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Tintuc\AtModel;

class TintucController extends Controller
{
    public function __construct(AtModel $AtModel){
        $this->AtModel=$AtModel;
    }
    public function index(){
        $objItems=$this->AtModel->getAll();
        return view('admin.tintuc.index',compact('objItems'));
    }
}
