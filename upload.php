<?php
	
	
	$errors= array();
	if(isset($_FILES['req_image'])){
		$req_folder ='assets/images/tmp/';
		$file_name = $_FILES['req_image']['name'];
		$file_size = $_FILES['req_image']['size'];
		$file_tmp = $_FILES['req_image']['tmp_name'];
		$file_type = $_FILES['req_image']['type'];
		
		$extensions=  array('xlsx','xls','svg','png','jpeg','jpg','tif','tiff','bmp','pdf','doc','docx');
		$info = new SplFileInfo($_FILES['req_image']['name']);
		if(!in_array($info->getExtension(),$extensions)){
			$errors['message']="Invalid file.";
		}    

		if($file_size > 2097152) {
			$errors['message']='File size must not exceed 2MB';
		}
		
		if(empty($errors)==true) {
			if(move_uploaded_file($file_tmp,$req_folder.$file_name)){
				$errors['error']= false;
				$errors['message'] ='Success';
			}else{
				$errors['error']= true;
				$errors['message'] ='Not Success';
			}
		}else{
			$errors['error']= true;
		}
	}
	echo json_encode($errors);
?>