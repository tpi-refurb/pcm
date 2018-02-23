
<?php	
	require('../setup.php');
	$id = decode_url((isset($_GET['i']) && $_GET['i'] != '') ? $_GET['i'] : '');
	$state = decode_url((isset($_GET['s']) && $_GET['s'] != '') ? $_GET['s'] : '0');
	$table = "pcm_deliveries";
	
	
	if(!empty($id)){
		$data = array();
		$data['is_lock'] =$state;
		$msg = ($state==='0')? 'unlocked':'locked';
		if($db->update($table,$data,'id='.$id)){
			$error['error'] = false;
			$error['message']='Selected delivery was successfully '.$msg;
		}else{
			$error['error'] = true;
			$error['message']='Error: Changing state of selected attachment '.$msg ;
		}
	}else{
		$error['error'] = true;
		$error['message']='Error'.$id;
	}
	
	echo json_encode($error);

?>