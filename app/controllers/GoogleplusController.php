<?php

class GoogleplusController extends BaseController
{

	public function enter_credentials()
	{
require_once 'C:\wamp\www\latestlinkrepos\public\includes\GoogleClientApi\src\Google\Client.php';
require_once 'C:\wamp\www\latestlinkrepos\public\includes\GoogleClientApi\src\Google\Service\Analytics.php';


$client = new Google_Client();
$client->setAccessType('online'); // default: offline
$client->setApplicationName('Link Repository');
$client->setClientId('954747709280-mvpg9jtim8i9mcg4q9k8vjuh37me58ei.apps.googleusercontent.com');
$client->setClientSecret('XD9sznoWu_LokQswMeMe8rPy');
// $client->setRedirectUri('http://localhost:7000');
$client->setDeveloperKey('AIzaSyCauF_BRsb5ClcuHjXTY4fac9m1kHxEmfQ'); // API key
$client->setScopes(array('https://www.googleapis.com/auth/plus.me','https://www.googleapis.com/auth/userinfo.email'));//setting the scopes to make it functional

// $service implements the client interface, has to be set before auth call
// $service = new Google_Service_Analytics($client);

if (isset($_GET['logout'])) { // logout: destroy token
    unset($_SESSION['token']);
	die('Logged out.');
}

if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    // header('Location: ' . filter_var('http://localhost:7000', FILTER_SANITIZE_URL));
    // return;
}

if (isset($_SESSION['token'])) { // extract token from session and configure client
    $token = $_SESSION['token'];
    $client->setAccessToken($token);
}

if($client->getAccessToken())
{
    $json_return=$client->getAccessToken();
    $json_array=str_split($json_return);
    $new_array=[];
    for($i=17;$i<100;$i++)
    {
        if($json_array[$i]!='"')
        {
            $new_array[$i]=$json_array[$i];
        }
        else
        {
            break;
        }
    }

    $q = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='.implode($new_array);
    $json = file_get_contents($q);
    $user = json_decode($json,true);
    
    $user_id=filter_var($user['id'], FILTER_SANITIZE_SPECIAL_CHARS);
    $user_name = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email= filter_var($user['email'], FILTER_SANITIZE_EMAIL); 
    $profile_url=filter_var($user['link'], FILTER_SANITIZE_SPECIAL_CHARS);
    $profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);

    $google_user_id=DB::table('googleusers')->where('google_id',$user_id)->count();

    if(!$google_user_id)
    {
    DB::table('googleusers')->insert(array('google_id'=> $user_id,'name'=> ucwords(strtolower($user_name)),'google_email'=>$email,'google_link'=> $profile_url,'google_picture_link'=> $profile_image_url));
    }
     
     Session::put('name',$user_name);
     Session::put('email',$email);
     return Redirect::to('login_with_fborgoogle');
    
}
if (!$client->getAccessToken()) { // auth call to google
    $authUrl = $client->createAuthUrl();
    header("Location: ".$authUrl);
    die;
}


}

}

?>