<?php

	//header("Content-Type: text/json");
	
	require('../setup.php');
	
	$table = "pcm_serials";	
	$error=array();	
	$data = array();
	$state = isset($_POST['s']) ? decode_url($_POST['s']): '';
	$id = isset($_POST['i']) ? decode_url($_POST['i']): '';
	
	if(!empty($state)){
		if($state==='d'){			
			if(empty($id)){
				$error['error']= true;
				$error['message']='Unexpected errors occured, No selected item!';
			}else{
				
				$password   =htmlspecialchars($_POST["unit_password"]);
				$reason	    =trim(htmlspecialchars($_POST["unit_reason"]));
				if(empty($reason)){
					$error["unit_reason"]='Reason is required.';					
				}				
				if(empty($password)){					
					$error["unit_password"]='Password is required.';
				}
				if(count($error) <=0){
					$uname	=  $auth->getUsername();
					$error = $auth->isAuthenticatedUser($uname, $password);
					if($error['error']===false){				
						$data = array('active'=>'0');
						if($db->update($table,$data,"id= ".$id)){
							$error['error']= false;
							$error['message']='Selected item was successfully deleted.';
							
							$entry_data =array(
								'activity'=>'Delete Entry',
								'description'=>'Delete selected serial with id '.$id.'. [Reason] : '.$reason,
								'date_created'=>date('Y-m-d'),
								'time_created'=>date('h:i:s A'),
								'user_id'=> $auth->getUserid());
							$db->insert('pcm_activities',$entry_data);
							
						}else{
							$error['error']= true;
							$error['message']='Error in deleting item. Please contact administrator.';
						}
					}
				}else{
					$error['error']= true;
				}				
			}
			
		}elseif($state==='cs'){
			if(!empty($id)){
				$unit_status	=htmlspecialchars($_POST["unit_status"]);
				if(empty($unit_status)){
					$error['error']= true;					
					$error["unit_status"]='Status is required.';
				}else{
					$label_status = $db->getValue('pcm_status','status','id='.$unit_status);
					if(strtoupper($label_status) ==='REPAIRED'){
                        $repaired_date      =htmlspecialchars($_POST["unit_repaired_date"]);
                        $repaired_portion	=htmlspecialchars($_POST["unit_repaired_portion"]);
						$replaced_parts     =htmlspecialchars($_POST["unit_replaced_parts"]);
                        if(empty($repaired_date)){
                            $error["unit_repaired_date"]='Date Repaired is required.';
                        }else{
                            $fdt = force_date($repaired_date);
                            $date_in    = $db->getValue('pcm_serials','date_in','id='.$id);
                            if(strtotime($fdt) < strtotime($date_in)){
                                $error["unit_repaired_date"]='Repaired date :'.$repaired_date.' must greater than date received :'.$date_in;
                            }else{
                                $data['date_repaired'] = $fdt;
                            }
                        }
                        if(empty($repaired_portion)){
							$error["unit_repaired_portion"]='Repaired Portion is required.';
						}else{
							$data['repaired_portion'] =strtoupper($repaired_portion);
						}
						if(empty($replaced_parts)){
							$error["unit_replaced_parts"]='Replaced Parts is required.';
						}else{
							$data['replaced_parts'] =strtoupper($replaced_parts);
						}
					}
					if(count($error) <=0){
						$data['status'] =$unit_status;
						if($db->update($table,$data,"id= ".$id)){
							$error['error']= false;
							$error['message']='Selected item was successfully updated.';
							
							$entry_data =array(
								'activity'=>'Change Status Entry',
								'description'=>'Change status into '.$label_status,
								'date_created'=>date('Y-m-d'),
								'time_created'=>date('h:i:s A'),
								'user_id'=> $auth->getUserid());
							$db->insert('pcm_activities',$entry_data);
							
						}else{
							$error['error']= true;
							$error['message']='No changes applied.';
						}
					}else{
						$error['error']= true;
					}
				}
			}else{
                $error['error']= true;
                $error['message']='Unexpected errors occured, No selected item!';
            }
		}elseif($state==='g'){
			$received_date	=htmlspecialchars(get_POST("unit_received_date"));
			$reference_no	=htmlspecialchars(get_POST("unit_reference_no"));
			$matcode		=htmlspecialchars(get_POST("unit_matcode"));
			$brand			=htmlspecialchars(get_POST("unit_brand"));
			$quantity		=htmlspecialchars(get_POST("unit_quantity"));
			
			
			$requisitioner	=$id;
            $rec_date =$received_date;
			if(empty($received_date)){			
				$error["unit_received_date"]='Received date is required.';
			}else{
                $rec_date = $fdt = force_date($received_date);
				if(strtotime($fdt) < strtotime('1 year ago')){
					$error["unit_received_date"]='Please check received date '.$received_date.'--'.$fdt;
				}else{
					$data['date_in'] = $fdt;
				}
			}			
			if(empty($brand)){			
				$error["unit_brand"]='Brand is required.';
			}else{
				$data['brand'] =$brand;
			}
			if(empty($requisitioner)){			
				$error["unit_requisitioner"]='Requisitioner is required.';
			}else{
				$data['requisitioner'] =$requisitioner;
			}
			if(empty($matcode)){
				$error['unit_matcode'] ='MATCODE is required.';				
			}else{
				$data['matcode'] =$matcode;
			}
			if(empty($quantity)){
				$error['unit_quantity'] ='Quantity is required.';				
			}else{
				//$data['quantity'] =$quantity;
			}
			if(empty($reference_no)){
				$error['unit_reference_no'] ='Reference Number is required.';
			}else{				
				$data['reference_no'] = strtoupper($reference_no);
			}
			
			if(count($error) <=0){
				$error['error']= false;	
				$add_link ='index.php?p='.encode_url('12').'&s='.encode_url('g').'&l='.encode_url('Requisitioners')
				.'&i='.encode_url($id)
				.'&pn='.encode_url('2')
				.'&r='.encode_url($id)
				.'&m='.encode_url($matcode)
				.'&d='.encode_url($rec_date)
				.'&rn='.encode_url($reference_no)
                    .'&b='.encode_url($brand)
                    .'&rd='.encode_url($rec_date);
				
				$error['url'] =  $add_link;
			}else{
				$error['error']= true;	
			}
		}else{
			$fdt ='';			
			$is_warranty	=htmlspecialchars(isset($_POST["unit_claimed_warranty"])? $_POST["unit_claimed_warranty"]: 0);
			$received_date	=htmlspecialchars($_POST["unit_received_date"]);
			$serial			=htmlspecialchars($_POST["unit_serial"]);
			$serial2		=htmlspecialchars($_POST["unit_serial2"]);			
			$asset_no		=htmlspecialchars(get_POST("unit_asset"));
			$matcode		=htmlspecialchars($_POST["unit_matcode"]);
			$reference_no	=htmlspecialchars($_POST["unit_reference_no"]);
			$brand			=htmlspecialchars($_POST["unit_brand"]);
			$requisitioner	=htmlspecialchars($_POST["unit_requisitioner"]);
			$notes			=trim(htmlspecialchars($_POST["unit_notes"]));
			
			if(!empty($is_warranty)){
				$is_warranty = ($is_warranty==='on')? '1': '0';
				$data['is_warranty'] =$is_warranty;
			}else{
				$data['is_warranty'] ='0';
			}
			if(empty($received_date)){			
				$error["unit_received_date"]='Received date is required.';
			}else{
				$data['date_inx'] =($received_date);
				$fdt = force_date($received_date);
				if(strtotime($fdt) < strtotime('1 year ago')){
					$error["unit_received_date"]='Please check received date '.$received_date.'--'.$fdt;
				}else{
					$data['date_in'] = $fdt;
				}
			}
			
			if(empty($serial)){			
				$error["unit_serial"]='Serial is required.';
			}else{
				$serial =strtoupper($serial);
				$data['serial'] =$serial;
			}
			if(!empty($serial2)){
				$data['serial_2'] =strtoupper($serial2);
			}
			if(!empty($asset_no)){
				$data['asset_no'] =strtoupper($asset_no);
			}		
			if(empty($brand)){			
				$error["unit_brand"]='Brand is required.';
			}else{
				$data['brand'] =$brand;
			}
			if(empty($requisitioner)){			
				$error["unit_requisitioner"]='Requisitioner is required.';
			}else{
				$data['requisitioner'] =$requisitioner;
			}
			if(!empty($matcode)){
				$data['matcode'] =$matcode;
			}
			if(!empty($reference_no)){
				$data['reference_no'] = strtoupper($reference_no);
			}
			if(!empty($notes)){
				$data['notes'] =$notes;
			}
			
			$data['date_modified'] = get_datetime();
			$data['unique_code'] = $serial.'_'.$fdt;
			
			if(count($error) <=0){
				$error['error']= false;	
				if($state==='u'){
					if($db->update($table,$data,"id= ".$id)){
						$error['error']= false;
						$error['message']='Selected item was succesfully updated.';
						
						$entry_data =array(
						'activity'=>'Update Entry',
						'description'=>'Update selected entry with serial '.$serial,
						'date_created'=>date('Y-m-d'),
						'time_created'=>date('h:i:s A'),
						'user_id'=> $auth->getUserid());
						$db->insert('pcm_activities',$entry_data);
				
					}else{
						$error['error']= true;
						$error['message']='No applied changes.';
					}						
				}else{
					if($db->exist($table,'serial',to_string($serial))){
						$old_date = $db->getValue($table,'date_in','serial='.to_string($serial));
						if($old_date===$fdt){
							$error['error']= true;
							$error['old_date']= $old_date;
							$error['message']='Already added into list.';
						}else{
							if($old_date<$fdt){		
								//if($db->update($table,$data,"serial= ".to_string($serial))){
								if($db->insert($table,$data)){
									$error['error']= false;
									$error['message']='Selected item was successfully updated.';
									
									$entry_data =array(
									'activity'=>'Add Entry',
									'description'=>'Add new entry with serial '.$serial,
									'date_created'=>date('Y-m-d'),
									'time_created'=>date('h:i:s A'),
									'user_id'=> $auth->getUserid());
									$db->insert('pcm_activities',$entry_data);
						
								}else{
									$error['error']= true;
									$error['message']='No applied changes.';
								}
							}else{
								$error['error']= true;
								$error['message']='Please check received date <strong class="text-blue">'.$fdt.'</strong> from last received date  <strong class="text-blue">'.$old_date.'</strong>';
							}
						}
					}else{
						if($db->insert($table,$data)){
							$error['message']='Item was successfully added.';
							$entry_data =array(
								'activity'=>'Add Entry',
								'description'=>'Add new entry with serial '.$serial,
								'date_created'=>date('Y-m-d'),
								'time_created'=>date('h:i:s A'),
								'user_id'=> $auth->getUserid());
							$db->insert('pcm_activities',$entry_data);
									
						}else{
							$error['error']= true;
							$error['message']='Adding new item was not successful.';
						}
					}
				}
				$error = array_merge($error,$data);
			}else{
				$error['error']= true;
			}
		}
		$error['state']= $state;			
	}else{
		$error['error']= true;
	}
	echo json_encode($error);
?>