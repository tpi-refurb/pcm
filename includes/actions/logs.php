<?php

	//header("Content-Type: text/json");
	
	require('../setup.php');
	$table	= "pcm_repair_history";
	$error	= array();	
	$data	= array();
	$state	= isset($_POST['s']) ? decode_url($_POST['s']): '';
	if(empty($state)){
		$state	= isset($_GET['s']) ? ($_GET['s']): '';
	}
	if($state==='d'){
		$id		= isset($_GET['i']) ? decode_url($_GET['i']): '';		
		if(!empty($id)){
			$data = array('active'=>'0');
			if($db->update($table,$data,"id= ".$id)){
				$error['error']= false;
				$error['message']='Selected log was succesfully deleted.';
				
				$log_data =array(
					'activity'=>'Delete Log',
					'description'=>' delete selected log with id '.$id,
					'date_created'=>date('Y-m-d'),
					'time_created'=>date('h:i:s A'),
					'user_id'=> $auth->getUserid());
				$db->insert('pcm_activities',$log_data);
					
			}else{
				$error['error']= true;
				$error['message']='Error in deleting log. Please contact administrator.';
			}	
		}else{
			$error['error']= true;
			$error['message']='Unexpected errors occured, No selected item!';		
		}			
	}else{
		$id                 =isset($_POST['i']) ? decode_url($_POST['i']): '';
		$repair_date        =htmlspecialchars($_POST["unit_repair_date"]);
		$repairs_done       =trim(htmlspecialchars($_POST["unit_repair_done"]));
		$repaired_portion	=trim(htmlspecialchars($_POST["unit_repaired_portion"]));		
		$is_repaired        =htmlspecialchars(isset($_POST["unit_mark_repaired"])? $_POST["unit_mark_repaired"]: 0);
		
		if(empty($id)){			
			$error["message"]='Error occured. Please contact administrator.';
		}else{
			$data['serial_id'] =$id;
		}
		
		if(empty($repaired_portion)){
			$error['unit_repaired_portion']='Repaired Portion is required.';
		}
		
		if(empty($repair_date)){			
			$error["unit_repair_date"]='Received date is required.';
		}else{
			$fdt = force_date($repair_date);
            $date_in = $db->getValue('pcm_serials','date_in','id='.$id);
            if(strtotime($fdt) > strtotime($date_in)){
                $data['date_done'] = $fdt.' '.date('h:i:s');
            }else{
                $error["unit_repair_date"]='Repaired date :'.$fdt.' must greater than date received :'.$date_in;
            }

		}
		
		
			
		$serial = $db->getValue('pcm_serials','serial', 'id='.$id);
		if(empty($serial)){			
			$error["message"]='Serial is required.';
		}else{
			$serial =strtoupper($serial);
			$data['serial'] =$serial;
		}
		
		if(empty($repairs_done)){
			$error['unit_repair_done']='Repair preformed is required.';
		}else{
			$data['repairs_done'] =$repairs_done;
		}		
		
		if(count($error) <=0){
			$error['error']= false;	
			if($state==='u'){
				if($db->update($table,$data,"serial_id= ".$id)){
					$error['error']= false;
					$error['message']='Selected item was succesfully updated.';
					
					$log_data =array(
						'activity'=>'Update Log',
						'description'=>' update selected log with id '.$id,
						'date_created'=>date('Y-m-d'),
						'time_created'=>date('h:i:s A'),
						'user_id'=> $auth->getUserid());
					$db->insert('pcm_activities',$log_data);
				
				}else{
					$error['error']= true;
					$error['message']='No applied changes.';
				}						
			}else{					
				if($db->insert($table,$data)){
					$error['message']='Log of '.$serial.' was succesfully added.';
					$log_data =array(
						'activity'=>'Add Log',
						'description'=>' Add new log for '.$serial,
						'date_created'=>date('Y-m-d'),
						'time_created'=>date('h:i:s A'),
						'user_id'=> $auth->getUserid());
					$db->insert('pcm_activities',$log_data);
				}else{
					$error['error']= true;
					$error['message']='Adding new log was not successful.';
				}
			}
			
			/* Automatically update the status Under Repair if not Marked as REPAIRED */
			$status_id = $db->getValue('pcm_status','id','status='.to_string('Under Repair'));
			if(!empty($is_repaired)){
				if($is_repaired==='on' or $is_repaired==='1'){
					$status_id = $db->getValue('pcm_status','id',"status = 'REPAIRED'");				
				}
			}			
			if(!empty($status_id)){
				$serial_data = array();
				$serial_data['status'] =$status_id;
				$serial_data['date_modified'] =get_datetime();
				$serial_data['repaired_portion'] =$repaired_portion;
				
				$fdt = force_date($repair_date);
				$date_repaired = $db->getValue('pcm_serials','date_repaired','id='.$id);
				if(strtotime($fdt) > strtotime($date_repaired)){
					$data['date_repaired'] = $fdt;
				}
		
				$db->update('pcm_serials',$serial_data,"id= ".$id);
			}
			$error = array_merge($error,$data);
		}else{
			$error['error']= true;
		}
	}
	
	echo json_encode($error);
?>