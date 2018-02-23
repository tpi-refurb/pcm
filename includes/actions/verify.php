<?php	
	require('../setup.php');
	$sn		=(isset($_POST['unit_deliver_serial']) ? $_POST['unit_deliver_serial']: '');
	
	$dt	=isset($_POST["dt"])? decode_url($_POST["dt"]): '';
	$st	=isset($_POST["st"])? decode_url($_POST["st"]): '';
	$bt	=isset($_POST["bt"])? decode_url($_POST["bt"]): '';
	$rt	=isset($_POST["rt"])? decode_url($_POST["rt"]): '';
		
	$res = array();
	if(!empty($sn)){
	
		$q = "SELECT * FROM pcm_serials WHERE status=".$st." AND brand=".$bt." AND requisitioner=".$rt." AND serial = ".to_string($sn);
		$rs = $db->getResults($q);
		if(count($rs)>0){
			$index=1;
			$res['error']= false;
			foreach($rs as $r){
				$id = $r['id'];
				$res[$index]['id'] =$id;
				$res[$index]['serial'] =$r['serial'];
				$res[$index]['date_in'] =$r['date_in'];
				$res[$index]['add_ctrl']='<a class="btn btn-flat btn-alt btn-sm waves-button waves-effect add_serial_to" id="add_'.($id).'"><span class="icon icon-save"></span>Add This Serial</a>';
				$index +=1;
			}
			$res['count'] =count($rs);
		}else{
			$res['count']= 0;
		}
		
	}else{
		$res['error']= true;
		$res['unit_deliver_serial']= 'Serial is required';
	}
	
	echo json_encode($res);	
	
?>