<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['middleware' => 'auth', 'uses'=>'Controller@index']);
Auth::routes();

Route::middleware('auth')->group( function(){
	
	Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
	/*Route::get('/dashboard', 'HomeController@index')->name('home');
	*//*Route::get('/change-password', 'HomeController@changePassword');*/
	Route::post('/post-password', 'HomeController@postPassword');
	Route::get('/edit-account', 'HomeController@editProfile');
	Route::post('/post-profile', 'HomeController@postProfile');
	// routes for user
	Route::get('/users/delete', 'UserController@userDelete');
	Route::get('/users/usergroup-list', 'UserController@userGroupList');
	Route::post('/users/assign-usergroup', 'UserController@assignUsergroup');
	Route::resource('/users', 'UserController');
	//routes for user groups
	Route::get('/user-groups/delete', 'UserGroupController@userGroupDelete');
	Route::get('/user-groups/dashboard-list', 'UserGroupController@dashboardList');
	Route::post('/user-groups/assign-dashcat', 'UserGroupController@assignDashcat');
	Route::resource('/user-groups', 'UserGroupController');
	//routes for dashboard category
	Route::get ('/dashboard-categories/delete', 'DashCategoryController@dashcatDelete');
	Route::get('/dashboard-categories/dashboard-list', 'DashCategoryController@dashboardList');
	Route::post('/dashboard-categories/assign-dashboard', 'DashCategoryController@assignDashboard');
	Route::resource('/dashboard-categories', 'DashCategoryController');
	//routes for dashboard
	Route::get ('/dashboard/delete', 'DashboardController@dashboardDelete');
	
	// route for open richfilemanager

	Route::get('/dashboard/rich-file-manager', 'DashboardController@richFileManager');
	Route::resource('/dashboard', 'DashboardController');
	Route::get('/dashboard/{any}', 'DashboardController@getStorageFiles')->where('any', '.*');
});


