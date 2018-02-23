
<?php	

	require('../setup.php');
	$error = array();	
	try{
		$dt	=isset($_POST["unit_deliver_date"])? $_POST["unit_deliver_date"]: '';
		$st	=isset($_POST["unit_deliver_status"])? $_POST["unit_deliver_status"]: '';
		$bt	=isset($_POST["unit_deliver_brand"])? $_POST["unit_deliver_brand"]: '';
		$rt	=isset($_POST["unit_deliver_requisitioner"])? $_POST["unit_deliver_requisitioner"]: '';
		$sp	=isset($_POST["unit_check_split"])? $_POST["unit_check_split"]: '';
		
		if(empty($sp)){
			$sp ='0';
		}else{
			$sp	=isset($_POST["unit_split"])? $_POST["unit_split"]: '';
			if(empty($sp)){
				$error['unit_split'] ='Please select split number';
			}
		}
		if(empty($dt)){
			$error['unit_deliver_date'] ='Please enter date';
		}
		if(empty($st)){
			$error['unit_deliver_status'] ='Please select remark';
		}
		if(empty($bt)){
			$error['unit_deliver_brand'] ='Please select brand';
		}
		if(empty($rt)){
			$error['unit_deliver_requisitioner'] ='Please select requisitioner';
		}
		if(count($error) <=0){
			$pdt = plain_date($dt);
			$table_suffix = $pdt.'_'.$st.'_'.$bt.'_'.$rt.'_'.$sp;
			$delivery->create_delivery($table_suffix);
			
			$stime	= date('Y-m-d h:i:s A');
			$etime	= date('Y-m-d').' 11:59:00 PM';
			$seconds= strtotime($etime) - strtotime($stime); //Set expired date to 12 AM of the day
			
			setcookie("dd",encode_url($dt),time()+$seconds, "/", $_SERVER["HTTP_HOST"],0);
			setcookie("pd",encode_url($pdt),time()+$seconds, "/", $_SERVER["HTTP_HOST"],0);
			$error['error'] = false;
			$error['message'] ='Delivery date changed to '.$dt;
			
			$status = $db->getValue('pcm_status','status','id='.$st);
			$requisitioner  = $db->getValue('pcm_requisitioners','requisitioner','id='.$rt);

            $notif_data =array(
                'title'=>'Delivery',
                'message'=>'Delivery dated on: '.$dt.' created.',
                'link'=>'index.php?p='.encode_url('19').'&s='.encode_url('v'),
                'date_created'=>date('Y-m-d h:i:s'),
                'view'=>0,
                'user_id'=> $auth->getUserid());
            $db->insert('pcm_notif',$notif_data);

			$del_data =array(
				'activity'=>'Create Delivery',
				'description'=>'create delivery dated on: '.$dt.' with status :'.$status.' to: '.$requisitioner,
				'date_created'=>date('Y-m-d'),
				'time_created'=>date('h:i:s A'),
				'user_id'=> $auth->getUserid());
			$db->insert('pcm_activities',$del_data);
							
		}else{
			$error['error'] = true;			
		}
		
	}catch(Exception $e){
		$error['error'] = true;
		$error['message'] ='Error in changing date of delivery.';
	}
	echo json_encode($error);
?>