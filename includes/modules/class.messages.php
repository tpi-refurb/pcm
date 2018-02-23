<?php

class Messages
{
	private $lang;	
	public function __construct($lang){
		$this->lang = $lang;
	}
	
	/*
	* Get message using key from lang array
	@ param $key
	@ param $args
	@ return string	
	*/
	public function get_message($key, $args = array()){
		if (!array_key_exists($key,$this->lang)){
			return '';
		}
		if(empty($args) or count($args)==0){
			return $this->lang[$key];
		}
		$str = $this->lang[$key];
		$char_start ='{';
		$char_end ='}';
		$tmp = array();
		foreach($args as $k => $v){
			$ikey = ($char_start . $k . $char_end);
			$tmp[$ikey] = $v;
		}
		return str_replace(array_keys($tmp), array_values($tmp), $str);	
	}	
	
	/* ****Usage****
		$msg = new Messages($lang);
		
		$args	= array('0'=>'Marianz', '2'=>'Rose');
		$str	= 'Hello {0} , I am {2}';
		$result = $msg->get_message($str,$args);
		
	*/
	
	
}

?>