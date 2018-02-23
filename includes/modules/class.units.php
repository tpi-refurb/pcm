<?php
class Units
{
    private $db;
	private $config;
	
    public function __construct(\PDO $dbh,$cfg)
    {
        $this->db = $dbh;
		$this->config = $cfg;
    }	
	
	function is_image($path){
		$a =$image_type='';
		try{
			$a = getimagesize($path);
			$image_type = $a[2];
		}catch(Exception $e){
			return false;
		}				
		if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP))){
			return true;
		}
		return false;
	}

    function print_statistics(){
        $query_list = array();
        $query_list['All units'] ="SELECT * FROM pcm_list WHERE active =1";
        $query_list['Active units'] ="SELECT * FROM pcm_statistics_underrepair";
        $query_list['Repaired units'] ="SELECT * FROM pcm_statistics_repaired";
        $query_list['Units without defect'] ="SELECT * FROM pcm_statistics_nodefect";
        $query_list['Units that are beyond repair'] ="SELECT * FROM pcm_statistics_beyondrepair";
        $query_list['Units that have been claimed for warranty'] ="SELECT * FROM pcm_statistics_claimedwarranty";
        $query_list['Units that are still within warranty'] ="SELECT * FROM pcm_statistics_withinwarranty";
        $query_list['empty'] ="";
        $query_list['Repaired units without D.R. No.'] ="SELECT * FROM pcm_statistics_repaired_nodr";
        $query_list['Repaired units without TPI Code/Sticker Code.'] ="SELECT * FROM pcm_statistics_repaired_notpicode";

        foreach($query_list as $desc =>$query){
            if($desc==='empty'){
                //echo '<tr><td></td><td></td></tr>';
                echo '<tr ><td colspan="2" style="background-color: #fafafa"></td></tr>';
            }else{
                $rs = $this->db->getResults($query);
                $view_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url($desc).'&i='.encode_url($query);
                echo '<tr>
						<td>'.$desc.'</td>
						<td><a href="'.$view_link.'"><span class="avatar avatar-alt avatar-xs"><strong>'.count($rs).'</strong></span></a></td>
					</tr>';
            }
        }

    }

    function print_brand_summary(){
        $bran_query ="SELECT * FROM pcm_brands ORDER BY brand_name ASC";
        $rs = $this->db->getResults($bran_query);
        foreach($rs as $r){
            $id= $r['id'];
            $brand_name= $r['brand_name'];
            $total_query ="SELECT * FROM pcm_list WHERE active =1 AND brand=".$id;
            $repaired_query ="SELECT * FROM pcm_statistics_repaired WHERE brand=".$id;
            $for_repair_query ="SELECT * FROM pcm_statistics_notrepaired WHERE brand=".$id;
            $beyond_repair_query ="SELECT * FROM pcm_statistics_beyondrepair WHERE brand=".$id;
            $return_query ="SELECT * FROM pcm_statistics_return WHERE brand=".$id;
            $others_query ="SELECT * FROM pcm_statistics_others WHERE brand=".$id;

            $summary_link = 'index.php?p='.encode_url('23').'&s='.encode_url('v').'&l='.encode_url('Brands').'&i='.encode_url($id);
            $total_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url('All '.$brand_name).'&b='.encode_url($id).'&pss='.encode_url("ALL").'&i='.encode_url($total_query);
            $repair_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url('Repaired '.$brand_name).'&b='.encode_url($id).'&pss='.encode_url("REPAIRED").'&i='.encode_url($repaired_query);
            $forrepair_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url('For Repair '.$brand_name).'&b='.encode_url($id).'&pss='.encode_url("UNDER REPAIR").'&i='.encode_url($for_repair_query);
			$beyondrepair_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url('Beyond Repair '.$brand_name).'&b='.encode_url($id).'&pss='.encode_url("BEYOND REPAIR").'&i='.encode_url($beyond_repair_query);
			$returned_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url('Returned '.$brand_name).'&b='.encode_url($id).'&pss='.encode_url("RETURNED").'&i='.encode_url($return_query);
			$others_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url('Others '.$brand_name).'&b='.encode_url($id).'&pss='.encode_url("OTHERS").'&i='.encode_url($others_query);

            $total          = $this->db->getResults($total_query);
            $repaired       = $this->db->getResults($repaired_query);
            $under_repair   = $this->db->getResults($for_repair_query);
            $beyond_repair   = $this->db->getResults($beyond_repair_query);
            $returned   = $this->db->getResults($return_query);
            $others   = $this->db->getResults($others_query);
            $completed_icon = "";
			$show_underepair_link ="";
			
			$total_summ = intval(count($repaired))+ intval(count($beyond_repair))+ intval(count($returned))+ intval(count($others));
			if($total_summ===count($total)){				
				$completed_icon = '<span class="avatar avatar-xxs avatar-alt pull-right"><span class="icon icon-check"></span></span>';
			}else {
				$completed_icon ='<span class="avatar avatar-xxs avatar-red pull-right"><span class="icon icon-warning"></span></span>';
			}
			
			$label_under_repair= (count($under_repair)>0)? '<strong class="text-red">'.count($under_repair).'</strong>':'';
			$label_beyond_repair= (count($beyond_repair)>0)? '<strong class="text-blue">'.count($beyond_repair).'</strong>':'';
			$label_return= (count($returned)>0)? '<strong class="text-yellow">'.count($returned).'</strong>':'';
			$label_others= (count($others)>0)? '<strong class="text-purple">'.count($others).'</strong>':'';
			
            echo '<tr>
						<td><a href="'.$summary_link.'">'.$brand_name.'</a></td>
						<td><a href="'.$total_link.'"><strong class="text-black">'.count($total).'</strong></a></td>
						<td><a href="'.$repair_link.'"><strong class="text-alt">'.count($repaired).'</strong></a></td>
						<td><a href="'.$forrepair_link.'">'.$label_under_repair.'</a></td>
						<td><a href="'.$beyondrepair_link.'">'.$label_beyond_repair.'</a></td>
						<td><a href="'.$returned_link.'">'.$label_return.'</a></td>
						<td><a href="'.$others_link.'">'.$label_others.'</a>	
						'.$completed_icon.'
						</td>
					</tr>';

        }
    }

    function print_brand_statistics($id){
        $query_list = array();
        $query_list['empty'] ="";
        $query_list['Total units'] ="SELECT * FROM pcm_list WHERE active =1 AND brand=".$id;
        $query_list['Repaired units'] ="SELECT * FROM pcm_statistics_repaired WHERE brand=".$id;
        $query_list['For Repair/Under Repair'] ="SELECT * FROM pcm_statistics_notrepaired WHERE brand=".$id;
        $query_list['empty_2'] ="";

        foreach($query_list as $desc =>$query){
            if(strpos($desc,'empty')!==false){
                //echo '<tr><td></td><td></td></tr>';
                echo '<tr ><td colspan="2" style="background-color: #fafafa"></td></tr>';
            }else{
                $rs = $this->db->getResults($query);
                $view_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url($desc).'&i='.encode_url($query);
                echo '<tr>
						<td>'.$desc.'</td>
						<td><a href="'.$view_link.'"><span class="avatar avatar-alt avatar-xs"><strong>'.count($rs).'</strong></span></a></td>
					</tr>';
            }
        }
        $query_list = array();
        $q = "SELECT DISTINCT date_in, DATE_FORMAT(date_in, '%M %d, %Y') AS `long_date_in` FROM pcm_serials WHERE brand = ".$id." ORDER BY date_in";
        $rs = $this->db->getResults($q);
        foreach($rs as $r) {
            $query_list['Received Date <strong class="text-alt">'.$r['long_date_in'].'</strong>'] ="SELECT * FROM pcm_list WHERE date_in ='".$r['date_in']."' AND brand=".$id;
        }

        foreach($query_list as $desc =>$query){
            if(strpos($desc,'empty')!==false){
                echo '<tr ><td colspan="2" style="background-color: #fafafa"></td></tr>';
            }else{
				$all_query = $query." ORDER BY reference_no, status_id, serial ASC;";
                $repair_query = $query." AND UCASE(status)='REPAIRED'  ORDER BY reference_no, status_id, serial ASC;";
                $underrepair_query = $query." AND UCASE(status)<> 'REPAIRED'  ORDER BY reference_no, status_id, serial ASC;";
                $rs = $this->db->getResults($all_query);
                $rrs = $this->db->getResults($repair_query);
                $urrs = $this->db->getResults($underrepair_query);
				
	
                $view_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url($desc).'&i='.encode_url($all_query).'&b='.encode_url($id).'&pss='.encode_url("ALL");
                $rview_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url($desc).'&i='.encode_url($repair_query).'&b='.encode_url($id).'&pss='.encode_url("REPAIRED");
                $urview_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url($desc).'&i='.encode_url($underrepair_query).'&b='.encode_url($id).'&pss='.encode_url("UNDER REPAIR");
                
				$indi_status = "";
				if(count($urrs)>0){
					if(count($rs)==count($urrs)){
						$indi_status ='<span class="avatar avatar-xxs avatar-red pull-right"><span class="icon icon-warning"></span></span>';
					}else{
					$indi_status =	   ' <a href="'.$urview_link.'" class="pull-right"><span class="avatar avatar-red avatar-xs"><strong>'.count($urrs).'</strong></span></a>
						    <a href="'.$rview_link.'" class="pull-right"><span class="avatar avatar-green avatar-xs"><strong>'.count($rrs).'</strong></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					}
				}else{
					$indi_status ='<span class="avatar avatar-xxs avatar-alt pull-right"><span class="icon icon-check"></span></span>';
				}
				
				echo '<tr>
						<td>'.$desc.'</td>
						<td>
						    <a href="'.$view_link.'"><span class="avatar avatar-alt avatar-xs"><strong>'.count($rs).'</strong></span></a>
							'.$indi_status.'
					   </td>
					</tr>';
            }
        }
    }

    function print_latest_activities($is_admin,$view){
		$q ="SELECT * FROM pcm_user_activities ORDER BY id DESC limit 10;";
        if($view==='all'){
            $q ="SELECT * FROM pcm_user_activities ORDER BY id DESC;";
        }
		$rs = $this->db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				$activity = $r['activity'];
				$description = $r['description'];
				$date_created = $r['date_created'];
				$time_created = $r['time_created'];
				$username = $r['username'];
				$fullname = $r['fullname'];
				$avatar = $r['avatar'];
				$avatar_color = $r['avatar_color'];
				
				$time_summ = get_time_difference($date_created.' '.$time_created);

                $print_msg= '<li><strong class="text-alt">'.$fullname.'</strong> '.$description.' <small class="text-green">'.$time_summ.'</small></li>';

                if($view==='all'){
                    echo '<tr><td>'.$print_msg.'</td></tr>';
                }else{
                    echo $print_msg;
                }

            }
		}else{
			echo '<h6 class="text-red text-center">No activities found!</h6>';
		}
	}
	
	function print_latest_search(){
		$q ="SELECT * FROM pcm_search ORDER BY id DESC limit 5;";
		$rs = $this->db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				$keyword = $r['keyword'];
				echo '<li><a href="index.php?p='.encode_url('11').'&q='.encode_url($keyword).'">'.$keyword.'</a></li>';
			}
		}else{
			echo '<h6 class="text-red text-center">No latest search found!</h6>';
		}
	}
	
	function print_top_search(){
		$q ="SELECT * FROM pcm_search ORDER BY count DESC limit 5;";
		$rs = $this->db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				$keyword = $r['keyword'];
				echo '<li><a href="index.php?p='.encode_url('11').'&q='.encode_url($keyword).'">'.$keyword.'</a></li>';
			}
		}else{
			echo '<h6 class="text-red text-center">No top searched!</h6>';
		}
	}

    function print_latest_entries($is_admin){
        $q ="SELECT * FROM pcm_serials WHERE active =1 ORDER BY id DESC limit 10;";
        $rs = $this->db->getResults($q);
        if(count($rs)>0){
            foreach($rs as $r){
                $id = $r['id'];
                $serial = $r['serial'];
                $asset = $r['asset_no'];
                if(empty($serial)){
                    $serial = $asset;
                }
                $log_link = 'index.php?p='.encode_url('16').'&s='.encode_url('v').'&i='.encode_url($id);
                $link = 'index.php?p='.encode_url('12').'&s='.encode_url('u').'&i='.encode_url($id);

                $enable_update ='';
                if($is_admin){
                    $enable_update ='<a class="btn  btn-rounded btn-sm btn-flat btn-alt waves-button waves-effect" href="'.$link.'"><span class="icon icon-edit"></span></a>';
                }
                echo '<li><a href="'.$log_link.'">'.$serial.'</a>'.$enable_update.'</li>';
            }
        }else{
            echo '<h6 class="text-red text-center">No latest entry!</h6>';
        }
    }

    function print_tiled_latest_entries($is_admin){
        $q ="SELECT * FROM pcm_serials WHERE active =1 ORDER BY id DESC limit 10;";
        $rs = $this->db->getResults($q);
        if(count($rs)>0){
            echo '<div class="tile-wrap">';
            foreach($rs as $r){
                $id = $r['id'];
                $serial = $r['serial'];
                $asset = $r['asset_no'];
                if(empty($serial)){
                    $serial = $asset;
                }

                $log_link = 'index.php?p='.encode_url('16').'&s='.encode_url('v').'&i='.encode_url($id);
                $link = 'index.php?p='.encode_url('12').'&s='.encode_url('u').'&i='.encode_url($id);
                $delete_link = 'index.php?p='.encode_url('12').'&s='.encode_url('d').'&i='.encode_url($id);
                $status_link = 'index.php?p='.encode_url('11').'&s='.encode_url('u').'&i='.encode_url($id).'&sn='.encode_url($serial);

                $enable_update ='';
                if($is_admin){
                    $enable_update ='
                    <a class="btn btn-sm btn-flat btn-alt waves-button waves-effect" href="'.$link.'"><span class="icon icon-edit"></span></a>
                    <a class="btn btn-sm btn-flat btn-red waves-button waves-effect" href="'.$delete_link.'"><span class="icon icon-delete"></span></a>
                    <a class="btn btn-sm btn-flat btn-alt waves-button waves-effect" href="'.$status_link.'"><span class="icon icon-speaker-notes"></span></a>
                   ';
                }

                echo '<div class="tile">
                        <div class="pull-right tile-side">
                            <!--<span class="icon icon-quick-contacts-mail icon-lg text-alt"></span>-->
                            '.$enable_update.'
                        </div>
                        <div class="tile-inner">
                            <span><a href="'.$log_link.'" >'.$serial.'</a></span>
                        </div>
                    </div>';
            }
            echo '</div>';
        }else{
            echo '<h6 class="text-red text-center">No latest entry!</h6>';
        }
    }

    function print_latest_updates($is_admin){
		$q ="SELECT * FROM pcm_serials WHERE active =1 ORDER BY date_modified DESC limit 10;";
		$rs = $this->db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				$id = $r['id'];
				$serial = $r['serial'];
				$asset = $r['asset_no'];
				
				$log_link = 'index.php?p='.encode_url('16').'&s='.encode_url('v').'&i='.encode_url($id);
				$link = 'index.php?p='.encode_url('12').'&s='.encode_url('u').'&i='.encode_url($id);
				if(empty($serial)){
					$serial = $asset;
				}
				$enable_update ='';
				if($is_admin){
					$enable_update ='<a class="btn  btn-rounded btn-sm btn-flat btn-alt waves-button waves-effect" href="'.$link.'"><span class="icon icon-edit"></span></a>';
				}
				echo '<li><a href="'.$log_link.'">'.$serial.'</a>'.$enable_update.'</li>';
			}
		}else{
			echo '<h6 class="text-red text-center">No latest updates found!</h6>';
		}
	}

    function print_tiled_latest_updates($is_admin){
        $q ="SELECT * FROM pcm_serials WHERE active =1 ORDER BY date_modified DESC limit 10;";
        $rs = $this->db->getResults($q);
        if(count($rs)>0){
            echo '<div class="tile-wrap">';
            foreach($rs as $r){
                $id = $r['id'];
                $serial = $r['serial'];
                $asset = $r['asset_no'];

                $log_link = 'index.php?p='.encode_url('16').'&s='.encode_url('v').'&i='.encode_url($id);
                $link = 'index.php?p='.encode_url('12').'&s='.encode_url('u').'&i='.encode_url($id);
                $delete_link = 'index.php?p='.encode_url('12').'&s='.encode_url('d').'&i='.encode_url($id);
                $status_link = 'index.php?p='.encode_url('11').'&s='.encode_url('u').'&i='.encode_url($id).'&sn='.encode_url($serial);
                $view_status_link = 'index.php?p='.encode_url('24').'&s='.encode_url('v').'&i='.encode_url($id).'&sn='.encode_url($serial);

                if(empty($serial)){
                    $serial = $asset;
                }
                $view_repair_status=
                $enable_update ='';
                if($is_admin){
                    $enable_update ='
                    <a class="btn btn-sm btn-flat btn-alt waves-button waves-effect" href="'.$link.'"><span class="icon icon-edit"></span></a>
                    <a class="btn btn-sm btn-flat btn-red waves-button waves-effect" href="'.$delete_link.'"><span class="icon icon-delete"></span></a>
                    <a class="btn btn-sm btn-flat btn-alt waves-button waves-effect" href="'.$status_link.'"><span class="icon icon-speaker-notes"></span></a>
                   ';
                }else{
                   $view_repair_status = '<a class="btn btn-sm btn-flat btn-blue waves-button waves-effect pull-right" href="'.$view_status_link.'" target="_blank"><span class="icon icon-pageview"></span></a>';

                }

                echo '<div class="tile">
                        <div class="pull-right tile-side">
                            <!--<span class="icon icon-quick-contacts-mail icon-lg text-alt"></span>-->
                            '.$enable_update.$view_repair_status.'
                        </div>
                        <div class="tile-inner">
                            <span><a href="'.$log_link.'" >'.$serial.'</a></span>
                        </div>
                    </div>';
            }
            echo '</div>';
        }else{
            echo '<h6 class="text-red text-center">No latest updates found!</h6>';
        }
    }

    function print_notifications($is_admin, $view){
        $q ="SELECT * FROM pcm_notif ORDER BY id DESC limit 10;";
        if($view==='all'){
            $q ="SELECT * FROM pcm_notif ORDER BY id DESC;";
        }
        $rs = $this->db->getResults($q);
        if(count($rs)>0){
            foreach($rs as $r){
                $id = $r['id'];
                $title = $r['title'];
                $message = $r['message'];
                $date_created = $r['date_created'];
                $is_view = $r['view'];
                $link = $r['link'].'&ti='.encode_url($id);
                $time_summ = get_time_difference($date_created);
                $icon = '';
                $description ='';
                if($is_view==='1') {
                    $icon = '<span class="avatar avatar-alt avatar-xxs"><span class="icon icon-check"></span></span>';
                    $description ='<a href="'.$link.'"><strong class="text-alt">'.$title.'</strong> '.$message.' <small class="text-green">'.$time_summ.'</small></a>';
                }else {
                    $icon = '<span class="avatar avatar-red avatar-xxs"><span class="icon icon-xxs icon-close"></span></span>';
                    $description ='<a href="'.$link.'"  class="text-hint"><strong class="text-hint">'.$title.'</strong> '.$message.' <small class="text-green">'.$time_summ.'</small></a>';
                }

                echo  '<div class="media">
                        <div class="media-object pull-right">
                            <label class="form-icon-label" >'.$icon.'</label>
                        </div>
                        <div class="media-inner">
                           '.$description.'
                        </div>
                    </div>';
            }
        }else{
            echo '<h6 class="text-red text-center">No notifications found!</h6>';
        }
    }

    function print_select_brands($iid){
		$q ="SELECT * FROM pcm_brands WHERE active =1;";
		
		$rs = $this->db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				$id		= $r['id'];
				$name	= $r['brand_name'];
				if($iid ===$id){
					echo '<option value="'.$id.'" selected>'.$name.'</option>';
				}else{
					echo '<option value="'.$id.'">'.$name.'</option>';
				}	
			}
		}
	}

    function print_select_requisitioners($iid){
		$q ="SELECT * FROM pcm_requisitioners WHERE active =1;";		
		$rs = $this->db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				$id		= $r['id'];
				$name	= $r['requisitioner'];
				if($iid ===$id){
					echo '<option value="'.$id.'" selected>'.$name.'</option>';
				}else{
					echo '<option value="'.$id.'">'.$name.'</option>';
				}				
			}
		}
	}

    function print_select_technicians($iid){
		$q ="SELECT * FROM pcm_technicians WHERE active =1;";		
		$rs = $this->db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				$id		= $r['id'];
				$name	= $r['firstname'].' '. $r['lastname'];
				if($iid ===$id){
					echo '<option value="'.$id.'" selected>'.$name.'</option>';
				}else{
					echo '<option value="'.$id.'">'.$name.'</option>';
				}				
			}
		}
	}
	
	function print_select_status($iid){
		$q ="SELECT * FROM pcm_status WHERE active =1;";
		
		$rs = $this->db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				$id		= $r['id'];
				$name	= $r['status'];
				if($iid ===$id){
					echo '<option value="'.$id.'" selected>'.$name.'</option>';
				}else{
					echo '<option value="'.$id.'">'.$name.'</option>';
				}	
			}
		}
	}

    function get_fullname($id){
		$q ="SELECT concat(firstname,' ', lastname) as fullname FROM cluster.installers where id =".$id;
		$rs = $this->db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				return $r['fullname'];
			}
		}
        return '';
	}
	
	function print_item_list($key, $id, $keyword, $is_admin){		
		$q ="SELECT * FROM pcm_list WHERE active =1 ORDER BY date_modified DESC;";
		if(!empty($key) and !empty($id)){
			$tables	=array('Brands'=>'brand','Status'=>'status_id', 'Requisitioners'=>'requisitioner', 'Technicians'=>'tech_id');
			if (array_key_exists($key,$tables)){
				$column = $tables[$key];
				$q ="SELECT * FROM pcm_list WHERE active =1 AND ".$column."=".$id." ORDER BY date_modified DESC;";				
			}else{
				$q = $id;
			}
		}else{
			if(!empty($keyword)){
				$this->add_search($keyword);
				$q ="SELECT * FROM pcm_list WHERE active =1 AND 
				(serial like '%".$keyword."%' OR 
				serial_2 like '%".$keyword."%' OR
				reference_no like '%".$keyword."%' OR
				asset_no like '%".$keyword."%' OR
				matcode like '%".$keyword."%' OR
				brand_name like '%".$keyword."%' OR
				requisitioner_name like '%".$keyword."%' OR
				dr_no like '%".$keyword."%' OR
				tpi_code like '%".$keyword."%' OR
				notes like '%".$keyword."%' OR
				firstname like '%".$keyword."%' OR
				status like '%".$keyword."%' OR
				repaired_portion like '%".$keyword."%' OR
				replaced_parts like '%".$keyword."%'
				) ORDER BY date_modified DESC;";
			}
		}
		
		
		$rs = $this->db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				$with_warning = false;
				$with_history = false;
				$with_attachments = '';
				$id			=  $r['id'];
				$serial		=  $r['serial'];
				$serial2	=  $r['serial_2'];
				$matcode	=  $r['matcode'];
				$asset_no	=  $r['asset_no'];
                $brand_name	=  $r['brand_name'];
                $reference_no=  $r['reference_no'];
				$req_name	=  $r['requisitioner_name'];
				$date_in	=  $r['date_in'];
				$date_out	=  $r['date_out'];
				$dr_no		=  $r['dr_no'];
				$tpi_code	=  $r['tpi_code'];
				$technician	=  $r['firstname'].' '.$r['lastname'];
				$notes		=  $r['notes'];
				$is_warranty	=  $r['is_warranty'];
				$date_modified	=  $r['date_modified'];
				$status		=  $r['status'];
				$status_id	=  $r['status_id'];
				$color		=  $r['color'];
				$delivery_table	=  $r['delivery_table'];
				$repaired_portion	=  $r['repaired_portion'];
				$date_repaired	=  $r['date_repaired'];
				
				$days_in = get_days_complete($date_in,get_currentdate());
				
				$tpi_code	= (empty($tpi_code)) ? '': '<span class="label avatar-green">'.$tpi_code.'</span>';
				$date_modified = get_time_difference($date_modified);
				$is_warranty = ($is_warranty==='1') ?
								'<div class="avatar avatar-red avatar-xxs">
									<span class="icon icon-check"></span>
								</div>':'<div class="avatar avatar-green avatar-xxs">
									<span class="icon icon-remove"></span>
								</div>';
                $view_status_link = 'index.php?p='.encode_url('24').'&s='.encode_url('v').'&i='.encode_url($id).'&sn='.encode_url($serial);

				$state_icon = '';
				$state_color = 'text-red';
                $enable_addto_deliver ='';
                $view_repair_status = '';
				if(strtoupper($status)==='REPAIRED'){
                    $view_repair_status = '<a class="btn btn-flat btn-blue btn-xs waves-button waves-effect pull-right" href="'.$view_status_link.'" target="_blank"><span class="icon icon-description"></span>View Repair Details</a>';

                    $state_icon = '<span class="icon icon-check"></span>';
					if(empty($date_out) and empty($dr_no)){
						$dr_no ='<strong class="text-red animated infinite flash">ATTENTION!!! Please provide D.R. number</strong>';
						$state_color = 'text-red';
						$with_warning = true;
						/* Show Add to Deliver if empty DR */
						if($is_admin){
							if(strtoupper($status)==='REPAIRED'){
								$enable_addto_deliver ='<a class="btn btn-yellow btn-xs waves-button waves-effect add_to_deliver" id="ad_'.encode_url($id).'" sn="'.$serial.'" style="width:139px"><span class="icon icon-local-shipping"></span>Add to Deliver</a>';
							}
						}

                    }elseif(empty($tpi_code)){
						$tpi_code ='<strong class="text-yellow animated infinite flash">ATTENTION!!! Please provide TPI Code/Sticker Code</strong>';
						$state_color = 'text-yellow';
						$with_warning = true;
					}else{
						
					}
				}
				if($with_warning ===true){
					$with_warning ='<span class="icon icon-warning '.$state_color.' animated infinite flash pull-right"></span>';
				}else{
					$with_warning ='';
					if(strtoupper($status)==='REPAIRED'){
						if(get_months(get_currentdate(),$date_out)<=6){
							$with_warning ='<span class="icon icon-info text-yellow animated infinite flash pull-right"></span>';
							$is_warranty = '<span class="text-yellow">This item is under warranty from Date Delivered to '.$req_name.' warehouse.</span>';
						}else if(get_months(get_currentdate(),$date_out)>6){
							$is_warranty = '<span class="text-green">Item\'s warranty has lapsed.</span>';
						}else{
							
						}
					}
				}
				
				$q ="SELECT * FROM pcm_attachments WHERE serial_id=".to_string($id);
				$rs = $this->db->getResults($q);
				if(count($rs)>0){
					$with_attachments = '<span class="icon icon-attach-file pull-right"></span>';
				}
				$q ="SELECT * FROM pcm_repair_history WHERE serial_id=".to_string($id);
				$rs = $this->db->getResults($q);
				if(count($rs)>0){
					$with_history = '<span class="icon icon-history pull-right"></span>';
				}
				
				$add_log = 'index.php?p='.encode_url('16').'&s='.encode_url('a').'&i='.encode_url($id);
				$log_link = 'index.php?p='.encode_url('16').'&s='.encode_url('v').'&i='.encode_url($id);
				$att_link = 'index.php?p='.encode_url('17').'&s='.encode_url('a').'&i='.encode_url($id);
				$att_view = 'index.php?p='.encode_url('17').'&s='.encode_url('v').'&i='.encode_url($id);
				$status_link = 'index.php?p='.encode_url('11').'&s='.encode_url('u').'&i='.encode_url($id).'&sn='.encode_url($serial);
				$update_link = 'index.php?p='.encode_url('12').'&s='.encode_url('u').'&i='.encode_url($id);
				$delete_link = 'index.php?p='.encode_url('12').'&s='.encode_url('d').'&i='.encode_url($id);
				
				
				
				$action_buttons ='';
                $no_deliver_table ='';
                $added_to_deliver ='';
				if($is_admin){

                    if(!empty($delivery_table)){
                        $added_to_deliver ='<span class="icon icon-local-shipping text-alt animated infinite flash pull-right"></span>';
                    }
					/* updates --
					<a class="btn btn-alt btn-xs waves-button waves-effect update_sn_status" id="st_'.encode_url($id).'" sn="'.$serial.'" s="'.$status_id.'" rp="'.$repaired_portion.'" dr="'.$date_repaired.'" style="width:139px"><span class="icon icon-edit"></span>Update Status</a>
					*/

					$action_buttons ='
						<a class="btn btn-green btn-xs waves-button waves-effect" href="'.$add_log.'" style="width:139px"><span class="icon icon-search"></span>Add Log</a>
						<a class="btn btn-blue btn-xs waves-button waves-effect" href="'.$att_link.'" style="width:139px"><span class="icon icon-attach-file"></span>Add Attachment</a>
						<a class="btn btn-alt btn-xs waves-button waves-effect" href="'.$status_link .'" style="width:139px"><span class="icon icon-edit"></span>Update Status</a>
						<a class="btn btn-red btn-xs waves-button waves-effect" href="'.$delete_link .'" style="width:139px"><span class="icon icon-delete"></span>Delete Item</a>
						'.$enable_addto_deliver .'
						<a class="btn  btn-rounded btn-sm btn-flat btn-alt waves-button waves-effect" href="'.$update_link .'"><span class="icon icon-edit"></span></a>
						</td>';
				}else{
					$enable_view_tsr ='';
					if(!empty($delivery_table)){
                        if($this->db->tableExist($delivery_table)) {
                            $tsr = $this->db->getValue($delivery_table, 'tsr', 'serial_id=' . $id);
                            if (!empty($tsr)) {
                                if(file_exists($tsr)){
                                    $enable_view_tsr = '<a class="btn btn-alt btn-xs waves-button waves-effect" href="' . $tsr . '" target="_blank"><span class="icon icon-description"></span>View TSR</a>';
                                }
                            }
                            $added_to_deliver ='<span class="icon icon-local-shipping text-alt animated infinite flash pull-right"></span>';

                        }else{
                            $no_deliver_table ='<span class="icon icon-local-shipping text-red animated infinite flash pull-right"></span>';
                        }
                    }
					
					$action_buttons ='						
						<a class="btn btn-green btn-xs waves-button waves-effect" href="'.$log_link.'"><span class="icon icon-search"></span>View repair logs</a>&nbsp;
						<a class="btn btn-blue btn-xs waves-button waves-effect" href="'.$att_view.'"><span class="icon icon-attach-file"></span>View Attachments</a>&nbsp;'.$enable_view_tsr;
				}


				echo '<tr>
					<td><strong>'.$serial.'</strong> '.$with_attachments.'  '.$with_history.' '.$with_warning.'  '.$added_to_deliver.'  '.$no_deliver_table.'</td>
					<td>'.$serial2.'</td>
					<td>'.$matcode.'</td>
					<td>'.$asset_no.'</td>
					<td>'.$reference_no.'</td>
					<td>'.$brand_name.'</td>
					<td>'.$req_name.'</td>
					<td>'.$date_in.'</td>
					<td><strong class="text-green">'.$date_repaired.'</strong>'.$view_repair_status.'</td>
					<td><strong class="text-alt">'.$date_out.'</strong></td>
					<td><strong class="text-alt">'.$dr_no.'</strong></td>
					<td>'.$tpi_code.'</td>
					<td>'.$technician.'</td>
					<td>'.$notes.'</td>
					<td>'.$date_modified.'</td>
					<td>'.$is_warranty.'</td>
					<td style="background:'.$color.'">'.$state_icon.$status.'</td>	
					<td> <span class="pull-right">'.$days_in.'</span>  </td>				
					<td style="padding:50px;">'.$action_buttons.'</td>
					</tr>';
				
			}
		}		
	}
	
	function print_item_info($serial,$is_admin, $page){
		$q ="SELECT * FROM pcm_list WHERE id ='".($serial)."'";
		$rs = $this->db->getResults($q);
		//$cols = $this->db->getColumns('pcm_list');
		
		$cols= array('serial'=>'Serial','serial_2'=>'Serial 2','asset_no'=>'Asset Number','reference_no'=>'Reference Number', 'date_in'=>'Delivered to TPI',
					'date_out'=>'Delivered to Requisitioner','dr_no'=>'D.R. Number','tpi_code'=>'TPI Code','is_warranty'=>'Is under Warranty',
					'date_modified'=>'Last record updates','brand_name'=>'Brand','requisitioner_name'=>'Requisitioner','status'=>'Status','active'=>'Active');

		
		if(count($rs)>0){
			echo '<table class="table item-info">';
			foreach($rs as $r){
				$id= $r['id'];
				foreach($cols as $k=>$c){
					$val = $r[$k];
					if($k==='active'){
						$val = ($val==='1') ?'<span class="icon icon-check text-alt"></span>':'<span class="icon icon-remove text-red"></span>';
					}elseif($k==='is_warranty'){
						$val = ($val==='1') ?
						'<div class="avatar avatar-red avatar-xs">
							<span class="icon icon-check"></span>
						</div>':'<div class="avatar avatar-green avatar-xs">
							<span class="icon icon-remove"></span>
						</div>';
					}elseif($k==='status'){
						$color = $r['color'];
						$val = '<span style="color:'.$color.'">'.$val.'</span>';
					}else{}
					if(!empty($val)){
						echo '<tr class="no-border-except-b">
								<td class="no-border-except-b"><span class="text-alt">'.$c.'</span></td>
								<td class="no-border-except-b"><strong>'.$val.'</strong></td>
							</tr>';
					}
				}

                $update_link = 'index.php?p='.encode_url('12').'&s='.encode_url('u').'&i='.encode_url($id);

                $enable_updates ='';
				if($is_admin){
					$link = 'index.php?p='.encode_url('12').'&s='.encode_url('u').'&i='.encode_url($id);
					$enable_updates ='<a class="btn btn-alt waves-button waves-effect waves-light pull-right" href="'.$link .'">Update Info</a>';
				}else{
					if($page==='logs'){
						$link = 'index.php?p='.encode_url('17').'&s='.encode_url('v').'&i='.encode_url($serial);
						$enable_updates ='<a href="'.$link .'">View Attachments</a>';
					}elseif($page==='attachments'){
						$link = 'index.php?p='.encode_url('16').'&s='.encode_url('v').'&i='.encode_url($serial);
						$enable_updates ='<a href="'.$link .'">View Logs</a>';
					}else{
						
					}
				}
				
				$q ="SELECT * FROM pcm_attachments WHERE serial=".to_string($serial);
				$attach =0;
				if($page==='attachments'){
					$q ="SELECT * FROM pcm_repair_history WHERE serial=".to_string($serial);
					$rs = $this->db->getResults($q);
					if(count($rs)>0){
						$attach = '<span class="icon icon-folder-shared icon-lg text-alt"></span>  <strong>  '.(count($rs)).'</strong>';
					}else{
						$attach = '<span class="text-red">No Logs</span>';	
						if($is_admin){
							$link = 'index.php?p='.encode_url('16').'&s='.encode_url('a').'&i='.encode_url($serial);
							$enable_updates ='<a href="'.$link .'">Add Log</a>';
						}
					}			
				}else{
					$rs = $this->db->getResults($q);
					if(count($rs)>0){
						$attach = '<span class="icon icon-attach-file icon-lg text-alt"></span>  <strong>  '.(count($rs)).'</strong>';
					}else{
						$attach = '<span class="text-red">No Attachments</span>';
						if($is_admin){
							$link = 'index.php?p='.encode_url('17').'&s='.encode_url('a').'&i='.encode_url($serial);
							$enable_updates ='<a href="'.$link .'">Add Attachment</a>';
						}
					}
				}

                echo '<tr class="no-border-except-b">
						<td class="no-border-except-b">'.$attach.'</td>						
						<td class="no-border-except-b">'.$enable_updates.'</td>
					</tr>';
                if($is_admin) {
                    echo '<tr class="no-border-except-b">
						<td class="no-border-except-b">Update Info</td>
						<td class="no-border-except-b"><a class="btn  btn-rounded btn-sm btn-flat btn-alt waves-button waves-effect" href="' . $update_link . '"><span class="icon icon-edit"></span></a></td>
					</tr>';
                }
			}
			echo '</table>';
		}else{
			echo '<h2 class="text-red">No data found!</h2>';
			
		}	
	}

    function print_serial_logs($id,$is_admin, $s){
		$q ="SELECT * FROM pcm_repair_history WHERE serial_id ='".($id)."' AND active =1 ORDER BY date_done DESC";
		$rs = $this->db->getResults($q);
		if(count($rs)>0){			
			foreach($rs as $r){
				$id				=  $r['id'];
				$repairs_done	=  $r['repairs_done'];
				$date_done		=  $r['date_done'];
				$date_done_txt = get_time_difference($date_done);
				//$date_done_txt = ($date_done);
				$enable_delete ='';
				if($is_admin){
					$enable_delete ='<span class="icon icon-cancel text-red this-is-link delete_log" id="log_'.encode_url($id).'"></span>';
				}
				echo '<a class="tile" href="javascript:void(0)">
						<div class="pull-right tile-side">
							<small class="text-green">'.$date_done_txt.'</small>&nbsp;&nbsp;						
							'.$enable_delete.'
						</div>
						<div class="tile-inner">
							<span>'.$repairs_done.'</span>							
						</div>
					</a>';
			}
		}else{
			if($s!=='a'){
				echo '<h3 class="text-red text-center">No logs found!</h3>';
			}
		}	
	}
	
	function print_all_logs($is_admin){
		$sq = 'SELECT count(serial) as count,serial,serial_id FROM pcm_repair_history group by serial order by count DESC';
		$rss = $this->db->getResults($sq);
		if(count($rss) >0){
			foreach($rss as $rs){
				$serial_id = $rs['serial_id'];
				$serial = $rs['serial'];
				$q = 'SELECT repairs_done FROM pcm_repair_history WHERE serial ='.to_string($serial).' AND active=1';
				$rs = $this->db->getResults($q);
				if(count($rs)>0){
					$log_view = 'index.php?p='.encode_url('16').'&s='.encode_url('v').'&i='.encode_url($serial_id);
					$log_add = 'index.php?p='.encode_url('16').'&s='.encode_url('a').'&i='.encode_url($serial_id);
					$index=1;
					echo '
					<div class="col-lg-4 col-sm-6">
						<div class="card">
							<aside class="card-side" style="background-color: #4caf50;">
								<span class="card-heading icon icon-info-outline"></span>
							</aside>
							<div class="card-main">
								<div class="card-inner">
									<p class="card-heading">'.$serial.'</p><p>';
									
							foreach($rs as $r){
								$repairs_done = $r['repairs_done'];
								echo '<div class="media">
										<div class="media-object pull-left"  style="padding:12px;">											
											<div class="avatar avatar-alt avatar-xxs" for="input-icon-'.$index.'">
												'.$index.'
											</div>
										</div>
										<div class="media-inner">
											<span id="input-icon-'.$index.'">'. $repairs_done.'</span>
										</div>
									</div>';
								$index +=1;		
							}
					$enable_add =($is_admin) ?'<li><a href="'.$log_add.'"><span class="icon icon-add text-alt"></span>&nbsp;<span class="text-blue">Add Log</span></a></li>':'';
					echo '</p>
							</div>
							<div class="card-action">
									<ul class="nav nav-list pull-left">
										<li>
											<a href="'.$log_view.'"><span class="icon icon-visibility text-alt"></span>&nbsp;<span class="text-blue">Open Log</span></a>
										</li>
										'.$enable_add.'
									</ul>									
								</div>
							</div>
						</div>
					</div>';
				}
				
			}			
		}
	}
	
	function print_all_drs($is_admin){
		$sq = 'SELECT count(dr_no) as count,dr_no,date_out,status,status_id,brand,requisitioner FROM pcm_list group by dr_no order by date_out DESC';
		$rss = $this->db->getResults($sq);
		if(count($rss) >0){
			foreach($rss as $rs){
				$dr_no = $rs['dr_no'];
				if(!empty($dr_no)){
					$date_out = full_date($rs['date_out']);
					$status = $rs['status'];
					
					$dt = $rs['date_out'];
					$st = $rs['status_id'];
					$bt = $rs['brand'];
					$rt = $rs['requisitioner'];
					
					$sp ='0';
					$pdt = plain_date($dt);
					$fdt = force_date($dt);
					$table_suffix =$pdt.'_'.$st.'_'.$bt.'_'.$rt.'_'.$sp;
					$view ='pcm_view_'.$table_suffix;
					
				echo '<tr>
						<td><strong>'.$dr_no.'</strong></td>
						<td><span class="text-alt">'.$date_out.'</span></td>
						<td><span class="text-blue">'.$status.'</span></td>
						<td>';
						
					$q = 'SELECT * FROM pcm_serials WHERE dr_no ='.to_string($dr_no).' AND active=1';
					$rs = $this->db->getResults($q);
					if(count($rs)>0){
							
						$index=1;
						foreach($rs as $r){
							$id = $r['id'];
							$serial = $r['serial'];
							$log_view = 'index.php?p='.encode_url('16').'&s='.encode_url('v').'&i='.encode_url($id);
							echo '<span class="icon icon-link margin-right-half"></span><a href="'.$log_view.'">'.$serial.'</a><br>';
						}
					}else{
						
					}

                    if($is_admin) {
                        //$cdr_link = 'includes/exports/dr.php?p='.encode_url('20').'&s='.encode_url('s').'&dt='.encode_url($fdt).'&st='.encode_url($st).'&bt='.encode_url($bt).'&rt='.encode_url($rt).'&sp='.encode_url($sp).'&tb='.encode_url($view);
                        $ctsr_link = 'index.php?p=' . encode_url('20') . '&s=' . encode_url('c') . '&dt=' . encode_url($fdt) . '&st=' . encode_url($st) . '&bt=' . encode_url($bt) . '&rt=' . encode_url($rt) . '&sp=' . encode_url($sp) . '&tb=' . encode_url($view);

                        $action_buttons = '<br>
						<a class="btn  btn-flat btn-red btn-xs waves-button waves-effect" href="' . $ctsr_link . '"><span class="icon icon-print"></span>Print TSR</a></td>';

                        echo $action_buttons;
                    }
					echo '</td>';
				echo '</tr>';
				}
			}
		}
	}
	
	function print_all_delivery($is_admin){
		$sq = 'SELECT count(dr_no) as count,dr_no,date_out,status FROM pcm_list group by dr_no order by date_out DESC';
		$rss = $this->db->getResults($sq);
		if(count($rss) >0){
			foreach($rss as $rs){
				$dr_no = $rs['dr_no'];
				if(!empty($dr_no)){
					$date_out = full_date($rs['date_out']);
					$status = $rs['status'];
					
				echo '<tr>
						<td><strong>'.$dr_no.'</strong></td>
						<td><span class="text-alt">'.$date_out.'</span></td>
						<td><span class="text-blue">'.$status.'</span></td>
						<td>';
						
					$q = 'SELECT * FROM pcm_serials WHERE dr_no ='.to_string($dr_no).' AND active=1';
					$rs = $this->db->getResults($q);
					if(count($rs)>0){
						$log_view = 'index.php?p='.encode_url('16').'&s='.encode_url('v').'&i='.encode_url($dr_no);
						$log_add = 'index.php?p='.encode_url('16').'&s='.encode_url('a').'&i='.encode_url($dr_no);
						$index=1;
						foreach($rs as $r){
							$serial = $r['serial'];
							$log_view = 'index.php?p='.encode_url('16').'&s='.encode_url('v').'&i='.encode_url($serial);
							echo '<span class="icon icon-link margin-right-half"></span><a href="'.$log_view.'">'.$serial.'</a><br>';
						}
					}else{
						
					}
									
					$action_buttons ='<br>
						<a class="btn btn-flat btn-alt btn-xs waves-button waves-effect" href="#"><span class="icon icon-attach-file"></span>Export TSR</a>
						<a class="btn  btn-flat btn-red btn-xs waves-button waves-effect" href="#"><span class="icon icon-print"></span>Print TSR</a></td>';
						
					echo $action_buttons;
					echo '</td>';
				echo '</tr>';
				}
			}
		}
	}
	
	function print_attachments($serial_id, $is_admin){
		$q ="SELECT * FROM pcm_attachments WHERE serial_id ='".($serial_id)."' AND public =1 ORDER BY id DESC";
		if($is_admin){
			$q ="SELECT * FROM pcm_attachments WHERE serial_id ='".($serial_id)."' ORDER BY id DESC";
		}
		$images_extensions = array('png','jpeg','jpg','tif','tiff','bmp','gif');
		$files_extensions = array('xlsx','xls','pdf','doc','docx');
		$rs = $this->db->getResults($q);
		if(count($rs)>0){			
			foreach($rs as $r){
				$id		=  $r['id'];
				$path	=  $r['path'];
				$type	=  $r['type'];
				$name	=  $r['friendly_name'];
				$public	=  $r['public'];
				$filename= basename($path);
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$thumb= '';
				if(in_array($ext,$images_extensions)){
					$thumb= '<img alt="alt text" src="'.$path.'">';
				}else{
					$thumb= '<img alt="alt text" src="assets/images/files/'.$ext.'.png">';
				}
				$download_link ='attachments/download.php?u=';
				$open_link =$path;
				if($type==='file'){
					$download_link =$path;
					$open_link =$path;
				}else{
					$download_link =($download_link.$path);
					$open_link =$path;
				}
				
				$public_icon ='';
				if($public==='1'){
					$public ='<a href="javascript:void(0)" class="change_state" msg="mark as Private" id="att_'.encode_url($id).'" state="'.encode_url('0').'"><span class="access-hide">Mark as Private</span><span class="icon icon-lock"></span></a>';
					$public_icon =
					'<div class="avatar avatar-green avatar-sm">
							<span class="icon icon-check"></span>
						</div>';
				}else{
					$public ='<a href="javascript:void(0)" class="change_state" msg="mark as Public" id="att_'.encode_url($id).'" state="'.encode_url('1').'"><span class="access-hide">Mark as Public</span><span class="icon icon-check"></span></a>';
					$public_icon =
					'<div class="avatar avatar-red avatar-sm">
							<span class="icon icon-lock"></span>
						</div>';					
				}
				$action_buttons ='';
				if($is_admin){
					$action_buttons =
					'<li><a href="'.$download_link.'"><span class="access-hide">Download Attachment</span><span class="icon icon-file-download"></span></a></li>
					<li><a href="'.$open_link.'"><span class="access-hide">View Attachment</span><span class="icon icon-visibility"></span></a></li>
					<li>'.$public.'</li>';
				}else{
					$public_icon ='';
					$action_buttons =
					'<li><a href="'.$download_link.'"><span class="access-hide">Download Attachment</span><span class="icon icon-file-download"></span></a></li>
					<li><a href="'.$open_link.'" target="_blank"><span class="access-hide">View Attachment</span><span class="icon icon-visibility"></span></a></li>';
				}
				echo '<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="card">
							<div class="card-main">
								<div class="card-img">
									'.$thumb.'
									<p class="card-img-heading">'.$name.'</p>
								</div>
								<div class="card-inner">
								'.$public_icon .'
									<p>
										'.$filename.'
									</p>
								</div>
								<div class="card-action">
									<ul class="nav nav-list pull-left">
										'.$action_buttons.'								
									</ul>
								</div>
							</div>
						</div>
					
					</div>';
			}
		}else{
			echo '<h3 class="text-red text-center">No attachments found!</h3>';
		}	
	}
	
	public function add_search($keyword){
		if(!empty($keyword)){
			$count = $this->db->getValue('pcm_search','count',"keyword ='".$keyword."'");
			if(empty($count)){
				 $this->db->insert('pcm_search',array('keyword'=>$keyword,'count'=>1));
			}else{
				$this->db->update('pcm_search',array('count'=>(intval($count)+1)),"keyword ='".$keyword."'");
			}
			
		}
	}
	
	public function getEntryCount($dt, $r){
		$q ="SELECT * FROM pcm_serials WHERE date_in ='".$dt."' AND active = 1 AND requisitioner = ".$r;
		$rs = $this->db->getResults($q);
		return count($rs);			
	}

    public function getNotifCount(){
        $q ="SELECT * FROM pcm_notif";
        $rs = $this->db->getResults($q);
        return count($rs);
    }

    public function check_parts_libs(){
        $sql = "SELECT brand, repaired_portion, replaced_parts FROM pcm_serials where replaced_parts != ''";
        $rs = $this->db->getResults($sql);
        foreach($rs as $r){
            $brand = $r['brand'];
            $portion = $r['repaired_portion'];
            $replaced_parts = $r['replaced_parts'];
            $split_parts = explode(',',$replaced_parts);
            if(count($split_parts)>0){
                for($i=0; $i < count($split_parts);$i++){
                    $part = trim($split_parts[$i]);
                    $qry ="SELECT * FROM pcm_parts_libraries where part= '".$part."'";
                    $p_rs = $this->db->getResults($qry);
                    if(count($p_rs)<1){
                        $this->db->insert('pcm_parts_libraries', array('brand'=>$brand, 'portion'=>$portion,'part'=>$part,'active'=>1));
                    }
                }
            }
        }
    }
}

?>
