<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\UserGroup;
use App\Model\UserGroupHasDashboardCat;
use App\Model\DashboardCategory;
use App\Model\UserHasUsergroup;
use App\User;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if($this->user->role == 'admin'){
                return $next($request);
            }
            return redirect('/login');
            
        });
    }

    public function index()
    {
       $data['usergroup'] = UserGroup::with('userGroupHasDashCat')->get();
       $data['count'] = count($data['usergroup']);
       return view('admin.user_group.user_group',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['dashcat'] = DashboardCategory::select('id','name')->get();
        $data['users'] = User::where('role','user')->select('id','firstname','lastname')->get();
        return view('admin.user_group.user_group_add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
                'usergroupname' => 'required',
            ]);
        $insert=[
            'name' => $request->usergroupname,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $id = UserGroup::insertGetId($insert);
        if($id){
            if(is_array($request->dashcat)){
                foreach ($request->dashcat as $key => $value) {
                    UserGroupHasDashboardCat::create(['usergroup_id' => $id, 'dashboardcategory_id' => $value,'created_at' => date('Y-m-d H:i:s')]);
                }
            }
            if(is_array($request->users)){
                foreach ($request->users as $k => $v) {
                    UserHasUsergroup::create(['usergroup_id' => $id, 'user_id' => $v,'created_at' => date('Y-m-d H:i:s')]);
                }
            }
            return redirect('/user-groups')->with('success', 'User Group added successfully.');
        }
        return redirect()->back()->with('error', 'Oops! something went wrong.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $data['usergroup'] = UserGroup::where('id',$id)->with(['userGroupHasDashCat','userHasUsergroup'])->first();
        $data['dashcat'] = DashboardCategory::select('id','name')->get();
        $data['users'] = User::where('role','user')->select('id','firstname','lastname')->get();
        return view('admin.user_group.user_group_edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $this->validate($request,[
                'usergroupname' => 'required',
            ]);
        $update=[
            'name' => $request->usergroupname,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data = UserGroup::where('id',$id)->update($update);
        if($data){
            UserGroupHasDashboardCat::where('usergroup_id',$id)->delete();
            UserHasUsergroup::where('usergroup_id',$id)->delete();
            if(is_array($request->dashcat)){
                foreach ($request->dashcat as $key => $value) {
                    UserGroupHasDashboardCat::create(['usergroup_id' => $id, 'dashboardcategory_id' => $value,'created_at' => date('Y-m-d H:i:s')]);
                }
            }
            if(is_array($request->users)){
                foreach ($request->users as $k => $v) {
                    UserHasUsergroup::create(['usergroup_id' => $id, 'user_id' => $v,'created_at' => date('Y-m-d H:i:s')]);
                }
            }
            return redirect('/user-groups')->with('success', 'User Group updated successfully.');
        }
        return redirect()->back()->with('error', 'Oops! something went wrong.');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userGroupDelete(Request $request)
    {
        if($request->get('id')){
            $id = explode(",", $request->get('id'));
            UserGroup::destroy($id);
            UserHasUsergroup::whereIn('usergroup_id', $id)->delete();
            UserGroupHasDashboardCat::whereIn('usergroup_id', $id)->delete();
            return 1;
        }
    }
    /**
    *
    * Dashboard List for assign User Group to Dashboard on model
    * @param no parameter
    * @return \Illuminate\Http\Response
    */
    public function dashboardList(Request $request){
        $id = $request->get('id');
        if($id){
                $list = DashboardCategory::with(['userGroupHasDashCat' => function($query) use ($id){
                    $query->where('usergroup_id',$id);
                }])->select('id','name')->get();
            return $list;
        }
    }

    public function assignDashcat(Request $request){
        $id = $request->get('usergroup_id');
        UserGroupHasDashboardCat::where('usergroup_id', $id)->delete();
        foreach ($request->dashcat as $value) {
                UserGroupHasDashboardCat::create(['usergroup_id' => $id, 'dashboardcategory_id' => $value,'created_at' => date('Y-m-d H:i:s')]);
         }
        return redirect('/user-groups')->with('success', 'User group assign to dashboard categories successfully.');
    }

}
