<?php

if($s==='a' and !$isLogin){ 
	$s ='v'; // if not login and state is Add then set as View state
}
	
$serial ='';
if(!empty($id)){
	$serial = $db->getValue('pcm_serials','serial', 'id='.$id);
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
					<div class="col-md-8">
						
					<?php if($s==='a'){ ?>
						<h2 class="content-sub-heading">Attachments for <strong class="text-default"><?php echo $serial;?></strong>.</h2>
						<form id="attachments_form" class="form">
							<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
							<input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">
						
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_type"><span class="text-red">*</span> Type:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<select class="form-control" id="unit_type" name="unit_type">
											<option value="link">Link</option>
                                            <option value="file">File</option>
                                            <option value="photo">Take Photo</option>
                                        </select>
									</div>
								</div>
							</div>
                            <div class="form-group" id="attach_link">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <label class="form-label" for="unit_url"><span class="text-red">*</span>Enter URL:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <input class="form-control" id="unit_url" name="unit_url" placeholder="Enter URL..." type="url">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="attach_capture">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <label class="form-label" for="unit_url"><span class="text-red">*</span>Take Photo:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <div class="media">
                                            <div class="media-object pull-right">
                                                <label class="btn btn-alt waves-button waves-effect waves-light" for="photo_file">
                                                    <i class="fa fa-camera"></i>
                                                </label>
                                            </div>
                                            <div class="media-inner">
                                                <input class="form-control"  id="photo_file" name="photo_file" type="text" value="Capture image from Web Cam" readonly>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="form-group" id="attach_file">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="input-file"><span class="text-red">*</span>Browse file:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<div class="media">
											<div class="media-object pull-right">
												<label class="btn btn-alt waves-button waves-effect waves-light" for="unit_attachments">
													<i class="fa fa-cloud-upload"></i>
												</label>
											</div>
											<div class="media-inner">
												<input class="form-control"  id="display_file" name="display_file" type="text" value="No chosen file" readonly>
												<input style="display: none;" id="unit_attachments" name="unit_attachments" type="file">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_url"><span class="text-red">*</span>Friendly Name:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_name" name="unit_name" placeholder="Enter Description" type="text">
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
											<label for="unit_view">
												<input class="access-hide" id="unit_view" name="unit_view" type="checkbox" >Show this file in public
											<span class="circle"></span><span class="circle-check"></span><span class="circle-icon icon icon-done"></span></label>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group form-group-label">
								<div class="row">
									<div class="col-md-10 col-md-push-1">
										<div class="errors-messages">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group-btn">
								<div class="row">
									<div class="col-lg-4 col-lg-push-2 col-md-6 col-md-push-3 col-sm-4 col-sm-push-4">
                                        <?php if($is_mobile or $is_tablet){ ?>
                                            <!-- @Todo -->
                                        <?php }else{ ?>
										<a class="btn btn-alt waves-button waves-effect waves-light pull-right" id="save_attach_button">Save Attachment</a>
                                        <?php } ?>
                                        <a class="btn btn-flat waves-button waves-effect waves-light pull-right" href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Back</a>
									</div>
								
								</div>
							</div>
						</form>
					<?php }elseif($s==='v'){ ?>
						<h2 class="content-sub-heading">Attachments for <strong class="text-default"><?php echo $serial;?></strong>.						
						</h2>
						<br>
						<div class="card-wrap">
							<div class="row">
								
								<?php $units->print_attachments($id,$global_isAdmin	);?>
								
							</div>						
						</div>
						<?php if($global_isAdmin) { ?>
						<div class="form-group-btn">
							<div class="row">
								<a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Back</a>
							</div>
						</div>
						<?php } ?>
					
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
				</div>
			</div>
		</div>
	</div>
	