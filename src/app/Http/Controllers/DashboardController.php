<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use App\Model\DashboardCategory;
use App\Model\Dashboard;
use App\Model\DashCatHasDashboard;
use Auth;
use Storage;
use finfo;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Auth::user()->id);
        if(Auth::user()->role !== 'user'){
            $data['dashboards'] = Dashboard::with('dashcat_detail')->get();
            return view('admin.home',$data);
        } else {
            $id = Auth::user()->id;
            $data['dashboards'] = DB::select("SELECT `dashboards`.`id`,`dashboards`.`name`,`dashboards`.`folder_name`,`dashboards`.`dashboardcategory_id`,`dashboards`.`description`,`dashboards`.`dashboard_link` FROM `dashboards` LEFT JOIN `dashboard_categories` ON `dashboards`.`dashboardcategory_id` = `dashboard_categories`.`id` LEFT JOIN `user_group_has_dashboard_category` ON `dashboard_categories`.`id` = `user_group_has_dashboard_category`.`dashboardcategory_id` LEFT JOIN `user_has_usergroups` ON `user_group_has_dashboard_category`.`usergroup_id` = `user_has_usergroups`.`usergroup_id` LEFT JOIN `users` ON `user_has_usergroups`.`user_id` = `users`.`id` WHERE `users`.`id` = '".$id."' GROUP BY `dashboards`.`id`");
            foreach ($data['dashboards'] as $key => $value) {
                $dashcat_detail[$key] = DashboardCategory::where('id',$value->dashboardcategory_id)->select('id','name')->first();
                $data['dashboards'][$key]->dashcat_detail = $dashcat_detail[$key];
            }
            return view('admin.user_dashboard',$data);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data['dashcat'] = DashboardCategory::get();
        $dir = storage_path().'/app/';
        $allFiles = scandir($dir ); // Or any other directory
        $data['files'] = array_diff($allFiles, array('.', '..', '.gitignore', '_thumbs', 'modules.json'));
        //dd($data['files']);
        return view('admin.dashboard.dashboard_add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request,[
            'name' => 'required',
        ]);
        $foldername = $request->foldername;
        $insert = [
            'name' => $request->name,
            'dashboardcategory_id' => $request->dashcat,
            'folder_name' => $foldername,
            'dashboard_link' => $request->dashboard_link,
            'description' => $request->description,
        ];
        $data = Dashboard::create($insert);
        if($data){
            return redirect()->back()->with('success', 'Dashboard added successfully.');

        }
        return redirect()->back()->with('error', 'Oops! something went wrong.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $folder = Dashboard::where('id',$id)->select('*')->first();
        if(!$folder){
            return redirect('/dashboard')->with('error','Dashboard not found.');
        }
        $where = Auth::user()->role == 'user' ? " where `users`.`id` = '".Auth::user()->id."'" : '';
        $data = DB::select("select dashboards.id,dashboards.folder_name,dashboards.name,dashboards.description,dashboards.dashboard_link from (`dashboards` left join `dashboard_categories` on `dashboards`.`dashboardcategory_id` = `dashboard_categories`.`id`) left join `user_group_has_dashboard_category` on `dashboard_categories`.`id` = `user_group_has_dashboard_category`.`dashboardcategory_id` left join `user_has_usergroups` on `user_group_has_dashboard_category`.`usergroup_id` = `user_has_usergroups`.`usergroup_id` left join `users` on `user_has_usergroups`.`user_id` = `users`.`id` ".$where);
        $idArr = [];
        
        foreach ($data as $value) {
            $idArr[] = $value->id;
        }
        if(!in_array($id, $idArr)){
            return redirect('/dashboard')->with('error','You are not authorised to see this dashboard.');
        }
        $file =[];

        $path = '';
        $storagePath = storage_path().'/app/'.$folder->folder_name.'/';
        $request->session()->put('folderName',null);
        $data = array('details'=>$folder);
        $data['details']->content="Cannot find file 'index.html', 'StatPlanet_Cloud_licensed_web_only.html' or 'StatPlanet_Cloud.html' – please upload the .html file to load the dashboard.";
        if (file_exists($storagePath.'index.html')) {
            $path=$folder->folder_name.'/index.html';
        } else if(file_exists($storagePath.'StatPlanet_Cloud_licensed_web_only.html')){
            $path=$folder->folder_name.'/StatPlanet_Cloud_licensed_web_only.html';
        } else if(file_exists($storagePath.'StatPlanet_Cloud.html')){
            $path=$folder->folder_name.'/StatPlanet_Cloud.html';
        }

        if($path){
            $request->session()->put('folderName',$folder->folder_name);
            $data['details']->content=Storage::get($path);
        }
        
        return view('admin.dashboard.dashboard',$data);
    }

    public function getStorageFiles($param=''){
        $folder = session('folderName');
        if($folder && $param){
            //$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
            $filename = $folder.'/'.$param;
            $extension = pathinfo(storage_path().'/app/'.$folder.'/'.$param)['extension'];

            if(strtolower($extension)=='css'){
                header("Content-Type: text/css");
            } else {
                header("Content-Type: ".(new finfo(FILEINFO_MIME))->buffer($folder.'/'.$param)."; charset=UTF-8");
            }

            echo Storage::get($folder.'/'.$param);
            die;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['dashboard'] = Dashboard::where('id',$id)->with('dashcat_detail')->first();
        $data['dashcat'] = DashboardCategory::get();
        $dir = storage_path().'/app/';
        $allFiles = scandir($dir ); // Or any other directory
        $data['files'] = array_diff($allFiles, array('.', '..', '.gitignore', '_thumbs', 'modules.json'));
        return view('admin.dashboard.dashboard_edit',$data);
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
            'name' => 'required',
        ]);
        $dashboard = Dashboard::find($id);
        $insert = [
            'name' => $request->name,
            'dashboardcategory_id' => $request->dashcat,
            'folder_name' => $request->foldername,
            'dashboard_link' => $request->dashboard_link,
            'description' => $request->description,
        ];
        if($request->file('file')){
            $files = $request->file('file');

            foreach ($files as $file) {
                // uploaded files in created folder
                Storage::putFileAs($dashboard->folder_name, $file, $file->getClientOriginalName());
            }
        }
        $data = Dashboard::where('id',$id)->update($insert);
        if($data){
            return redirect()->back()->with('success', 'Dashboard updated successfully.');
        }
        return redirect()->back()->with('error', 'Oops! something went wrong.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dashboardDelete(Request $request)
    {
        if($request->get('id')){
            $id = explode(",", $request->get('id'));
            foreach ($id as $value) {
                $data = Dashboard::find($value);
                if($data){
                    Storage::deleteDirectory($data->folder_name);
                }
            }
            Dashboard::destroy($id);
            DashCatHasDashboard::whereIn('dashboard_id', $id)->delete();
            return 1;
        }
    }

    public function richFileManager(){
        return view('admin.richFileManager.index');
    }

}
