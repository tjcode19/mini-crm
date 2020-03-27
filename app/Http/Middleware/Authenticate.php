<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Auth\GenericUser;
use \Firebase\JWT\ExpiredException;
use \Firebase\JWT\JWT;
use \Firebase\JWT\SignatureInvalidException;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $authorization_string = $request->headers->get('Authorization');

        if (!$authorization_string) {
            return response()->json(['status' => false, 'message' => 'Unauthorized, Bearer Token not set'], 401);
        }

        list($type, $token) = explode(' ', $authorization_string);

        if ($type != 'Bearer' || !$token) {
            return response()->json(['status' => false, 'message' => 'Invalid token format, <Bearer $token> format allowed'], 401);
        }
        $payload = $this->decodeToken($token);
        $p = json_decode($payload);

        //dd($p->payload);

        if ($p->status) {
            try{
                $request->auth = new GenericUser(['company_id' => $p->payload->company_id, 'employee_id' => $p->payload->employee_id, 'type' => $p->payload->type]);
            }
            catch(Exception $e){
                return json_encode(['status' => false, 'message' => 'Invalid token'], 401);
            }
            
        }
        else{
            return response()->json(['status' => false, 'message' => $p->message], 401);
        }

        return $next($request);
    }

    private function decodeToken(String $token = null) {
        $output['message'] = "Token cannot be empty";
        $output['status'] = false;
       
        if ($token) {         
            try {
                $payload = JWT::decode($token, config('const.AUTH_KEY'), array('HS256'));  
                // dd($payload);             
                return json_encode(['status' => true, 'message' => 'Token accepted', 'payload'=>$payload], 200);
            } catch (\Exception | ExpiredException | SignatureInvalidException $e) {
                if ($e instanceof ExpiredException) {
                    return json_encode(['status' => false, 'message' => 'Token expired'], 401);
                }
                return json_encode(['status' => false, 'message' => 'Invalid token'], 401);
            }
        }
        return json_encode($output, 401);
    }
}
