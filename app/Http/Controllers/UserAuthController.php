<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


use Laravel\Lumen\Routing\Controller as BaseController;

class UserAuthController extends Controller
{
    public function __construct()
    {
        //
    }

    public function userLogin(Request $request){

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'type' => 'required'
        ]);

        if($request->type != "company"){
            return $this->employeelogin($request);
        }
        else{
            return $this->companyLevellogin($request);
        }

        
    }

    public function companyLevellogin($request){
        $auth = Company::where('email', $request->username)->first();
        if(!$auth){
            return response()->json(['status'=>false, 'message' => 'User does not exist'], 200);
        }
        else{
            if($auth->status < 1){
                return response()->json(['status'=>false, 'message' => 'User Account Inactive'], 200);
            }
            else{
                if(Hash::check($request->password, $auth->password)){
                    $login_info = json_encode(['login_time'=> date("h:i:s")]); 
                    $token_credentials = json_encode([
                        'type'=> $auth->type, 
                        'company_id'=>$auth->company_id, 
                        'employee_id' => $auth->id]); 
                    $token =  $this->createToken($token_credentials); 
                    $auth->update(['login_info'=>$login_info]);
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Successful',
                        'token' => $token, 
                        'type'=> 'company',
                        'data'=>$auth->schema()
                    ], 
                        200);
                }
                else{
                    return response()->json(['status'=>false, 'message' => 'Invalid login credentials'], 200);
                }
            }
        }

    }

    public function employeelogin($request){
        $auth = Employee::where('email', $request->username)->first();
        if(!$auth){
            return response()->json(['status'=>false, 'message' => 'User does not exist'], 200);
        }
        else{
            if($auth->status < 1){
                return response()->json(['status'=>false, 'message' => 'User Account Inactive'], 200);
            }
            else{
                if(Hash::check($request->password, $auth->password)){
                    $login_info = json_encode(['login_time'=> date("h:i:s")]); 
                    $token_credentials = json_encode([
                        'type'=> $auth->type, 
                        'company_id'=>$auth->company_id, 
                        'employee_id' => $auth->id]); 

                    $token =  $this->createToken($token_credentials); 
                    $auth->update(['login_info'=>$login_info]);
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Successful',
                        'token' => $token,
                        'type' => $auth->type, 
                        'data'=>$auth->schema(),
                        'company' => (($auth->type!='admin')?$auth->companyData->schema():'')
                    ], 
                        200);
                }
                else{
                    return response()->json(['status'=>false, 'message' => 'Invalid login credentials'], 200);
                }
            }
        }
        
    }

    //request password reset code
    public function passwordResetToken(Request $request){
        $this->validate($request, [
            'username' => 'required'
        ]);
        
        $auth = UserAuth::where('username', $request->username)->first();
        if(!$auth){
            return response()->json(['status' => false, 'message'=>'Invalid Username, contact your administrator'], 404);
        }
        $userEmail = $auth->employeeData->email;

        $password_reset_token  = $this->generate_string(6);
        
        if(!$auth->reset_code ){
            $auth->update(['reset_token' => $password_reset_token]);
        }

        //dispatch(new SendPasswordResetTokenMailJob($request->email, $reset_code, $auth));

        return response()->json(['status' => true, 'message' => 'Password reset token sent'], 200);
    }

    //reset password with code set to email address
    public function passwordReset(Request $request){
        $this->validate($request, [
            'token' => 'required',
            'password' => 'required'
        ]);

        $auth = UserAuth::where('reset_token', $request->token)->first();

        if(!$auth){
            return response()->json(['status' => false, 'message' =>  'Invalid Token'], 400);
        }
        else{
            $auth->update(['reset_token'=>NULL, 'password'=>Hash::make($request->password)]);  
            return response()->json(['status' => true, 'message' => 'Password has been reset successfully'], 200);
        }   
    }

    public function logout(Request $request){
        $this->validate($request, [
            'username' => 'required|exists:user_auth,username'
        ]);

        $auth = UserAuth::where('username', $request->username)->first();
        if(!$auth){
            return response()->json(['status'=>false, 'message' => 'User does not exist'], 400);
        }
        else{
            $auth->update(['login_info'=>NULL,'hash_value'=>NULL]);
            return response()->json(['status'=>true, 'message' => 'Logout Successful'], 201);
            
        }      
    }

    public function refreshToken(Request $request){
        $auth = UserAuth::where('id', $request->user_id)->first();

        if($auth->isLogin()){
            $token =  $this->createToken($auth); 
            return response()->json([
                'status' => true,
                'message' => 'Token Regenerated',
                'token' => $token], 
                200);
        }
        return response()->json(['status' => false,'message' => 'Token Regeneration Failed, No authenticated User'], 200);
      
    }
}
