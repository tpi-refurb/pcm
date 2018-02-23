
	<nav class="menu menu-right" id="profile">
		<div class="menu-scroll">
			<div class="menu-wrap" style="background:url('assets/images/bg.png');background-repeat: no-repeat;">
				<div class="menu-top">
					<div class="menu-top-img">
						<img alt="<?php echo $global_username; ?>" src="assets/images/samples/landscape.jpg">
					</div>
					<div class="menu-top-info">
						<a class="menu-top-user" href="javascript:void(0)"><span class="avatar pull-left"><img alt="User Logged-in <?php echo $global_username; ?>" src="assets/images/users/avatar.jpg"></span><?php echo $global_fullname; ?>  <small class="text-green"><?php echo '  '.$global_level;?></small></a>
						
					</div>
				</div>
				<div class="menu-content">
					<ul class="nav">
						<?php if($global_isAdmin){ ?>
                            <li>
                                <a href="<?php echo 'index.php?p='.encode_url('22').'&s='.encode_url('v');?>"><span class="icon icon-history"></span>Activities</a>
                            </li>
                            <li>
                                <a href="<?php echo 'index.php?p='.encode_url('13').'&s='.encode_url('v');?>"><span class="icon icon-settings"></span>Settings</a>
                            </li>
                        <?php } ?>
						<li>
							<a href="<?php echo 'index.php?p='.encode_url('13').'&s='.encode_url('c');?>"><span class="icon icon-lock"></span>Change Password</a>
						</li>					
						<li>
							<a href="logout.php"><span class="icon icon-exit-to-app"></span>Logout</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</nav>
	