<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Classes\Unifiapi;

use Socialize;

use Input;

use Hash;

use Auth;

use Exception;

class SocialLoginController extends Controller
{
	
   public function __construct()
	{
		
	}
 
	public function index()
	{
		return view('home');
	}
 
	public function facebookAuthRedirect() {
 	 	return Socialize::with('facebook')->fields(['first_name', 'last_name', 'email', 'gender', 'birthday'])->scopes(['email', 'user_birthday'])->redirect();
 	}
 
 	public function facebookSuccess() {
 			

 			app('App\Http\Controllers\Unifiapi')->init(session('mac'),session('ap'));
 			
 			
 	  		//$provider = Socialize::with('facebook');
 	  		$user = Socialize::with('facebook')->fields(['name', 'email', 'gender', 'verified', 'first_name', 'last_name', 'picture'])->user();
 	  		//$user = Socialite::driver('facebook')->user();
	    	//$user = $provider->stateless()->user();
	    	//dd($user);
	    	//$email = $user->email;
	    	//$name  = $user->name;
	    	$email = $user->email;
	    	$name = $user->name;
	    	//$gender = $user['gender'];
	    	$verified = $user->token;
	    	//$first_name = $user->nickname;
	    	$last_name = $user->avatar;
	    	$picture = $user->avatar_original;
	    	$mac = session('mac');
	    	//$password = substr($user->token,0,10);
	    	$facebook_id = $user->id;
 
	    	if($email == null){ // case permission is not email public.
	    		$user = $this->checkExistUserByFacebookId($facebook_id); 
	    		if($user == null){
	    			$email = $facebook_id;
	    		}
	    	}
	    	else
	    	{
	    		$user = $this->checkExistUserByEmail($email); 
	    		if($user != null){
		    		if($user->id_face == ""){ // update account when not have facebook id.
		    			$user->id_face = $facebook_id;
		    			$user->save();
		    		}
	    		}
	    	}
 
		    if($user != null){ // Auth exist account.
		    	Auth::login($user);
		    	return redirect('http://epointnet.com');
		    }
		    else{ // new Account.
		    	$user = $this->registerUser($email,$name,$facebook_id,$verified,$last_name,$picture,$mac);
		    	Auth::login($user);
		    	return redirect('http://epointnet.com');
		    }
		
		return redirect('/');
 	}
 
 	private function checkExistUserByEmail($email){
 		$user = \App\Metropolitan::where('email','=',$email)->first();
 		return $user;
 	}
 
 	private function checkExistUserByFacebookId($facebook_id){
 		$user = \App\Metropolitan::where('facebook_id','=',$facebook_id)->first();
 		return $user;
 	}
 
 	private function registerUser($email,$name,$facebook_id,$verified,$last_name,$picture,$mac){
 		$user = new \App\Metropolitan;
 
		$user->email = $email;
		$user->name = $name;
		//$user->gender = $gender;
		$user->verified = $verified;
		//$user->first_name = $first_name;
		$user->last_name = $last_name;
		$user->picture = $picture;
		$user->mac = $mac;
		//$user->password = Hash::make($password); // Hash::make
		$user->id_face = $facebook_id;
		$user->save();
 
		return $user;
 	}
 
}
