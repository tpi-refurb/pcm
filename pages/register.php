<?php

	

?>
<div class="content">
		<div class="content-heading">
			<div class="container container-full">
				<h1 class="heading">Register</h1>
			</div>
		</div>
		<div class="content-inner">
			<div class="container container-full">
				<div class="row row-fix">
					<?php if($s==='s'){ ?>
						<div class="col-md-8 col-md-12">
						<p class="text-center">
							<h2 class="content-sub-heading text-center">You have successfully registered.</h2>
							<a class="btn btn-alt waves-button waves-effect" style="display: block; margin: 0 auto;width:200px;" href="<?php echo 'index.php?p='.encode_url('10'); ?>">Goto Home</a>
						</p>
						</div>
					<?php }else{?>
					
					<div class="col-md-8">					
					
						<form id="signup_form" class="form" method="post" enctype="multipart/form-data">
								<input hidden type="hidden" id="r" name="r" value="<?php echo 'index.php?p='.encode_url('9').'&s='.encode_url('s');?>">
								<input hidden type="hidden" id="l" name="l" value="<?php echo encode_url($l); ?>">
								<input hidden type="hidden" id="s" name="s" value="<?php echo encode_url($s); ?>">
								<input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">
							
							<h2 class="content-sub-heading">Enter your personal info.</h2>
							
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="ui_firstname"><span class="text-red">*</span> Firstname:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<input class="form-control" id="ui_firstname" name="ui_firstname" placeholder="Enter firstname" type="text" >
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="ui_lastname"><span class="text-red">*</span> Lastname:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<input class="form-control" id="ui_lastname" name="ui_lastname" placeholder="Enter Lastname" type="text">
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="ui_email"><span class="text-red">*</span> Email:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<input class="form-control" id="ui_email" name="ui_email" placeholder="Enter email" type="email">
										</div>
									</div>
								</div>
								
								<h2 class="content-sub-heading">Login details</h2>
								
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="ui_username"><span class="text-red">*</span> Username:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<input class="form-control" id="ui_username" name="ui_username" placeholder="Enter username" type="text" >
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="ui_password"><span class="text-red">*</span> Password:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<input class="form-control" id="ui_password" name="ui_password" placeholder="Enter password" type="password" >
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-2 col-md-3 col-sm-4">
											<label class="form-label" for="ui_confirmpassword"><span class="text-red">*</span> Confirm Password:</label>
										</div>
										<div class="col-lg-4 col-md-6 col-sm-8">
											<input class="form-control" id="ui_confirmpassword" name="ui_confirmpassword" placeholder="Enter re-type password" type="password" >
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
										<a class="btn btn-alt waves-button waves-effect waves-light pull-right" id="signup_button">Submit</a>
										<a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Cancel</a>
										
									</div>
								</div>
							</div>
						</form>
						
						
			
					</div>
					<div class="col-md-3 col-md-4 content-fix">
						<div class="content-fix-scroll">
							<div class="content-fix-wrap">
								<div class="content-fix-inner">
									<h2 class="content-sub-heading">Latest Entries</h2>
									<ul>
										<?php $units->print_latest_entries($global_isAdmin); ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	