<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Company;


class CompanyMiddleware
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
        if($user->type != 'company'){
            return response()->json(['status' => false, 'message' => 'Permission denied, you are not a company administrator'], 401);
        }

        return $next($request);
    }

    protected function  companyExist($id){
        return Company::where(['id' => $id, 'status' => 1])->first();
    }
}
