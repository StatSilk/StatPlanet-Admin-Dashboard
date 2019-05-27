<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DashboardCategory extends Model
{
    //
    public function dashboard(){
    	return $this->hasMany('App\Model\DashCatHasDashboard','dashboardcategory_id','id')->with('dashboardName');
    }
    public function userGroupHasDashCat(){
		return $this->hasMany('App\Model\UserGroupHasDashboardCat','dashboardcategory_id','id');
	}
}
