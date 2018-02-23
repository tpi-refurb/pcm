<?php

	
	$password=
	$reason =
	$serial=
	$serial_2=
	$asset_no=
	$matcode=
	$ref_no=
	$brand_img =
	$brand=
	$requisitioner=
	$date_in=
	$date_out=
	$dr_no=
	$tpi_code=
	$technician=
	$test_id=
	$notes=
	$is_warranty=
	$date_modified=
	$active=
	$checked ='';
	if($s==='g'){
		if($pn==='1'){
			$title = $db->getValue('pcm_requisitioners','requisitioner','id='.$id);
		}else{
			$brand = $db->getValue('pcm_brands','brand_name','id='.$b);
			$brand_img = $db->getValue('pcm_brands','image','id='.$b);
			$requisitioner = $db->getValue('pcm_requisitioners','requisitioner','id='.$r);
			$title = $brand;
		}
	}else{
		if(!empty($id)){
			$q ="SELECT * FROM pcm_serials WHERE id= ".$id;
			$rs = $db->getResults($q);
			if(count($rs)>0){
				foreach($rs as $r){
					$serial		=$r['serial'];
					$serial_2	=$r['serial_2'];
					$asset_no	=$r['asset_no'];
					$ref_no		=$r['reference_no'];
					$matcode	=$r['matcode'];
					$brand		=$r['brand'];
					$requisitioner=$r['requisitioner'];
					$date_in	=$r['date_in'];
					$notes=		$r['notes'];
					$is_warranty=$r['is_warranty'];
					$checked = $is_warranty ==='1'? 'checked': '';
				}
			}		
		}
		
	}

?>
<div class="content">
		<div class="content-heading">
			<div class="container container-full">
				<h1 class="heading"><?php echo $title; ?></h1>
			</div>
		</div>
		<div class="content-inner">
			<div class="container container-full">
				<div class="row row-fix">
			
					<div class="col-md-3 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
										
								<?php if($s==='g' and $pn==='2'){ ?>
										<h2 class="content-sub-heading">Entry Details</h2>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-12">
													<label class="form-label"> Received Date:</label>
												</div>
												<div class="col-lg-12">
													<p class="form-control-static"><strong class="text-alt"><?php echo $rd;?></strong></p>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-12">
													<label class="form-label">Requisitioner:</label>
												</div>
												<div class="col-lg-12">
													<p class="form-control-static"><strong class="text-alt"><?php echo $requisitioner;?></strong></p>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-12">
													<label class="form-label">Reference Number:</label>
												</div>
												<div class="col-lg-12">
													<p class="form-control-static"><strong class="text-alt"><?php echo $rn;?></strong></p>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-lg-12">
													<label class="form-label">MATCODE:</label>
												</div>
												<div class="col-lg-12">
													<p class="form-control-static"><strong class="text-alt"><?php echo $m;?></strong></p>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">													
												<div class="col-md-2 col-sm-6">
													<label class="form-label">Entries:</label>
												</div>
												<div class="col-md-8 col-sm-6">
													<span class="avatar avatar-alt avatar-xs"><?php echo $units->getEntryCount($rd,$r); ?></span>
												</div>												
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-lg-12">
													<label class="form-label">Image:</label>
												</div>
												<div class="col-lg-12">
													<img class="requi-logo" style="width:250px;height:250px;" src="<?php echo $brand_img; ?>" />
												</div>
											</div>
										</div>

								<?php }else { ?>
									<h2 class="content-sub-heading">Quick Add from:</h2>
									<div class="tile-wrap">										
										<?php $mainten->print_tile_requisitioner();?>
										
									</div>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>

					
					<div class="col-md-6">
						
						<form id="entry_form" class="form">
							
							<input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">
						<?php if($s==='a' or $s==='u'){ ?>
							<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
							<h2 class="content-sub-heading">Please fill up information.</h2>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="input-color"></label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<div class="checkbox checkbox-adv">
											<label for="unit_claimed_warranty">
												<input class="access-hide" id="unit_claimed_warranty" name="unit_claimed_warranty" type="checkbox"  <?php echo $checked; ?>>Claimed as under warranty
											<span class="circle"></span><span class="circle-check"></span><span class="circle-icon icon icon-done"></span></label>
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_received_date1"><span class="text-red">*</span> Received Date:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<div class="media">
											<div class="media-object pull-right">
												<label class="form-icon-label" for="unit_received_date"><span class="access-hide">Received Date:</span><span class="icon icon-event"></span></label>
											</div>
											<div class="media-inner">
												<input class="datepicker-adv datepicker-adv-default form-control picker__input" id="unit_received_date" name="unit_received_date" type="text" readonly="" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="unit_received_date_root" value="<?php echo $date_in;?>">
											</div>
										</div>						
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_reference_no">Reference Number:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_reference_no" name="unit_reference_no" placeholder="Enter Reference Number" type="text" value="<?php echo $ref_no;?>">
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_matcode">MATCODE:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_matcode" name="unit_matcode" placeholder="Enter matcode" type="text" value="<?php echo $matcode;?>">
									</div>
								</div>
							</div>
														
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_requisitioner"><span class="text-red">*</span> Requisitioner:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<select class="form-control" id="unit_requisitioner" name="unit_requisitioner">
											<option class="empty-option" value="">Select Requisitioner</option>
											<?php $units->print_select_requisitioners($requisitioner); ?>
										</select>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_brand"><span class="text-red">*</span> Brand:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<select class="form-control" id="unit_brand" name="unit_brand">
											<option value="">Select Brand</option>
											<?php $units->print_select_brands($brand); ?>
										</select>
									</div>
								</div>
							</div>
													
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_serial"><span class="text-red">*</span> Serial 1:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_serial" name="unit_serial" placeholder="Enter serial " type="text" value="<?php echo $serial;?>">
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_serial2">Serial 2:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_serial2" name="unit_serial2" placeholder="Enter serial 2" type="text" value="<?php echo $serial_2;?>">
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_asset">Asset 1:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_asset" name="unit_asset" placeholder="Enter asset 1" type="text" value="<?php echo $asset_no;?>">
									</div>
								</div>
							</div>
						
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_notes">Notes:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<textarea class="form-control" id="unit_notes" name="unit_notes" rows="3"> <?php echo $notes;?></textarea>
									</div>
								</div>
							</div>
							
						<?php }elseif($s==='d'){ ?>
							<input hidden type="hidden" id="r" name="r" value="<?php echo 'index.php?p='.encode_url('11').'&s='.encode_url($s); ?>">
							<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
							<h2 class="content-sub-heading">Please enter reason and password to delete <strong class="text-black"><?php echo $serial; ?>.</strong></h2>							
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_reason"><strong class="text-red">*</strong> Reason:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<textarea class="form-control" id="unit_reason" name="unit_reason" rows="3"> <?php echo $reason;?></textarea>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_password"><strong class="text-red">*</strong> Password:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_password" name="unit_password" placeholder="Enter password" type="password" value="<?php echo $password;?>">
									</div>
								</div>
							</div>	
							
							<!--
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
							-->
							
						<?php }elseif($s==='g'){ ?>
								<?php if($pn==='1'){ ?>
									<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
									<input hidden type="hidden" id="pn" name="pn" value="<?php echo encode_url($pn); ?>">
									<h2 class="content-sub-heading">Please fill up information.</h2>									
									<div class="form-group">
										<div class="row">
											<div class="col-lg-2 col-md-3 col-sm-4">
												<label class="form-label" for="unit_received_date1"><span class="text-red">*</span> Received Date:</label>
											</div>
											<div class="col-lg-4 col-md-6 col-sm-8">
												<div class="media">
													<div class="media-object pull-right">
														<label class="form-icon-label" for="unit_received_date"><span class="access-hide">Received Date:</span><span class="icon icon-event"></span></label>
													</div>
													<div class="media-inner">
														<input class="datepicker-adv datepicker-adv-default form-control picker__input" id="unit_received_date" name="unit_received_date" type="text" readonly="" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="unit_received_date_root" value="<?php echo $rd;?>">
													</div>
												</div>						
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-lg-2 col-md-3 col-sm-4">
												<label class="form-label" for="unit_reference_no">Reference Number:</label>
											</div>
											<div class="col-lg-4 col-md-6 col-sm-8">
												<input class="form-control" id="unit_reference_no" name="unit_reference_no" placeholder="Enter Reference Number" type="text" value="<?php echo $rn;?>">
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-lg-2 col-md-3 col-sm-4">
												<label class="form-label" for="unit_matcode">MATCODE:</label>
											</div>
											<div class="col-lg-4 col-md-6 col-sm-8">
												<input class="form-control" id="unit_matcode" name="unit_matcode" placeholder="Enter matcode" type="text" value="<?php echo $m;?>">
											</div>
										</div>
									</div>
							
									<div class="form-group">
										<div class="row">
											<div class="col-lg-2 col-md-3 col-sm-4">
												<label class="form-label" for="unit_brand"><span class="text-red">*</span> Brand:</label>
											</div>
											<div class="col-lg-4 col-md-6 col-sm-8">
												<select class="form-control" id="unit_brand" name="unit_brand">
													<option value="">Select Brand</option>
													<?php $units->print_select_brands($b); ?>
												</select>
											</div>
										</div>
									</div>
								
									<div class="form-group">
										<div class="row">
											<div class="col-lg-2 col-md-3 col-sm-4">
												<label class="form-label" for="unit_quantity"><span class="text-red">*</span> Quantity:</label>
											</div>
											<div class="col-lg-4 col-md-6 col-sm-8">
												<input class="form-control" id="unit_quantity" name="unit_quantity" placeholder="Enter pickup quantity" type="text" value="<?php echo $m;?>">
											</div>
										</div>
									</div>
								
								<?php }else if($pn==='2'){ ?>
										<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url('a'); ?>">
										<input hidden type="hidden" id="unit_brand" name="unit_brand" value="<?php echo $b; ?>">
										<input hidden type="hidden" id="unit_received_date" name="unit_received_date" value="<?php echo $rd; ?>">
										<input hidden type="hidden" id="unit_requisitioner" name="unit_requisitioner" value="<?php echo $r; ?>">
										<input hidden type="hidden" id="unit_reference_no" name="unit_reference_no" value="<?php echo $rn; ?>">
										<input hidden type="hidden" id="unit_matcode" name="unit_matcode" value="<?php echo $m; ?>">
										
										<h2 class="content-sub-heading">Please enter serial and click save.</h2>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-4">
                                            <label class="form-label" for="input-color"></label>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-8">
                                            <div class="checkbox checkbox-adv">
                                                <label for="auto_save">
                                                    <input class="access-hide" id="auto_save" name="auto_save" type="checkbox" <?php echo ($config->pcm_auto_save_serial ==='1') ? 'checked': ''; ?>>Auto save when enter key is press
                                                    <span class="circle"></span><span class="circle-check"></span><span class="circle-icon icon icon-done"></span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div><br><br>


										<div class="form-group">
											<div class="row">
												<div class="col-lg-2 col-md-3 col-sm-4">
													<label class="form-label" for="unit_serial"><span class="text-red">*</span> Serial 1:</label>
												</div>
												<div class="col-lg-4 col-md-6 col-sm-8">
													<input class="form-control" id="unit_serial" name="unit_serial" placeholder="Enter serial " type="text" value="<?php echo $serial;?>">

                                                </div>
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-lg-2 col-md-3 col-sm-4">
													<label class="form-label" for="unit_serial2">Serial 2:</label>
												</div>
												<div class="col-lg-4 col-md-6 col-sm-8">
													<input class="form-control" id="unit_serial2" name="unit_serial2" placeholder="Enter serial 2" type="text" value="<?php echo $serial_2;?>">
												</div>
											</div>
										</div>
										<!--
										<div class="form-group">
											<div class="row">
												<div class="col-lg-2 col-md-3 col-sm-4">
													<label class="form-label" for="unit_asset">Asset 1:</label>
												</div>
												<div class="col-lg-4 col-md-6 col-sm-8">
													<input class="form-control" id="unit_asset" name="unit_asset" placeholder="Enter asset 1" type="text" value="<?php echo $asset_no;?>">
												</div>
											</div>
										</div>
										-->
										
										<div class="form-group">
											<div class="row">
												<div class="col-lg-2 col-md-3 col-sm-4">
													<label class="form-label" for="unit_notes">Notes:</label>
												</div>
												<div class="col-lg-4 col-md-6 col-sm-8">
													<textarea class="form-control" id="unit_notes" name="unit_notes" rows="2"><?php echo $notes;?></textarea>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-lg-2 col-md-3 col-sm-4">
													<label class="form-label" for="input-color"></label>
												</div>
												<div class="col-lg-4 col-md-6 col-sm-8">
													<div class="checkbox checkbox-adv">
														<label for="unit_claimed_warranty">
															<input class="access-hide" id="unit_claimed_warranty" name="unit_claimed_warranty" type="checkbox"  <?php echo $checked; ?>>Claimed as under warranty
														<span class="circle"></span><span class="circle-check"></span><span class="circle-icon icon icon-done"></span></label>
													</div>
												</div>
											</div>
										</div>
								
								<?php }else{ ?>

								<?php } ?>
						
						<?php }else{ ?>
						
						<?php } ?>
						
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
								<div class="col-lg-4 col-lg-push-2 col-md-6 col-md-push-3 col-sm-8 col-sm-push-4">								
									<span class="margin-right-half text-red">*</span><span >means required</span><br>
									<?php if($s==='g' and $pn==='1'){ ?>
                                        <?php if(!$is_mobile){ ?>
										<a class="btn btn-alt waves-button waves-effect waves-light pull-right" id="next_add_button">Next<span class="icon icon-arrow-forward"></span></a>
                                        <?php } ?>
                                        <a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Back</a>
									<?php }else if($s==='g' and $pn==='2'){ ?>
                                        <?php if(!$is_mobile){ ?>
                                            <a class="btn btn-alt waves-button waves-effect waves-light pull-right"  id="save_entry_button"><span class="icon icon-save"></span>&nbsp;&nbsp;Save</a>
                                        <?php } ?>
                                        <a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="<?php echo 'index.php?p='.encode_url('12').'&s='.encode_url('g').'&l='.encode_url('Requisitioners').'&i='.encode_url($id).'&r='.encode_url($r).'&pn='.encode_url('1').'&m='.encode_url($m).'&rd='.encode_url($rd).'&rn='.encode_url($rn).'&b='.encode_url($b); ?>"><span class="icon icon-arrow-back"></span>Back</a>

                                    <?php }else if($s==='d'){ ?>
                                        <?php if($is_mobile or $is_tablet){ ?>
                                            <a class="btn btn-flat btn-green waves-button waves-effect waves-light pull-right"  href="<?php echo 'index.php?p='.encode_url('11');?>"><span class="icon icon-search"></span>View All</a>
                                        <?php }else{ ?>
                                            <a class="btn btn-red waves-button waves-effect waves-light pull-right"  id="delete_entry_button"><span class="icon icon-delete"></span>&nbsp;&nbsp;Delete</a>
                                        <?php } ?>
                                        <a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Back</a>

                                    <?php }else{ ?>
									<?php } ?>

                                </div>
							</div>
						</div>
						
						
					</form>
				
			
					</div>
					<div class="col-md-3 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
									<h2 class="content-sub-heading">Latest Entries</h2>
									<!--<ul>
										<?php $units->print_latest_entries($global_isAdmin); ?>
									</ul>
									-->
                                    <?php $units->print_tiled_latest_entries($global_isAdmin); ?>
								</div>
                                <?php if($global_isAdmin){ ?>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-10 col-md-push-1">
                                                <a class="btn btn-block btn-alt waves-button waves-effect waves-light" href="<?php echo 'index.php?p='.encode_url('11').'&s='.encode_url('v');?>">View More...</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	