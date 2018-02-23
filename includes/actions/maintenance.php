<?php

	//header("Content-Type: text/json");
	
	require('../setup.php');
	
	$valid_state	=array('a', 'u', 'v', 'd');
	
	$key	= decode_url($_POST['l']);
	$id		= decode_url($_POST['i']);
	$state	= decode_url($_POST['s']);
	
	$tables	=array('Brands'=>'pcm_brands','Status'=>'pcm_status', 'Requisitioners'=>'pcm_requisitioners','Technicians'=>'pcm_technicians', 'Parts'=>'pcm_parts_libraries');
	$columns=array('Brands'=>'brand_name','Status'=>'status', 'Requisitioners'=>'requisitioner', 'Technicians'=>'firstname', 'Parts'=>'part');
	$table = $tables[$key];
	$column= $columns[$key];
	
	
	$error=array();	
	$data = array();
	
	// Check table, column and state if valid
	if (!in_array($table, $tables)){
        $error['error']= true;
		$error['message']='Unexpected errors occured. '.$table.' not found.';
	}elseif (!in_array($state, $valid_state)){
		$error['error']= true;
		$error['message']='Unexpected errors occured. Please contact administrator.';
	}else{
		if($state==='d'){			
			if(!empty($id)){				
				$password	=htmlspecialchars($_POST["unit_password"]);
				$reason			=trim(htmlspecialchars($_POST["unit_reason"]));
				if(!empty($reason)){
					//$data['unit_reason'] =$reason;
				}else{
					$error["unit_reason"]='Reason is required.';
				}				
				if(empty($password)){					
					$error["unit_password"]='Password is required.';
				}
				if(count($error) <=0){
					$uname	= $auth->getUsername();
					$error = $auth->isAuthenticatedUser($uname, $password);
					if($error['error']===false){				
						$data = array('active'=>'0');
						if($db->update($table,$data,"id= ".$id)){
							$error['error']= false;
							$error['message']='Selected item was succesfully deleted.';
							
							$mainten_data =array(
								'activity'=>'Delete '.$key,
								'description'=>' Delete selected item in  '.$key.'. [Reason] : '.$reason,
								'date_created'=>date('Y-m-d'),
								'time_created'=>date('h:i:s A'),
								'user_id'=> $auth->getUserid());
							$db->insert('pcm_activities',$mainten_data);
							
						}else{
							$error['error']= true;
							$error['message']='Error in deleting item. Please contact administrator.';
						}
					}
				}else{
					$error['error']= true;
				}
			}else{
				$error['error']= true;
				$error['message']='Unexpected errors occured, No selected item!';		
			}			
		}else{
			$value='';
			$active	=htmlspecialchars(isset($_POST["unit_active"])? $_POST["unit_active"]: 0);
			if(!empty($active)){
				$active = ($active==='on')? '1': '0';
				$data['active'] =$active;
			}else{
				$data['active'] ='0';
			}
			if($table==='pcm_technicians'){
				$lastname	=strtoupper(htmlspecialchars($_POST["unit_lastname"]));
				$firstname	=strtoupper(htmlspecialchars($_POST["unit_firstname"]));
				$middlename	=strtoupper(htmlspecialchars($_POST["unit_middlename"]));
				
				if(!empty($firstname)){
					$data['firstname'] =$value =$firstname;
				}else{
					$error["unit_firstname"]='Firstname is required.';
				}				
				if(!empty($lastname)){
					$data['lastname'] =$lastname;
				}else{
					$error["unit_lastname"]='Lastname is required.';
				}				
				if(!empty($middlename)){
					$data['middlename'] =$middlename;
				}else{
					$error["unit_middlename"]='Middlename is required.';
				}
				
			}elseif($table==='pcm_requisitioners'){
				$requisitioner	=htmlspecialchars($_POST["unit_requisitioner"]);
				$contact_person	=htmlspecialchars($_POST["unit_contact_person"]);
				$tin	=htmlspecialchars($_POST["unit_tin"]);
				$address	=htmlspecialchars($_POST["unit_address"]);
				$logo	=trim(htmlspecialchars($_POST["display_file"]));
				
				if(!empty($requisitioner)){
					$data['requisitioner'] =$value =$requisitioner;
				}else{
					$error["unit_requisitioner"]='Requisitioner is required.';
				}
				if(!empty($contact_person)){
					$data['contact_person'] =$contact_person;
				}else{
					$error["unit_contact_person"]='Contact person is required.';
				}				
				if(!empty($tin)){
					$data['tin'] =$tin;
				}
				if(!empty($address)){
					$data['address'] =$address;
				}
				$tmo_folder ='assets/images/tmp/';
				$req_folder ='assets/images/requisitioner/';
				if(empty($logo) or $logo==='No chosen file'){
					$old_logo = '';
					if($state==='u'){
						$old_logo  = $db->getValue($table, 'logo', "id=".$id);
					}else{
						$old_logo  = $db->getValue($table, 'logo', "requisitioner='".$requisitioner."'");
					}					
					if(empty($old_logo)){
						$data['logo'] =$req_folder.'blank.png';
					}
				}else{
					$info = new SplFileInfo($logo);
					$new_name =strtolower(remove_unwanted_char($requisitioner)).'.'.$info->getExtension();
					if(rename("../../".$tmo_folder.$logo, '../../'.$req_folder.$new_name)){
						$data['logo'] =$req_folder.$new_name;
					}
				}
				
			}elseif($table==='pcm_status'){
				$status	=htmlspecialchars($_POST["unit_status"]);
				$description	=htmlspecialchars($_POST["unit_description"]);
				$color	=htmlspecialchars($_POST["color_status"]);
				
				if(!empty($status)){
					$data['status'] =$value =$status;
				}else{
					$error["unit_status"]='Status is required.';
				}				
				if(!empty($description)){
					$data['description'] =$description;
				}
				if(!empty($color)){
					$data['icolor'] =$color;
				}else{
					$data['icolor'] ='#FF0000';
				}
				
			}elseif($table==='pcm_brands'){
				$brand	=htmlspecialchars($_POST["unit_brand"]);
				$image	=trim(htmlspecialchars($_POST["display_file"]));
                $is_capture	=htmlspecialchars(isset($_POST["unit_capture_photo"])? $_POST["unit_capture_photo"]: 0);
                if(!empty($is_capture)){
                    $is_capture = ($is_capture==='on')? '1': '0';
                }else{
                    $is_capture ='0';
                }

				if(!empty($brand)){
					$data['brand_name'] =$value =$brand;
				}else{					
					$error["unit_brand"]='Status is required.';
				}	
				
				$tmp_folder ='assets/images/tmp/';
				$req_folder ='assets/images/brands/';
				if(empty($image) or $image==='No chosen file' or $image==='No captured image'){
					$old_logo  = $db->getValue($table, 'image', "brand_name='".$brand."'");
					if(empty($old_logo)){
						$data['image'] =$req_folder.'blank.png';
					}
				}else{
					$info = new SplFileInfo($image);
					$new_name =strtolower(remove_unwanted_char($brand)).'.'.$info->getExtension();
                    if(file_exists("../../".$tmp_folder.$image)) {
                        if (rename("../../" . $tmp_folder . $image, '../../' . $req_folder . $new_name)) {
                            $data['image'] = $req_folder . $new_name;
                        }
                    }
				}
            }elseif($table==='pcm_parts_libraries'){
                $part       =strtoupper(trim(htmlspecialchars($_POST["unit_part"])));
                $portion	=strtoupper(trim(htmlspecialchars($_POST["unit_portion"])));
                $brand      =strtoupper(trim(htmlspecialchars($_POST["unit_brand"])));

                if(!empty($part)){
                    $data['part'] =$value =$part;
                }else{
                    $error["unit_part"]='Component is required.';
                }
                if(!empty($portion)){
                    $data['portion'] =$portion;
                }else{
                    $error["unit_portion"]='Portion is required.';
                }
                if(empty($brand)){
                    $error["unit_brand"]='Brand is required.';
                }else{
                    $data['brand'] =$brand;
                }

                if(!empty($part) and !empty($brand) and !empty($portion)){
                    $check_q = "SELECT * FROM ".$table." WHERE part='".$part."' AND brand =".$brand." AND portion='".$portion."'";
                    $rs = $db->getResults($check_q);
                    if(count($rs)>0){
                        $error["message"]='Please check entered component, already exist in selected brand and entered portion.';
                    }
                }

			}else{
				$error["message"] ="Luh?";
				$error["table"] =$table;
			}
			
			if(count($error) <=0){
				$error['error']= false;	
				if($state==='a'){
					if($db->insert($table,$data)){
						$error['error']= false;
						$error['message']='Item was succesfully added.';
						
						$mainten_data =array(
							'activity'=>'Add '.$key,
							'description'=>' add new item into  '.$key,
							'date_created'=>date('Y-m-d'),
							'time_created'=>date('h:i:s A'),
							'user_id'=> $auth->getUserid());
						$db->insert('pcm_activities',$mainten_data);
							
					}else{
						$error['error']= true;
						$error['message']='Adding new item was not successful.';
					}
					$error['action']='Adding';
				}else if($state==='u'){
					$chk_id  = $db->getValue($table, 'id', $column."='".$value."'");
					if(empty($chk_id)){
						if($db->update($table,$data,"id= ".$id)){
							$error['error']= false;
							$error['message']='Selected item was succesfully updated.';
						}else{
							$error['error']= true;
							$error['message']='No applied changes.';
						}
					}else{
						if($chk_id!==$id){
							$error['error']= true;
							$error["message"] = $value. ' already exist!';
						}else{
							if($db->update($table,$data,"id= ".$id)){
								$error['error']= false;
								$error['message']='Selected item was succesfully updated.';
							}else{
								$error['error']= true;
								$error['message']='No applied changes.';
							}
						}
					}
					
					$mainten_data =array(
						'activity'=>'Update '.$key,
						'description'=>' update selected item from  '.$key,
						'date_created'=>date('Y-m-d'),
						'time_created'=>date('h:i:s A'),
						'user_id'=> $auth->getUserid());
					$db->insert('pcm_activities',$mainten_data);
						
					$error['action']='Editing';
				}else{
					$error['error']= true;
					$error['message']='An ALIEN action: this action was not found in developer\'s command.';		
				}				
			}else{
				$error['error']= true;
			}
		}
	}
	echo json_encode($error);
?>