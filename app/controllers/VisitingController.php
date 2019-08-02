<?php

class VisitingController extends BaseController
{
	public function visits()
	{
		$link=Input::get('link');
		DB::table('metadatas')->where('link',$link)->increment('counter');
		return Redirect::to($link); 
	}
}