<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserLog;


class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Log the user activity here
        $logData = [
            'user_id' => auth()->id() ?? null,
            'ip_address' => $request->ip(),
            'activity' => $request->fullUrl(),
            'name' => auth()->user()->name ?? 'Anonymous',
            'method' => $request->method(),
            'user_agent' => $request->header('User-Agent'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        UserLog::create($logData);

        // Store $logData in your database or log file

        return $response;
    }


}
