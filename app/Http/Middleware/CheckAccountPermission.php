<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAccountPermission
{
    public function handle($request, Closure $next, $permission)
    {
        $user = Auth::user();

        // Decode the JSON permissions from the user
        $permissions = json_decode($user->account_permission, true);

        // Check if the specific permission exists and is true
        if (is_null($permissions) || !isset($permissions[$permission]) || !$permissions[$permission]) {
            // Redirect or return error response if permission is not granted
            return redirect()->route('panel.dashboard')->with('error', 'You do not have permission to access this page.');
            // return response('Unauthorized', 403);
        }

        return $next($request);
    }
}
