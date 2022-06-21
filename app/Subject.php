<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Subject extends Model
{
    //
    protected $fillable = [
        'name',
        'code',
        'description',
        'user_id',
        'instructor_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function instructor()
    {
        return $this->belongsTo('App\User','id','instructor_id');
    }

    public function getCreatedAtAttribute($new_date)
    {
         //new date from carbon 
         //short word format like Jan 02, 2021
        return Carbon::parse($new_date)->format('M d, Y');
    }

}
