<?php

namespace App;

use Attribute as GlobalAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Personnel extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['employee_number','first_name','last_name','middle_name','suffix','type'];
    protected $dates = ['created_at','updated_at','deleted_at'];
    public function getFirstNameAttribute($value){
        return ucwords($value);
    }

    public function getTypeAttribute($value){
      return ucwords($value);
    }

    public function getLastNameAttribute($value){
        return ucwords($value);
    }

    public function getMiddleNameAttribute($v){
        return ucwords($v);
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

    public function setTypeAttribute($value){
      $this->attributes['type'] = strtolower($value);
    }

    public function user(){
        return $this->hasOne('App/User','membership_number','employee_number');
    }
}
