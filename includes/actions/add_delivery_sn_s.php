
<?php	

	require('../setup.php');
	$error = array();	
	try{
		
		$table	=isset($_POST["unit_delivery_date"])? $_POST["unit_delivery_date"]: '';		
		$id		=isset($_POST["i"])? decode_url($_POST["i"]): '';
		
		if(empty($id)){
			$error['unit_deliver_serial'] ='Please enter serial';
		}
		if(empty($table)){
			$error['unit_delivery_date'] ='Please select date';
		}
		
		if(count($error) <=0){
			$serial ='';
			$trm_tbl = str_replace('pcm_delivery_','',$table);
			
			$split_dt = explode('_',$trm_tbl);
			$pdt =  $split_dt[0];
			$st =  $split_dt[1];
			$bt =  $split_dt[2];
			$rt =  $split_dt[3];
			$sp =  $split_dt[4];
			$dt = force_date($pdt);
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
				$error['message'] ='Already added to '.full_date($dt);
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