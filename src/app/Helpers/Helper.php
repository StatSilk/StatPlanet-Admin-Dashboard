<?php
//app/Helpers/Envato/User.php
namespace App\Helpers;
 
use App\User;
use Illuminate\Support\Facades\Crypt;
 
class Helper {
    /**
     * @param int $user_id User-id
     * 
     * @return string
     */
    public static function match_username($user_name) {
        $user = User::where('role','user')->select('id','username','email')->get();
        foreach ($user as $key => $value) {
        	if($value->username === $user_name || $value->email === $user_name){
        		return true;
        		break;
        	}
        }
    }
}