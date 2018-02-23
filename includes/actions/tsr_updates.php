<?php	
	require('../setup.php');
	$dr_no		=strtoupper(isset($_POST['unit_dr_no']) ? $_POST['unit_dr_no']: '');
	$tech		=(isset($_POST['unit_deliver_technician']) ? $_POST['unit_deliver_technician']: '');
	
	$test_power	=(isset($_POST['unit_test_power']) ? $_POST['unit_test_power']: '');	
	$test_fan	=(isset($_POST['unit_test_fan']) ? $_POST['unit_test_fan']: '');	
	$test_burn	=(isset($_POST['unit_test_burn']) ? $_POST['unit_test_burn']: '');
	
	$dt	=isset($_POST["dt"])? decode_url($_POST["dt"]): '';
	$st	=isset($_POST["st"])? decode_url($_POST["st"]): '';
	$bt	=isset($_POST["bt"])? decode_url($_POST["bt"]): '';
	$rt	=isset($_POST["rt"])? decode_url($_POST["rt"]): '';
	$sp	=isset($_POST["sp"])? decode_url($_POST["sp"]): '';
	$tb	=isset($_POST["tb"])? decode_url($_POST["tb"]): '';
	
	if(empty($test_power)){
		$test_power ='NONE';
	}else{
		$test_power ='OK';
	}
	if(empty($test_fan)){
		$test_fan ='NONE';
	}else{
		$test_fan ='OK';
	}
	if(empty($test_burn)){
		$test_burn ='NONE';
	}else{
		$test_burn ='OK';
	}
	
	$error = array();
	if(empty($dr_no)){
		$error['unit_dr_no'] ='Please enter D.R. Number';
	}
	if(empty($tech)){
		$error['unit_deliver_technician'] ='Please select Technician';
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
	if(empty($tb)){
		$error['message'] ='Please select table';
	}	
	if(count($error) <=0){
		$pdt = plain_date($dt);
		$table_suffix =$pdt.'_'.$st.'_'.$bt.'_'.$rt.'_'.$sp;
		$view ='pcm_view_'.$table_suffix;
		$table ='pcm_delivery_'.$table_suffix;
		$q ="SELECT * FROM ".$view;
		$rs = $db->getResults($q);
		if(count($rs) >0){
			foreach($rs as $r){
				$serial_id = $r['id'];
				$data = array('dr_no'=>$dr_no,'technician'=>$tech,'test_power'=>$test_power,'test_fan'=>$test_fan,'test_burn'=>$test_burn);				
				$db->update($table,$data,'serial_id='.$serial_id);
				$data['date_out'] = force_date($dt);
				$db->update('pcm_serials',$data,'id='.$serial_id);
			}
		}
		
		
	}else{
		$error['error']= true;
	}
	
	echo json_encode($error);	
	
?>