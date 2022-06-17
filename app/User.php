<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','membership_number','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($username) {
       return self::where('username', $username)->first(); // change column name whatever you use in credentials
    }

    public function hasRole($role) {
        return $this->role == $role;
    }

    // one-to-one relationship with student if the user role is student
    public function student() {
        if($this->hasRole('student')) {
            // return through matching user->membership_number and student_student_number
            return $this->belongsTo('App\Student', 'student_number', 'membership_number');
        }
    }

    // one-to-one relationship with instructor if the user role is instructor, staff, admin
    public function instructor() {
        if($this->hasRole('instructor') || $this->hasRole('staff') || $this->hasRole('admin')) {
            // return if hasOne through matching user->membership_number and personnel->employee_number
            return $this->belongsTo('App\Personnel','employee_number','membership_number');
        }
    }
}
