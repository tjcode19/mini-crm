<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

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
            'password' =>Hash::make($request->password),
            'company_id' => $request->company_id
        ]);
    }

    public function companyData() {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    
    public function schema() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ];
    }
}
