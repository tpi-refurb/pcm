<?php


	
include('includes/setup.php');


$result = $auth->logout($_COOKIE[$config->cookie_name]);
$userid = $auth->getUserid();
$auth->setOffline($userid);

clearCookies();
removeCookies();

$logout_data =array(
	'activity'=>'Logout',
	'description'=>' logout successfully',
	'date_created'=>date('Y-m-d'),
	'time_created'=>date('h:i:s A'),
	'user_id'=> $userid);
$db->insert('pcm_activities',$logout_data);

// Destroy the session variables
session_destroy();

redirect_to('index.php');