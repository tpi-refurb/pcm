
<?php	

	require('../setup.php');
	$error = array();	
	try{
		$ac	=isset($_POST["ac"])? decode_url($_POST["ac"]): '';
		$dt	=isset($_POST["dt"])? decode_url($_POST["dt"]): '';
		$st	=isset($_POST["st"])? decode_url($_POST["st"]): '';
		$bt	=isset($_POST["bt"])? decode_url($_POST["bt"]): '';
		$rt	=isset($_POST["rt"])? decode_url($_POST["rt"]): '';
		$sp	=isset($_POST["sp"])? decode_url($_POST["sp"]): '';
		
		$id	=isset($_POST["i"])? $_POST["i"]: '';
		
		
		
		if(empty($id)){
			$error['unit_deliver_serial'] ='Please enter serial';
		}
		if(empty($ac)){
			$error['ac'] =$ac.' is invalid'. encode_url('d');
		}
		if(empty($dt)){
			$error['message'] ='Please enter date';
		}
		if(empty($st)){
			$error['message'] ='Please select remark';
		}
		if(empty($bt)){
			$error['message'] ='Please select brand';
		}
		if(empty($rt)){
			$error['message'] ='Please select requisitioner';
		}
		if(empty($sp)){
			$sp ='0';
		}
		if(count($error) <=0){
			$serial ='';
			$pdt = plain_date($dt);
			$table_suffix =$pdt.'_'.$st.'_'.$bt.'_'.$rt.'_'.$sp;
			$table ='pcm_delivery_'.$table_suffix;
			if($ac=='d'){
				if(!empty($id)){
					$dr_no = $db->getValue('pcm_serials','dr_no','id='.$id); //Check if contains D.R.# to prevent delete
					if(empty($dr_no)){
						if($db->delete($table,'serial_id='.$id)){
							$error['error']= false;
							$error['message']='Serial was succesfully deleted.';
							
							$db->update('pcm_serials', array('delivery_table'=>null),'id='.$id);
						}
					}else{
						$error['error'] = true;	
						$error['message'] ='Oppps! you cannot delete this serial.';
					}
					
				}else{
					$error['error'] = true;	
					$error['message'] ='Please select serial to delete.';
				}
			}else{
				$data['serial_id'] =$id;
				$data['status'] =$st;
				if(!$db->exist($table,'serial_id',$id)){
					$delivery_table = $db->getValue('pcm_serials','delivery_table','id='.$id);					
					if(empty($delivery_table)){
						if($db->insert($table,$data)){
							$error['error']= false;
							$error['message']='Serial was succesfully added.';
							
							$db->update('pcm_serials', array('delivery_table'=>$table),'id='.$id);
							
							$serial = $db->getValue('pcm_serials','serial','id='.$id);					
							$insert_data =array(
							'activity'=>'Add Serial To Delivery',
							'description'=>$serial.' was added into delivery '.$dt,
							'date_created'=>date('Y-m-d'),
							'time_created'=>date('h:i:s A'),
							'user_id'=>$auth->getUserid());
							$db->insert('pcm_activities',$insert_data);
							
						}else{
							$error['error']= true;
							$error['message']='No changes applied.';
						}
					}else{
						$trm_tbl = str_replace('pcm_delivery_','',$delivery_table);			
						$split_dt = explode('_',$trm_tbl);
						$pdt =  $split_dt[0];
						$dt = force_date($pdt);
						
						$error['error'] = true;
						$error['message'] ='Already added in delivery dated: '.full_date($dt).' Remove this selected serial from previous delivery list';
					}
				}else{
					$error['error'] = true;
					$error['message'] ='Already exist in delivery for selected date '.full_date($dt);
				}
			}
		}else{
			$error['error'] = true;
		}
		$error['id'] = $id;
	}catch(Exception $e){
		$error['error'] = true;
		$error['message'] ='Error in changing date of delivery.'.$e;
	}
	echo json_encode($error);
?>