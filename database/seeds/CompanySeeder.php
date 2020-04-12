<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        for($c =1; $c<=30; $c++){
            $company = DB::table('company')->insert([
                 'name' => 'Company '. $c,
                 'email' => 'comp'.$c.'@comp.com',
             ]);
 
             $employee = DB::table('employee')->insert([
                 'name' => 'Employee '. Str::random(3),
                 'email' => 'emp'.$c.Str::random(2).'@comp.com',
                 'password' =>Hash::make('admin'),
                 'company_id' => $c,
                 'type' => 'company'
             ]);
 
             $employee = DB::table('employee')->insert([
                 'name' => 'Employee '.Str::random(3),
                 'email' => 'emp'.$c.Str::random(3).'@comp.com',
                 'password' =>Hash::make('employee'),
                 'company_id' => $c,
                 'type' => 'employee'
             ]);
          }
    }
}
