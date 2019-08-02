<?php

class AdminController extends BaseController
{
	public function show()
	{
		$i=0;
		$array_today=[];
		$array_month=[];
		$array_week=[];

		$sql=DB::table('metadatas')->orderBy('counter','desc')->take(5)->get();
		$sql_trending=DB::table('metadatas')->select('created_at')->get();

		date_default_timezone_set('Asia/Kolkata');
		$day=date('l w'); //l shows the day and w shows the numeric representation of day from 0 through 6
		$date=date('d-m-Y');

		$date_month=strtotime($date)-(30*24*60*60)-1;
		$date_final_month=date('d-m-Y',$date_month);

		$date_week=strtotime($date)-(7*24*60*60);
		$date_final_week=date('d-m-Y',$date_week);

		foreach ($sql_trending as $trending) 
		{
			$abcd=strtotime($trending->created_at);
			$final=date('d-m-Y',$abcd);
			
			if($date==$final)
				{
					$array_today[$i]=$trending->created_at;
					$i++;
				}
		}
		
		foreach ($sql_trending as $trending) 
		{
			$abcd=strtotime($trending->created_at);
			$final=date('d-m-Y',$abcd);

			if(strtotime($final)>=strtotime($date_final_month))
				{
					$array_month[$i]=$trending->created_at;
					$i++;
				}
		}

		foreach ($sql_trending as $trending) 
		{
			$abcd=strtotime($trending->created_at);
			$final=date('d-m-Y',$abcd);

			if(strtotime($final)>=strtotime($date_final_week))
				{
					$array_week[$i]=$trending->created_at;
					$i++;
				}
		}

		// $trending_today=DB::table('metadatas')->whereIn('created_at',$array_today)->distinct()->orderBy('counter','desc')->take(1)->get();
		// $trending_month=DB::table('metadatas')->whereIn('created_at',$array_month)->distinct()->orderBy('counter','desc')->take(1)->get();
		// $trending_week=DB::table('metadatas')->whereIn('created_at',$array_week)->distinct()->orderBy('counter','desc')->take(1)->get();
		return View::make('Adminpanel')
		->with('result',$sql);
		// ->with('trending_today',$trending_today)
		// ->with('trending_month',$trending_month)
		// ->with('trending_week',$trending_week);
		
	}
	public function homepanel()
	{
		$result=DB::table('metadatas')->orderBy('counter','desc')->take(12)->get();//getting first 12 results
		$newresult=DB::table('metadatas')->orderBy('counter','desc')->groupBy('category')->take(5)->get(); //getting first 5 results grouped by category
		foreach($newresult as $newres)
		{
			$photo_taker=DB::table('metadatas')->select('photo')->where('category',$newres->category)->orderByRaw('RAND()')->take(1)->get();//this query selects photo of different categories and orders it randomly and then selects 1 result	
		
		}
		// var_dump($newresult);
		
		return View::make('Adminpanel')->with('result',$result)->with('newresult',$newresult)->with('photo_taker',$photo_taker);
	}
}