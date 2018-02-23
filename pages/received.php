<?php
	if($s==='a' and !$isLogin){ 
		$s ='v'; // if not login and state is Add then set as View state
	}
    $ti = isset($_GET['ti'])  ? decode_url($_GET['ti']) : '';	//Notif Id
    if(!empty($ti)){
        $db->update('pcm_notif',array('view'=>1),'id='.$ti);
    }
    $delivery->check_delivery($global_isAdmin);
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
							<h2 class="content-sub-heading">Select date for delivery and remark</h2>
							<form id="delivery_form" class="form">								
								<input hidden type="hidden" id="r" name="r" value="<?php echo 'index.php?p='.encode_url('19').'&s='.encode_url('v');?>">
								<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
								<input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">
							
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_deliver_date"><span class="text-red">*</span> Delivery Date:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<div class="media">
												<div class="media-object pull-right">
													<label class="form-icon-label" for="unit_deliver_date"><span class="access-hide">Delivery Date:</span><span class="icon icon-event"></span></label>
												</div>
												<div class="media-inner">
													<input class="datepicker-adv datepicker-adv-default form-control picker__input" id="unit_deliver_date" name="unit_deliver_date" type="text" readonly="" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="unit_deliver_date_root">
												</div>
											</div>						
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_deliver_requisitioner"><span class="text-red">*</span> Requisitioner:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<select class="form-control" id="unit_deliver_requisitioner" name="unit_deliver_requisitioner">
												<option class="empty-option" value="">Select Requisitioner</option>
												<?php $units->print_select_requisitioners($id); ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_deliver_brand"><span class="text-red">*</span> Brand:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<select style="color: rgb(21, 21, 21);" class="form-control" id="unit_deliver_brand" name="unit_deliver_brand">
												<option style="color: rgb(216, 216, 216);" value="">Select Brand</option>
												<?php $units->print_select_brands($id); ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_deliver_status"><span class="text-red">*</span> Remark:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<select style="color: rgb(21, 21, 21);" class="form-control" id="unit_deliver_status" name="unit_deliver_status">
												<option style="color: rgb(216, 216, 216);" value="">Select Remark</option>
												<?php $units->print_select_status($id); ?>
											</select>
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
												<label for="unit_check_split">
													<input class="access-hide" id="unit_check_split" name="unit_check_split" type="checkbox">Split Delivery
												<span class="circle"></span><span class="circle-check"></span><span class="circle-icon icon icon-done"></span></label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group" id="group_div">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_split">Split :</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<select class="form-control" id="unit_split" name="unit_split">
												<option value="1" selected>1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
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
										<div class="col-lg-4 col-lg-push-2 col-md-6 col-md-push-3 col-sm-4 col-sm-push-4">
											<a class="btn btn-alt waves-button waves-effect waves-light pull-right" id="create_delivery_button">Create</a>
											<a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Back</a>
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
										<th data-hide="phone,tablet">Requisitioner</th>
										<th data-hide="phone">Completed</th>	
										<th data-hide="all">Serials</th>									
									</tr>
								</thead>
								<tbody>
									<?php $delivery->print_deliveries($global_isAdmin); ?>							
								</tbody>	
								<tfoot class="hide-if-no-paging">
									<tr>

										<td colspan="3" class="text-center">
											<ul class="pagination nav nav-list"></ul>
										</td>
									</tr>
								</tfoot>							
							</table>
						</div>							
						<div class="row">
                            <div class="media">
                                <div class="media-object pull-left">
                                    <label class="form-icon-label" for="label_split"><span class="avatar avatar-xxs avatar-blue pull-right">x</span></label>
                                </div>
                                <div class="media-inner">
                                    <span class="text-hint" id="label_split">Group number : represent if delivery being split</span>
                                </div>
                            </div>
							<div class="media">
								<div class="media-object pull-left">
									<label class="form-icon-label" for="label_qty"><span class="avatar avatar-xxs avatar-green pull-right">x</span></label>
								</div>
								<div class="media-inner">
									<span class="text-hint" id="label_qty">Quantity of delivered serials</span>
								</div>
							</div>
							<div class="media">
								<div class="media-object pull-left">
									<label class="form-icon-label" for="label_incomplete"><span class="avatar avatar-xxs avatar-red pull-right"><span class="icon icon-warning"></span></span></label>
								</div>
								<div class="media-inner">
									<span class="text-hint" id="label_incomplete">Incomplete: no serials added, DR. No not yet printed/created</span>
								</div>
							</div>
                            <div class="media">
                                <div class="media-object pull-left">
                                    <label class="form-icon-label" for="label_complete"><span class="avatar avatar-xxs avatar-alt pull-right"><span class="icon icon-check"></span></span></label>
                                </div>
                                <div class="media-inner">
                                    <span class="text-hint" id="label_complete">Complete: provided all requirements for delivery</span>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-object pull-left">
                                    <label class="form-icon-label" for="label_dr" style="margin-left: 10px;"><span class="label label-alt pull-right"><span class="icon icon-close"></span></span></label>
                                </div>
                                <div class="media-inner">
                                    <span class="text-hint" id="label_dr">DR Number</span>
                                </div>
                            </div>
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
	
	
	