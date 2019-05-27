<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserHasUsergroup extends Model
{
	protected $fillable = [
        'usergroup_id','user_id','type'
    ];

    public function usergroup_detail(){
    	return $this->hasOne('App\Model\UserGroup','id','usergroup_id');
    }
}
