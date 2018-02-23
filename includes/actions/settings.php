<?php
	require('../setup.php');
	$data = array();
	$error = array();
	$rs = $db->getResults('SELECT * FROM config');
	
	foreach($rs as $cfg){
		$name =$cfg['setting'];
		$val =$cfg['value'];
		$type =$cfg['type'];
		$description =$cfg['description'];
		$required =$cfg['required'];
		
		$newval ='';
		if(strpos($name,'table') !==false){
			//$error[$name]=$newval;
		}else if(strpos($name,'bcrypt') !==false){
			//$error[$name]=$newval;
		}else{
			$ui_name = 'ui_settings_'.$name;
			if($type==='BOOLEAN'){
				$ui_name = 'chk_ui_settings_'.$name;
			}
			if(isset($_REQUEST[$ui_name])){
				$newval = htmlspecialchars($_REQUEST[$ui_name]);
				if(!empty($newval)){
					if($type==='BOOLEAN'){
						$data[$name] = ($newval==='on' or $newval==='1')?'1':'0';						
					}else{
						$data[$name] = $newval;
					}
				}else{
					if($type==='BOOLEAN'){
						$data[$name] = '0';
					}else{
						if($required==='1' or strtolower($required)==='yes'){
							$error[$ui_name] =$description.' is required';
						}
					}
				}
			}else{
				if($required==='1' or strtolower($required)==='yes'){
					$error[$ui_name] =$name.' is required';
				}
			}		
		}
	}

	if(count($error) <=0){			
		foreach($data as $key=>$c_val){
			$query = $db->prepare("UPDATE config SET value = ? WHERE setting = ?");
			if($query->execute(array($c_val, $key))) {
				$config->{$key} = $c_val;
			}
		}
		$error['error']= false;	
		$error['message']= "Settings changed.";
	}else{
		$error['error']= true;
	}
	echo json_encode($error);
		
?>