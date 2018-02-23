
<div class="content">
		<div class="content-heading">
			<div class="container container-full">
				<h1 class="heading"><?php echo $title; ?></h1>
			</div>
		</div>
		<div class="content-inner">
			<div class="container container-full">
				<div class="row row-fix">
					<?php if($s==='s'){ ?>
						<div class="col-md-12 col-md-6 col-md-4">
						<p class="text-center success_settings">
							<?php if($l==='settings'){ ?>
							<h2 class="content-sub-heading text-center">Settings was successfully updated.</h2>
							<?php }else{ ?>
							<h2 class="content-sub-heading text-center password">Your password has been successfully changed. It will logout automatically.</h2>
							<?php } ?>
						</p>
						</div>
					<?php }elseif($s==='c'){ ?>
						<div class="col-md-8 col-md-12">
							<h2 class="content-sub-heading">Provide your current password then enter new one.</h2>
							<form id="password_form" class="form" method="post" enctype="multipart/form-data">
								<input hidden type="hidden" id="r" name="r" value="<?php echo 'index.php?p='.encode_url('13').'&s='.encode_url('s').'&l='.encode_url('password');?>">
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="ui_currentpassword"><span class="text-red">*</span>Current Password:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-6">
											<input class="form-control" id="ui_currentpassword" name="ui_currentpassword" placeholder="Enter current password" type="password" >
										</div>
									</div>
								</div>
								<br>
								<br>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="ui_password"><span class="text-red">*</span> Password:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-6">
											<input class="form-control" id="ui_password" name="ui_password" placeholder="Enter password" type="password" >
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="ui_confirmpassword"><span class="text-red">*</span> Confirm Password:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-6">
											<input class="form-control" id="ui_confirmpassword" name="ui_confirmpassword" placeholder="Enter re-type password" type="password" >
										</div>
									</div>
								</div>
								
								<div class="form-group form-group-label">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="error_msgs"></label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<div class="errors-messages">
											</div>
										</div>
									</div>
								</div>
								
							</form>
						</div>
					<?php }elseif($s==='v'){ ?>
					
					
					<div class="col-md-8">					
					
						<form id="settings_form" class="form" method="post" enctype="multipart/form-data">
								<input hidden type="hidden" id="r" name="r" value="<?php echo 'index.php?p='.encode_url('13').'&s='.encode_url('s').'&l='.encode_url('settings');?>">
								<input hidden type="hidden" id="l" name="l" value="<?php echo encode_url($l); ?>">
								<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
								<input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">

								<?php 
											
												$keys = array('site'=>'Site','smtp'=>'Email','cookie'=>'Cookies','pcm'=>'System');
												
												foreach($keys as $k => $v){
													?>
													
													<h2 class="content-sub-heading"><?php echo $v;?> Configuration</h2>
													<div id="ui_collapse_<?php echo $k;?>">
														<?php 
															$q = "SELECT * FROM config WHERE setting LIKE '".$k."%';";
															//$q = "SELECT * FROM tlr.config;";
															$rs = $db->getResults($q);
															foreach($rs as $r){ 
																$name = $r['setting'];
																$val = $r['value'];
																$type = $r['type'];
																$desc = $r['description'];
																$required = $r['required'];
																$setting = str_replace('site_','', $name);
																$show_req = ($required==='1')?'<span class="text-red">*</span>':'';
															
															if($type=='BOOLEAN'){
																$checked = ($val==='1')? 'checked' : '';
																echo '
																<div class="form-group">
																	<div class="row">
																		<div class="col-lg-2 col-md-3 col-sm-4">
																			<label class="form-label" for="ui_settings_'.$name.'"></label>
																		</div>
																		<div class="col-lg-4 col-md-6 col-sm-8">
																			<div class="checkbox checkbox-adv">
																				<label for="ui_settings_'.$name.'">
																					<input class="access-hide" id="ui_settings_'.$name.'" name="ui_settings_'.$name.'" type="checkbox" '.$checked.'>'.$desc.'
																				<span class="circle"></span><span class="circle-check"></span><span class="circle-icon icon icon-done"></span></label>
																			</div>
																		</div>
																	</div>
																</div>';
															}else if($type=='VARCHAR'){
																
															}else{
																echo '<div class="form-group">
																	<div class="row">
																		<div class="col-lg-2 col-md-3 col-sm-4">
																			<label class="form-label" for="ui_settings_'.$name.'">'.$show_req.$desc.'</label>
																		</div>
																		<div class="col-lg-4 col-md-6 col-sm-8">
																			<input class="form-control" type="text" placeholder="Enter '.$desc.'" id="ui_settings_'.$name.'" name="ui_settings_'.$name.'"  value="'.$val.'">
																		</div>
																	</div>
																</div>';
															}
															}
															
														?>
													</div>
													
													<?php
												}
											
											
											?>
								
								<div class="form-group form-group-label">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="error_msgs"></label>
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
											<a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Cancel</a>
											
										</div>
									</div>
								</div>
						</form>
						
						
			
					</div>
					<div class="col-md-3 col-md-4 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
									<h2 class="content-sub-heading">Latest Activities</h2>
									<ul>
										<?php $units->print_latest_activities($global_isAdmin,'10'); ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<?php }else{?>
					
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	