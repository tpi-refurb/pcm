<?php
require('../setup.php');
$q=(isset($_GET['q']) ? $_GET['q']: '');
$c=strtolower(isset($_GET['t']) ? $_GET['t']: '');
$tbl='pcm_serials';
$w=$c;
if($c==='matcode'){
	
}else if($c==='reference_no'){
	
}else if($c==='repaired_portion'){
	
}else if($c==='delivery'){	
	$st = decode_url((isset($_GET['st']) && $_GET['st'] != '') ? $_GET['st'] : '');
	$bt = decode_url((isset($_GET['bt']) && $_GET['bt'] != '') ? $_GET['bt'] : '');
	$rt = decode_url((isset($_GET['rt']) && $_GET['rt'] != '') ? $_GET['rt'] : '');
	$c= 'serial';
	$w =" status=".$st." AND brand=".$bt." AND requisitioner=".$rt." AND serial";	
}else{
	$tbl= 'pcm_serials';
	$c='serial';
}

$a = array();
$query ="SELECT distinct(".$c.") FROM ".$tbl." WHERE ".$w." like'%".$q."%'";
//$a[]['query']=$query;
$rs = $db->getResults($query);

foreach($rs as $r){
	$a[]['name'] = $r[$c];
}
echo json_encode($a);

?>