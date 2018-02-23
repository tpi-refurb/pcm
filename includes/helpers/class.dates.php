<?php

if ( ! function_exists('force_date')){
	function force_date($date_string){
		$d=strtotime($date_string);
		return date("Y-m-d", $d);
	}
}

if ( ! function_exists('slashed_date')){
	function slashed_date($date_string){
		$d=strtotime($date_string);
		return date("m/d/Y", $d);
	}
}

if ( ! function_exists('dotted_date')){	
	function dotted_date($date_string){
		$d=strtotime($date_string);
		return date("Y.m.d", $d);
	}
}

if ( ! function_exists('plain_date')){
	function plain_date($date_string){
		$d=strtotime($date_string);
		return date("Ymd", $d);
	}
}

if ( ! function_exists('full_date')){
	function full_date($date_string){
		$d=strtotime($date_string);
		return date("F d, Y l", $d);
	}
}
if ( ! function_exists('long_date')){
	function long_date($date_string){
		$d=strtotime($date_string);
		return date("F d, Y", $d);
	}
}

if ( ! function_exists('shorten_date')){
	function shorten_date($date_string){
		$d=strtotime($date_string);
		return date("M d, Y", $d);
	}
}

if ( ! function_exists('get_datetime')){
	function get_datetime(){
		return date("Y-m-d h:i:s");
	}
}

if ( ! function_exists('get_currentdate')){
	function get_currentdate(){
		return date("Y-m-d");
	}
}

if ( ! function_exists('get_days')){
	function get_days($start_date,$end_date){
		 return round(abs(strtotime($start_date)-strtotime($end_date))/86400);		
	}
}

if ( ! function_exists('get_days_complete')){
	function get_days_complete($start_date,$end_date){	
		$date1 = new DateTime($start_date);
		$date2 = new DateTime($end_date);
		$interval = $date1->diff($date2);
		
		$years = '';
		$months = '';
		$days = '';
		if(intval($interval->y)>0){
			if(intval($interval->y)==1){
				$years= $interval->y . " year";
			}else{
				$years= $interval->y . " years";
			}
		}
		if(intval($interval->m)>0){
			if(empty($years)){
				if(intval($interval->m)==1){
					$months= $interval->m . " month";
				}else{
					$months= $interval->m . " months";
				}
			}else{				
				if(intval($interval->m)==1){
					$months= (", ".$interval->m . " month");
				}else{
					$months= (", ".$interval->m . " months");
				}
			}
		}
		if(intval($interval->d)>0){
			if(!empty($years) || !empty($months) ){
				if(intval($interval->d)==1){
					$days= (", ".$interval->d . " day");
				}else{
					$days= (", ".$interval->d . " days");
				}
			}else{
				if(intval($interval->d)==1){
					$days= $interval->d . " day";
				}else{
					$days= $interval->d . " days";
				}
			}
		}
		return $years. $months.$days; 
	}
}


if ( ! function_exists('add_days')){
	function add_days($date, $days){
		return date('Y-m-d',strtotime($date.' +'.$days.' days'));
	}
}


if ( ! function_exists('get_months')){
	function get_months($start_date,$end_date){
		$d1 = strtotime($start_date);
		$d2 = strtotime($end_date);
		$min_date = min($d1, $d2);
		$max_date = max($d1, $d2);
		$i = 0;
		
		while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
			$i++;
		}
		return $i;
	}
}

if ( ! function_exists('get_time_difference')){
	function get_time_difference($created_time){
        date_default_timezone_set('Asia/Manila'); //Change as per your default time
        $str = strtotime($created_time);
        $today = strtotime(date('Y-m-d H:i:s'));
        
        $time_differnce = $today-$str;	// It returns the time difference in Seconds...
        $years = 60*60*24*365;			// To Calculate the time difference in Years...
        $months = 60*60*24*30;			// To Calculate the time difference in Months...
        $days = 60*60*24;				// To Calculate the time difference in Days...
        $hours = 60*60;					// To Calculate the time difference in Hours...
        $minutes = 60;					// To Calculate the time difference in Minutes...
	
        if(intval($time_differnce/$years) > 1){
            return intval($time_differnce/$years)." years ago";
        }else if(intval($time_differnce/$years) > 0){
            return intval($time_differnce/$years)." year ago";
        }else if(intval($time_differnce/$months) > 1){
            return intval($time_differnce/$months)." months ago";
        }else if(intval(($time_differnce/$months)) > 0){
            return intval(($time_differnce/$months))." month ago";
        }else if(intval(($time_differnce/$days)) > 1){
            return intval(($time_differnce/$days))." days ago";
        }else if (intval(($time_differnce/$days)) > 0){
            return intval(($time_differnce/$days))." day ago";
        }else if (intval(($time_differnce/$hours)) > 1){
            return intval(($time_differnce/$hours))." hours ago";
        }else if (intval(($time_differnce/$hours)) > 0){
            return intval(($time_differnce/$hours))." hour ago";
        }else if (intval(($time_differnce/$minutes)) > 1) {
            return intval(($time_differnce/$minutes))." minutes ago";
        }else if (intval(($time_differnce/$minutes)) > 0){
            return intval(($time_differnce/$minutes))." minute ago";
        }else if (intval(($time_differnce)) > 1){
            return intval(($time_differnce))." seconds ago";
        }else{
            return "few seconds ago";
        }
	}
}


if ( ! function_exists('sortFunction')){
	function sortFunction( $a, $b ) {
		return strtotime($a["date"]) - strtotime($b["date"]);
	}
}