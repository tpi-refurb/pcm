<?php

include('includes/setup.php');
$type = isset($_GET['t']) ? decode_url($_GET['t']) : '';	// type
if($type==='n'){
    $notif_count = $units->getNotifCount();
    echo json_encode(array('count'=>$notif_count));
}else {
    $uid = isset($_COOKIE[$config->cookie_userid]);
    $uname = isset($_COOKIE[$config->cookie_username]);
    $login = $auth->isLogin();
    $isLogin = false;
    if ($uid and $uname and $login) {
        $isLogin = true;
    } else {
        if ($login) {
            clearCookies();
            removeCookies();
        }
    }
    echo json_encode(array('isLogin'=>$isLogin));
}
