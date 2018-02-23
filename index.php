<?php
define('MAIN_INCLUDED', 1);
require_once('includes/setup.php');
$DEBUG = true; //set to false in deployment
$current_date =date("Y-m-d");
$current_year =date("Y");
$page = decode_url((isset($_GET['p']) && $_GET['p'] != '') ? $_GET['p'] : '');	// Page No
$pn = decode_url((isset($_GET['pn']) && $_GET['pn'] != '') ? $_GET['pn'] : '');	// Page No
$dt = decode_url((isset($_GET['d']) && $_GET['d'] != '') ? $_GET['d'] : '');		// Selected Date
$rd = decode_url((isset($_GET['rd']) && $_GET['rd'] != '') ? $_GET['rd'] : '');		// Received Date
$id = decode_url((isset($_GET['i']) && $_GET['i'] != '') ? $_GET['i'] : '');		// Selected ID
$sn = decode_url((isset($_GET['sn']) && $_GET['sn'] != '') ? $_GET['sn'] : '');		// Selected ID
$l = decode_url((isset($_GET['l']) && $_GET['l'] != '') ? $_GET['l'] : '');		// Selected Side/Sub List
$b = decode_url((isset($_GET['b']) && $_GET['b'] != '') ? $_GET['b'] : '');		// Selected Brand
$r = decode_url((isset($_GET['r']) && $_GET['r'] != '') ? $_GET['r'] : '');		// Selected Requisitioner
$rn = decode_url((isset($_GET['rn']) && $_GET['rn'] != '') ? $_GET['rn'] : '');	// Selected Reference Number
$m = decode_url((isset($_GET['m']) && $_GET['m'] != '') ? $_GET['m'] : '');		// Selected MATCODE
$s = decode_url((isset($_GET['s']) && $_GET['s'] != '') ? $_GET['s'] : '');		// Entry/Maintenance State (View, Add, Edit and Delete)
$q	= ((isset($_GET['q']) && $_GET['q'] != '') ? decode_url($_GET['q']) : '');		// Search Keyword
$pss	= ((isset($_GET['pss']) && $_GET['pss'] != '') ? decode_url($_GET['pss']) : '');// Print Brand Summary STATUS (ALL, REPAIRED, UNDER REPAIR)

$dt	= decode_url(isset($_COOKIE['dd'])? $_COOKIE['dd']: $dt);
$pdt	= decode_url(isset($_COOKIE['pd'])? $_COOKIE['pd']: $dt);
$dt = empty($dt)? get_currentdate(): $dt;
$pdt = plain_date($dt);
$is_mobile = $detect->isMobile();
$is_tablet = $detect->isTablet();
$title= 'Home';
$content=PAGES_PATH.DS.'home.php';

	$global_username	= $auth->getUsername();
	$global_userid		= $auth->getUserid();
	$global_isAdmin		= $auth->isAdmin($global_userid);
	$global_fullname	= $auth->getFullname($global_username);
	$global_level		= $auth->getLevelName($global_userid);
	$global_level_lower	= strtolower($global_level);
	$isLogin			= $auth->isLogin();
	$global_isAdmin		= ($isLogin)? true: false;
	switch ($page){
		case '9' :
			$title="Register";	
			$content=PAGES_PATH.DS.'register.php';
			break;
		case '10' :
			$title="Home";	
			$content=PAGES_PATH.DS.'home.php';
			break;
		case '11' :		
				$title="Items";
				/*
				if($s==='g'){
					$content=PAGES_PATH.DS.'data_group.php';
				}else{
					$content=PAGES_PATH.DS.'data.php';
				}
				*/
				$title="Items";
				$content=PAGES_PATH.DS.'data.php';
			
			
			break;		
		case '12' :
			if($isLogin){
				if($s==='u'){
					$title="Update Entry";	
				}elseif($s==='d'){
					$title="Delete Entry";	
				}else{
					$title="New Entry";	
				}
				$content=PAGES_PATH.DS.'entry.php';	
			}else{
				$page='10';
			}			
			break;
		case '13' :	
			$title="Settings";
			if($s==='c'){
				$title ='Change Password';
			}else{
				$title ='Settings';
			}
			$content=PAGES_PATH.DS.'settings.php';		
			break;	
		case '14' :	
			$title="Profile";	
			$content=PAGES_PATH.DS.'profile.php';		
			break;	
		case '15' :
			$title="Maintenance";
			$content=PAGES_PATH.DS.'maintenance.php';
			break;	
		case '16' :
			$title="Item Logs";
			$content=PAGES_PATH.DS.'logs.php';
			break;	
		case '17' :
			$title="Attachments";
			$content=PAGES_PATH.DS.'attachments.php';
			break;
		case '18' :
			$title="Delivery Receipts";
			$content=PAGES_PATH.DS.'drs.php';
			break;	
		case '19' :
			$title="Delivery List";
			$content=PAGES_PATH.DS.'delivery.php';
			break;
        case '20' :
            $title="Add Serial Delivery";
            $content=PAGES_PATH.DS.'delivery_add_sn.php';
            break;
        case '21' :
            $title="Capture Photo";
            $content=PAGES_PATH.DS.'capture.php';
            break;
        case '22' :
            $title="Activities";
            $content=PAGES_PATH.DS.'activities.php';
            break;
        case '23' :
            $title="Summary";
            $content=PAGES_PATH.DS.'summary.php';
            break;
        case '24' :
            $title="Status Details";
            $content=PAGES_PATH.DS.'details_status.php';
            break;
		case '25' :
			$title="Recieved";
			$content=PAGES_PATH.DS.'received.php';
			break;
		case '26' :
			$title="References";
			$content=PAGES_PATH.DS.'references.php';
			break;
        case '100' :
			$title="Access Denied";
			$content=PAGES_PATH.DS.'error.php';
			break;	
		default :
			$page ='10';
			$title="Home";	
			$content =PAGES_PATH.DS.'home.php';				
			break;
	}	


	include TEMPLATE_PATH.DS.'html-header.php';
	include TEMPLATE_PATH.DS.'html-top_header.php';
	include TEMPLATE_PATH.DS.'html-side_bar.php';
	include TEMPLATE_PATH.DS.'html-side_profile.php';
	include TEMPLATE_PATH.DS.'html-side_search.php';
	include TEMPLATE_PATH.DS.'html-side_notif.php';
	include $content;
	include TEMPLATE_PATH.DS.'html-footer.php';
	exit;	

