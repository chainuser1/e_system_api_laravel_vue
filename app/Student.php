<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Student extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'student_number',
        'first_name',
        'last_name',
        'middle_name',
        'suffix',
        'status',
    ];

    protected $dates = ['created_at','updated_at','deleted_at'];
    public function getFirstNameAttribute($value){
        return ucwords($value);
    }

    public function getLastNameAttribute($value){
        return ucwords($value);
    }

    public function getMiddleNameAttribute($v){
        return ucwords($v);
    }

    public function getStatusAttribute($value){
      return ucwords($value);
    }

    public function setLastNameAttribute($value){
        $this->attributes['last_name'] = ucwords($value);
    }

    public function setFirstNameAttribute($value){
        $this->attributes['first_name'] = ucwords($value);
    }

    public function setMiddleNameAttribute($value){
        $this->attributes['middle_name'] = ucwords($value);
    }

    public function getCreatedAtAttribute($date){
        // return a carbon diffForHuman
        if($date)
            return Carbon::createFromDate($date)->diffForHumans();
        else
            return null;
    }

    public function getUpdatedAtAttribute($date)
    {
        if($date)
            return Carbon::createFromDate($date)->diffForHumans();
        else
            return null;
    }

    public function getDeletedAtAttribute($date){
        if($date)
            return Carbon::createFromDate($date)->diffForHumans();
        else
            return null;
    }

    public function setStatusAttribute($value){
      $this->attributes['status'] = strtolower($value);
    }

    // student has one user based on membership_number
    public function user(){
        return $this->hasOne('App/User','membership_number','student_number');
    }
}
