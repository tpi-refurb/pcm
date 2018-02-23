	<footer class="footer">
		<div class="container">
			<p>Telcomtrix Phils., Inc. © 2016. All RIGHT RESERVED.</p>
		</div>
	</footer>
	<div class="fbtn-container">
		<div class="fbtn-inner">
		<?php if($page==='10'){ ?>
			<?php if($global_isAdmin){ ?>
				
			<?php } ?>
		<?php }elseif($page==='11'){ ?>
			<?php if($global_isAdmin or $global_level_lower==='encoder'){ ?>
                <?php if($s==='u'){ ?>
                    <?php if($is_mobile or $is_tablet){ ?>
                    <a class="fbtn fbtn-red fbtn-lg" id="update_status_button"><span class="fbtn-text">Update  Requisitioners</span><span class="fbtn-ori icon icon-check"></span></a>
                    <?php } ?>
                <?php }else{ ?>
                    <a class="fbtn fbtn-red fbtn-lg" href="<?php echo 'index.php?p='.encode_url('12').'&s='.encode_url('a');?>" ><span class="fbtn-text">Add Item</span><span class="fbtn-ori icon icon-add"></span></a>
                <?php } ?>
            <?php  } ?>
		<?php } elseif($page==='12'){ ?>
			<?php if($s==='a'){ ?>
				<a class="fbtn fbtn-red fbtn-lg" id="save_entry_button"><span class="fbtn-text">Save Item</span><span class="fbtn-ori icon icon-save"></span></a>
			<?php } elseif($s==='u'){ ?>
				<a class="fbtn fbtn-red fbtn-lg" id="update_entry_button"><span class="fbtn-text">Update Item</span><span class="fbtn-ori icon icon-check"></span></a>
            <?php } elseif($s==='d'){ ?>
                <?php if($is_mobile or $is_tablet){ ?>
                    <a class="fbtn fbtn-red fbtn-lg" id="delete_entry_button"><span class="fbtn-text">Delete Item</span><span class="fbtn-ori icon icon-delete"></span></a>
                <?php }else{ ?>
                    <a class="fbtn fbtn-red fbtn-lg" href="<?php echo 'index.php?p='.encode_url('11').'&s='.encode_url('v');?>"><span class="fbtn-text">View All <?php echo $l;?></span><span class="fbtn-ori icon icon-visibility"></span></a>
                <?php } ?>
            <?php } elseif($s==='g'){ ?>
                <?php if($is_mobile or $is_tablet){ ?>
                    <?php if($pn==='1'){ ?>
                        <a class="fbtn fbtn-red fbtn-lg" id="next_add_button"><span class="fbtn-text">Next</span><span class="fbtn-ori icon icon-arrow-forward"></span></a>
                    <?php } elseif($pn==='2'){ ?>
                        <a class="fbtn fbtn-red fbtn-lg" id="save_entry_button"><span class="fbtn-text">Save</span><span class="fbtn-ori icon icon-save"></span></a>
                    <?php }else{ ?>
                        <!-- @TODO ---->
                    <?php } ?>
                <?php } ?>
            <?php }else{ ?>
				<!-- @TODO ---->
			<?php } ?>
		<?php } elseif($page==='15'){ ?>
			<?php if($global_isAdmin){ ?>
				<?php if($s==='a'){ ?>
                    <?php if($is_mobile or $is_tablet){ ?>
					<a class="fbtn fbtn-red fbtn-lg" id="save_mainten_button"><span class="fbtn-text">Save <?php echo $l;?></span><span class="fbtn-ori icon icon-save"></span></a>
                    <?php }else{ ?>
                        <a class="fbtn fbtn-red fbtn-lg" href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('v').'&l='.encode_url($l);?>"><span class="fbtn-text">View All <?php echo $l;?></span><span class="fbtn-ori icon icon-visibility"></span></a>
                    <?php } ?>
				<?php } elseif($s==='u'){ ?>
                    <?php if($is_mobile or $is_tablet){ ?>
					<a class="fbtn fbtn-red fbtn-lg" id="update_mainten_button"><span class="fbtn-text">Update  <?php echo $l;?></span><span class="fbtn-ori icon icon-check"></span></a>
                    <?php } ?>
                <?php } elseif($s==='d'){ ?>
                    <?php if($is_mobile or $is_tablet){ ?>
					<a class="fbtn fbtn-red fbtn-lg" id="delete_mainten_button"><span class="fbtn-text">Delete  <?php echo $l;?></span><span class="fbtn-ori icon icon-delete"></span></a>
                    <?php } ?>
                <?php }else{ ?>
					<a class="fbtn fbtn-red fbtn-lg" id="add_mainten_button" href="<?php echo 'index.php?p='.encode_url('15').'&s='.encode_url('a').'&l='.encode_url($l);?>"><span class="fbtn-text">Add  <?php echo $l;?></span><span class="fbtn-ori icon icon-add"></span></a>
				<?php } ?>
			<?php } ?>
		<?php } elseif($page==='16'){ ?>
			<?php if($global_isAdmin){ ?>
				<?php if($s==='a'){ ?>
                    <?php if($is_mobile or $is_tablet){ ?>
                        <a class="fbtn fbtn-red fbtn-lg" id="save_log_button"><span class="fbtn-text">Save Log</span><span class="fbtn-ori icon icon-save"></span></a>
                    <?php }else{ ?>
                        <a class="fbtn fbtn-red fbtn-lg" href="<?php echo 'index.php?p='.encode_url('16').'&s='.encode_url('v').'&i='.encode_url($id); ?>"><span class="fbtn-text">View Logs</span><span class="fbtn-ori icon icon-visibility"></span></a>
                    <?php } ?>
                <?php } elseif($s==='v'){ ?>
					<a class="fbtn fbtn-red fbtn-lg" href="<?php echo 'index.php?p='.encode_url('16').'&s='.encode_url('a').'&i='.encode_url($id); ?>"><span class="fbtn-text">Add Log</span><span class="fbtn-ori icon icon-add"></span></a>			
				<?php }else{ ?>
					<!-- @TODO ---->
				<?php } ?>
			<?php }else{ ?>
				<a class="fbtn fbtn-red fbtn-lg" href="javascript: history.go(-1)"><span class="fbtn-text">Back</span><span class="fbtn-ori icon icon-arrow-back"></span></a>
			<?php } ?>	
		<?php } elseif($page==='17'){ ?>
			<?php if($global_isAdmin){ ?>
				<?php if($s==='a'){ ?>
                    <?php if($is_mobile or $is_tablet){ ?>
                        <a class="fbtn fbtn-red fbtn-lg" id="save_attach_button"><span class="fbtn-text">Save Attachment</span><span class="fbtn-ori icon icon-save"></span></a>
                    <?php }else{ ?>
					<a class="fbtn fbtn-red fbtn-lg" href="<?php echo 'index.php?p='.encode_url('17').'&s='.encode_url('v').'&i='.encode_url($id); ?>"><span class="fbtn-text">View Attachments</span><span class="fbtn-ori icon icon-visibility"></span></a>
                    <?php } ?>
                <?php } elseif($s==='v'){ ?>
					<a class="fbtn fbtn-red fbtn-lg" href="<?php echo 'index.php?p='.encode_url('17').'&s='.encode_url('a').'&i='.encode_url($id); ?>"><span class="fbtn-text">Add Attachment</span><span class="fbtn-ori icon icon-add"></span></a>			
				<?php }else{ ?>
					<!-- @TODO ---->
				<?php } ?>
			<?php }else{ ?>
				<a class="fbtn fbtn-red fbtn-lg" href="javascript: history.go(-1)"><span class="fbtn-text">Back</span><span class="fbtn-ori icon icon-arrow-back"></span></a>
			<?php } ?>
		<?php } elseif($page==='18'){ ?>
			<?php if($global_isAdmin){ ?>
				<?php if($s==='a'){ ?>
					<a class="fbtn fbtn-red fbtn-lg" href="<?php echo 'index.php?p='.encode_url('18').'&s='.encode_url('v'); ?>"><span class="fbtn-text">View Receipts</span><span class="fbtn-ori icon icon-visibility"></span></a>
				<?php } elseif($s==='v'){ ?>
					<a class="fbtn fbtn-red fbtn-lg" href="<?php echo 'index.php?p='.encode_url('18').'&s='.encode_url('a'); ?>"><span class="fbtn-text">Create Receipts</span><span class="fbtn-ori icon icon-add"></span></a>			
				<?php }else{ ?>
					<!-- @TODO ---->
				<?php } ?>
			<?php }else{ ?>
				<a class="fbtn fbtn-red fbtn-lg" href="javascript: history.go(-1)"><span class="fbtn-text">Back</span><span class="fbtn-ori icon icon-arrow-back"></span></a>
			<?php } ?>		
		<?php } elseif($page==='19'){ ?>
			<?php if($global_isAdmin){ ?>
				<?php if($s==='a'){ ?>
					<a class="fbtn fbtn-red fbtn-lg" href="<?php echo 'index.php?p='.encode_url('19').'&s='.encode_url('v'); ?>"><span class="fbtn-text">View Delivery</span><span class="fbtn-ori icon icon-visibility"></span></a>
				<?php } elseif($s==='v'){ ?>
					<a class="fbtn fbtn-red fbtn-lg" href="<?php echo 'index.php?p='.encode_url('19').'&s='.encode_url('a'); ?>"><span class="fbtn-text">Create Delivery</span><span class="fbtn-ori icon icon-add"></span></a>			
				<?php }else{ ?>
					<!-- @TODO ---->
				<?php } ?>
			<?php }else{ ?>
				<a class="fbtn fbtn-red fbtn-lg" href="javascript: history.go(-1)"><span class="fbtn-text">Back</span><span class="fbtn-ori icon icon-arrow-back"></span></a>
			<?php } ?>	
		<?php } elseif($page==='13'){ ?>
			<?php if($global_isAdmin){ ?>
				<?php if($s==='c'){ ?>
					<a class="fbtn fbtn-red fbtn-lg" id="change_pwd"><span class="fbtn-text">Update Password</span><span class="fbtn-ori icon icon-check"></span></a>
				<?php }elseif($s==='v'){ ?>
					<a class="fbtn fbtn-red fbtn-lg" id="save_settings"><span class="fbtn-text">Update Settings</span><span class="fbtn-ori icon icon-check"></span></a>					
				<?php } else{ ?>
					<!-- @TODO ---->
				<?php } ?>
			<?php }else{ ?>
				<a class="fbtn fbtn-red fbtn-lg" href="javascript: history.go(-1)"><span class="fbtn-text">Back</span><span class="fbtn-ori icon icon-arrow-back"></span></a>
			<?php } ?>
		<?php }else{ ?>
		 
			<!-- @TODO ---->
		<?php } ?>
		</div>
	</div>
	
	<?php if(!$auth->isLogin()) { ?>			
	<div aria-hidden="true" class="modal fade" id="modal-login" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-xs">
			<div class="modal-content">
				<div class="modal-heading">
					<a class="modal-close" data-dismiss="modal">&times;</a>
					<h2 class="modal-title text-alt">Login PCM</h2>
				</div>
				<div class="modal-inner">
						
					<div class="container">
						<div class="row">
							<p class="text-center">
								<span class="avatar avatar-inline avatar-lg">
									<img alt="Login" src="assets/images/users/avatar.jpg">
								</span>
							</p>
							<form id="signin_form" class="form">
								<div class="form-group form-group-label">
									<div class="row">
										<div class="col-md-10 col-md-push-1">
											<label class="floating-label" for="login_username">Username</label>
											<input class="form-control" id="login_username" name="login_username" type="text">
										</div>
									</div>
								</div>
								<div class="form-group form-group-label">
									<div class="row">
										<div class="col-md-10 col-md-push-1">
											<label class="floating-label" for="login_password">Password</label>
											<input class="form-control" id="login_password" name="login_password" type="password">
										</div>
									</div>
								</div>
								<div class="form-group form-group-label">
									<div class="row">
										<div class="col-md-10 col-md-push-1">
											<div class="errors-messages">
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-md-10 col-md-push-1">
											<button class="btn btn-alt btn-block waves-button waves-effect waves-light" id="signin_button">Sign In</button>											
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-10 col-md-push-1">
											<!--
											<div class="checkbox checkbox-adv">
												<label for="login-remember">
													<input class="access-hide" id="login-remember" name="login-remember" type="checkbox">Stay signed in
												</label>
											</div>
											-->
										</div>
									</div>
								</div>
								
							</form>							
							<div class="clearfix">
								<p class="margin-no-top pull-left"><a href="javascript:void(0)">Need help?</a></p>
								<p class="margin-no-top pull-right"><a href="<?php echo 'index.php?p='.encode_url('9').'&s='.encode_url('a'); ?>">Create an account</a></p>
							</div>							
						</div>
					</div>
					
				</div>				
			</div>
		</div>
	</div>
	
	<?php } ?>
	
	<script type="text/javascript" src="assets/js/base.js"></script>
	
	<script type="text/javascript" src="assets/js/jquery-3.1.0.min.js"></script>

    <script type="text/javascript" src="assets/plugins/bootstrap/bootstrap.min.js"></script>
	
	<?php //if($s!=='a' and $s!=='u' and $s!=='d'){ ?>
	<script type="text/javascript" src="assets/plugins/footable/footable.all.min.js"></script>
	<?php //} ?>
	<script type="text/javascript" src="assets/plugins/confirm/jquery.confirm.js"></script>
	
	<script type="text/javascript" src="assets/plugins/autocomplete/jquery.easy-autocomplete.js"></script>

    <?php if($l==='Brands') { ?>
        <script type="text/javascript" src="assets/plugins/webcam/webcam.js"></script>
		<script type="text/javascript" src="assets/js/marianz.cam.js"></script>
    <?php } ?>

	<script type="text/javascript" src="assets/js/marianz.varia.js"></script>
	<script type="text/javascript" src="assets/js/marianz.dialog.js"></script>
	
	<?php if(!$auth->isLogin()) { ?>
	<script type="text/javascript" src="assets/js/marianz.auth.js"></script>
	<?php } ?>

    <script type="text/javascript" src="assets/js/marianz.app.js"></script>
    </body>
</html>