<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model 
{
    public $table = 'employee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_at', 'deleted_at', 'updated_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public static function createNew($request) {
        return self::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'company_id' => $request->company_id,
            'api_token' => 'hjgugu48763874jhgjhgs8dysyudtiw'
        ]);
    }

    public function userData()
    {
        return $this->belongsTo('App\Model\UserAuth', 'employee_id');
    }

    
    public function schema() {
        return [
            'name' => $this->name,
            'email' => $this->email
        ];
    }
}
