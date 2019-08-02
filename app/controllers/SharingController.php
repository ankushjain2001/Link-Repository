<?php

class SharingController extends BaseController
{
	public function share()
	{
		$link=Input::get('link');
		$email=Session::get('email');

		DB::table('userlinks')->where('email',$email)->where('link',$link)->update(array('shared' => '1'));
		
		return Redirect::back()->with('message','Link will be shared on your timeline after review');

	}
	public function favourites()
	{
		$link=Input::get('link');
		$email=Session::get('email');
		DB::table('userlinks')->where('email',$email)->where('link',$link)->update(array('favourite' => '1'));
		return Redirect::back()->with('message','Link has been added to your favourites successfully');
	}

	public function allow_link()
	{
		$link=Input::get('link');
		$email=Session::get('email');
		DB::table('userlinks')->where('email',$email)->where('link',$link)->update(array('allow'=>1));
		return Redirect::back();
	}
	public function deny_link()
	{
		$link=Input::get('link');
		$email=Session::get('email');
		DB::table('userlinks')->where('email',$email)->where('link',$link)->update(array('allow'=>0));
		return Redirect::back();
	}
}

?>