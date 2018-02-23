<?php
//require 'mailer/PHPMailerAutoload.php';

class Maintenance
{
    private $db;
	
    public function __construct(\PDO $dbh)
    {
        $this->db = $dbh;
    }
	
	public function print_table_colums($key,$is_admin){
		$tables	=array('Brands'=>'pcm_brands','Status'=>'pcm_status', 'Requisitioners'=>'pcm_requisitioners', 'Technicians'=>'pcm_technicians');
		$table = $tables[$key];
		$q = "SELECT * FROM ".$table." WHERE active= 1";
		$cols = $this->db->getColumns($table);
		if(count($cols)>0){
			foreach($cols as $c){
				$col = $c['Field'];
				if(!empty($col)){
					if($col!=='id'){
						echo '<th>'.ucwords($col).'</th>';
					}
				}
			}
			if($is_admin){
				echo '<th data-hide="phone,tablet">Action</th>';
			}else{
				echo '<th data-hide="all"> </th>';
			}
		}
	}
	
	public function print_static_colums($key,$is_admin){
		if($key==='Brands'){
			echo '
			<th>Brand</th>
			<th>Active</th>
			<th data-hide="phone">Image</th>';
		}else if($key==='Status'){
			echo '
			<th>Status</th>
			<th data-hide="phone,tablet">Description</th>
			<th>Color</th>
			<th>Active</th>';
		}else if($key==='Requisitioners'){
			echo '
			<th>Requisitioner</th>
			<th>Logo</th>
			<th data-hide="phone,tablet">Contact Person</th>
			<th data-hide="phone,tablet">Address</th>
			<th data-hide="phone,tablet">TIN</th>
			<th>Active</th>';
		}else if($key==='Technicians'){
            echo '
			<th>Firstname</th>
			<th data-hide="phone,tablet">Middlename</th>
			<th>Lastname</th>
			<th>Active</th>';
        }else if($key==='Parts'){
            echo '
			<th>Part</th>
			<th>Brand</th>
			<th data-hide="phone,tablet">Portion</th>
			<th data-hide="phone,tablet">Active</th>';
        }else{
			
		}
		if($is_admin){
			echo '<th data-hide="phone,tablet">Action</th>';
		}else{
			echo '<th data-hide="all"> </th>';
		}
	}
	
	public function print_table_rows($key,$is_admin){
		$tables	=array('Brands'=>'pcm_brands','Status'=>'pcm_status', 'Requisitioners'=>'pcm_requisitioners', 'Technicians'=>'pcm_technicians', 'Parts'=>'pcm_parts_libraries');
		$table = $tables[$key];
		$q = "SELECT * FROM ".$table." WHERE active= 1";
		$cols = $this->db->getColumns($table);
		
		$rows = $this->db->getResults($q);
		if(count($rows)>0){
			foreach($rows as $r){
				$id = $r['id'];
				echo '<tr>';
				foreach($cols as $c){
					$col = $c['Field'];
					$val = $r[$col];
					if($col==='id'){
						
					}elseif($col==='active'){
						$val = ($val==='1') ?
								'<div class="avatar avatar-alt avatar-xs">
									<span class="icon icon-check"></span>
								</div>':'<div class="avatar avatar-red avatar-xs">
									<span class="icon icon-remove"></span>
								</div>';
						echo '<td>'.$val.'</td>';
					}elseif($col==='icolor'){
						 $val = '<span class="label" style="background-color:'.$val.'">'.$val.'</span>';
						 echo '<td>'.$val.'</td>';						 
					}elseif($col==='logo' or $col==='image'){
                        $val = '<img class="requi-logo" src="'.$val.'"/>';
                        echo '<td>'.$val.'</td>';
                    }elseif($col==='brand'){
                        $val = $this->db->getValue('pcm_brands','brand_name','id='.$val);
                        echo '<td>'.$val.'</td>';
                    }else{
						echo '<td>'.$val.'</td>';					
					}
					
				}
				if($is_admin){
                    $summary_link = 'index.php?p='.encode_url('23').'&s='.encode_url('v').'&l='.encode_url($key).'&i='.encode_url($id);
                    $view_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url($key).'&i='.encode_url($id);
                    $edit_link = 'index.php?p='.encode_url('15').'&s='.encode_url('u').'&l='.encode_url($key).'&i='.encode_url($id);
					$delete_link = 'index.php?p='.encode_url('15').'&s='.encode_url('d').'&l='.encode_url($key).'&i='.encode_url($id);
                    if($key==='Parts'){
                        echo '<td>
						<a class="btn btn-flat btn-alt waves-button waves-effect" href="'.$edit_link.'"><span class="icon icon-edit"></span></a>
						<a class="btn btn-flat btn-red waves-button waves-effect" href="'.$delete_link.'"><span class="icon icon-delete"></span></a>
						</td>';
                    }else{
                        $enable_summary = ($key==='Brands')?'<a class="btn btn-flat btn-alt waves-button waves-effect" href="'.$summary_link.'"><span class="icon icon-now-widgets"></span>View Summary</a>':'';
                        echo '<td>
						<a class="btn btn-flat btn-alt waves-button waves-effect" href="'.$view_link.'"><span class="icon icon-search"></span>View List</a>
						'.$enable_summary.'
						<a class="btn btn-flat btn-alt waves-button waves-effect" href="'.$edit_link.'"><span class="icon icon-edit"></span></a>
						<a class="btn btn-flat btn-red waves-button waves-effect" href="'.$delete_link.'"><span class="icon icon-delete"></span></a>
						</td>';

                    }

				}else{
                    if($key!=='Parts') {
                        $summary_link = 'index.php?p='.encode_url('23').'&s='.encode_url('v').'&l='.encode_url($key).'&i='.encode_url($id);
                        $view_link = 'index.php?p=' . encode_url('11') . '&s=' . encode_url('v') . '&l=' . encode_url($key) . '&i=' . encode_url($id);
                        $enable_summary = ($key==='Brands')?'<a class="btn btn-flat btn-alt waves-button waves-effect" href="'.$summary_link.'"><span class="icon icon-now-widgets"></span>View Summary</a>':'';

                        echo '<td>
						<a class="btn btn-flat btn-alt waves-button waves-effect" href="' . $view_link . '"><span class="icon icon-search"></span>View All</a>
						'.$enable_summary.'
						</td>';
                    }
				}
				echo '<tr>';
			}
		}
	}
	
	function print_tile_requisitioner(){
		$q = "SELECT * FROM pcm_requisitioners WHERE active= 1";		
		$rows = $this->db->getResults($q);
		if(count($rows)>0){
			foreach($rows as $r){
				$id = $r['id'];
				$logo = $r['logo'];
				$requisitioner = $r['requisitioner'];
				$add_link ='index.php?p='.encode_url('12').'&s='.encode_url('g').'&l='.encode_url('Requisitioners').'&i='.encode_url($id).'&r='.encode_url($id).'&pn='.encode_url('1');
				
				echo '<div class="tile">
					<div class="pull-left tile-side">
						<img class="requi-logo icon icon-lg text-alt" style="width:20px;height:20px;" src="'.$logo.'">
					</div>					
					<div class="tile-inner">
						<span><a href="'.$add_link.'" class="text-alt"><strong> '.$requisitioner.'</strong></a></span>					
					</div>
				</div>';
			}
		}
	}


    function print_tile_brands_summary(){
        $q = "SELECT * FROM pcm_brands WHERE active= 1";
        $rows = $this->db->getResults($q);
        if(count($rows)>0){
            foreach($rows as $r){
                $id = $r['id'];
                $logo = $r['image'];
                $brand = $r['brand_name'];
                $add_link ='index.php?p='.encode_url('23').'&s='.encode_url('v').'&l='.encode_url('Brands').'&i='.encode_url($id).'&r='.encode_url($id).'&pn='.encode_url('1');

                echo '<div class="tile">
					<div class="pull-left tile-side">
						<img class="requi-logo icon icon-lg text-alt" style="width:20px;height:20px;" src="'.$logo.'">
					</div>
					<div class="tile-inner">
						<span><a href="'.$add_link.'" class="text-alt"><strong> '.$brand.'</strong></a></span>
					</div>
				</div>';
            }
        }
    }
	
	function print_datatile_requisitioner($is_admin){
		$q = "SELECT * FROM pcm_requisitioners WHERE active= 1";		
		$rows = $this->db->getResults($q);
		if(count($rows)>0){
			foreach($rows as $r){
				$id = $r['id'];
				$logo = $r['logo'];
				$requisitioner = $r['requisitioner'];
				$add_link ='index.php?p='.encode_url('12').'&s='.encode_url('g').'&l='.encode_url('Requisitioners').'&i='.encode_url($id).'&r='.encode_url($id).'&pn='.encode_url('1');
				$view_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url('Requisitioners').'&i='.encode_url($id);
				$delete_link = 'index.php?p='.encode_url('15').'&s='.encode_url('d').'&l='.encode_url('Requisitioners').'&i='.encode_url($id);
				
				$enable_add = '';
				if($is_admin){
					$enable_add ='<a class="pull-right" href="'.$delete_link.'"><span class="avatar avatar-red avatar-xs"><span class="icon icon-delete"></span></span></a>	
						<a class="pull-right"><span style="margin-left:8px;"></span></a>
						<a class="pull-right" href="'.$add_link.'"><span class="avatar avatar-alt avatar-xs"><span class="icon icon-add"></span></span></a>';
				}
				echo '<div class="tile">
					<div class="pull-left tile-side">
						<img class="requi-logo icon icon-lg text-alt" style="width:20px;height:20px;" src="'.$logo.'">
					</div>					
					<div class="tile-inner">
						<span class="text-overflow"><a href="'.$view_link.'" class="text-alt"><strong> '.$requisitioner.'</strong></a></span>
						'.$enable_add.'
					</div>						
				</div>';
			}
		}
	}
		
	function print_tab_requisitioner(){
		$q = "SELECT * FROM pcm_requisitioners WHERE active= 1";		
		$rows = $this->db->getResults($q);
		if(count($rows)>0){
			foreach($rows as $r){
				$id = $r['id'];
				$logo = $r['logo'];
				$requisitioner = $r['requisitioner'];
				$add_link ='index.php?p='.encode_url('19').'&s='.encode_url('a');
				$active= ($id<2)? 'active': '';
				echo '<li class="'.$active.'">
						<a class="waves-effect" data-toggle="tab" href="#req_'.$id.'"><img class="icon icon-lg text-alt" width="20px" height="20px" src="'.$logo.'"></a>
					</li>';
			}
		}
	}
	
		
	function print_list_requisitioner(){
		$q = "SELECT * FROM pcm_requisitioners WHERE active= 1";		
		$rows = $this->db->getResults($q);
		if(count($rows)>0){
			foreach($rows as $r){
				$id = $r['id'];
				$logo = $r['logo'];
				$requisitioner = $r['requisitioner'];
				$view_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url('Requisitioners').'&i='.encode_url($id);
				$active= ($id<2)? 'active': '';
				echo '<li><a href="'.$view_link.'"><<img class="icon icon-lg text-alt" width="20px" height="20px" src="'.$logo.'">'.$requisitioner.'</a></li>';
			}
		}
	}
	
	function print_tab_reqcontent($is_admin){
		$q = "SELECT * FROM pcm_requisitioners WHERE active= 1";		
		$rows = $this->db->getResults($q);
		if(count($rows)>0){
			foreach($rows as $r){
				$id = $r['id'];
				$active= ($id<=1)? 'active': '';
				echo '<div class="tab-pane fade '.$active.' in" id="req_'.$id.'">';
				$this->print_table_start($id);
				$q ="SELECT * FROM pcm_list WHERE active =1 AND requisitioner=".$id." ORDER BY date_modified DESC;";
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
						
						
						$tpi_code	= (empty($tpi_code)) ? '': '<span class="label avatar-green">'.$tpi_code.'</span>';
						$date_modified = get_time_difference($date_modified);
						$is_warranty = ($is_warranty==='1') ?
										'<div class="avatar avatar-red avatar-xxs">
											<span class="icon icon-check"></span>
										</div>':'<div class="avatar avatar-green avatar-xxs">
											<span class="icon icon-remove"></span>
										</div>';
										
						$state_icon = '';
						$state_color = 'text-red';
						$enable_addto_deliver ='';
						if(strtoupper($status)==='REPAIRED'){
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
						$status_link = 'index.php?p='.encode_url('11').'&s='.encode_url('u').'&i='.encode_url($id);
						$link = 'index.php?p='.encode_url('12').'&s='.encode_url('u').'&i='.encode_url($id);
						$delete_link = 'index.php?p='.encode_url('12').'&s='.encode_url('d').'&i='.encode_url($id);
						
						
						
						$action_buttons ='';
						
						if($is_admin){
							
							/* updates --
							<a class="btn btn-alt btn-xs waves-button waves-effect update_sn_status" id="st_'.encode_url($id).'" sn="'.$serial.'" s="'.$status_id.'" rp="'.$repaired_portion.'" dr="'.$date_repaired.'" style="width:139px"><span class="icon icon-edit"></span>Update Status</a>
							*/
							
							$action_buttons ='
								<a class="btn btn-green btn-xs waves-button waves-effect" href="'.$add_log.'" style="width:139px"><span class="icon icon-search"></span>Add Log</a>
								<a class="btn btn-blue btn-xs waves-button waves-effect" href="'.$att_link.'" style="width:139px"><span class="icon icon-attach-file"></span>Add Attachment</a>
								<a class="btn btn-alt btn-xs waves-button waves-effect" href="'.$status_link .'" style="width:139px"><span class="icon icon-edit"></span>Update Status</a>
								<a class="btn btn-red btn-xs waves-button waves-effect" href="'.$delete_link .'" style="width:139px"><span class="icon icon-delete"></span>Delete Item</a>
								'.$enable_addto_deliver .'
								</td>';
						}else{
							$enable_view_tsr ='';
							if(!empty($delivery_table)){
								$tsr = $this->db->getValue($delivery_table,'tsr','serial_id='.$id);
								if(!empty($tsr)){
									$enable_view_tsr ='<a class="btn btn-alt btn-xs waves-button waves-effect" href="'.$tsr.'" target="_blank"><span class="icon icon-description"></span>View TSR</a>';					
								}
							}
							
							$action_buttons ='						
								<a class="btn btn-green btn-xs waves-button waves-effect" href="'.$log_link.'"><span class="icon icon-search"></span>View repair logs</a>&nbsp;
								<a class="btn btn-blue btn-xs waves-button waves-effect" href="'.$att_view.'"><span class="icon icon-attach-file"></span>View Attachments</a>&nbsp;'.$enable_view_tsr;
						}
						$added_to_deliver ='';
						if(!empty($delivery_table)){
							$added_to_deliver ='<span class="icon icon-local-shipping text-alt animated infinite flash pull-right"></span>';
						}
						echo '<tr>
							<td><strong>'.$serial.'</strong>  '.$with_attachments.'  '.$with_history.' '.$with_warning.'  '.$added_to_deliver.'</td>
							<td>'.$serial2.'</td>
							<td>'.$matcode.'</td>
							<td>'.$asset_no.'</td>
							<td>'.$brand_name.'</td>
							<td>'.$req_name.'</td>
							<td>'.$date_in.'</td>
							<td><strong class="text-alt">'.$date_out.'</strong></td>
							<td><strong class="text-alt">'.$dr_no.'</strong></td>
							<td>'.$tpi_code.'</td>
							<td>'.$technician.'</td>
							<td>'.$notes.'</td>
							<td>'.$date_modified.'</td>
							<td>'.$is_warranty.'</td>
							<td style="background:'.$color.'">'.$state_icon.$status.'</td>					
							<td style="padding:50px;">'.$action_buttons.'</td>
							</tr>';
						
					}
				}		
			
				$this->print_table_end();
				echo '</div>';
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
	
	function print_table_start($id){
		echo '<div class="table-responsive">							
				<table id="table_'.$id.'" class="table footable toggle-circle-filled-colored" data-sorting="true" data-filter="#filter" data-page-size="10" data-limit-navigation="5" title="Table'.$id.'">
					<thead>
						<tr>
							<th data-toggle="true">Serial</th>
							<th data-hide="all">Serial 2</th>
							<th data-hide="all">MATCODE</th>
							<th data-hide="all">Asset No.</th>
							<th data-hide="phone">Brand</th>
							<th data-hide="phone">Requisitioner</th>
							<th data-hide="all">Date Received</th>
							<th data-hide="all">Date Delivered to Requisitioner Warehouse</th>
							<th data-hide="all">DR No.</th>
							<th data-hide="all">TPI Code</th>
							<th data-hide="all">Technician</th>
							<th data-hide="all">Notes</th>
							<th data-hide="all">Last Date Modified</th>
							<th data-hide="phone,tablet">Warranty</th>
							<th>Status</th>
							<th data-hide="all">Action</th>
						</tr>
					</thead>
					<tbody>';
	}
	
	function print_table_end(){
		echo '</tbody>
				<tfoot class="hide-if-no-paging">
				<tr>
					<td colspan="3" class="text-center">
						<ul class="pagination nav nav-list"></ul>
					</td>
				</tr>
				</tfoot>
			</table>
		</div>';
	}
}

?>
