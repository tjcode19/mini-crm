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
    $router->post('create','CompanyController@createNew');
    $router->get('/all','CompanyController@allCompanies'); 
    $router->get('/{company_id}','CompanyController@singleCompany');     
    $router->put('/{company_id}','CompanyController@updateCompany');
    $router->delete('/{company_id}','CompanyController@deleteCompany');      
});

/******** Employee Management starts here ********/

$router->group(['prefix' => 'api/v1/employee'], function () use ($router){
    $router->post('/create','EmployeeController@createNew');     
    $router->get('/all','EmployeeController@allEmployee'); 
    $router->put('/{employee_id}','EmployeeController@updateEmployee'); 
    $router->get('/{employee_id}','EmployeeController@singleEmployee'); 
    $router->delete('/{employee_id}','EmployeeController@deleteEmployee'); 
});

/******** Employee Management ends here ********/
