<?php

class FacebookController extends BaseController
{
	public function enter_credentials()
	{
	$facebook = new Facebook(Config::get('facebook'));
    $params = array(
        'redirect_uri' => url('/login/fb/callback'),
        'scope' => 'email',
    );
    return Redirect::to($facebook->getLoginUrl($params));
	}

	public function check_and_insert_credentials()
	{
		$code = Input::get('code');
	    if (strlen($code) == 0) return Redirect::to('/')->with('message', 'There was an error communicating with Facebook');

	    $facebook = new Facebook(Config::get('facebook'));
	    $uid = $facebook->getUser();

	    if ($uid == 0) return Redirect::to('/')->with('message', 'There was an error');

	    $me = $facebook->api('/me');

	    $facebookprofile = Facebookprofile::whereUid($uid)->first();
	    if (empty($facebookprofile)) {

	        $facebookuser = new Facebookuser;
	        $facebookuser->name = $me['first_name'].' '.$me['last_name'];
	        $facebookuser->email = $me['email'];
	        $facebookuser->photo = 'https://graph.facebook.com/'.$uid.'/picture?type=large';

	        $facebookuser->save();

	        $facebookprofile = new Facebookprofile();
	        $facebookprofile->uid = $uid;
	        $facebookprofile->access_token = $facebook->getAccessToken();
	        $facebookprofile->save();

	        
	        // $facebookprofile = $facebookuser->facebookprofiles()->save($facebookprofile);
    }
    	 $facebookuser = new Facebookuser;
	     $facebookuser->name = $me['first_name'].' '.$me['last_name'];
	     Session::put('name',$facebookuser->name);
    	 return Redirect::to('login_with_fborgoogle');

    		
    
    // $facebookprofile->save();

    // $facebookuser = $facebookprofile->facebookuser;

  //   	$metadata=DB::table('metadatas')->get();
		// $view=View::make('Linkrepositorynew')->with('metadata',$metadata)->with('name',$my);
		// return $view;
	}
}