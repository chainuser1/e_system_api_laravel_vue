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
}
