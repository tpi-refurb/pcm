<?php

if ( ! function_exists('to_string')){	
	function to_string($input){
		if(!empty($input)){
			$input = stripslashes($input);
			$input = htmlspecialchars($input);
			$escaped = trim($input);
			return "'".$escaped."'";
		}
		return "''";
	}
}

if ( ! function_exists('get_single_random_array')){	
	function get_single_random_array($data){
		if(is_array($data)){
			$rand_keys = array_rand($data, 1);
			return $data[$rand_keys];
		}else{
			return $data;
		}	
	}
}
if ( ! function_exists('remove_special_char')){	
	function remove_special_char($string) {
	   $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
}
if ( ! function_exists('remove_unwanted_char')){	
	function remove_unwanted_char($string) {	  
	   return preg_replace('/[^A-Za-z0-9\- _]/', '', $string); // Removes special chars.
	}
}