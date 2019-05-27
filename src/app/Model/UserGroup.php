<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    // relation for usergroup with dashboard category
	public function userGroupHasDashCat(){
		return $this->hasMany('App\Model\UserGroupHasDashboardCat','usergroup_id','id')->with('dashcat_detail');
	}

	public function userHasUsergroup(){
		return $this->hasMany('App\Model\UserHasUsergroup','usergroup_id','id');
	}
}
