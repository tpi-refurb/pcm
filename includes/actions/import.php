<?php

require('../setup.php');
/** PHPExcel_IOFactory */
//require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';

/** Include PHPExcel */
require_once dirname('../libraries/PHPExcel/Classes/PHPExcel.php');

$default_sheet = 'data_sheet';
$error = array();
$error['error'] = true;

$inputFileName = ((isset($_GET['f']) && $_GET['f'] != '') ? $_GET['f'] : '');
$full_filename = SITE_ROOT.'/attachments/'.$inputFileName;
if (file_exists($full_filename)) {
	/* Check file extension */
	$excel_version='Excel2007';
	$info = new SplFileInfo($full_filename);
	if($info->getExtension()==='xlsx'){
		$excel_version='Excel2007';
	}else if($info->getExtension()==='xls'){
		$excel_version='Excel5';
	}else{
		$error['message'] ='Invalid file  <strong class="text-brand">'.$inputFileName.'</strong>.<br>Please provide only excel file. (<strong class="text-brand">*.xlsx/*.xls </strong>)';
	}

	$objReader = PHPExcel_IOFactory::createReader($excel_version);	
	$work_sheets = $objReader->listWorksheetNames($full_filename);	
	$sheets = array();
	foreach ($work_sheets as $sheet_name) {	
		$sheets[] =$sheet_name;
	}
	if (!in_array($default_sheet, $sheets)) {
		$default_sheet = 'data';
	}
	if (!in_array($default_sheet, $sheets)) {
		$default_sheet = 'Sheet5'; //Second Attempt
	}
	if (in_array($default_sheet, $sheets)) {
		$objReader->setLoadSheetsOnly($default_sheet); //defaul sheet name
		$objReader->setReadDataOnly(true);

		$objPHPExcel = $objReader->load($full_filename);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$highestRow = $objWorksheet->getHighestRow(); 
		$highestColumn = $objWorksheet->getHighestColumn(); 

		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); 

		$validColumns= array ('ord_no','JobType','ServiceNo', 'SubsName','FullName','ContactNo','CabinetNo','JobDescription',
			'ApptDate','ApptSlot','ApptSlotFrom','ApptSlotTo','HistoryStatus','AccountNo','InstAddress','ExchangeCode','JobTypeId',
			'JobStatus','ServiceType', 'JobActivityList','unique_ord_no');/* Get all columns */
		$columns = array();
		for ($col = 0; $col <= $highestColumnIndex; ++$col) {
			$colname = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
			if(!empty($colname)){
				if (in_array($colname, $validColumns)) {
					$columns[$col] =$colname;
				}
			}	
		}

		if (!in_array("ord_no", $columns) or count($columns)<=0) {
			unlink($full_filename);
			$error['message'] = $inputFileName." No valid columns/fields found from selected file.";
		}


		if(empty($error['message'])){			
			for ($row = 2; $row <= $highestRow; ++$row) {	
				$data = array();
				$chk_column ='unique_ord_no';
				$serialkey ='';
				foreach($columns as $key =>$field){		
					$colindex =array_search( $field, $columns, true ); //Get the column index from gernerated columns above.
					$val = ($objWorksheet->getCellByColumnAndRow($colindex, $row)->getValue());
					$val =trim($val);
					if($field==='unique_ord_no'){
						if(!empty($val)){														
							$serialkey = $val;				
							$chk_column = $field;
						}
					}elseif($field==='ord_no'){
						if(!empty(trim($val)) and empty($serialkey)){
							$serialkey = $val;				
							$chk_column =$field;
						}
					}elseif($field ==='ApptDate'){
						$val = force_date($val);
					}else{
						
					}
					if(!empty(trim($val))){
						$data[$field] = $val;
					}	
				}

				if(!empty($serialkey)){
					/*
					$uno =$data['unique_ord_no'];
					if(strpos('_',$uno)===false){
						$serialkey =$uno.'_'.slashed_date($data['ApptDate']);
						$data['unique_ord_no'] =$serialkey;
					}
					*/
					if($db->exist('clus_orders',$chk_column,to_string($serialkey))){
						$db->update('clus_orders', $data,$chk_column."=".to_string($serialkey));			
					}else{
						$db->insert('clus_orders', $data);		
					}
				}
			}
		}

		
		$error['error'] = false;
		$error['file'] = $inputFileName;
		$error['message']='Importing excel file <strong class="text-brand">'.$inputFileName.'</strong> was successfully completed.';
	}else{
		$error['message'] = "Sheet name '<strong class=\"text-red\">".$default_sheet."</strong>' not found from selected file.";
	}
	if (file_exists($full_filename)) {
		unlink($full_filename);
	}	
}else{
	$error['message'] = $inputFileName." file not exist.";
}

echo json_encode($error);