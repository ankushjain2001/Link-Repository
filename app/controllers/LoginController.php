<?php

class LoginController extends BaseController
{

	public function enter_credentials()
	{
		$validator=Validator::make(
	array('name' => Input::get('name'),'email' => Input::get('email'),'username' => Input::get('username'),'password' => Input::get('password')),
	array('name'=>'required','email'=>'required|email|unique:users,email','username'=>'required|min:8','password' => 'required|min:8')
		);

		if($validator->fails())
		{
			return Redirect::to('home')->withErrors($validator);
		}
		else
		{
			$user = new User;
	        $user->name = Input::get('name');
	        $user->email = Input::get('email');
	        $user->username = Input::get('username');
	        $user->password=Hash::make(Input::get('password'));
	        if(Input::get('password') == Input::get('cpassword'))
	        {
	        	$user->save();
	        }
	        return Redirect::to('home')->with('message','User successfully registered');
	     }
	}
	public function redirect_to_home()
	{
			$my=User::where('username',Session::get('username'))->get();

			foreach($my as $m)
			{
			Session::put('name',$m->name);
			Session::put('email',$m->email);

			$links=DB::table('userlinks')->where('email',$m->email)->join('metadatas','metadatas.link','=','userlinks.link')->get();
			$favourites=DB::table('userlinks')->where('email',$m->email)->where('favourite',1)->join('metadatas','metadatas.link','=','userlinks.link')->get();

			$view=View::make('Linkrepository')->with('links',$links)->with('favourites',$favourites);
			return $view;
			}
	}
	public function redirect_to_home_fborgoogle()
	{
			$links=DB::table('userlinks')->where('email',Session::get('email'))->join('metadatas','metadatas.link','=','userlinks.link')->get();
			$favourites=DB::table('userlinks')->where('email',Session::get('email'))->where('favourite',1)->join('metadatas','metadatas.link','=','userlinks.link')->get();

			$view=View::make('Linkrepository_for_fborgoogle')->with('links',$links)->with('favourites',$favourites);
			return $view;
	}

}