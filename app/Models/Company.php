<?php 

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
 
class Company extends Model
{ 
    public $table = 'company';
    protected $guarded = [
        'created_at', 'deleted_at', 'updated_at',
    ];

    public static function createNew($request) {
        return self::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'logo' => $request->password,
            'url' => $request->password,
        ]);
    }


    public function employees() {
        return $this->hasMany('App\Models\Employee', 'employee_id');
    }

    public function status(){
        return (($this->status != null) || ($this->status> 0))?'Active':'Inactive';
    }

    public function schemaOne() {
        return [
            'company_id' => $this->id,
            'name' => $this->name,
           // 'status'=> $this->status(),
            'verified'=> $this->verified,
           /// 'type' => $this->type->name,           
           // 'category'=> $this->category->name,
        ];
    }

    public function schema() {
        return [
            'company_id' => $this->id,
            'name' => $this->name,
            'status'=> 'Inactive',
            'verified'=> $this->verified, 
            'email' => $this->email    
        ];
    }
}
