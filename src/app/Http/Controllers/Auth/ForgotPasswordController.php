<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\User;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request){
    
        $users = User::select('id','email')->get();
        foreach ($users as $user) {
            if ($request->email === $user->email) {
                $response =   Password::sendResetLink(array('id'=>$user->id));
                switch ($response) {
                    case Password::RESET_LINK_SENT:
                        return redirect()->back()->with('status', trans($response));

                    case Password::INVALID_USER:
                        return redirect()->back()->withErrors(['email' => trans($response)]);
               }
                break; // Exit from the foreach loop
            }
        }
        return redirect()->back()->with('error','Sorry! No user find with this email id');
    }
}
