<?php
class db extends PDO {
	private $error;
	private $sql;
	private $bind;
	private $errorCallbackFunction;
	private $errorMsgFormat;

	# @object, Object for logging exceptions	
	//private $log;
	
	public function __construct($dsn, $user="", $passwd="") {
		
		//$this->log = new Log();	
		$options = array(
			PDO::ATTR_PERSISTENT => true, 
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);

		try {
			parent::__construct($dsn, $user, $passwd, $options);
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
			
			#write log from caught exxception
			echo $this->exceptionLog($e->getMessage());			
		}
	}

	private function debug() {
		if(!empty($this->errorCallbackFunction)) {
			$error = array("Error" => $this->error);
			if(!empty($this->sql))
				$error["SQL Statement"] = $this->sql;
			if(!empty($this->bind))
				$error["Bind Parameters"] = trim(print_r($this->bind, true));

			$backtrace = debug_backtrace();
			if(!empty($backtrace)) {
				foreach($backtrace as $info) {
					if($info["file"] != __FILE__)
						$error["Backtrace"] = $info["file"] . " at line " . $info["line"];	
				}		
			}

			$msg = "";
			if($this->errorMsgFormat == "html") {
				if(!empty($error["Bind Parameters"]))
					$error["Bind Parameters"] = "<pre>" . $error["Bind Parameters"] . "</pre>";
				$css = trim(file_get_contents(dirname(__FILE__) . "/error.css"));
				$msg .= '<style type="text/css">' . "\n" . $css . "\n</style>";
				$msg .= "\n" . '<div class="db-error">' . "\n\t<h3>SQL Error</h3>";
				foreach($error as $key => $val)
					$msg .= "\n\t<label>" . $key . ":</label>" . $val;
				$msg .= "\n\t</div>\n</div>";
			}
			elseif($this->errorMsgFormat == "text") {
				$msg .= "SQL Error\n" . str_repeat("-", 50);
				foreach($error as $key => $val)
					$msg .= "\n\n$key:\n$val";
			}

			$func = $this->errorCallbackFunction;
			$func($msg);
		}
	}

	public function delete($table, $where, $bind="") {
		$sql = "DELETE FROM " . $table . " WHERE " . $where . ";";		
		return $this->run($sql, $bind);
		
	}

	private function filter($table, $info) {
		$driver = $this->getAttribute(PDO::ATTR_DRIVER_NAME);
		if($driver == 'sqlite') {
			$sql = "PRAGMA table_info('" . $table . "');";
			$key = "name";
		}
		elseif($driver == 'mysql') {
			$sql = "DESCRIBE " . $table . ";";
			$key = "Field";
		}
		else {	
			$sql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
			$key = "column_name";
		}	

		if(false !== ($list = $this->run($sql))) {
			$fields = array();
			foreach($list as $record) {
                $fields[] = $record[$key];
            }
			return array_values(array_intersect($fields, array_keys($info)));
		}
		return array();
	}

	private function cleanup($bind) {
		if(!is_array($bind)) {
			if(!empty($bind))
				$bind = array($bind);
			else
				$bind = array();
		}
		return $bind;
	}

	public function insert($table, $info) {
		$fields = $this->filter($table, $info);
		$sql = "INSERT INTO " . $table . " (" . implode($fields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";	
		
		//$this->log->writeLog('insert function : '.$sql);
		
		$bind = array();
		foreach($fields as $field)
			$bind[":$field"] = $info[$field];
		return $this->run($sql, $bind);
	}
	
	
	public function getRowCounts($sql){
		$result = $this->query($sql);
		return $result->rowCount() ;
	}
	public function getColumns($table)
	{
		$sql ='SHOW COLUMNS FROM '.$table;
		$stmt = $this->query($sql);
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $results;
	}
	
	public function getTableRowsCount($table)
	{
		$result = $this->query("SELECT * FROM ".$table);
		return $result->rowCount() ;
	}
		
	public function getResults($sql)
	{
		$stmt = $this->query($sql);
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $results;
	}
	
	public function run($sql, $bind="") {
	
		//$this->log->writeLog('run function : '.$sql);
		
		//echo $sql;
		
		$this->sql = trim($sql);
		$this->bind = $this->cleanup($bind);
		$this->error = "";

		try {
			$pdostmt = $this->prepare($this->sql);
			if($pdostmt->execute($this->bind) !== false) {
				if(preg_match("/^(" . implode("|", array("select", "describe", "pragma")) . ") /i", $this->sql))
					return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
				elseif(preg_match("/^(" . implode("|", array("delete", "insert", "update")) . ") /i", $this->sql))
					return $pdostmt->rowCount();
			}	
		} catch (PDOException $e) {
			//$this->log->writeLog('run function UNHANDLED EXCEPTION: '.$e->getMessage());
			$this->error = $e->getMessage();				
			$this->debug();
			
			echo $this->exceptionLog($e->getMessage(),$this->sql);
			
			return false;
		}
	}

	public function select($table, $where="", $bind="", $fields="*") {
		$sql = "SELECT " . $fields . " FROM " . $table;
		if(!empty($where))
			$sql .= " WHERE " . $where;
		$sql .= ";";
		return $this->run($sql, $bind);
	}
	
	public function exist($table, $column, $value)
	{
		$sql = "SELECT * FROM ".$table." WHERE ".$column."=".$value.";";
		
		//$this->log->writeLog('exist function : '.$sql);	
		if($this->getRowCounts($sql)>0){
			return true;
		}
		return false;
	}

	public function setErrorCallbackFunction($errorCallbackFunction, $errorMsgFormat="html") {
		//Variable functions for won't work with language constructs such as echo and print, so these are replaced with print_r.
		if(in_array(strtolower($errorCallbackFunction), array("echo", "print")))
			$errorCallbackFunction = "print_r";

		if(function_exists($errorCallbackFunction)) {
			$this->errorCallbackFunction = $errorCallbackFunction;	
			if(!in_array(strtolower($errorMsgFormat), array("html", "text")))
				$errorMsgFormat = "html";
			$this->errorMsgFormat = $errorMsgFormat;	
		}	
	}

	public function update($table, $info, $where, $bind="") {
		$fields = $this->filter($table, $info);
		$fieldSize = sizeof($fields);

		$sql = "UPDATE " . $table . " SET ";
		for($f = 0; $f < $fieldSize; ++$f) {
			if($f > 0)
				$sql .= ", ";
			$sql .= $fields[$f] . " = :update_" . $fields[$f]; 
		}
		$sql .= " WHERE " . $where . ";";

		$bind = $this->cleanup($bind);
		foreach($fields as $field)
			$bind[":update_$field"] = $info[$field];
		
		return $this->run($sql, $bind);
	}
	
	public function getValue($table,$column, $where)
	{
		$query ='SELECT '.$column.' FROM '.$table.' WHERE '.$where;
		$stmt = $this->query($query);
		$results = $stmt->fetch();
		
		return $results[0];
	}

    public  function getLastValue($table,$column, $where,$order_by){
        $query = "SELECT ".$column." FROM ".$table." WHERE ".$where." order by ".$order_by." DESC limit 1";
        $stmt = $this->query($query);
        $results = $stmt->fetch();

        return $results[0];
    }
	
	public function tableExist($tablename)
	{
		$query = "SHOW TABLES LIKE '$tablename'";
		$stmt = $this->query($query);
		$results = $stmt->fetchAll();
		
		$count = count($results);		
		if($count > 0){
			return true;
		}
		return false;
	}
	
	
	public function getTables($db, $where){
		$query ='SHOW TABLES FROM '.$db;
		if(!empty($where)){
			$query ='SHOW TABLES FROM '.$db.' '.$where;
		}
		$stmt = $this->query($query);
		$results = $stmt->fetchAll();
		
		return $results;
	}
	
	public function getJsonResult($table, $criteria){
		$q="SELECT * FROM ".$table;
		if(!empty($criteria)){
			$q="SELECT * FROM ".$table. " WHERE ".$criteria;
		}
		
		$stmt = $this->query($q);	
		if ($stmt->rowCount() > 0) {		
			$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			$data = array();
			foreach($rs as $r){			
				$data[] = $r;
			}
			$jsonarr =json_encode($data);
			$data = preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $jsonarr); #Remove double qoutes in name only
			$data =  str_replace('"', "", $data); 
			$data = ltrim($data,'[');
			$data = rtrim($data,']');
			return $data;
		}
		return array('empty'=>'No data found');		
	}
	private function exceptionLog($message , $sql = "")
	{
		$exception  = 'Unhandled Exception. <br />';
		$exception .= $message;
		$exception .= "<br /> You can find the error back in the log.";

		if(!empty($sql)) {
			# Add the Raw SQL to the Log
			$message .= "\r\nRaw SQL : "  . $sql;
		}
			# Write into log
			//$this->log->writeLog($message);

		return $exception;
	}		
}	
?>
