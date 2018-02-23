<?php
defined('EOL') ? null : define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

class Performance
{
	private $message;
	private $callStartTime;
	private $callEndTime;
	private $callTime;
	
    public function __construct()
    {
		$this->start_perf();
    }
	
	public function start_perf(){
		$this->message = date('H:i:s') . " Started..." . EOL;
		$this->callStartTime = microtime(true);
	}
	
	public function end_perf(){
		$this->callEndTime = microtime(true);
		$this->callTime = $this->callEndTime - $this->callStartTime;
		$this->message =  'Call time finished in ' . sprintf('%.4f',$this->callTime) . " seconds" . EOL;
		
		return sprintf('%.4f',$this->callTime)." sec";
	}
	
	public function memory_usage(){
		$mem_usg =(memory_get_usage(true) / 1024 / 1024);
		$this->message = date('H:i:s') . ' Current memory usage: ' . $mem_usg . " MB" . EOL;
		
		return $mem_usg .' MB';
	}
	
	public function echo_message(){
		echo $this->message;
	}

	public function echo_input_message($message=""){
		if(empty($message)){
			echo $this->message;
		}else{
			echo date('H:i:s') .' '.$message. EOL;;
		}
	}
   
}

?>
