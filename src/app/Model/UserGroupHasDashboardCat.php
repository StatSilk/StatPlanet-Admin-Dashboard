<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserGroupHasDashboardCat extends Model
{
   protected $table = 'user_group_has_dashboard_category';
   protected $fillable = [
        'usergroup_id','dashboardcategory_id'
    ];

    public function dashcat_detail(){
    	return $this->hasOne('App\Model\DashboardCategory','id','dashboardcategory_id');
    }
}