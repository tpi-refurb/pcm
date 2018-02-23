
	<div class="menu menu-right menu-search" id="search">
		<div class="menu-scroll">
			<div class="menu-wrap">
				<div class="menu-top">
					<div class="menu-top-info">
						<form id="search_form" class="form-group-alt menu-top-form"  method="POST">
						<?php
							if(isset($_POST['search_button'])){
								$keyword 	= trim($_POST["keyword"]);	
								 if(!empty($keyword)){
									 redirect_to('index.php?p='.encode_url('11').'&q='.encode_url($keyword));
								 }else{
									 redirect_to('index.php?p='.encode_url($page).'&q=');
								 }
							}else{
								 
							}
						?>
							<label class="access-hide" for="menu-search">Search</label>
							<input class="form-control form-control-inverse menu-search-focus" id="keyword" name="keyword" placeholder="Enter keyword then hit enter" type="search">
							<button class="access-hide" type="submit" id="search_button" name="search_button">Search</button>							
						</form>
					</div>
				</div>
				<div class="menu-content">
					<div class="menu-content-inner">
						<p><strong>Latest Search Queries:</strong></p>
						<ul>
							<?php $units->print_latest_search(); ?>
						</ul>
						<hr>
						<p><strong>Top Searched Queries:</strong></p>
						<ul>
							<?php $units->print_top_search(); ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
