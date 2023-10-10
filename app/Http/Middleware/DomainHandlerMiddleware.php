<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Str;
use App\Models\UserShop;
use Illuminate\Support\Facades\Config;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class DomainHandlerMiddleware
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
        $route_name = \Request::route()->getName();
        $route_path = \Request::path();

        
        // Allowed Subdomains
        if($subdomain == 'localhost' || $subdomain == '' || $subdomain == null || $subdomain == 'www' || $subdomain == '121'){
            return $response = $next($request);
        }
        
        elseif(Str::contains($route_name, 'pages.')){
            
            // Keep and proceed
            if (!UserShop::where('slug', $subdomain)->first()) {
                return abort(404); // or redirect to your homepage route.
            }
            // Suspected Line
            $request->merge(["subdomain" => $subdomain]);
            return $response = $next($request);
            
        }else{
            $response = $next($request);
            // return dd($subdomain);
           
           // Remove subdomain
           if (UserShop::where('slug', $subdomain)->first()) {
               $domain = env('APP_DOMAIN');
               $channel = env('APP_CHANNEL');
               if($route_path == '/'){
                    $route_path = '/home';
                    $url = $channel.$subdomain.'.'.$domain.$route_path;
                }else{
                   $route_path = '/'.$route_path;
                   $url = $channel.$domain.$route_path;
               }
               return redirect($url);
            }else{
                return $response = $next($request);
            }
        }

    }
}
