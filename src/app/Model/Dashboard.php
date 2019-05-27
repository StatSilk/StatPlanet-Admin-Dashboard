<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
	protected $fillable = [
        'name','folder_name','dashboardcategory_id','description','dashboard_link'
    ];
    public function dashboard(){
    	return $this->hasMany('App\Model\DashCatHasDashboard','dashboard_id','id');
    }
    public function dashcat_detail(){
    	return $this->hasOne('App\Model\DashboardCategory','id','dashboardcategory_id')->select('id','name');
    }
}
