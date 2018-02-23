<?php
	
	if($s==='a' and !$isLogin){ 
		$s ='v'; // if not login and state is Add then set as View state
	}
	$reason=
	$password=
	$brand=
	$requisitioner=
	$logo=
	$contact_person=
	$address=
	$tin=
	$status=
	$description=
	$technician=
	$firstname=
	$middlename=
	$lastname =
    $part =
    $portion =
	$active='';
	$checked ='checked';
	$color='#5367ce';


	
	if(!empty($id)){
		$tables	=array('Brands'=>'pcm_brands','Status'=>'pcm_status', 'Requisitioners'=>'pcm_requisitioners', 'Technicians'=>'pcm_technicians', 'Parts'=>'pcm_parts_libraries');
		$table = $tables[$l];
		$q ="SELECT * FROM ".$table." WHERE id= ".$id;
		$rs = $db->getResults($q);
		if(count($rs)>0){
			foreach($rs as $r){
				$active = $r['active'];
				if($l==='Brands'){
					$brand          =$r['brand_name'];
				}else if($l==='Status'){
					$status         =$r['status'];
					$description	=$r['description'];
					$color          =$r['icolor'];
				}else if($l==='Requisitioners'){
					$requisitioner  =$r['requisitioner'];
					$contact_person =$r['contact_person'];
					$logo           =$r['logo'];
					$address        =$r['address'];
					$tin            =$r['tin'];
				}else if($l==='Technicians'){
                    $firstname		=$r['firstname'];
                    $middlename     =$r['middlename'];
                    $lastname       =$r['lastname'];
                }else if($l==='Parts'){
                    $part           =$r['part'];
                    $portion        =$r['portion'];
                    $brand          =$r['brand'];
                }else{
					
				}				
				$checked = $active ==='1'? 'checked': '';
			}
		}		
	}

if($l==='Parts'){
    $units->check_parts_libs();
}
?>
<div class="content">
		<div class="content-heading">
			<div class="container container-full">
				<h1 class="heading"><?php echo $l; ?></h1>
			</div>
		</div>
		<div class="content-inner">
			<div class="container container-full">
				<div class="row row-fix">					
					<div class="col-md-8">
						
					<?php if($s==='v'){ ?>
						<div class="table-responsive">
							<table class="table footable toggle-circle-filled-colored" data-sorting="true" data-filter="#filter" data-page-size="10" data-limit-navigation="5" title="<?php echo empty($l)?'All': $l; ?> Table">
								<thead>
									
										<?php $mainten->print_static_colums($l,$global_isAdmin); ?>							
									
								</thead>
								<tbody>
									<?php $mainten->print_table_rows($l,$global_isAdmin); ?>
								</tbody>
								<tfoot class="hide-if-no-paging">
									<tr>										
										<td colspan="4" class="text-center">
											<ul class="pagination nav nav-list"></ul>
										</td>
									</tr>
								</tfoot>								
							</table>
						</div>
						
						
					
					<?php }elseif($s==='a' or $s==='u'){ ?>
					<h2 class="content-sub-heading">Please fill up information.</h2>
					<form id="mainten_form" class="form" method="post" enctype="multipart/form-data">
							<input hidden type="hidden" id="r" name="r" value="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('v').'&l='.encode_url($l);?>">
							<input hidden type="hidden" id="l" name="l" value="<?php echo encode_url($l); ?>">
							<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
							<input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">
						<?php if($l==='Requisitioners'){ ?>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_requisitioner"><span class="text-red">*</span> Requisitioner:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_requisitioner" name="unit_requisitioner" placeholder="Enter requisitioner " type="text" value="<?php echo $requisitioner;?>">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_contact_person"><span class="text-red">*</span> Contact Person:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_contact_person" name="unit_contact_person" placeholder="Enter contact person " type="text" value="<?php echo $contact_person;?>">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_tin">TIN:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_tin" name="unit_tin" placeholder="Enter TIN" type="text" value="<?php echo $tin;?>">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_address"><span class="text-red">*</span> Address:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_address" name="unit_address" placeholder="Enter address " type="text" value="<?php echo $address;?>">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="input-file"><span class="text-red">*</span>Browse Logo:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<div class="media">
											<div class="media-object pull-right">
												<label class="btn btn-alt waves-button waves-effect waves-light" for="req_image">
													<i class="fa fa-cloud-upload"></i>
												</label>
											</div>
											<div class="media-inner">
												<input class="form-control"  id="display_file" name="display_file" type="text" value="No chosen file" readonly>
												<input style="display: none;" id="req_image" name="req_image" type="file">
											</div>
										</div>
									</div>
								</div>
							</div>
							
						<?php }elseif($l==='Brands'){ ?>
                            <input hidden type="hidden" id="cru" name="cru" value="<?php echo 'index.php?p='.encode_url('21').'&s='.encode_url('v').'&l='.encode_url($l).'&b=';?>">

                            <div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_brand"><span class="text-red">*</span> Brand Name:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_brand" name="unit_brand" placeholder="Enter brand " type="text" value="<?php echo $brand;?>" required>
									</div>
								</div>
							</div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <label class="form-label" for="unit_capture_photo"></label>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <div class="checkbox checkbox-adv">
                                            <label for="unit_capture_photo">
                                                <input class="access-hide" id="unit_capture_photo" name="unit_capture_photo" type="checkbox">Capture image from camera
                                                <span class="circle"></span><span class="circle-check"></span><span class="circle-icon icon icon-done"></span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

							<div class="form-group brand_upload">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="input-file"><span class="text-red">*</span>Brand Picture:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<div class="media">
											<div class="media-object pull-right">
												<label class="btn btn-alt waves-button waves-effect waves-light" for="req_image">
													<i class="fa fa-cloud-upload"></i>
												</label>
											</div>
											<div class="media-inner">
												<input class="form-control" id="display_file" name="display_file" value="No chosen file" readonly="" type="text">
												<input style="display: none;" id="req_image" name="req_image" type="file">
											</div>
										</div>
									</div>
								</div>
							</div>
                            <div class="form-group brand_capture">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <label class="form-label" for="input-file"><span class="text-red">*</span>Brand Picture:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <div class="media">

                                            <div class="media-inner">
                                                <!--<input class="form-control" id="display_file" name="display_file" value="No captured image" readonly="" type="text"> -->
                                                <div id="screen"> </div>
                                                <div class="transbox">
                                                    <h1 id="count_down">3</h1>

                                                </div>
                                            </div>
                                            <a class="btn btn-alt waves-button waves-effect waves-light" id=capture_button"  name=capture_button" >
                                                <i class="fa fa-camera"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
						<?php }elseif($l==='Status'){ ?>	
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_status">Status:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_status" name="unit_status" placeholder="Enter status" type="text" value="<?php echo $status;?>">
									</div>
								</div>
							</div>
							
							
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_description"><span class="text-red">*</span> Description:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<input class="form-control" id="unit_description" name="unit_description" placeholder="Enter Description" type="text" value="<?php echo $description;?>">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="unit_color"><span class="text-red">*</span> Color:</label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										
										<div class="media">
											<div class="media-object pull-right">												
												<input class="form-control" id="color_status" name="color_status" type="color" value="<?php echo $color;?>">
											</div>
											<div class="media-inner">
												<input class="form-control" id="unit_color" name="unit_color"  type="text" value="<?php echo $color;?>" readonly>
											</div>
										</div>	
									</div>
								</div>
							</div>


                        <?php }elseif($l==='Technicians'){ ?>


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <label class="form-label" for="unit_firstname"><span class="text-red">*</span> Firstname:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <input class="form-control" id="unit_firstname" name="unit_firstname" placeholder="Enter firstname" type="text" value="<?php echo $firstname;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <label class="form-label" for="unit_middlename"><span class="text-red">*</span> Middlename:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <input class="form-control" id="unit_middlename" name="unit_middlename" placeholder="Enter Middlename" type="text" value="<?php echo $middlename;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <label class="form-label" for="unit_lastname"><span class="text-red">*</span> Lastname:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <input class="form-control" id="unit_lastname" name="unit_lastname" placeholder="Enter Lastname" type="text" value="<?php echo $lastname;?>">
                                    </div>
                                </div>
                            </div>
                        <?php }elseif($l==='Parts'){ ?>


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <label class="form-label" for="unit_part"><span class="text-red">*</span> Components:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <input class="form-control" id="unit_part" name="unit_part" placeholder="Enter parts" type="text" value="<?php echo $part;?>">
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
                                        <label class="form-label" for="unit_portion"><span class="text-red">*</span> Portion:</label>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-8">
                                        <input class="form-control" id="unit_portion" name="unit_portion" placeholder="Enter portion" type="text" value="<?php echo $portion;?>">
                                    </div>
                                </div>
                            </div>

                        <?php }else{ ?>
								<!---@TODO--->
						<?php } ?>
							
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-3 col-sm-4">
										<label class="form-label" for="input-color"></label>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-8">
										<div class="checkbox checkbox-adv">
											<label for="unit_active">
												<input class="access-hide" id="unit_active" name="unit_active" type="checkbox"  <?php echo $checked; ?>>Set as Active
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
								<div class="col-lg-4 col-lg-push-2 col-md-6 col-md-push-3 col-sm-8 col-sm-push-4">								
									<span class="margin-right-half text-red">*</span><span >means required</span><br>
                                    <?php if($is_mobile or $is_tablet){ ?>
									    <a class="btn btn-flat btn-green waves-button waves-effect waves-light pull-right"  href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('v').'&l='.encode_url($l);?>"><span class="icon icon-search"></span>View All</a>
                                    <?php }else{ ?>
                                        <?php if($s==='a'){ ?>
                                        <a class="btn btn-alt waves-button waves-effect waves-light pull-right"  id="save_mainten_button"><span class="icon icon-save"></span>&nbsp;&nbsp;Save</a>
                                        <?php } else { ?>
                                            <a class="btn btn-alt waves-button waves-effect waves-light pull-right"  id="update_mainten_button"><span class="icon icon-check"></span>&nbsp;&nbsp;Update</a>
                                        <?php } ?>
                                    <?php } ?>
                                    <a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Back</a>
									
								</div>
							</div>
						</div>
					</form>
					<?php }elseif($s==='d'){ ?>		
							<h2 class="content-sub-heading">Please enter reason and password.</h2>
							<form id="mainten_form" class="form">
								<input hidden type="hidden" id="r" name="r" value="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('v').'&l='.encode_url($l);?>">
								<input hidden type="hidden" id="l" name="l" value="<?php echo encode_url($l); ?>">
								<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
								<input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">
								
								
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
                                            <?php if($is_mobile or $is_tablet){ ?>
                                                <a class="btn btn-flat btn-green waves-button waves-effect waves-light pull-right"  href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('v').'&l='.encode_url($l);?>"><span class="icon icon-search"></span>View All</a>
                                            <?php }else{ ?>
                                                <a class="btn btn-red waves-button waves-effect waves-light pull-right"  id="delete_mainten_button"><span class="icon icon-delete"></span>&nbsp;&nbsp;Delete</a>
                                            <?php } ?>
                                            <a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Back</a>

                                        </div>
                                    </div>
                                </div>
							</form>
					<?php }else{ ?>
					
					<?php } ?>
			
					</div>
					<div class="col-md-3 col-md-4 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
                                    <?php if($is_mobile) { ?>
                                        <p><a class="btn btn-block btn-alt collapsed waves-button waves-effect" data-toggle="collapse" href="#collapsible-entries"><span class="collapsed-hide">Hide Latest Entries</span><span class="collapsed-show">Show Latest Entries...</span></a></p>
                                        <div class="collapsible-region collapse" id="collapsible-entries">
                                            <ul>
                                                <?php $units->print_latest_entries($global_isAdmin); ?>
                                            </ul>
                                        </div>
                                    <?php }else { ?>
									<h2 class="content-sub-heading">Latest Entries</h2>
									<ul>
										<?php $units->print_latest_entries($global_isAdmin); ?>
									</ul>
                                    <?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php if($l==='Brands'){ ?>
<div aria-hidden="true" class="modal fade" id="modal_take_photo" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-heading">
                <a class="modal-close" data-dismiss="modal">&times;</a>
                <h2 class="modal-title text-alt">Take Photo</h2>
            </div>
            <div class="modal-inner">
                <div class="container">
                        <form id="capture_form" class="form">
                            <input hidden type="hidden" id="i" name="i" value="">

                            <div class="video-container">
                                <video class="video-player" id="v"></video>
                            </div>
                            <canvas id="canvas" style="display:none;"></canvas>
                            <img src="" id="photo" alt="photo">

                        </form>
                        <div class="clearfix">
                            <p class="margin-no-top pull-left"></p>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>
