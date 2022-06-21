<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo('App\User', 'membership_number','instructor_id');
    }
}
