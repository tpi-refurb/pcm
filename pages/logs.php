<?php

if($s==='a' and !$isLogin){ 
	$s ='v'; // if not login and state is Add then set as View state
}

$checked ='';
$serial ='';
if(!empty($id)){
	$serial = $db->getValue('pcm_serials','serial', 'id='.$id);
	$status_id = $db->getValue('pcm_serials','status', 'id='.$id);
	$status = $db->getValue('pcm_status','status', 'id='.$status_id);
	$checked = (strtoupper($status)==='REPAIRED')? 'checked' : '';
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
							
					<?php if(empty($s) or $s==='s'){ ?>
						<div class="col-md-12 col-md-10 col-md-8">
							<div class="card-wrap">
								<div class="row">
								
									<?php $units->print_all_logs($global_isAdmin); ?>				
									
									
								</div>
							</div>
						</div>
					<?php }else{ ?>
						<div class="col-md-8">						
							<?php if($s==='a'){ ?>
							<h2 class="content-sub-heading">Repair logs for <strong class="text-default"><?php echo $serial;?></strong>.</h2>
							
							<form id="logy_form" class="form">
								<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
								<input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">
							
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_repair_date"><span class="text-red">*</span> Performed Date:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<div class="media">
												<div class="media-object pull-right">
													<label class="form-icon-label" for="unit_repair_date"><span class="access-hide">Performed Date:</span><span class="icon icon-event"></span></label>
												</div>
												<div class="media-inner">
													<input class="datepicker-adv datepicker-adv-default form-control picker__input" id="unit_repair_date" name="unit_repair_date" type="text" readonly="" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="unit_repair_date_root" >
												</div>
											</div>						
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_repaired_portion"><span class="text-red">*</span> Repaired Portion:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<input class="form-control" id="unit_repaired_portion" name="unit_repaired_portion" placeholder="Enter repaired portion" type="text">
										</div>
									</div>
								</div>
									
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_repair_done"><span class="text-red">*</span> Repaired/Replaced Parts:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">

                                            <div class="media">
                                                <div class="media-object pull-right">
                                                    <label class="form-icon-label" for="unit_repair_done"><span class="btn-rounded btn-sm btn-alt waves-button waves-effect icon icon-refresh" id="generate_random_parts"></span></label>
                                                </div>
                                                <div class="media-inner">
                                                    <textarea class="form-control" id="unit_repair_done" name="unit_repair_done" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
									</div>
								</div>
								
								
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_mark_repaired"></label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<div class="checkbox checkbox-adv">
											<label for="unit_mark_repaired">
												<input class="access-hide" id="unit_mark_repaired" name="unit_mark_repaired" type="checkbox"  <?php echo $checked; ?>>Mark as REPAIRED
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
                                            <span class="margin-right-half text-red">*</span><span >means required</span><br>
                                            <?php if($is_mobile or $is_tablet){ ?>
											    <!-- @Todo -->
                                            <?php }else{ ?>
                                                <a class="btn btn-alt waves-button waves-effect waves-light pull-right" id="save_log_button">Save Log</a>
                                            <?php } ?>
                                            <a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Back</a>
										</div>
									
									</div>
								</div>
							</form>							
							<?php }elseif($s==='d'){ ?>
							
							<?php }elseif($s==='v'){ ?>
								<h2 class="content-sub-heading">Repair logs for <strong class="text-default"><?php echo $serial;?></strong>.</h2>
								<ul class="nav">
									<?php $units->print_serial_logs($id,$global_isAdmin,$s); ?>							
								</ul>
								<?php if($global_isAdmin) { ?>
								<div class="form-group-btn">
									<div class="row">
										<a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Back</a>
									</div>
								</div>
								<?php } ?>
							<?php }else{ ?>
							
							
							
							<?php } ?>						
						</div>
						
						<div class="col-md-3 col-md-4 content-fix">
							<div class="content-fix-scroll">
								<div class="content-fix-wrap">
									<div class="content-fix-inner">
                                        <?php if($is_mobile) { ?>
                                            <p><a class="btn btn-block btn-alt collapsed waves-button waves-effect" data-toggle="collapse" href="#collapsible-region"><span class="collapsed-hide">Hide Info</span><span class="collapsed-show">Show Info...</span></a></p>
                                            <div class="collapsible-region collapse" id="collapsible-region">
                                                <?php $units->print_item_info($id,$global_isAdmin, 'logs'); ?>
                                            </div>
                                        <?php }else { ?>
										<h2 class="content-sub-heading"><strong class="text-black"><?php echo $serial;?></strong> Information</h2>
											<?php $units->print_item_info($id,$global_isAdmin, 'logs'); ?>
                                        <?php } ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					
				</div>
			</div>
		</div>
	</div>
	