<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Company;


class AdminMiddleware
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
        $user = $request->auth;
        if($user->type != 'admin'){
            return response()->json(['status' => false, 'message' => 'Permission denied, you are not an administrator'], 401);
        }

        return $next($request);
    }
}
