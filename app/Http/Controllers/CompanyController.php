<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Employee;
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
            'email' => 'required|email|unique:employee,email',
            'password' => 'required|min:4|max:16',
            'employee_name' => 'required|min:4|max:34'
        ]);
 
        $companyData = Company::createNew($request); 
        if(!$companyData){
            return response()->json(['status' => false, 'message' => 'Creation Failed'], 500);
        }  
        else{
            $request->company_id = $companyData->id;
            $request->type = 'company';
            $employee = Employee::createNew($request);
            if(!$companyData){
                return response()->json(['status' => false, 'message' => 'Creation Failed'], 500);
            } 
            else{
                return response()->json([
                    'status' => true,
                    'message'=>'Company Account Created Successfully', 
                    'data' => $companyData->schemaOne()], 
                    200);
            }
               
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
