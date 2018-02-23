<?php	
require('../setup.php');
$id		= isset($_POST['i']) ? decode_url($_POST['i']): '';
$res = array();
if(empty($id)){
    $res['error']=true;
    $res['message']='No id...';
}else{
    $portion = isset($_POST['unit_repaired_portion']) ? htmlspecialchars($_POST['unit_repaired_portion']): '';
    $res['portion']=$portion;
    if(empty($portion)){
        $res['error']=true;
        $res["message"]='Repaired Portion is required.';
    }else{
        $brand = $db->getValue('pcm_serials','brand','id='.$id);
        $q = "SELECT part FROM pcm_parts_libraries WHERE brand=".$brand." AND portion LIKE '%".$portion."%'";
        $rs = $db->getResults($q);
        $res['q']=$q;
        if(count($rs)>0){
            $parts = array();
            foreach($rs as $r){
                $parts[] =$r['part'];
            }
            $res['parts']= $delivery->shuffle_arrays($parts);
            $res['error']=false;
        }else{
            $res['error']=true;
            $res['message']='No parts to generate';
        }
    }
}
echo json_encode($res);
	
?>