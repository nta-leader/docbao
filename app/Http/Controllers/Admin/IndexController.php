<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Index\AiModel;

class IndexController extends Controller
{
    public function __construct(AiModel $AiModel){
        $this->AiModel=$AiModel;
    }
    public function index(){
        return view('admin.index.index');
    }
}
