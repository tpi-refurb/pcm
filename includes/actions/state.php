
<?php	
	require('../setup.php');
	$id = decode_url((isset($_GET['i']) && $_GET['i'] != '') ? $_GET['i'] : '');
	$state = decode_url((isset($_GET['s']) && $_GET['s'] != '') ? $_GET['s'] : '0');
	$table = "pcm_attachments";
	
	
	if(!empty($id)){
		$data = array();
		$data['public'] =$state;
		$msg = ($state==='0')? 'deleted':'activated';			
		if($db->update($table,$data,'id='.$id)){
			$error['error'] = false;
			$error['message']='Selected attachment was successfully '.$msg;
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