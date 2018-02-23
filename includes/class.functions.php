<?php
if ( ! function_exists('get_POST')){	
	function get_POST($key)
	{
		return isset($_POST[$key]) ? $_POST[$key] : null;
	}
}

if ( ! function_exists('get_GET')){	
	function get_GET($key){
		return isset($_GET[$key]) ? $_GET[$key] : null;
	}
}

if ( ! function_exists('get_REQUEST')){	
	function get_REQUEST($key){
		return isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
	}
}

if ( ! function_exists('getCleanedPHPSELF')){	
	function getCleanedPHPSELF(){
		return htmlspecialchars($_SERVER["PHP_SELF"]);
	}
}

if ( ! function_exists('getFileExtension')){	
	function getFileExtension($file_name) {
		return substr(strrchr($file_name,'.'),1);
	}
}

if ( ! function_exists('clean_POST')){	
	function clean_POST($data){	  
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return trim($data);
	}
}


if ( ! function_exists('decode_url_id')){
	function decode_url_id($id = NULL) {
		if( isset($id) && !empty($id) ){
			$id = decode_url($id);	
			$id = preg_replace("/[^0-9]/", "", $id);
			if( !empty( $id ) && is_numeric( $id ) ){
				return $id;
			}else{
				return preg_replace("/[^0-9]/", "", $id);
			}
		}
		return null;
	}
}

if ( ! function_exists('get_decoded')){
	function get_decoded($value = NULL) {
		if( isset($value) && !empty($value) ){
			return decode_url($value);
		}
		return null;
	}
}

if ( ! function_exists('rand_color')){
	function rand_color() {
		return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
	}
}

if ( ! function_exists('getFullnameInitial')){
	function getFullnameInitial($fullname = NULL) {
		if( isset($fullname) && !empty($fullname) ){
			$sname = explode(' ', $fullname);
			if(count($sname)>1){
				$fname = substr($sname[0], 0, 1);
				$lname = substr($sname[1], 0, 1);
				return $fname.$lname;
			}else{
				return substr($sname[0], 0, 1);
			}
		}
		return '';
	}
}

if ( ! function_exists('redirect_to')){		
	function redirect_to($location = NULL) {
		if($location != NULL){
			header("Location: {$location}");
			exit;
		}
	}
}

if ( ! function_exists('redirect')){
	function redirect($location=Null){
		if($location!=Null){
			echo "<script>
					window.location='{$location}'
				</script>";	
		}else{
			echo 'error location';
		}
		 
	}
}

if ( ! function_exists('require_all')){	
	function require_all($dirs) {
		if(is_array($dirs)){
			foreach ($dirs as $dir) {
				if(is_dir($dir)){		
					foreach(glob($dir."*.php") as $file) {
						//echo $file.'<br>';
						require_once ($file);					
					}					
				}
			}
		}else{
			if(is_dir($dirs)){		
				foreach(glob($dirs . "*.php") as $file) {				
					require_once $file;				
				}
			}
		}	
	}
}


if ( ! function_exists('file_path')){	
	function file_path(){
		$pathinfo = pathinfo(__FILE__);
		echo $pathinfo['dirname'];
	}
}

if ( ! function_exists('currentpage')){
	function currentpage(){
		$this_page = $_SERVER['SCRIPT_NAME']; // will return /path/to/file.php
	    $bits = explode('/',$this_page);
	    $this_page = $bits[count($bits)-1]; // will return file.php, with parameters if case, like file.php?id=2
	    $this_script = $bits[0]; // will return file.php, no parameters*/
		 return $bits[3];	  
	}
}

if ( ! function_exists('clearCookies')){
	function clearCookies(){
		$past = time() - 3600;
		foreach ( $_COOKIE as $key => $value ){
			setcookie( $key, $value, $past, '/' );
			setcookie($key, '', 1);
			setcookie($key, '', 1, '/');
		}
	}
}

if ( ! function_exists('removeCookies')){
	function removeCookies(){		 
		if (isset($_SERVER['HTTP_COOKIE'])){
			$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
			foreach($cookies as $cookie) {
				$parts = explode('=', $cookie);
				$name = trim($parts[0]);
				setcookie($name, '', time()-1000);
				setcookie($name, '', time()-1000, '/');
			}
		}
	}
}
?>