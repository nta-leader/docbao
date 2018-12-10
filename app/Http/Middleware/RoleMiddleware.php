<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        $username=Auth::user()->username;
        if(strpos($role,$username)===false){
            return redirect()->back()->with(['msg'=>'Bạn không có chức năng này !']);
        }
        return $next($request);
    }
}
