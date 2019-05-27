<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use Notifiable;
    //use Encryptable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*use EncryptableTrait;

    protected $EncryptableTrait = [
        'firstname','lastname', 'email','username'
    ];*/
    protected $fillable = [
        'firstname','lastname', 'email', 'password','username','userid','usergroupid','role'
    ];

    public function userHasUsergroup(){
        return $this->hasMany('App\Model\UserHasUsergroup','user_id','id')->with('usergroup_detail');
    }



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFirstnameAttribute($value) {
        return Crypt::decryptString($value);
    }
    public function getLastnameAttribute($value) {
        return Crypt::decryptString($value);
    }
    public function getUsernameAttribute($value) {
        return Crypt::decryptString($value);
    }
 
    public function getEmailAttribute($value) {
        return Crypt::decryptString($value);
    }
 
    public function setFirstnameAttribute($value) {
        $this->attributes['firstname'] = Crypt::encryptString($value);
    }
    public function setLastnameAttribute($value) {
        $this->attributes['lastname'] = Crypt::encryptString($value);
    }
    public function setUsernameAttribute($value) {
        $this->attributes['username'] = Crypt::encryptString($value);
    }
 
    public function setEmailAttribute($value) {
        $this->attributes['email'] = Crypt::encryptString($value);
    }
}
