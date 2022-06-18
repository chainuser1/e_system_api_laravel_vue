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

    public function hasAnyRole($roles){
        if(is_array($roles)){
            foreach($roles as $role){
                if($this->hasRole($role)){
                    return true;
                }
            }
        }
        else{
            return false;
        }
    }

    public function getNameAttribute($value){
      return ucwords($value);
    }

    public function setRoleAttribute($value){
      // convert $value to lower case and assign to $this->role
      $this->attributes['role'] = strtolower($value);
    }

    // public function getRoleAttribute($value){
    //   return ucwords($value);
    // }

}
