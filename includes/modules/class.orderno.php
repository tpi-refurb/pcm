<?php
//require 'mailer/PHPMailerAutoload.php';

class OrderHistory
{
    private $db;
	
    public function __construct(\PDO $dbh)
    {
        $this->db = $dbh;
    }
	
	public function create_history($data){
		# $cols = valid columns (array)
		$cols = array('ord_no','remarks','reason','date_visited','date_updated','userid','action');
		#reconstruct data array to avoid error
		$res = array();
		foreach($data as $k =>$v){
			# filter content from data array, containing key in valid columns
			if(in_array($k, $cols)){
				# re-initialize value
				$res[$k] = $v;
			}
		}
		# and now insert into order history
		$this->db->insert('tlr_ordnohistory',$res);
	}
	

}

?>
