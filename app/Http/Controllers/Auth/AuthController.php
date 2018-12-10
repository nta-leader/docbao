<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{
    public function postlogin(Request $req){
        $data = $req->only(['username','password']);
        $username=trim($req->username);
        $password=trim($req->password);
    	if (Auth::attempt($data)) {
    		$auth=Auth::user();
    		if($auth->active == 1){
    			return redirect()->route('admin.index.index');
            }
            return redirect()->route('docbao.login')->with(['msg'=>'Tài khoản đang bị khóa !']);
		}else{
			return redirect()->route('docbao.login')->with(['msg'=>'Sai username hoặc password !']);
		}
    }
    public function logout(){
    	Auth::logout();
    	return redirect()->route('docbao.login');
    }
}
