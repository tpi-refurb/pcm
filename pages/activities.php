<div class="content">
		<div class="content-heading">
			<div class="container container-full">
				<div class="col-md-6 col-sm-8">
					<h1 class="heading">Activities </h1>
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
						<h2 class="content-sub-heading">Users Activities</h2>
						<div class="table-responsive">
							<table class="table" title="Default Tabl">
								<thead>
									<tr>
										<th>Description</th>
									</tr>
								</thead>
								<tbody>

                                <?php $units->print_latest_activities($global_isAdmin,'all'); ?>
								
								</tbody>
							</table>
						</div>
					
					
					</div>
					<div class="col-md-3 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
									<h2 class="content-sub-heading">Latest Updates</h2>
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
	