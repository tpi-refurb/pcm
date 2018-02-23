<?php

$title = 'Items';
if($s==='a'){
	if(!empty($id)){
		$rs = $db->getResults("SELECT * pcm_serials WHERE id =".$id);
	}
}else{
	
}

?>
<div class="content">
		<div class="content-heading">
			<div class="container container-full">
				<div class="col-md-6 col-sm-8">
					<h1 class="heading"><?php echo $title; ?> </h1>
				</div>
				<div class="col-md-6 col-sm-4">
					<div class="dropdown dropdown-inline pull-right">
						<a class="btn btn-alt dropdown-toggle-btn" data-toggle="dropdown"><?php echo empty($l)?'All': $l; ?><span class="icon icon-keyboard-arrow-down margin-left-half"></span></a>
						<ul class="dropdown-menu">
							<li>
								<a href="javascript:void(0)">1</a>
							</li>
							<li>
								<a href="javascript:void(0)">2</a>
							</li>
							<li>
								<a href="javascript:void(0)">3</a>
							</li>
						</ul>
					</div>
				</div>	
			</div>
		</div>
		<div class="content-inner">
			<div class="container container-full">
				<div class="row row-fix">				
					<div class="col-md-8">
					
						<h2 class="content-sub-heading">Basic Tab</h2>
						<nav class="tab-nav">
							<ul class="nav nav-justified">
								<?php $mainten->print_tab_requisitioner(); ?>
							</ul>
						</nav>
						<div class="tab-content">
								<?php $mainten->print_tab_reqcontent($global_isAdmin); ?>						
						</div>
					
					</div>
					<div class="col-md-3 col-md-4 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
									<h2 class="content-sub-heading">Latest Items Update</h2>
									<ul>
										<?php $units->print_latest_updates($global_isAdmin); ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div aria-hidden="true" class="modal fade" id="modal_update_status" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-xs">
			<div class="modal-content">
				<div class="modal-heading">
					<a class="modal-close" data-dismiss="modal">&times;</a>
					<h2 class="modal-title text-alt">Update Status</h2>
				</div>
				<div class="modal-inner">
					<h5 class="inner-title">Please select new Status for </h5>
					<div class="container">						
						<div class="row">							
							<form id="changestatus_form" class="form">
								<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url('cs'); ?>">
								<input hidden type="hidden" id="i" name="i" value="">
								<div class="form-group">
									<div class="row">										
										<div class="col-lg-12">
											<select style="color: rgb(21, 21, 21);" class="form-control" id="unit_status" name="unit_status">
												<option style="color: rgb(216, 216, 216);" value="">Select Remark</option>
												<?php $units->print_select_status($id); ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-12">
											<label class="form-label" for="unit_repaired_portion">Repaired Date:</label>
										</div>									
										<div class="col-lg-12">
											<div class="media">
												<div class="media-object pull-right">
													<label class="form-icon-label" for="unit_repaired_date"><span class="icon icon-event"></span></label>
												</div>
												<div class="media-inner">
													<input class="datepicker-adv datepicker-adv-default form-control picker__input" id="unit_repaired_date" name="unit_repaired_date" type="text" readonly="" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="unit_repaired_date_root" value="">
												</div>
											</div>						
										</div>
									</div>
								</div>
								
								<div  id="div_repaired_portion">
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<label class="form-label" for="unit_repaired_portion"><span class="text-red">*</span> Repaired Portion:</label>
											</div>
											<div class="col-lg-12">
												<input class="form-control" id="unit_repaired_portion" name="unit_repaired_portion" placeholder="Enter repaired portion" type="text">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<label class="form-label" for="unit_replaced_parts"><span class="text-red">*</span> Replaced Parts:</label>
											</div>
											<div class="col-lg-12">
												<input class="form-control" id="unit_replaced_parts" name="unit_replaced_parts" placeholder="Enter replaced parts" type="text">
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group-btn">
									<div class="row">
										<div class="col-lg-12">
											<a class="btn btn-alt waves-button waves-effect waves-light pull-right" id="update_status_button">Update</a>
											<a class="btn btn-flat waves-button waves-effect waves-light pull-right" data-dismiss="modal"><span class="icon icon-arrow-back"></span>Cancel</a>
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
								
							</form>							
							<div class="clearfix">
								<p class="margin-no-top pull-left"><a href="javascript:void(0)">Need help?</a></p>
							</div>							
						</div>
					</div>
					
				</div>				
			</div>
		</div>
	</div>
	
	
	
	<div aria-hidden="true" class="modal fade" id="modal_add_todeliver" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-xs">
			<div class="modal-content">
				<div class="modal-heading">
					<a class="modal-close" data-dismiss="modal">&times;</a>
					<h2 class="modal-title text-alt">Add to Deliver</h2>
				</div>
				<div class="modal-inner">
					<h5 class="inner-title">Please select delivery date </h5>
					<div class="container">						
						<div class="row">							
							<form id="to_deliver_form" class="form">
								<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url('cs'); ?>">
								<input hidden type="hidden" id="i" name="i" value="">
								<div class="form-group">
									<div class="row">										
										<div class="col-lg-12">
											<select style="color: rgb(21, 21, 21);" class="form-control" id="unit_delivery_date" name="unit_delivery_date">
												<option style="color: rgb(216, 216, 216);" value="">Select Date</option>
												<?php $delivery->print_select_delivery($global_isAdmin); ?>
											</select>
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
										<div class="col-lg-12">
											<a class="btn btn-alt waves-button waves-effect waves-light pull-right" id="add_now_button">Add Now</a>
											<a class="btn btn-flat waves-button waves-effect waves-light pull-right" data-dismiss="modal"><span class="icon icon-arrow-back"></span>Cancel</a>
										</div>
									
									</div>
								</div>
							</form>	
							<div class="clearfix">
								<p class="margin-no-top pull-left"></p>
							</div>								
						</div>
					</div>
					
				</div>				
			</div>
		</div>
	</div>
	