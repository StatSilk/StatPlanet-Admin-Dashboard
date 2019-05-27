<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Hash;
use Auth;
use DB;
use Helper;
use App\User;
use App\Model\UserHasUsergroup;
use App\Model\UserGroup;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
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
        /*$data = Helper::match_username('yamini');
        dd($data);*/
        $data['users'] = User::where('role','user')
                ->select('id','firstname','lastname','username','email')
                ->with('userHasUsergroup')
                ->get();
        $data['count'] = count($data['users']);
        return view('admin.user.user',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $data['usergroup'] = UserGroup::select('id','name')->get();
       return view('admin.user.user_add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Helper::match_username($request->username)){
            return redirect()->back()->with('error', 'This username is already exist.');  
        }
        if(Helper::match_username($request->email)){
            return redirect()->back()->with('error', 'This email is already exist.');  
        }
        $this->admin = Auth::user();
        $this->validate($request,[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|unique:users',
            ]);
        $insert=[
            'firstname' => Crypt::encryptString($request->firstname),
            'lastname' => Crypt::encryptString($request->lastname),
            'email' => Crypt::encryptString($request->email),
            'username' => Crypt::encryptString($request->username),
            'password' => Hash::make($request->input('password')),
            'userid' => $this->admin->id,
            'role' => 'user',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $id = User::insertGetId($insert);
        if($id){
            if(is_array($request->user_group)){
                foreach ($request->user_group as $key => $value) {
                    UserHasUsergroup::create(['user_id' => $id, 'usergroup_id' => $value,'created_at' => date('Y-m-d H:i:s')]);
                }
            }
            return redirect('/users')->with('success', 'User added successfully.');
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
        $data['users'] = User::where('id',$id)->with('userHasUsergroup')->first();
        $data['usergroup'] = UserGroup::select('id','name')->get();
        return view('admin.user.user_edit',$data);
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
        $this->admin = Auth::user();
        $this->validate($request,[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            ]);
        $update=[
            'firstname' => Crypt::encryptString($request->firstname),
            'lastname' => Crypt::encryptString($request->lastname),
            'email' => Crypt::encryptString($request->email),
            'username' => Crypt::encryptString($request->username),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if($request->password){
            $update['password'] = Hash::make($request->input('password'));
        }
        $data = User::where('id',$id)->update($update);
       if($data){
            UserHasUsergroup::where('user_id',$id)->delete();
            if(is_array($request->user_group)){

                foreach ($request->user_group as $key => $value) {
                    UserHasUsergroup::create(['user_id' => $id, 'usergroup_id' => $value,'created_at' => date('Y-m-d H:i:s')]);
                }
            }
            return redirect('/users')->with('success', 'User updated successfully.');
        }
        return redirect()->back()->with('error', 'Oops! something went wrong.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userDelete(Request $request)
    {
        if($request->get('id')){
            $id = explode(",", $request->get('id'));
            User::destroy($id);
            UserHasUsergroup::whereIn('user_id', $id)->delete();
            return 1;
        }
    }

    /**
    *
    * User Group List for assign user to User Group on model
    * @param no parameter
    * @return \Illuminate\Http\Response
    */
    public function userGroupList(Request $request){
        DB::enableQueryLog();
        if($request->get('id')){
            $id = explode(",", $request->get('id'));
            if(count($id) > 1 ){
                $list = UserGroup::select('id','name')->get(); 
            }else{
                $list = UserGroup::with(['UserHasUsergroup' => function($query) use ($id){
                    $query->where('user_id',$id);
                }])->select('id','name')->get();

            }
            return $list;
        }
    }

    public function assignUsergroup(Request $request){
        $id = explode(",", $request->get('user_id'));
        UserHasUsergroup::whereIn('user_id', $id)->delete();
        foreach ($request->user_group as $value) {
            foreach ($id as $v) {
                $updateUserGroup = UserHasUsergroup::insert(['usergroup_id' => $value,'user_id' => $v]);
            }
        }
        return redirect('/users')->with('success', 'User assign to user group successfully.');
    }
}
