<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/******** All Company related starts here ********/

$router->group(['prefix' => 'api/v1/company'], function () use ($router){
    $router->get('/all','CompanyController@allCompanies');    
    $router->group(['middleware' => 'auth'], function () use ($router){  
        $router->group(['middleware' => 'admin'], function () use ($router){  
            //Admin right is need to access these endpoints
            $router->post('create','CompanyController@createNew');            
            $router->put('/{company_id}','CompanyController@updateCompany');
            $router->delete('/{company_id}','CompanyController@deleteCompany');  
        });
    }); 
    $router->get('/{company_id}','CompanyController@singleCompany');    
});

/******** Employee Management starts here ********/

$router->group(['prefix' => 'api/v1/employee'], function () use ($router){
    $router->group(['middleware' => 'auth'], function () use ($router){ 
        $router->group(['middleware' => 'company', 'middleware' => 'admin'], function () use ($router){  
            $router->post('/create','EmployeeController@createNew');     
            $router->get('/all','EmployeeController@allEmployee'); 
            $router->delete('/{employee_id}','EmployeeController@deleteEmployee'); 
        });        
        $router->get('/{employee_id}','EmployeeController@singleEmployee');         
        $router->put('/{employee_id}','EmployeeController@updateEmployee'); 
    });
});

/******** Employee Management ends here ********/


/******** Authentication/Authorization starts here ********/

$router->group(['prefix' => 'api/v1/auth'], function () use ($router){
    $router->post('/login','userAuthController@userLogin');     
    $router->get('/all','EmployeeController@allEmployee'); 
    $router->put('/{employee_id}','EmployeeController@updateEmployee'); 
    $router->get('/{employee_id}','EmployeeController@singleEmployee'); 
    $router->delete('/{employee_id}','EmployeeController@deleteEmployee'); 
});

/******** Employee Management ends here ********/
