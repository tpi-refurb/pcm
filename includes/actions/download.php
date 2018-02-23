<?php

function downloadFile($url){    
    $file = fopen ($url, 'rb');
    if ($file) {
		$newfname =basename($url);
        $newf = fopen ($newfname, 'wb');
        if ($newf) {
            while(!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
            }
        }
    }
    if ($file) {
        fclose($file);
    }
    if ($newf) {
        fclose($newf);
    }
	
}
$url = isset($_GET['u'])?$_GET['u']: '';
downloadFile($url);


?>