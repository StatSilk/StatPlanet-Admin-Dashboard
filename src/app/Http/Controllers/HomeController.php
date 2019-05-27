<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use app\User;
use Auth;
use Hash, Session;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role !== 'user'){
            return view('admin.home');
        }
            return view('admin.user_dashbaord');

    }

    public function changePassword()
    {
        return view('admin.change_password');
    }
    
    public function postPassword(Request $request){

        $this->admin = Auth::user();
        $this->id   = $this->admin->id;

        $this->validate($request, [
        'old_password'   => 'required',
        'new_password'   => 'required',
        ]);

        if (Hash::check($request->input('old_password'), $this->admin->password)) {
            $this->admin->password = Hash::make($request->input('new_password'));

            $this->admin->save();

            return redirect()->back()->with('success', 'Your password has been updated.');
        } else {
            return redirect()->back()->with('error', 'The old password you provided could not be verified');
        }        
    }

    public function editProfile(){
        $user['user'] = Auth::user();
        return view('admin.edit_profile', $user);
    }

    public function postProfile(Request $request){
        $this->validate($request, [
            'firstname'   => 'required',
            'lastname'    => 'required',
            'email'       => 'required',
            ]);
        
        $this->admin = Auth::user();
        $this->id   = $this->admin->id;

        $this->admin->firstname = $request->firstname;
        $this->admin->lastname = $request->lastname;
        $this->admin->email = $request->email;
        
        $this->admin->update();
        return redirect()->back()->with('success', 'Your profile has been updated.');
    }
  
}
