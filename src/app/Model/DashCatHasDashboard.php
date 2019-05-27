<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DashCatHasDashboard extends Model
{
	protected $table = 'dashboard_category_has_dashboard';
	
    protected $fillable = [
        'dashboardcategory_id','dashboard_id'
    ];
    public function dashboardName(){
    	return $this->hasOne('App\Model\Dashboard','id','dashboard_id')->select('id','name');
    }
}
