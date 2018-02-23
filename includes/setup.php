<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Manila"); 

//(\ for windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('VERSION') ? null : define('VERSION', '1.0.0');
defined('SITE_ROOT') ? null : define ('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.'pcm');
defined('INCLUDES_PATH') ? null : define ('INCLUDES_PATH',SITE_ROOT.DS.'includes');
defined('PAGES_PATH') ? null : define ('PAGES_PATH',SITE_ROOT.DS.'pages');
defined('ASSETS_PATH') ? null : define ('ASSETS_PATH',SITE_ROOT.DS.'assets');
defined('ATTACHMENTS') ? null : define ('ATTACHMENTS',SITE_ROOT.DS.'attachments');
defined('TEMPLATE_PATH') ? null : define ('TEMPLATE_PATH',INCLUDES_PATH.DS.'templates');

defined('CSS_PATH') ? null : define ('CSS_PATH',ASSETS_PATH.DS.'css');
defined('FONTS_PATH') ? null : define ('FONTS_PATH',ASSETS_PATH.DS.'fonts');
defined('JS_PATH') ? null : define ('JS_PATH',ASSETS_PATH.DS.'js');


define( 'DB_HOST', 'localhost' );			#set database host
define( 'DB_USER', 'tpi' );				#set database user
define( 'DB_PASS', 'telcomtrix' );				#set database password
define( 'DB_NAME', 'pcm' );					#set database name
define( 'SEND_ERRORS_TO', 'marianzjr02@gmail.com' ); #set email notification email addressForgot password?

define( 'DISPLAY_DEBUG', true );			#display db errors?


//load basic functions
require_once(INCLUDES_PATH.DS."class.functions.php");
require_once(INCLUDES_PATH.DS."languages".DS."en.php");
$dirs = array(
	INCLUDES_PATH.DS."helpers".DS,
	INCLUDES_PATH.DS."modules".DS,
	INCLUDES_PATH.DS."libraries".DS
);

require_all($dirs);

//require_once("class.templates.php");
$db			= new db("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

$perf		= new Performance();
$config		= new Config($db);
$ord_hist	= new OrderHistory($db);
$units		= new Units($db,$config);
$delivery	= new Delivery($db,$config);
$mainten	= new Maintenance($db);
//$paginator = new Paginator($db);
$auth		= new Auth($db, $config, $lang);
$msg		= new Messages($lang);		
$email		= new Email($db, $config);
$detect		= new Mobile_Detect();

?>
