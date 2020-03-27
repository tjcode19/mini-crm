<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public $auth;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //payload form decrypted bearer token set
        $this->auth = $request->auth;
    }

    //

    public function createNew(Request $request){

        $this->validate($request, [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:company,email',
            'password' => 'required|min:4|max:16'
        ]);
 
        $companyData = Company::createNew($request); 
        if(!$companyData){
            return response()->json(['status' => false, 'message' => 'Creation Failed'], 500);
        }  
        else{
                // $request->employee_id = $employeeData->id;
                // $username = explode("@",$request->email);
                // $request->username = $username[0];
                // $request->password = $this->generate_string(6);
                // $auth = UserAuth::createNew($request);

                // if(!$auth){
                //     return response()->json(['status' => false, 'message' => 'Auth Creation Failed'], 500);
                // }
                // $auth->passwordRaw = $request->password;
                // $notice = new LoginCredentialsJob($auth);
                // $send_notice = $notice->handle();

                return response()->json([
                    'status' => true,
                    'message'=>'Company Account Created Successfully', 
                    'data' => $companyData->schema()], 
                    200);
        }
    }

    public function allCompanies(){
        $companies = Company::all();
        if(!$companies){
            return response()->json(['status' => false, 'message'=>'Unable to fetch Records'], 500);
        }
        $no_of_rec = sizeof($companies);

        if($no_of_rec > 0){
            $data = $companies->map(function ($companies){
                return $companies->schema();
            });

            return response()->json(['status' => true,'message'=> $no_of_rec.' Record(s) Found', 'data' => $data], 200);
        }
        else{
            return response()->json(['status' => true, 'message'=>'No Record Found'], 200);
        }
    }

    public function singleCompany($id) {

        $companyRecord = Company::find($id); 

        if (!$companyRecord) {
            return response()->json(['status' => false, 'message' => 'No Record Found'], 404);
        }
        return response()->json(['status' => true, 'message' => 'Record Found', 'data'=> $companyRecord->schema()], 200);
    }

    public function updateCompany(Request $request, $id){

        $this->validate($request, [
            'name' => 'required'
        ]);
 
        $companyData = Company::find($id); 
        if(!$companyData){
            return response()->json(['status' => false, 'message' => 'No Record Found'], 404);
        }  
        else{
            $companyUpdate = $companyData->update([
                'name' => $request->name
            ]);
            if(!$companyUpdate){
                return response()->json(['status' => false, 'message' => 'Update Failed'], 500); 
            }
            return response()->json([
                'status' => true, 
                'message'=>'Update Suceesful', 
                'data' => $companyData->schema()], 
                200);
        } 
    }

    public function deleteCompany($id) {

        $companyRecord = Company::find($id); 

        if (!$companyRecord) {
            return response()->json(['status' => false, 'message' => 'No Record Found'], 404);
        }
        $companyRecord->delete();
        return response()->json(['status' => true, 'message' => 'Deletion Successful'], 200);
    }

}
