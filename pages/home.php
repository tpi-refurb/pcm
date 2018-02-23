<div class="content">
		<div class="content-heading">
			<div class="container container-full">
				<div class="col-md-6 col-sm-8">
					<h1 class="heading">Summary </h1>
				</div>
				<div class="col-md-6 col-sm-4">
					<?php if(!$auth->isLogin()) { ?>
					<a class="btn btn-flat btn-yellow waves-button waves-effect pull-right" href="<?php echo 'index.php?p='.encode_url('9').'&s='.encode_url('a'); ?>">Register</a>
					<?php } ?>
				</div>	
			</div>
		</div>
		<div class="content-inner">
			<div class="container container-full">
				<div class="row row-fix">
					<div class="col-md-3 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
									
									<?php if($global_isAdmin){ ?>
									<h2 class="content-sub-heading">Create Entry</h2>
									<div class="tile-wrap">
										<div class="tile" style="background-color:#f5f5f5">
											<div class="pull-left tile-side">
												<span class="icon icon-playlist-add icon-lg text-alt"></span>
											</div>
											<div class="tile-inner">
												<span><a href="<?php echo 'index.php?p='.encode_url('12').'&s='.encode_url('a'); ?>" class="text-alt">Create Entry</a></span>
											</div>
										</div>
										
										<?php $mainten->print_tile_requisitioner();?>
										
									</div>

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

									<h2 class="content-sub-heading">Quick Add</h2>
									<div class="tile-wrap">										
										<div class="tile">
											<div class="pull-left tile-side">
												<span class="icon icon-local-shipping icon-lg text-alt"></span>
											</div>
											<div class="tile-inner">
												<span><a href="<?php echo 'index.php?p='.encode_url('19').'&s='.encode_url('a'); ?>" class="text-alt">Create Delivery</a></span>
											</div>
										</div>
										<div class="tile">
											<div class="pull-left tile-side">
												<span class="icon icon-quick-contacts-mail icon-lg text-alt"></span>
											</div>
											<div class="tile-inner">
												<span><a href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('a').'&l='.encode_url('Requisitioners');?>" class="text-alt">Add Requisitioner</a></span>
											</div>
										</div>
										<div class="tile">
											<div class="pull-left tile-side">
												<span class="icon icon-business icon-lg text-alt"></span>
											</div>
											<div class="tile-inner">
												<span><a href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('a').'&l='.encode_url('Brands');?>" class="text-alt">Add Brand</a></span>
											</div>
										</div>
										<div class="tile">
											<div class="pull-left tile-side">
												<span class="icon icon-loyalty icon-lg text-alt"></span>
											</div>
											<div class="tile-inner">
												<span><a href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('a').'&l='.encode_url('Status');?>" class="text-alt">Add Status</a></span>
											</div>
										</div>
										<div class="tile">
											<div class="pull-left tile-side">
												<span class="icon icon-group-add icon-lg text-alt"></span>
											</div>
											<div class="tile-inner">
												<span><a href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('a').'&l='.encode_url('Technicians');?>" class="text-alt">Add Technician</a></span>
											</div>
										</div>
									</div>
									<?php } else { ?>

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

										<h2 class="content-sub-heading">Latest Items Update</h2>
										<ul>
											<?php $units->print_latest_updates($global_isAdmin); ?>
										</ul>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h2 class="content-sub-heading">Statistics</h2>
						<div class="table-responsive">
							<table class="table" title="Statistics">
								<thead>
									<tr>
										<th>Description</th>
										<th>Count</th>
									</tr>
								</thead>
								<tbody>
								
								<?php $units->print_statistics(); ?>
								
								</tbody>
							</table>
						</div>
                        <h2 class="content-sub-heading">Brand Summary
						<a class="btn btn-flat btn-blue btn-md waves-button waves-effect" href="<?php echo 'includes/exports/bs.php?p='.encode_url('11'); ?>" target="_blank"><span class="icon icon-print"></span>Print</a>
						</h2>		
                        <div class="table-responsive">
                            <table class="table" title="Brands">
                                <thead>
                                <tr>
                                    <th>Brand</th>
                                    <th>Total</th>
                                    <th>Repaired</th>
                                    <th>Under Repair</th>
                                    <th>Beyond Repair</th>
                                    <th>Returned</th>
                                    <th>Others</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $units->print_brand_summary(); ?>

                                </tbody>
                            </table>
                        </div>
					
					</div>
					<div class="col-md-3 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
									<h2 class="content-sub-heading">Latest Activities</h2>
									<ul>
										<?php $units->print_latest_activities($global_isAdmin,'10'); ?>
									</ul>
                                    <?php if($isLogin){ ?>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-10 col-md-push-1">
                                                <a class="btn btn-block btn-alt waves-button waves-effect waves-light" href="<?php echo 'index.php?p='.encode_url('22').'&s='.encode_url('v');?>">View More...</a>
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
	</div>
	