<?php
	/* Clear saved session to prevent showing success dialog */
	$error = array();
	
	/* Pre checking ****/
	$unit_type	=htmlspecialchars(isset($_POST["unit_type"])?$_POST["unit_type"]:'');
	$unit_name	=htmlspecialchars(isset($_POST["unit_name"])?$_POST["unit_name"]:'');
	$file	=trim(htmlspecialchars(isset($_POST["display_file"])?$_POST["display_file"]:''));	
	if(empty($unit_type)){
		$error['unit_type'] ='Please select type.';
	}
	if(empty($unit_name)){
		$error['unit_name'] ='Please enter friendly name.';
	}else{
		$data['friendly_name'] =$unit_name;
	}	
	
	if(empty($file)){
		$error['display_file'] ='Please browse file.';
	}else{
		if($file==='No chosen file'){
			$error['display_file'] ='No chosen file. Please browse file.';
		}
	}
			
	if(count($error) <=0){		
		if(is_array($_FILES)) {
			$error['error'] = true;
			$valid_extensions = array('xlsx','xls','svg','png','jpeg','jpg','tif','tiff','bmp','pdf','doc','docx');
			$excelfile ='';
			if(isset($_FILES['unit_attachments'])){
				$excelfile=$_FILES['unit_attachments']['tmp_name'];
			}else{
				$error['message']='ERROR: System error, excel has invalid variable index.';
			}	
			$error['excel'] =$excelfile;
			if(is_uploaded_file($excelfile)) {
				$sourcePath = $excelfile;
				$detinationFilename =$_FILES['unit_attachments']['name'];
				$targetPath = "../../attachments/".$detinationFilename;			
				$info = new SplFileInfo($detinationFilename);
				if(!in_array($info->getExtension(),$valid_extensions)){		
					$error['message'] ='Invalid file  <strong class="text-alt">'.$detinationFilename.'</strong>.<br>Please provide file with extension. (<strong class="text-alt">'.implode(', ',$valid_extensions).'</strong>)';	
				}else{
					if(move_uploaded_file($sourcePath,$targetPath)) {
						$error['error'] = false;
						$error['file'] = $detinationFilename;
						$error['message']='Uploading excel file <strong class="text-alt">'.$detinationFilename.'</strong> was successfully completed.';					
					}else{
						$error['message']='Uploading excel file was not success.';
					}
				}
			}else{
				$error['message']='Excel file was not uploaded.';
			}		
		}else{
			$error['error'] = true;
			$error['message']='No excel file.';
		}
	}else{
		$error['error']= true;
	}
	echo json_encode($error);
?>