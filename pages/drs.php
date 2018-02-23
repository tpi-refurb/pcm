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
						<!--<h2 class="content-sub-heading">Items List</h2> -->
						<div class="table-responsive">
							<table class="table footable toggle-circle-filled-colored" data-sorting="true" data-filter="#filter" data-page-size="10" data-limit-navigation="5" title="Items Table">
								<thead>
									<tr>
										<th data-toggle="true">D.R. Number</th>
										<th>Date Delivered</th>
										<th>Remarks</th>
										<th data-hide="all">Serials</th>										
									</tr>
								</thead>
								<tbody>
									<?php $units->print_all_drs($global_isAdmin); ?>							
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
	