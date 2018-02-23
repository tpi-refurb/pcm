<?php

	//header("Content-Type: text/json");
	
	require('../setup.php');
	$table = "pcm_attachments";
	$error=array();	
	$data = array();
	$state = isset($_POST['s']) ? decode_url($_POST['s']): '';
	$id = isset($_POST['i']) ? decode_url($_POST['i']): '';	
	if(!empty($state)){
		if($state==='d'){			
			if(!empty($id)){				
				$data = array('public'=>'0');				
				if($db->update($table,$data,"id= ".$id)){
					$error['error']= false;
					$error['message']='Selected attachment was succesfully deleted.';
				}else{
					$error['error']= true;
					$error['message']='Error in deleting attachment. Please contact administrator.';
				}	
			}else{
				$error['error']= true;
				$error['message']='Unexpected error. Seems no serial selected. Please contact administrator.';
			}			
		}else{
			$path ='';
			$unit_view	= isset($_POST["unit_view"]) ? htmlspecialchars($_POST["unit_view"]):'0';
			$unit_type	=htmlspecialchars($_POST["unit_type"]);
			$unit_name	=htmlspecialchars($_POST["unit_name"]);
			
			if(empty($id)){			
				$error["message"]='Error occured. Please contact administrator.';
			}else{
				$data['serial_id'] =$id;
			}
			
			$serial = $db->getValue('pcm_serials','serial', 'id='.$id);
			if(empty($serial)){
				$error['message'] ='Please select type.';
			}else{
				$data['serial'] =$serial;
			}
			if(!empty($unit_view)){
				$unit_view = ($unit_view==='on')? '1': '0';
				$data['public'] =$unit_view;
			}else{
				$data['public'] ='0';
			}
			if(empty($unit_type)){
				$error['unit_type'] ='Please select type.';
			}else{
				$data['type'] =$unit_type;
			}
			if(empty($unit_name)){
				$error['unit_name'] ='Please enter friendly name.';
			}else{
				$data['friendly_name'] =$unit_name;
			}
			
			if($unit_type==='link'){
				$unit_url		= trim(htmlspecialchars($_POST["unit_url"]));
				if(empty($unit_url)){
					$error['unit_url'] ='Please enter file URL.';
				}else{
					if (filter_var($unit_url, FILTER_VALIDATE_URL) === FALSE) {
						$error['unit_url'] ='Please enter valid URL.';
					}else{
						$data['path'] =$path =$unit_url;
					}					
				}
			}else{
				$file	=trim(htmlspecialchars($_POST["display_file"]));
				if(empty($file) or $file==='No chosen file'){
					$error['display_file'] ='Please browse file.';
				}else{
					$data['path'] =$path = 'attachments/'. $file;
				}
			}
						
			if(count($error) <=0){
				$error['error']= false;
				$q_check = "SELECT * FROM ".$table." WHERE serial_id =".$id." AND path ='".$path."'";
				$rs = $db->getResults($q_check);
				if(count($rs) >0){
					$error['error']= true;
					$error['message']='Attach file already exist for '.$serial.'. Try rename.';
				}else{
					if($db->insert($table,$data)){
						$error['message']='Attachment was succesfully added.';
						
						$attach_data =array(
						'activity'=>'Insert Attachment',
						'description'=>$file.' type '.$unit_type.' was added into attachment',
						'date_created'=>date('Y-m-d'),
						'time_created'=>date('h:i:s A'),
						'user_id'=>$auth->getUserid());
						$db->insert('pcm_activities',$attach_data);
					}else{
						$error['error']= true;
						$error['message']='Adding new attachment was not successful.';
					}
				}				
			}else{
				$error['error']= true;
			}
		}
	}else{
		$error['error']= true;
		$error['message']='Unexpected error. Please contact administrator.';
	}
	$error = array_merge($error,$data);
	echo json_encode($error);
?>