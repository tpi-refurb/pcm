<?php	
	require('../setup.php');
	$action = ((isset($_GET['a']) && $_GET['a'] != '') ? $_GET['a'] : '');
	$username=	$firstname= $lastname= $email= $password= $confirmpassword="";

	$error = array();
	if($action ==='login'){
		$username		= $_POST["login_username"];
		$password		= $_POST['login_password'];
		$remember		= 0;
		
		if(empty($username)){
			$error["login_username"] ='Username is required';
		}
		if(empty($password)){
			$error["login_password"] ='Password is required';
		}
		
		if(count($error)>0){
			$error["error"]=true;
		}else{
			$error = $auth->loginUser($username,$password,$remember);		
			
			if($error["error"]==false){			
				$userid =$auth->getUID($username);
				$level =$auth->getLevel($username);
				$hashId = $auth->getSessionHash($userid);
				
				$stime		= date('Y-m-d h:i:s A');
				$etime		= date('Y-m-d').' 11:59:00 PM';		
				$seconds	= strtotime($etime) - strtotime($stime); //Set expired date to 12 AM of the day
				
				setcookie($config->cookie_name,$hashId,time()+($seconds), "/", $_SERVER["HTTP_HOST"],0);
				setcookie($config->cookie_userid,encode_url($userid),time()+($seconds), "/", $_SERVER["HTTP_HOST"],0);
				setcookie($config->cookie_username,encode_url($username),time()+($seconds), "/", $_SERVER["HTTP_HOST"],0);
				
				$login_data =array(
				'activity'=>'Login',
				'description'=>$username.' logged-in successfully',
				'date_created'=>date('Y-m-d'),
				'time_created'=>date('h:i:s A'),
				'user_id'=> $userid);
				$db->insert('pcm_activities',$login_data);
						
				unset($_POST);					
			}else{
				$error["error"]=true;
			}
		}
		echo json_encode($error);		
	}else{
		
		$username		= $_POST['ui_username'];	
		$email			= $_POST['ui_email'];
		$firstname		= $_POST['ui_firstname']; 
		$lastname		= $_POST['ui_lastname'];
		$password		= $_POST['ui_password'];
		$confirmpassword= $_POST['ui_confirmpassword'];
		
		if(empty($username)){
			$error["ui_username"] ='Username is required';
		}
		if(empty($email)){
			$error["ui_email"] ='Email is required';
		}
		if(empty($firstname)){
			$error["ui_firstname"] ='Firstname is required';
		}
		if(empty($lastname)){
			$error["ui_lastname"] ='Lastname is required';
		}
		if(empty($password)){
			$error["ui_password"] ='Password is required';
		}
		if(empty($confirmpassword)){
			$error["ui_confirmpassword"] ='Re-type password is required';
		}
		
		if(count($error)>0){
			$error["error"]=true;
			echo json_encode($error);
		}else{
			$error =$auth->registerNewUser($email, $password, $confirmpassword,$username,$firstname, $lastname);
			if($error["error"]==false){				
				unset($_POST);				
			}
			echo json_encode($error);
		}
		
	}
	
?>