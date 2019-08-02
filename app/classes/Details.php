<?php

class Details
{

public static function doMessage($html,$link,$category,$str,$email,$newmeta,$title)
{


// $array=str_split($html);
//        $var=0;
// if(preg_match("/<img([^>]*)?src=[\"\']([^\"\']*\.jpe?g)([^>]*)[\"\']/Ui", $html, $matches))
// {
  
//     $image=$matches[0];

//     $newarray=str_split($image);

//     $newimage='src="';

//     $hello="";

//     $newposs=strpos($image, $newimage);

//   for($var=$newposs+5;$var<strlen($image);$var++)
// 		{
// 			if($newarray[$var]!='"')
// 			{
// 				$hello=$hello.$newarray[$var];
// 			}
		
// 		}s
//     }
// else
//     {
    
//     echo 'No match found';
//     }

Metadata::create(array(
	'link' => $link,
	'heading' => $title,
	'category' => $category,
	'photo' => $str,
	'description' => $newmeta
	));

DB::table('userlinks')->insert(array('link' => $link,'email' => $email,'shared' => '0','favourite' => '0'));
}
}
?>