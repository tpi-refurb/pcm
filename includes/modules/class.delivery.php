<?php
class Delivery
{
    private $db;
	public $config;
	
    public function __construct(\PDO $dbh, $config)
    {
        $this->db = $dbh;
		$this->config = $config;
    }	
	public function create_delivery($pdt){
		//$pdt = plain_date($dt);
		$sql ="CREATE TABLE IF NOT EXISTS `pcm_delivery_".$pdt."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `serial_id` int(11) DEFAULT NULL,
			  `status` int(11) DEFAULT NULL,
			  `remarks` varchar(255) DEFAULT NULL,
			  `dr` varchar(255) DEFAULT NULL,
			  `tsr` varchar(255) DEFAULT NULL,
			  `dr_no` varchar(45) DEFAULT NULL,
			  `test_power` varchar(45) DEFAULT NULL,
			  `test_fan` varchar(45) DEFAULT NULL,
			  `test_burn` varchar(45) DEFAULT NULL,
			  `technician` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$this->db->run($sql);
		$sql_view = "CREATE OR REPLACE VIEW `pcm_view_".$pdt."` AS
						SELECT 
							`pps`.`id` AS `id`,
							`pps`.`serial` AS `serial`,
							`pps`.`serial_2` AS `serial_2`,
							`pps`.`asset_no` AS `asset_no`,
							`pps`.`matcode` AS `matcode`,
							`pps`.`brand` AS `brand`,
							`pps`.`requisitioner` AS `requisitioner`,
							`pps`.`date_in` AS `date_in`,
							`pps`.`date_out` AS `date_out`,
							`pps`.`dr_no` AS `dr_no`,
							`pps`.`tpi_code` AS `tpi_code`,
							`pps`.`technician` AS `technician`,
							`pps`.`test_id` AS `test_id`,
							`pps`.`notes` AS `notes`,
							`pps`.`is_warranty` AS `is_warranty`,
							`pps`.`date_modified` AS `date_modified`,
							`pps`.`active` AS `active`,
							`pps`.`status_id` AS `status_id`,
							`pps`.`tech_id` AS `tech_id`,
							`pps`.`brand_name` AS `brand_name`,
							`pps`.`requisitioner_name` AS `requisitioner_name`,
							`pps`.`address` AS `address`,
							`pps`.`firstname` AS `firstname`,
							`pps`.`lastname` AS `lastname`,
							`pps`.`status` AS `status`,
							`pps`.`repaired_portion` AS `repaired_portion`,
							`pps`.`replaced_parts` AS `replaced_parts`,
                            `pps`.`date_repaired` AS `date_repaired`,
							`pps`.`color` AS `color`
						FROM
							(`pcm_delivery_".$pdt."` `ppd`
							JOIN `pcm_list` `pps` ON (((`ppd`.`serial_id` = `pps`.`id`)
								AND (`pps`.`status_id` = `ppd`.`status`))))";
		$this->db->run($sql_view);
	}
	
	public function print_latest_deliveries($is_admin){
		$rs = $this->db->getTables('pcm',"LIKE 'pcm_delivery_%';");
		if(count($rs)>0){
			$total_count  =0;
			foreach($rs as $r){
				$tbl = $r[0];
								
				if(strpos($tbl,'pcm_delivery_')!== false){
					$trm_tbl = str_replace('pcm_delivery_','',$tbl);
					$view = str_replace('pcm_delivery_','pcm_view_',$tbl);
					
					$split_dt = explode('_',$trm_tbl);
					$pdt =  $split_dt[0];
					$st =  $split_dt[1];
					$bt =  $split_dt[2];
					$rt =  $split_dt[3];
					$sp =  $split_dt[4];				
					$fdt = force_date($pdt);						
					//if(strtotime($fdt) > strtotime('2 month ago')){
					if(strtotime($fdt) > strtotime('5 year ago')){						
						$full_dt = full_date($fdt);					
						$enable_update ='';
						if($is_admin){
							$enable_update ='<a class="btn  btn-rounded btn-sm btn-flat btn-alt waves-button waves-effect" href="#"><span class="icon icon-edit"></span></a>';
						}
						echo '<li><a href="#">'.$full_dt.'</a>'.$enable_update.'</li>';
					}
				}
			}
		}
	}
	
	public function print_deliveries_summary($dt,$st,$bt,$rt,$sp,$is_admin){
		$pdt = plain_date($dt);
		$table_suffix =$pdt.'_'.$st.'_'.$bt.'_'.$rt.'_'.$sp;
		$table ='pcm_view_'.$table_suffix;
		$q ="SELECT * FROM ".$table;
		$rs = $this->db->getResults($q);
		if(count($rs) >0){
			echo '<table class="table item-info">
				<tr>
					<td><strong>Serial</strong></td>
					<td><strong>Date Received</strong></td>
					<td><strong>Delete</strong></td>
				</tr>';
			
			foreach($rs as $r){
				$id= $r['id'];
				$serial= $r['serial'];
				$date_in= $r['date_in'];
				$status= $r['status'];
				echo '<tr class="no-border-except-b">
					<td>'.$serial.'</td>
					<td>'.$date_in.'</td>
					<td><a class="btn  btn-flat btn-red btn-sm waves-button waves-effect delete_serial_to" id="del_'.($id).'"><span class="icon icon-delete"></span>Remove</a></td>
				</tr>';
			}
			echo '</table>';
		}
		
	}
	
	public function print_deliveries($is_admin){
		$rs = $this->db->getTables('pcm',"LIKE 'pcm_delivery_%';");
		$tables_array =array();
		if(count($rs)>0){
			$total_count  =0;
			foreach($rs as $r){
				$tbl = $r[0];								
				if(strpos($tbl,'pcm_delivery_')!== false){
					$trm_tbl = str_replace('pcm_delivery_','',$tbl);
					$view = str_replace('pcm_delivery_','pcm_view_',$tbl);					
					$split_dt = explode('_',$trm_tbl);
					$pdt =  $split_dt[0];
					$st =  $split_dt[1];
					$bt =  $split_dt[2];
					$rt =  $split_dt[3];
					$sp =  $split_dt[4];
					$fdt = force_date($pdt);
					$tables_array[]=array(
					"tbl" => $tbl,
					"trim_tbl"  => $trm_tbl,
					"view"  => $view,
					"date"  => $fdt,
					"pdt"  => $pdt,
					"st"  => $st,
					"bt"  => $bt,
					"rt"  => $rt,
					"sp"  => $sp
					);
				}
				
			}
			$reverse_array = array_reverse($tables_array);
			$last = count($reverse_array) - 1;
			foreach ($reverse_array as $i => $row){
				$isFirst = ($i == 0);
				$isLast = ($i == $last);
				//echo  $i."   ".$row['tbl']."----- ". $row['date']."<br>";
				
				$tbl = $row['tbl'];
				$trim_tbl = $row['trim_tbl'];
				$view = $row['view'];
				$fdt = $row['date'];
				$pdt = $row['pdt'];
				$split_dt = explode('_',$trm_tbl);
				//$pdt =  $split_dt[0];
				$st =  $row['st'];
				$bt =  $row['bt'];
				$rt = $row['rt'];
				$sp = $row['sp'];
				
				$status = $this->db->getValue('pcm_status','status','id='.$st);
				$color  = $this->db->getValue('pcm_status','icolor','id='.$st);
				$brand  = $this->db->getValue('pcm_brands','brand_name','id='.$bt);
				$requisitioner  = $this->db->getValue('pcm_requisitioners','requisitioner','id='.$rt);
				
				$splitted ='';
				if(empty($sp)){
				}else{
					$splitted ='<span class="avatar avatar-xxs avatar-blue pull-right">'.$sp.'</span>';
				}
				//if(strtotime($fdt) > strtotime('5 month ago')){
				if(strtotime($fdt) > strtotime('5 year ago')){
					if($this->db->tableExist($view)){
						echo '<tr>';
						$q ="SELECT * FROM ".$view;
						$q_dr_no = "SELECT distinct(dr_no) FROM ".$view;
						$rs = $this->db->getResults($q);
						$dr_rs = $this->db->getResults($q_dr_no);
						$count =count($rs);

						$print_dr_number = '';
						if(count($dr_rs)>0){
							$dr_number = $dr_rs[0]['dr_no'];
							$print_dr_number= '<strong class="label label-alt pull-right" style="font-size:14px;">'.$dr_number.'</strong>';
						}
						
						$full_dt = full_date($pdt);	
						echo '<td>'.$full_dt.'<span class="avatar avatar-xs avatar-green pull-right">'.$count.'</span>'.$splitted.$print_dr_number.' </td>';
						
						$serials ='';
						$completed_icon ='';
						$with_warning = false;
						$no_dr = 0;
						if($count >0){
							foreach($rs as $r){
								$id		= $r['id'];
								$serial = $r['serial'];
								$dr_no = $r['dr_no'];
								
								$dr_warning ='';
								if(empty($dr_no)){
									$no_dr +=1;
									$dr_warning ='<small class=" text-red animated infinite flash pull-right"><span class="icon icon-error"></span>No D.R. Number</small>';
								}
								
								$enable_delete ='';
								//if($is_admin){
								//	$enable_delete ='<a class="btn  btn-rounded btn-sm btn-flat btn-red waves-button waves-effect" href="#"><span class="icon icon-close"></span></a>';
								//}
								
								if($is_admin){
									$enable_delete ='<span class="icon icon-cancel waves-button waves-effect text-red this-is-link delete_deliver_serial" id="del_'.encode_url($id).'"></span>';
								}
								$serials = $serials .'<br>'.($serial.' '.$dr_warning);
							}
							$completed_icon ='<span class="avatar avatar-xs avatar-alt"><span class="icon icon-check"></span></span>';
						}else{
							$completed_icon ='<span class="avatar avatar-xs avatar-red"><span class="icon icon-warning"></span></span>';
						}
						$total_count = $total_count +1;
						echo '<td><strong style="color:'.$color.';">'.$status.'</strong></td>';						
						echo '<td>'.$brand.'</td>';							
						echo '<td>'.$requisitioner.'</td>';	
						
						
						if($no_dr >0){
							$completed_icon ='<span class="avatar avatar-xs avatar-red"><span class="icon icon-warning"></span></span>';
						}
						
						echo '<td>'.$completed_icon.'</td>';	
						
						$enable_add = '';
						$action_buttons = '';
						if($is_admin){
							$add_link = 'index.php?p='.encode_url('20').'&s='.encode_url('a').'&dt='.encode_url($fdt).'&st='.encode_url($st).'&bt='.encode_url($bt).'&rt='.encode_url($rt).'&sp='.encode_url($sp);
							$cdr_link = 'includes/exports/dr.php?p='.encode_url('20').'&s='.encode_url('s').'&dt='.encode_url($fdt).'&st='.encode_url($st).'&bt='.encode_url($bt).'&rt='.encode_url($rt).'&sp='.encode_url($sp).'&tb='.encode_url($view); 
							$ctsr_link = 'index.php?p='.encode_url('20').'&s='.encode_url('c').'&dt='.encode_url($fdt).'&st='.encode_url($st).'&bt='.encode_url($bt).'&rt='.encode_url($rt).'&sp='.encode_url($sp).'&tb='.encode_url($view);


							$is_lock = $this->db->getValue('pcm_deliveries','is_lock',"delivery_table ='".$tbl."'");
							if(empty($is_lock)){
								$enable_add ='<a class="btn btn-flat btn-alt btn-xs waves-button waves-effect" href="'.$add_link.'"><span class="icon icon-add"></span>Add Serial</a>';
							}else{
								$del_id = $this->db->getValue('pcm_deliveries','id',"delivery_table ='".$tbl."'");
								$enable_add ='<a class="btn btn-flat btn-alt btn-xs waves-button waves-effect unlock_delivery" id="del_'.encode_url($del_id).'" state="'.encode_url('0').'"><span class="icon icon-lock"></span>Unlock</a>';
							}

							$action_buttons = '<br>'.$enable_add.'
							<a class="btn btn-flat btn-blue btn-xs waves-button waves-effect" href="'.$cdr_link.'" target="_blank"><span class="icon icon-assignment-turned-in"></span>Print DR</a>
							<a class="btn btn-flat btn-green btn-xs waves-button waves-effect" href="'.$ctsr_link.'"><span class="icon icon-description"></span>Create TSR</a>
							<a class="btn btn-flat btn-alt btn-xs waves-button waves-effect" href="'.$cdr_link.'"><span class="icon icon-assignment-ind"></span>Update Delivery Info</a>';
						}else{
							$userid	= isset($_COOKIE[$this->config->cookie_userid])? decode_url($_COOKIE[$this->config->cookie_userid]):'';
							if(!empty($userid)){
								$level	= $this->db->getValue('users_group','group_name','id='.$userid);
								if(strtolower($level)==='encoder'){
									$add_link = 'index.php?p='.encode_url('20').'&s='.encode_url('a').'&dt='.encode_url($fdt).'&st='.encode_url($st).'&bt='.encode_url($bt).'&rt='.encode_url($rt).'&sp='.encode_url($sp);

									$action_buttons = '<br>
									<a class="btn btn-flat btn-alt btn-xs waves-button waves-effect" href="'.$add_link.'"><span class="icon icon-add"></span>Add Serial</a>';
								}
							}
						}
						echo '<td>'.$serials.'<br>'.$action_buttons.'</td>';
						echo '</tr>';
						
						
					}else{ //end if($this->db->tableExist($view)){
						echo '<tr><td>Not exist view!.</td></tr>';
					}
				} // End of if(strtotime($fdt) > strtotime('5 month ago')){
						
			}
		}
		
	}
	
	
	public function print_deliveries_xxxxx($is_admin){
		$rs = $this->db->getTables('pcm',"LIKE 'pcm_delivery_%';");
		if(count($rs)>0){
			$total_count  =0;
			foreach($rs as $r){
				$tbl = $r[0];
								
				if(strpos($tbl,'pcm_delivery_')!== false){
					$trm_tbl = str_replace('pcm_delivery_','',$tbl);
					$view = str_replace('pcm_delivery_','pcm_view_',$tbl);
					
					$split_dt = explode('_',$trm_tbl);
					$pdt =  $split_dt[0];
					$st =  $split_dt[1];
					$bt =  $split_dt[2];
					$rt =  $split_dt[3];
					$sp =  $split_dt[4];
					
					$status = $this->db->getValue('pcm_status','status','id='.$st);
					$color  = $this->db->getValue('pcm_status','icolor','id='.$st);
					$brand  = $this->db->getValue('pcm_brands','brand_name','id='.$bt);
					$requisitioner  = $this->db->getValue('pcm_requisitioners','requisitioner','id='.$rt);
					
					$fdt = force_date($pdt);
					
					$splitted ='';
					if(empty($sp)){
					}else{
                        $splitted ='<span class="avatar avatar-xxs avatar-blue pull-right">'.$sp.'</span>';
                    }
					if(strtotime($fdt) > strtotime('5 month ago')){
						if($this->db->tableExist($view)){
							echo '<tr>';
							$q ="SELECT * FROM ".$view;
                            $q_dr_no = "SELECT distinct(dr_no) FROM ".$view;
                            $rs = $this->db->getResults($q);
                            $dr_rs = $this->db->getResults($q_dr_no);
                            $count =count($rs);

                            $print_dr_number = '';
                            if(count($dr_rs)>0){
                                $dr_number = $dr_rs[0]['dr_no'];
                                $print_dr_number= '<strong class="label label-alt pull-right" style="font-size:14px;">'.$dr_number.'</strong>';
                            }
							
							$full_dt = full_date($pdt);	
							echo '<td>'.$full_dt.'<span class="avatar avatar-xs avatar-green pull-right">'.$count.'</span>'.$splitted.$print_dr_number.' </td>';
							
							$serials ='';
							$completed_icon ='';
							$with_warning = false;
							$no_dr = 0;
							if($count >0){
								foreach($rs as $r){
									$id		= $r['id'];
									$serial = $r['serial'];
									$dr_no = $r['dr_no'];
									
									$dr_warning ='';
									if(empty($dr_no)){
										$no_dr +=1;
										$dr_warning ='<small class=" text-red animated infinite flash pull-right"><span class="icon icon-error"></span>No D.R. Number</small>';
									}
									
									$enable_delete ='';
									//if($is_admin){
									//	$enable_delete ='<a class="btn  btn-rounded btn-sm btn-flat btn-red waves-button waves-effect" href="#"><span class="icon icon-close"></span></a>';
									//}
									
									if($is_admin){
										$enable_delete ='<span class="icon icon-cancel waves-button waves-effect text-red this-is-link delete_deliver_serial" id="del_'.encode_url($id).'"></span>';
									}
									$serials = $serials .'<br>'.($serial.' '.$dr_warning);
								}
								$completed_icon ='<span class="avatar avatar-xs avatar-alt"><span class="icon icon-check"></span></span>';
							}else{
								$completed_icon ='<span class="avatar avatar-xs avatar-red"><span class="icon icon-warning"></span></span>';
							}
							$total_count = $total_count +1;
							echo '<td><strong style="color:'.$color.';">'.$status.'</strong></td>';						
							echo '<td>'.$brand.'</td>';							
							echo '<td>'.$requisitioner.'</td>';	
							
							
							if($no_dr >0){
								$completed_icon ='<span class="avatar avatar-xs avatar-red"><span class="icon icon-warning"></span></span>';
							}
							
							echo '<td>'.$completed_icon.'</td>';	
							
							$enable_add = '';
                            $action_buttons = '';
							if($is_admin){
								$add_link = 'index.php?p='.encode_url('20').'&s='.encode_url('a').'&dt='.encode_url($fdt).'&st='.encode_url($st).'&bt='.encode_url($bt).'&rt='.encode_url($rt).'&sp='.encode_url($sp);
								$cdr_link = 'includes/exports/dr.php?p='.encode_url('20').'&s='.encode_url('s').'&dt='.encode_url($fdt).'&st='.encode_url($st).'&bt='.encode_url($bt).'&rt='.encode_url($rt).'&sp='.encode_url($sp).'&tb='.encode_url($view); 
								$ctsr_link = 'index.php?p='.encode_url('20').'&s='.encode_url('c').'&dt='.encode_url($fdt).'&st='.encode_url($st).'&bt='.encode_url($bt).'&rt='.encode_url($rt).'&sp='.encode_url($sp).'&tb='.encode_url($view);


                                $is_lock = $this->db->getValue('pcm_deliveries','is_lock',"delivery_table ='".$tbl."'");
                                if(empty($is_lock)){
                                    $enable_add ='<a class="btn btn-flat btn-alt btn-xs waves-button waves-effect" href="'.$add_link.'"><span class="icon icon-add"></span>Add Serial</a>';
                                }else{
                                    $del_id = $this->db->getValue('pcm_deliveries','id',"delivery_table ='".$tbl."'");
                                    $enable_add ='<a class="btn btn-flat btn-alt btn-xs waves-button waves-effect unlock_delivery" id="del_'.encode_url($del_id).'" state="'.encode_url('0').'"><span class="icon icon-lock"></span>Unlock</a>';
                                }

                                $action_buttons = '<br>'.$enable_add.'
								<a class="btn btn-flat btn-blue btn-xs waves-button waves-effect" href="'.$cdr_link.'" target="_blank"><span class="icon icon-assignment-turned-in"></span>Print DR</a>
								<a class="btn btn-flat btn-green btn-xs waves-button waves-effect" href="'.$ctsr_link.'"><span class="icon icon-description"></span>Create TSR</a>
								<a class="btn btn-flat btn-alt btn-xs waves-button waves-effect" href="'.$cdr_link.'"><span class="icon icon-assignment-ind"></span>Update Delivery Info</a>';
							}else{
								$userid	= isset($_COOKIE[$this->config->cookie_userid])? decode_url($_COOKIE[$this->config->cookie_userid]):'';
								if(!empty($userid)){
									$level	= $this->db->getValue('users_group','group_name','id='.$userid);
									if(strtolower($level)==='encoder'){
										$add_link = 'index.php?p='.encode_url('20').'&s='.encode_url('a').'&dt='.encode_url($fdt).'&st='.encode_url($st).'&bt='.encode_url($bt).'&rt='.encode_url($rt).'&sp='.encode_url($sp);

                                        $action_buttons = '<br>
										<a class="btn btn-flat btn-alt btn-xs waves-button waves-effect" href="'.$add_link.'"><span class="icon icon-add"></span>Add Serial</a>';
									}
								}
							}
							echo '<td>'.$serials.'<br>'.$action_buttons.'</td>';
							echo '</tr>';
							
							
						}else{ //end if($this->db->tableExist($view)){
                            echo '<tr><td>Not exist view!.</td></tr>';
                        }
					} // End of if(strtotime($fdt) > strtotime('5 month ago')){
				}else{
                    //echo '<tr><td>'.$tbl.' -->No pcm delivery found!.</td></tr>';
                }
				
			}
		}else{
           echo '<tr><td>No delivery found!.</td></tr>';
        }
		
	}
	
	
	
	
	function check_delivery($is_admin){
		$rs = $this->db->getTables('pcm',"LIKE 'pcm_delivery_%';");
		if(count($rs)>0){
			$total_count  =0;
			foreach($rs as $r){
				$tbl = $r[0];
								
				if(strpos($tbl,'pcm_delivery_')!== false){
					$trm_tbl = str_replace('pcm_delivery_','',$tbl);
					$view = str_replace('pcm_delivery_','pcm_view_',$tbl);
					
					$split_dt = explode('_',$trm_tbl);
					$dt =  $split_dt[0];
					$fdt = force_date($dt);
					
					//if(strtotime($fdt) < strtotime('5 day ago')){
					if(strtotime($fdt) < strtotime('5 year ago')){
						$rs = $this->db->getResults("SELECT * FROM ".$tbl);
						if(count($rs)<=0){
							$this->db->run('DROP VIEW IF EXISTS '.$view);
							$this->db->run('DROP TABLE IF EXISTS '.$tbl);
						}else{
                            if($this->db->exist('pcm_deliveries','delivery_table',to_string($tbl))){
                                $this->db->update('pcm_deliveries',array('date_out'=>$fdt,'delivery_table'=>$tbl,'is_lock'=>1),'delivery_table='.to_string($tbl));
                            }else{
                                $this->db->insert('pcm_deliveries',array('date_out'=>$fdt,'delivery_table'=>$tbl,'is_lock'=>1));
                            }
                        }
					}else{
                        if(!$this->db->exist('pcm_deliveries','delivery_table',to_string($tbl))){
                            $this->db->insert('pcm_deliveries',array('date_out'=>$fdt,'delivery_table'=>$tbl));
                        }
                    }
				}
			}
		}
	}


    function delivery_noDR($is_admin){
        $rs = $this->db->getTables('pcm',"LIKE 'pcm_delivery_%';");
        if(count($rs)>0){
            $total_count  =0;
            foreach($rs as $r){
                $tbl = $r[0];
                if(strpos($tbl,'pcm_delivery_')!== false){
                    $trm_tbl = str_replace('pcm_delivery_','',$tbl);
                    $view = str_replace('pcm_delivery_','pcm_view_',$tbl);

                    $split_dt = explode('_',$trm_tbl);
                    $dt =  $split_dt[0];
                    $fdt = force_date($dt);

                    if(strtotime($fdt) < strtotime('2 day ago')){
                        $rows = $this->db->getResults("SELECT * FROM ".$tbl);
                        if(count($rows)<=0){
                            foreach($rows as $row){

                            }
                        }
                    }
                }
            }
        }
    }

    function print_select_delivery($is_admin){
		$rs = $this->db->getTables('pcm',"LIKE 'pcm_delivery_%';");
		if(count($rs)>0){
			$total_count  =0;
			foreach($rs as $r){
				$tbl = $r[0];
								
				if(strpos($tbl,'pcm_delivery_')!== false){
					$trm_tbl = str_replace('pcm_delivery_','',$tbl);
					$view = str_replace('pcm_delivery_','pcm_view_',$tbl);
					
					$split_dt = explode('_',$trm_tbl);
					$pdt =  $split_dt[0];
					$st =  $split_dt[1];
					$bt =  $split_dt[2];
					$rt =  $split_dt[3];
					$sp =  $split_dt[4];
					
					$status = $this->db->getValue('pcm_status','status','id='.$st);
					$color  = $this->db->getValue('pcm_status','icolor','id='.$st);
					$brand  = $this->db->getValue('pcm_brands','brand_name','id='.$bt);
					$requisitioner  = $this->db->getValue('pcm_requisitioners','requisitioner','id='.$rt);
					
					$fdt = force_date($pdt);
					
					$splitted ='';
					if(!empty($sp)){
						$splitted ='<span class="text-alt">_ Group:'.$sp.'</span>';
					}
					if(strtotime($fdt) > strtotime('1 year ago')){					
						$is_lock = $this->db->getValue('pcm_deliveries','is_lock','delivery_table ='.to_string($tbl));
                        if(empty($is_lock)){
                            $full_dt = full_date($pdt);
                            echo '<option value="'.$tbl.'">'.$full_dt.' Status: '.$status.' - '.$brand.$splitted .'</option>';
                        }
					}
				}
			}
		}
	}
	function print_top_search(){
		$q ="SELECT * FROM pcm_search ORDER BY count DESC limit 5;";
		$rs = $this->db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				$keyword = $r['keyword'];
				echo '<li><a href="javascript:void(0)">'.$keyword.'</a></li>';
			}
		}
	}

    function shuffle_arrays($parts = array()){
        shuffle($parts);
        return implode(', ', $parts);
    }
    function get_random_parts($parts = array()){
        $max_length = count($parts);
        $length = $max_length;
        if($max_length >10){
            $length = rand($max_length-2, $max_length);
        }
        $random_keys =array_rand($parts,$length);
        $results = array();
        for ($i =0; $i < count($random_keys); $i++){
            $results[$i]=$parts[$random_keys[$i]];
        }

        return implode(', ', $results);

    }
	
	function sortFunction( $a, $b ) {
		return strtotime($a["date"]) - strtotime($b["date"]);
	}
}

?>
