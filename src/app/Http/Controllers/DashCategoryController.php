<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\DashboardCategory;
use App\Model\DashCatHasDashboard;
use App\Model\Dashboard;

class DashCategoryController extends Controller
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
        $data['dashboardCat'] = DashboardCategory::with('dashboard')->get();
        $data['count'] =count($data['dashboardCat']);
        return view('admin.dash_category.dash_category',$data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['dashboard'] = Dashboard::select('id','name')->get();
        return view('admin.dash_category.dash_category_add',$data);
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
            'dashcatname' => 'required',
            ]);
        $insert=[
            'name' => $request->dashcatname,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $id = DashboardCategory::insertGetId($insert);
        if($id){
            if(is_array($request->dashboard)){
                foreach ($request->dashboard as $key => $value) {
                    DashCatHasDashboard::create(['dashboardcategory_id' => $id, 'dashboard_id' => $value,'created_at' => date('Y-m-d H:i:s')]);
                }
            }
            return redirect('/dashboard-categories')->with('success', 'Dashboard category added successfully.');
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
        $data['dashboardCat'] = DashboardCategory::where('id',$id)->with('dashboard')->first();
        $data['dashboard'] = Dashboard::select('id','name')->get();
        return view('admin.dash_category.dash_category_edit',$data);
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
            'dashcatname' => 'required',
            ]);
        $update=[
            'name' => $request->dashcatname,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data = DashboardCategory::where('id',$id)->update($update);
        if($data){
            DashCatHasDashboard::where('dashboardcategory_id',$id)->delete();
            if(is_array($request->dashboard)){
                foreach ($request->dashboard as $key => $value) {
                    DashCatHasDashboard::create(['dashboardcategory_id' => $id, 'dashboard_id' => $value,'created_at' => date('Y-m-d H:i:s')]);
                }
            }
            return redirect('/dashboard-categories')->with('success', 'Dashboard category updated successfully.');
        }
        return redirect()->back()->with('error', 'Oops! something went wrong.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dashcatDelete(Request $request)
    {
        if($request->get('id')){
            $id = explode(",", $request->get('id'));
            DashboardCategory::destroy($id);
            DashCatHasDashboard::whereIn('dashboardcategory_id', $id)->delete();
            return 1;
        }
    }

    /**
    *
    * Dashboard List for assign Dashboard Category to Dashboard on model
    * @param no parameter
    * @return \Illuminate\Http\Response
    */
    public function dashboardList(Request $request){
        $id = $request->get('id');
        if($id){
                $list = Dashboard::with(['dashboard' => function($query) use ($id){
                    $query->where('dashboardcategory_id',$id);
                }])->select('id','name')->get();
            return $list;
        }
    }
    /**
    *
    * update  Dashboard Category to Dashboard on model
    * @param int  $id
    * @return \Illuminate\Http\Response
    */
    public function assignDashboard(Request $request){
        $id = $request->get('dashcat_id');
        DashCatHasDashboard::where('dashboardcategory_id', $id)->delete();
        foreach ($request->dashboard as $value) {
                DashCatHasDashboard::create(['dashboardcategory_id' => $id, 'dashboard_id' => $value,'created_at' => date('Y-m-d H:i:s')]);
         }
        return redirect('/dashboard-categories')->with('success', 'Dashboard Categories assign to dashboard successfully.');
    }
}
