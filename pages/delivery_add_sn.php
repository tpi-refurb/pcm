<?php 
$dt = decode_url((isset($_GET['dt']) && $_GET['dt'] != '') ? $_GET['dt'] : '');
$st = decode_url((isset($_GET['st']) && $_GET['st'] != '') ? $_GET['st'] : '');
$bt = decode_url((isset($_GET['bt']) && $_GET['bt'] != '') ? $_GET['bt'] : '');
$rt = decode_url((isset($_GET['rt']) && $_GET['rt'] != '') ? $_GET['rt'] : '');
$sp = decode_url((isset($_GET['sp']) && $_GET['sp'] != '') ? $_GET['sp'] : '0');

$pdt = plain_date($dt);
$table_suffix =$pdt.'_'.$st.'_'.$bt.'_'.$rt.'_'.$sp;
$view ='pcm_view_'.$table_suffix;
$table ='pcm_delivery_'.$table_suffix;

$dr_no =
$tech_id =
$test_power=
$test_fan=
$test_burn = '';
$text_power= 
$text_fan=
$text_burn ='NONE';
$q ='SELECT distinct(dr_no), test_power, test_fan, test_burn, technician FROM '.$table;
$rs = $db->getResults($q);
if(count($rs)>0){
	foreach($rs as $r){
		$dr_no = $r['dr_no'];
		$tech_id  = $r['technician'];
		$text_power = $r['test_power'];
		$text_fan = $r['test_fan'];
		$text_burn =$r['test_burn'];
	
		$test_power = ($text_power==='OK') ?'checked' :'';
		$test_fan = ($text_fan==='OK') ?'checked' :'';
		$test_burn =($text_burn==='OK') ?'checked' :'';
	}
}
$status = $db->getValue('pcm_status','status','id='.$st);
$color  = $db->getValue('pcm_status','icolor','id='.$st);
$brand  = $db->getValue('pcm_brands','brand_name','id='.$bt);
$requisitioner  = $db->getValue('pcm_requisitioners','requisitioner','id='.$rt);

if($s==='c'){ 
	$title ='Create DR';
}elseif($s==='d'){ 
	$title ='Delete Delivery';
}else{
	$title ='Add Serial Delivery';
}
if($s==='a' and !$isLogin){ 
	$s ='v'; // if not login and state is Add then set as View state
	$title ='Delivery List';
}

?>
<div class="content">
		<div class="content-heading">
			<div class="container container-full">
				<h1 class="heading"><?php echo $title;?></h1>
			</div>
		</div>
		<div class="content-inner">
			<div class="container container-full">
				<div class="row row-fix">				
					<div class="col-md-8">
					<?php if($s==='a'){ ?>
							<h2 class="content-sub-heading">Enter serial then click add</h2>
							
							<form id="add_sn_delivery_form" class="form" method="POST">								
								<input hidden type="hidden" id="r" name="r" value="<?php echo 'index.php?p='.encode_url('19').'&s='.encode_url('v');?>">
								<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
								<input hidden type="hidden" id="ac" name="ac" value="<?php echo encode_url('a'); ?>">
								<input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">
								<input hidden type="hidden" id="dt" name="dt" value="<?php echo encode_url($dt); ?>">
								<input hidden type="hidden" id="st" name="st" value="<?php echo encode_url($st); ?>">
								<input hidden type="hidden" id="bt" name="bt" value="<?php echo encode_url($bt); ?>">
								<input hidden type="hidden" id="rt" name="rt" value="<?php echo encode_url($rt); ?>">
								<input hidden type="hidden" id="sp" name="sp" value="<?php echo encode_url($sp); ?>">
								<input hidden type="hidden" id="tb" name="tb" value="<?php echo encode_url($view); ?>">
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_deliver_serial"><span class="text-red">*</span> Serial:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">											
											<div class="media">
												<div class="media-object pull-right">
													<div id="verifier_div"><a class="btn btn-rounded btn-sm btn-alt waves-button waves-effect" id="verify_serial_button"><span class="icon icon-add"></span></a></div>
													<div id="progress_div" class="progress-circular progress-circular-inline progress-circular-alt">
														<div class="progress-circular-wrapper">
															<div class="progress-circular-inner">
																<div class="progress-circular-left">
																	<div class="progress-circular-spinner"></div>
																</div>
																<div class="progress-circular-gap"></div>
																<div class="progress-circular-right">
																	<div class="progress-circular-spinner"></div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="media-inner">
													<input class="form-control" id="unit_deliver_serial" name="unit_deliver_serial" placeholder="Enter serial " type="text">
												</div>
											</div>		
										</div>
									</div>
								</div>
								
								<div class="form-group form-group-label">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="result" ></label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<div id="result" class="errors-messages">
											</div>
										</div>
									</div>
								</div>
							
							</form>	
							
							<div class="row">
								<div class="col-lg-2 col-md-3 col-sm-4"></div>
								<div class="col-lg-4 col-md-6 col-sm-8">											
									<h3 class="content-sub-heading">Serials for <strong class="text-black"><?php echo $dt.' '.$sp;?></strong> delivery :  <strong class="text-black"> <?php echo $status;?></strong></h3>										
									<?php $delivery->print_deliveries_summary($dt,$st,$bt,$rt,$sp,$global_isAdmin); ?>	
								</div>
							</div>
					<?php }elseif($s==='c'){ ?>
							<h2 class="content-sub-heading">Please select technician and enter D.R. Number</h2>
							<form id="create_tsr_form" class="form">								
								<input hidden type="hidden" id="r" name="r" value="<?php echo 'index.php?p='.encode_url('19').'&s='.encode_url('v');?>">
								<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
								<input hidden type="hidden" id="ac" name="ac" value="<?php echo encode_url('a'); ?>">
								<input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">
								<input hidden type="hidden" id="dt" name="dt" value="<?php echo encode_url($dt); ?>">
								<input hidden type="hidden" id="st" name="st" value="<?php echo encode_url($st); ?>">
								<input hidden type="hidden" id="bt" name="bt" value="<?php echo encode_url($bt); ?>">
								<input hidden type="hidden" id="rt" name="rt" value="<?php echo encode_url($rt); ?>">
								<input hidden type="hidden" id="sp" name="sp" value="<?php echo encode_url($sp); ?>">
								<input hidden type="hidden" id="tb" name="tb" value="<?php echo encode_url($view); ?>">
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<span class="form-label">Date Out:</span>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<p class="form-control-static"><?php echo $dt;?></p>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<span class="form-label">Requisitioner:</span>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<p class="form-control-static"><?php echo $requisitioner;?></p>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<span class="form-label">Brand:</span>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<p class="form-control-static"><?php echo $brand;?></p>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<span class="form-label">Status:</span>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<p class="form-control-static"><?php echo $status;?></p>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_deliver_technician"><span class="text-red">*</span> Technician:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<select class="form-control" id="unit_deliver_technician" name="unit_deliver_technician">
												<option class="empty-option" value="">Select Technician</option>
												<?php $units->print_select_technicians($tech_id); ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_dr_no"><span class="text-red">*</span> D.R. Number:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<input class="form-control" id="unit_dr_no" name="unit_dr_no" placeholder="Enter D.R. Number " type="text" value="<?php echo $dr_no;?>">
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_test_power">Power On Test</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<div class="checkbox checkbox-adv">
												<label for="unit_test_power">
													<input class="access-hide test_tsr" id="unit_test_power" name="unit_test_power" type="checkbox" action="test" <?php echo $test_power;?>><span class="label_unit_test_power"><?php echo $text_power;?></span>
												<span class="circle"></span><span class="circle-check"></span><span class="circle-icon icon icon-done"></span></label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_test_fan">FAN Test</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<div class="checkbox checkbox-adv">
												<label for="unit_test_fan">
													<input class="access-hide test_tsr" id="unit_test_fan" name="unit_test_fan" type="checkbox" action="test" <?php echo $test_fan;?>><span class="label_unit_test_fan"><?php echo $text_fan;?></span>
												<span class="circle"></span><span class="circle-check"></span><span class="circle-icon icon icon-done"></span></label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_test_burn">BURN Test</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<div class="checkbox checkbox-adv">
												<label for="unit_test_burn">
													<input class="access-hide test_tsr" id="unit_test_burn" name="unit_test_burn" type="checkbox" action="test" <?php echo $test_burn;?>><span class="label_unit_test_burn"><?php echo $text_burn;?></span>
												<span class="circle"></span><span class="circle-check"></span><span class="circle-icon icon icon-done"></span></label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group form-group-label">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="input-color"></label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<div class="errors-messages">
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="form-group-btn">
									<div class="row">
										<div class="col-lg-4 col-lg-push-2 col-md-6 col-md-push-3 col-sm-4 col-sm-push-4">											
											<a class="btn btn-alt waves-button waves-effect waves-light pull-right" id="create_tsr_delivery_button"><span class="icon icon-description"></span>Create TSR</a>
											<a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Back</a>	
											
										</div>
									
									</div>
									<div class="row">
										<div class="col-lg-4 col-lg-push-2 col-md-6 col-md-push-3 col-sm-4 col-sm-push-4">	
											<a class="btn btn-flat btn-alt btn-sm waves-button waves-effect waves-light pull-right" href="<?php echo 'includes/exports/dr.php?p='.encode_url($page).'&s='.encode_url('s').'&dt='.encode_url($dt).'&st='.encode_url($st).'&bt='.encode_url($bt).'&rt='.encode_url($rt).'&sp='.encode_url($sp).'&tb='.encode_url($view); ?>" target="_blank"><span class="icon icon-print"></span>Print DR</a>																																									
											<a class="btn btn-flat btn-alt btn-sm waves-button waves-effect waves-light pull-right" id="update_delivery_info_button"><span class="icon icon-assignment-ind"></span>Update DR</a>
										</div>
									
									</div>
								</div>
						
							</form>
							
					<?php }elseif($s==='d'){ ?>
					
					<?php }else{ ?>
						<!--<h2 class="content-sub-heading">Items List</h2> -->
						<div class="table-responsive">
							<table class="table footable toggle-circle-filled-colored" data-sorting="true" data-filter="#filter" data-page-size="10" data-limit-navigation="5">
								<thead>
									<tr>
										<th data-toggle="true">Date</th>
										<th data-hide="phone">Remarks</th>
										<th data-hide="phone">Brand</th>	
										<th data-hide="phone">Requisitioner</th>	
										<th data-hide="phone">Completed</th>	
										<th data-hide="all">Serials</th>									
									</tr>
								</thead>
								<tbody>
									<?php $delivery->print_deliveries($global_isAdmin); ?>							
								</tbody>								
							</table>
						</div>
					
					
					<?php } ?>
					</div>
					<div class="col-md-3 col-md-4 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
									<h2 class="content-sub-heading">Latest Delivery</h2>
									<ul>
										<?php $delivery->print_latest_deliveries($global_isAdmin); ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	