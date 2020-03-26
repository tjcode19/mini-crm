<?php 

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
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
            'password' => $request->password,
            'logo' => $request->password,
            'url' => $request->password,
        ]);
    }

    public function updateSchool($request) {
        return $this->update([
            'name' => $request->name,
            'school_type_id' => $request->school_type_id,
            'school_category_id' => $request->school_category_id,
            'status'=> $request->status
        ]);
    }

    public function type() {
        return $this->belongsTo('App\Model\SchoolType','school_type_id', 'id');
    }

    public function category() {
        return $this->belongsTo('App\Model\SchoolCategory','school_category_id', 'id');
    }

    public function users() {
        return $this->hasMany('App\Model\UserAuth', 'school_id');
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
        ];
    }
}
