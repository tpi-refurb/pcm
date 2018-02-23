<?php

$title = 'Items';
$status_id ='';
$serial =
$date_repaired =
$repaired_portion =
$replaced_parts = '';

if($s==='u'){
	if(!empty($id)){
		$rs = $db->getResults("SELECT * FROM pcm_serials WHERE id =".$id);
		if(count($rs) >0){
			foreach($rs as $r){
				$serial = $r['serial'];
				$date_repaired = $r['date_repaired'];
				$repaired_portion = $r['repaired_portion'];
				$replaced_parts = $r['replaced_parts'];
				$status_id = $r['status'];
			}
		}
        if(empty($replaced_parts)){
            $replaced_parts = $db->getLastValue('pcm_repair_history','repairs_done','serial_id='.$id, 'id');
        }
        if(empty($date_repaired)){
            $date_repaired = $db->getLastValue('pcm_repair_history','date_done','serial_id='.$id, 'id');
        }
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
                <?php if(!$is_mobile){ ?>
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
                <?php } ?>
			</div>
		</div>
		<div class="content-inner">
			<div class="container container-full">
				<div class="row row-fix">
					<div class="col-md-8">
						<?php if($DEBUG===true){ echo $id; } ?>
						
						<?php if(!empty($l) and !empty($id)){ ?>						
							<h2 class="content-sub-heading">Filter by :<?php echo $l; ?>  <strong id="data_count" class="text-red animated infinite flash">1</strong>
						<a class="btn btn-flat btn-blue btn-md waves-button waves-effect" href="<?php echo 'includes/exports/ps.php?p='.encode_url('11').'&q='.encode_url($id).'&dt='.encode_url($dt).'&bt='.encode_url($b).'&pss='.encode_url($pss);?>" target="_blank"><span class="icon icon-print"></span>Print</a>
							</h2>
						<?php } ?>
						<?php if($s==='g'){ ?>
							<h2 class="content-sub-heading">Requisitioners' Data </h2>

							<div class="tile-wrap">
								<?php $mainten->print_datatile_requisitioner($global_isAdmin);?>

							</div>
						<?php }else if($s==='u'){ ?>
							<h2 class="content-sub-heading">Update status for <strong class="text-black"><?php echo $sn; ?></strong>.</h2>

							<form id="changestatus_form" class="form">
								<input hidden type="hidden" id="r" name="r" value="<?php echo 'index.php?p='.encode_url('11');?>">
								<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url('cs'); ?>">
								<input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">

								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="unit_status"><span class="text-red">*</span> Select Remark:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<select class="form-control" id="unit_status" name="unit_status">
												<option value="">Select Remark</option>
												<?php $units->print_select_status($status_id); ?>
											</select>
										</div>
									</div>
								</div>


                                <div class="form-group group-repaired_portion">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-4">
                                            <label class="form-label" for="unit_repaired_date"><span class="text-red">*</span>Date Repaired:</label>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-8">
                                            <div class="media">
                                                <div class="media-object pull-right">
                                                    <label class="form-icon-label" for="unit_repaired_date"><span class="access-hide">Date Repaired:</span><span class="icon icon-event"></span></label>
                                                </div>
                                                <div class="media-inner">
                                                    <input class="datepicker-adv datepicker-adv-default form-control picker__input" id="unit_repaired_date" name="unit_repaired_date" type="text" readonly="" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="unit_repaired_date_root" value="<?php echo $date_repaired;?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group group-repaired_portion">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-4">
                                            <label class="form-label" for="unit_repaired_portion"><span class="text-red">*</span>Repaired Portion:</label>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-8">
                                            <input class="form-control" id="unit_repaired_portion" name="unit_repaired_portion" placeholder="Enter repaired portion" type="text" value="<?php echo $repaired_portion; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group group-repaired_portion">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-4">
                                            <label class="form-label" for="unit_replaced_parts"><span class="text-red">*</span> Replaced Parts:</label>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-8">

                                            <div class="media-object pull-right">
                                                <label class="form-icon-label" for="unit_replaced_parts"><span class="btn-rounded btn-sm btn-alt waves-button waves-effect icon icon-refresh" id="generate_parts"></span></label>
                                            </div>
                                            <div class="media-inner">
                                                <!--<input class="form-control" id="unit_replaced_parts" name="unit_replaced_parts" placeholder="Enter replaced parts" type="text" value="<?php echo $replaced_parts; ?>"> -->
                                                <textarea class="form-control" id="unit_replaced_parts" name="unit_replaced_parts" rows="4"><?php echo $replaced_parts;?></textarea>
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
											<?php }else{ ?>
                                                <a class="btn btn-alt waves-button waves-effect waves-light pull-right" id="update_status_button">Update</a>
                                            <?php } ?>
                                            <a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Cancel</a>
										</div>
									</div>
								</div>

							</form>



						<?php }else{ ?>
						<div class="table-responsive">
							<!--
							<table class="table footable toggle-circle-filled-colored" data-sorting="true" data-filter="#filter" data-page-size="10" data-limit-navigation="5" title="Items Table">
							-->
							<table id="data_table" class="table footable toggle-circle-filled-colored" data-sorting="true" data-filter="#filter" data-page-size="10" data-limit-navigation="5">
								<thead>
									<tr>
										<th data-toggle="true">Serial</th>
										<th data-hide="all">Serial 2</th>
										<th data-hide="all">MATCODE</th>
										<th data-hide="all">Asset No.</th>
                                        <th data-hide="all">Reference No</th>
                                        <th data-hide="phone">Brand</th>
										<th data-hide="phone">Requisitioner</th>
                                        <th data-hide="all">Date Received</th>
                                        <th data-hide="all">Date Repaired</th>
										<th data-hide="all">Date Delivered to Requisitioner Warehouse</th>
										<th data-hide="all">DR No.</th>
										<th data-hide="all">TPI Code</th>
										<th data-hide="all">Technician</th>
										<th data-hide="all">Notes</th>
										<th data-hide="all">Last Date Modified</th>
										<th data-hide="phone,tablet">Warranty</th>
										<th>Status</th>
										<th>Days</th>
										<th data-hide="all">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(empty($q)){
										$units->print_item_list($l,$id,'',$global_isAdmin);
									}else{
										$units->print_item_list($l,$id,$q,$global_isAdmin);
									}
									?>
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

						<?php } ?>
					</div>
					<div class="col-md-3 col-md-4 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
									<h2 class="content-sub-heading">Latest Items Update</h2>
									<!--
                                    <ul>
										<?php $units->print_latest_updates($global_isAdmin); ?>
									</ul>
									-->
                                    <?php $units->print_tiled_latest_updates($global_isAdmin); ?>

                                    <h2 class="content-sub-heading">Quick View</h2>
                                    <div class="tile-wrap">
                                        <div class="tile">
                                            <div class="pull-left tile-side">
                                                <span class="icon icon-quick-contacts-mail icon-lg text-alt"></span>
                                            </div>
                                            <div class="tile-inner">
                                                <span><a href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('v').'&l='.encode_url('Requisitioners');?>" class="text-alt">Requisitioners</a></span>
                                            </div>
                                        </div>
                                        <div class="tile">
                                            <div class="pull-left tile-side">
                                                <span class="icon icon-business icon-lg text-alt"></span>
                                            </div>
                                            <div class="tile-inner">
                                                <span><a href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('v').'&l='.encode_url('Brands');?>" class="text-alt">Brands</a></span>
                                            </div>
                                        </div>
                                        <div class="tile">
                                            <div class="pull-left tile-side">
                                                <span class="icon icon-loyalty icon-lg text-alt"></span>
                                            </div>
                                            <div class="tile-inner">
                                                <span><a href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('v').'&l='.encode_url('Status');?>" class="text-alt">Status</a></span>
                                            </div>
                                        </div>
                                        <div class="tile">
                                            <div class="pull-left tile-side">
                                                <span class="icon icon-group-add icon-lg text-alt"></span>
                                            </div>
                                            <div class="tile-inner">
                                                <span><a href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('v').'&l='.encode_url('Technicians');?>" class="text-alt">Technicians</a></span>
                                            </div>
                                        </div>
                                    </div>


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
