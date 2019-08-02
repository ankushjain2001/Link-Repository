<?php

class StorageController extends BaseController
{
	// public function enter_user_metadata()
	// {
	// 	$link=Input::get('link_add');
	// 	$heading=Input::get('heading_add');
	// 	$description=Input::get('description_add');
	// 	$category=Input::get('category_add');
	// 	DB::table('metadatas')->insert(array('link' => $link,'heading' => $heading , 'description' => $description, 'category' => $category));
	// }
	public function enter_user_metadata()
	{
	include('C:/wamp/www/latestlinkrepos/public/includes/simple_html_dom_new.php');

	$link=Input::get('link'); 
	$category=Input::get('category');
	

	$meta=get_meta_tags($link);
	$newmeta=$meta['description'];

	$html = new simple_html_dom();

$html->load_file($link);

$title = $html->find('title',0)->innertext;

$img="";
$tags = get_meta_tags($link);
if(@$tags['twitter:image']){
		// echo $tags['twitter:image']."</br>";
  //     echo '<img src="' .$tags['twitter:image'] . '" width="400px" height="400px" alt="error">'. "<br>";
       $img=$tags['twitter:image'];
       
       // HelpersDOM2::doMessage($html,$link,$category,$packer);
}

foreach($html->find('img') as $element) 

{
       $str=$element->src;

	   // if($str&&!((substr( $str, strlen( $str ) - strlen( "png" ) ) == "png")||(substr( $str, strlen( $str ) - strlen( "gif" ) ) == "gif")))
	   // {
	   // 	// $height=0;
	   // 	if(substr( $str, 0, 4 ) === "http")
    //     $str=$str;
    //     else
    //     $str="http:".$str;
	   // 	if(@getimagesize($str))
	   // 	{
	   		// list($width, $height) = getimagesize($str);
       // echo '<img src="' .$str . '" width="$element->width" height="$element->height" alt="error">'. "<br>";
       // echo $element->height." ";
       // echo $element->width;
       // $ext = pathinfo($str, PATHINFO_EXTENSION);
       // echo $ext;
		$email=Session::get('email');
	   		if ($img) {

	   			Details::doMessage($html,$link,$category,$img,$email,$newmeta,$title);
	   			return Redirect::to('login_without_any')->with('message','Link Inserted Successfully');
	   			break;
	       	}
	   		
	   		
	   		else
	   		{
	   			Details::doMessage($html,$link,$category,$str,$email,$newmeta,$title);
	   			return Redirect::to('login_without_any')->with('message','Link Inserted Successfully');
	       		break;
	   		}

	       	
     	 // 	}
	   		
     	 // }
	 }

// }
	// $array=[];//array declared
	// $array1=[];//array declared
	// $array2=[];//array declared
	// $array3=[];//array declared
	// $array_final=[];

	// $html=file_get_html($link);

	// $i=0;
	// $j=0;
	// $k=0;
	// $l=0;
	// $m=0;
	// foreach($html->find('img') as $e)
	// {
 //    $array[$i++]=$e->width;

 //    $array1[$j++]=$e->height;

	// $array2[$k++]=$e->src;

	// }
	
	// for($l=0;$l<count($array2);$l++)
	// {
	// 	$array3[$l]=$array[$l]+$array1[$l];
	// }
	// $abcd=array_keys($array3,max($array3));//returns index where values are maximum

	// foreach($abcd as $a)
	// {
	// 		$array_final[$m++]=$a;
	// }
	// // print_r($array_final);

	// if(substr($link.$array2[$array_final[0]],0,5)=='http:' || substr($link.$array2[$array_final[0]],0,5)=='https')
	// {
	// 	$photo=$array2[$array_final[0]];
	// }
	// else
	// {
	// 	$photo=$link.$array2[$array_final[0]];
	// }

	}
	public function ajax_req()
	{
		$term=Input::get('searchit');
		if($term=="")
		echo "";
		else
		{
		$array=str_split($term);
		$sql=DB::table('metadatas')->select('category')->where('category','LIKE','%'.$array[0].$array[1].'%')->distinct()->get();
		
		echo '<div id="ajax_category_main">';

		foreach($sql as $sql_result)
		{
			echo '<div id="ajax_category" onclick="filler(\''.$sql_result->category.'\')">';
			echo $sql_result->category;
			echo '</div>';
		}
		echo '</div>';
	}
	}
	public function search_query()
	{
		$search_query=Input::get('search_query');
		$result=DB::table('metadatas')->where('category',$search_query)->distinct()->get();
		foreach ($result as $res)
		{
			echo $res->link;
		}
	}
}