<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public $auth;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->auth = $request->auth;
    }

    //

    public function createNew(Request $request){

        $this->validate($request, [
            'company_id' => 'required|exists:company,id',
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:employee,email',
            'password' => 'required|min:4|max:16'
        ]);
 
        $employeeData = Employee::createNew($request); 
        if(!$employeeData){
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
                    'message'=>'Employee Account Created Successfully', 
                    'data' => $employeeData->schema()], 
                    200);
        }
    }

    public function allEmployee(){
        if($this->auth->type != 'admin'){
            $employees = Employee::where(['company_id' => $this->auth->company_id])->get();
        }
        else{
            $employees = Employee::all();
        }
        
        if(!$employees){
            return response()->json(['status' => false, 'message'=>'Unable to fetch Records'], 500);
        }
        $no_of_rec = sizeof($employees);

        if($no_of_rec > 0){
            $data = $employees->map(function ($employee){
                return $employee->schema();
            });

            return response()->json(['status' => true,'message'=> $no_of_rec.' Record(s) Found', 'data' => $data], 200);
        }
        else{
            return response()->json(['status' => true, 'message'=>'No Record Found'], 200);
        }
    }

    public function singleEmployee($id) {

        if($this->auth->type == 'employee'){
            if($this->auth->employee_id == $id){
                $employeeRecord = Employee::find($id); 
            }
            else{
                return response()->json(['status' => false, 'message' => 'Access Denied'], 401);
            }

        }
        else{
            $employeeRecord = Employee::find($id); 
        }        

        if (!$employeeRecord) {
            return response()->json(['status' => false, 'message' => 'No Record Found'], 404);
        }
        return response()->json(['status' => true, 'message' => 'Record Found', 'data'=> $employeeRecord->schema()], 200);
    }

    public function updateEmployee(Request $request, $id){

        $this->validate($request, [
            'name' => 'required'
        ]);
 
        $employeeData = Employee::find($id); 
        if(!$employeeData){
            return response()->json(['status' => false, 'message' => 'No Record Found'], 404);
        }  
        else{
            $employeeUpdate = $employeeData->update([
                'name' => $request->name
            ]);
            if(!$employeeUpdate){
                return response()->json(['status' => false, 'message' => 'Update Failed'], 500); 
            }
            return response()->json([
                'status' => true, 
                'message'=>'Update Suceesful', 
                'data' => $employeeData->schema()], 
                200);
        } 
    }

    public function deleteEmployee($id) {

        $employeeRecord = Employee::find($id); 

        if (!$employeeRecord) {
            return response()->json(['status' => false, 'message' => 'No Record Found'], 404);
        }
        $employeeRecord->delete();
        return response()->json(['status' => true, 'message' => 'Deletion Successful'], 200);
    }

}
