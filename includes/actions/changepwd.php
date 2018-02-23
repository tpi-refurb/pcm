<?php

	//header("Content-Type: text/json");
	
	require('../setup.php');
	
	
	$error	=array();	
	
	$cp	=(htmlspecialchars($_POST["ui_currentpassword"]));	
	if(empty($cp)){
		$error["error"]=true;
		$error['ui_currentpassword']='Please enter valid current password.';
	}else{
		$uname = $auth->getUsername();
		$error = $auth->isAuthenticatedUser($uname,$cp);
		$userid = $auth->getUserid();
		$user = $auth->getUser($userid);
		$hashed_password =$user['password'];
		if (password_verify($cp, $hashed_password)) {
			$np	=(htmlspecialchars($_POST["ui_password"]));
			$rp	=(htmlspecialchars($_POST["ui_confirmpassword"]));
			
			if(empty($np)){
				$error["error"]=true;
				$error['ui_password'] ='Enter new password';
			}
			if(empty($rp)){
				$error["error"]=true;
				$error['ui_confirmpassword'] ='Re-type password';
			}else{
				if($rp !==$np){
					$error["error"]=true;
					$error['ui_confirmpassword'] ='Password not match.';
				}
			}
			
			if($error["error"]===false){			
				$error = $auth->changePassword($userid, $cp, $np, $rp);
				if($error['error']===false){
					$error['message']='Password changed successfully.';
					$error["error"]=false;
					
					$pwd_data =array(
					'activity'=>'Change Password',
					'description'=>$uname.' changed password successfully',
					'date_created'=>date('Y-m-d'),
					'time_created'=>date('h:i:s A'),
					'user_id'=> $userid);
					$db->insert('pcm_activities',$pwd_data);
					
				}else{
					$error["error"]=true;
					$error['message']='Changing password not success. Please try again.';
				}
			}else{
				$error["error"]=true;
			}			
		}else{
			$error["error"]=true;
			$error['ui_currentpassword']='Please enter valid current password.';
		}
	}
	echo json_encode($error);
?>