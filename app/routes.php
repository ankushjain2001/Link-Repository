<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('home','AdminController@homepanel');

// Route::get('login','AdminController@show');

Route::post('check', function () {
	if (Auth::check()) {
		return true;
	}
});

Route::post('home', function(){
		if(Auth::attempt(Input::only('username', 'password'))) 
		{
		Session::put('username',Input::get('username'));
		return Redirect::to('login_without_any');
		}
		else 
		{
		return Redirect::back()->withInput()->with('message', "Invalid credentials");
}
});

	Route::get('logout', function(){
				Auth::logout();
		// return Redirect::to('https://mail.google.com/mail/u/0/?logout&hl=en');
		return Redirect::to('home')->with('message', 'You are now logged out');
			});

Route::get('login/gplus','GoogleplusController@enter_credentials');

Route::get('login/fb','FacebookController@enter_credentials');

Route::get('login/fb/callback','FacebookController@check_and_insert_credentials');

Route::get('register_without_any','LoginController@enter_credentials');

Route::get('login_without_any','LoginController@redirect_to_home');

Route::get('login_with_fborgoogle','LoginController@redirect_to_home_fborgoogle');

Route::get('insert_user_links','StorageController@enter_user_metadata');

Route::get('tovisit','VisitingController@visits');

Route::get('share','SharingController@share');

Route::get('favourites','SharingController@favourites');

Route::get('check_username',function(){ //check existence of username

	$username=Input::get('username');
	$username_exists=DB::table('users')->where('username',$username)->count();

	if(empty($username))
	{
		echo "";
	}
	else if(strlen($username)<8 && !empty($username))
	{
		echo '<p style="color:red;font-weight:bold;">Minimum 8 characters are required</p>';
	}
	else if($username_exists and strlen($username)>=8)
	{
		echo '<p style="color:red;font-weight:bold;">Not available</p>';
	}
	else
	{
		echo '<p style="color:green;font-weight:bold">Available</p>';
	}
});

Route::get('ownerpanel_show_shared',function()
	{
		$links=DB::table('userlinks')->where('shared',1)->get();
		return View::make('Ownerpanel')->with('links',$links);
	});


Route::get('allow','SharingController@allow_link');

Route::get('deny','SharingController@deny_link');

Route::get('forgot_password',function()
	{
		return View::make('Password_recovery_scheme');
	});

Route::get('change_password',function()
{
	$username=Input::get('username');
	$password=Hash::make(Input::get('password'));
	DB::table('users')->where('username',$username)->update(array('password'=>$password));
	return Redirect::to('home')->with('message','Your password has been changed successfully');
});
