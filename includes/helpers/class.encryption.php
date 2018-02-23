<?php

if ( ! function_exists('encryptor')){	
	function encryptor($action, $string) {
		$output = false;

		$encrypt_method = "AES-256-CBC";
		//pls set your unique hashing key
		$secret_key = 'pcm_marianz';
		$secret_iv = 'pcm_marianz20';

		// hash
		$key = hash('sha256', $secret_key);
		
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		//do the encyption given text/string/number
		if( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		}
		else if( $action == 'decrypt' ){
			//decrypt the given text/string/number
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}

		return $output;
	}
}

if ( ! function_exists('encode_url')){	
	function encode_url($stringKey){
		return urlencode(encryptor('encrypt', $stringKey));
	}
}

if ( ! function_exists('decode_url')){	
	function decode_url($encodedKey){
		$decryptedKey = urldecode($encodedKey);
		return encryptor('decrypt', $decryptedKey);
	}
}