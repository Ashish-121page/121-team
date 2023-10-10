<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserShop;

class SubDomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $server = explode('.', $request->server('HTTP_HOST'));
        $subdomain = $server[0];
        if (!UserShop::where('slug', $subdomain)->first()) {
            return abort(404); // or redirect to your homepage route.
        }
        $request->merge(["subdomain" => $subdomain]);
        return $next($request);
    }
}