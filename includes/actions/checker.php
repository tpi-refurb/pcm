<?php	
	require('../setup.php');
	$ord_no		=(isset($_GET['o']) ? $_GET['o']: '');
	$cols = array('SubsName','InstAddress','ServiceNo','ContactNo','CabinetNo','JobType','ApptDate','ApptSlot','HistoryStatus');
	$res = array();
	if(!empty($ord_no)){
		$ord_no = remove_special_char($ord_no);
		$q = "SELECT * FROM clus_orders WHERE ord_no = ".to_string($ord_no);
		$rs = $db->getResults($q);
		if(count($rs)>0){
			$res['exist']= true;
			foreach($rs as $r){
				foreach($cols as $c){
					$res[$c]=$r[$c];
				}
			}
		}else{
			$res['exist']= false;
		}
		
	}else{
		$res['exist']= false;
	}
	
	echo json_encode($res);	
	
?>