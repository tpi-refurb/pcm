<?php
    if(!empty($id)){
        if($l==='Brands'){
            $brand_name = $db->getValue('pcm_brands','brand_name', 'id='.$id);
        }
    }

?>
<div class="content">
		<div class="content-heading">
			<div class="container container-full">
				<div class="col-md-6 col-sm-8">
					<h1 class="heading"><?php echo empty($l)?'All': $l; ?> Summary </h1>
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
						<h2 class="content-sub-heading"><?= $brand_name.' '.$id; ?> Statistics</h2>
						<div class="table-responsive">
							<table class="table" title="Default Table">
								<thead>
									<tr>
										<th>Description</th>
										<th>Count</th>
									</tr>
								</thead>
								<tbody>
								
								<?php $units->print_brand_statistics($id); ?>
								
								</tbody>
							</table>
						</div>
					
					
					</div>
					<div class="col-md-3 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
                                    <h2 class="content-sub-heading">Brand Summary</h2>
                                    <div class="tile-wrap">

                                        <?php $mainten->print_tile_brands_summary();?>

                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	