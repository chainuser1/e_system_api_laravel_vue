<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Subject;
class Activity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_url',
        'user_id',
        'subject_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'subject_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function getFileUrlAttribute($value)
    {
        return asset($value);
    }

    public function getCreatedAtAttribute($value)
    {
        // convert to timestamp
        return strtotime($value);
    }


}
