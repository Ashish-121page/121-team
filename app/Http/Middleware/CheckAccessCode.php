<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AccessCode;

class CheckAccessCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        return $next($request);


        // if(auth()->check()){
        //     if(AuthRole() == "User"){
        //        $chk = AccessCode::where('redeemed_user_id',auth()->id())->first();
        //        if(!$chk && auth()->user()->is_supplier != 1){
        //            return redirect(route('auth.login-index'));
        //        }
        //     }
        //     return $next($request);
        // }else{
        //     return redirect(route('auth.login-index'));
        // }
    }
}
