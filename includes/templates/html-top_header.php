
	<header class="header">
		<ul class="nav nav-list pull-left">
			<li>
				<a class="menu-toggle" href="#menu">
					<span class="access-hide">Menu</span>
					<span class="icon icon-menu icon-lg"></span>
					<span class="header-close icon icon-arrow-back icon-lg"></span>
				</a>
			</li>
		</ul>
		<!--
		<a class="header-logo" href="index.php"><img src="assets/images/logo.png"/></a>
		<span class="header-fix-hide header-text">PCM Assistant</span>
		<span class="header-fix-show header-text"><?php echo $title; ?></span>
		-->
		<?php if($detect->isMobile()) { ?>
			 <span class="header-logo header-fix-hide header-text"><a href="index.php"><img src="assets/images/logo-w.png"/></a></span>
		<?php } else { ?>
			<span class="header-logo header-fix-hide header-text"><a href="index.php"><img src="assets/images/logo.png"/></a></span>
		<?php }  ?>
		<span class="header-fix-show header-text"><?php echo $title; ?></span>
		<ul class="nav nav-list pull-right">
			
			<li>				
				<a class="menu-toggle" href="#notif">
					<span class="access-hide">Notif</span>
					<span class="notif-icon icon icon-notifications icon-lg"></span>
					<span class="header-close icon icon-close icon-lg"></span>
				</a>
			</li>
			<li>
				<a class="menu-toggle" href="#search">
					<span class="access-hide">Search</span>
					<span class="icon icon-search icon-lg"></span>
					<span class="header-close icon icon-close icon-lg"></span>
				</a>
			</li>
			<li>
			<?php if($auth->isLogin()) { ?>			
				<a class="menu-toggle" href="#profile">
					<span class="access-hide"><?php echo $global_username; ?></span>
					<span class="avatar avatar-sm"><img alt="<?php echo $global_username; ?>" src="assets/images/users/avatar.jpg"></span>
					<span class="header-close icon icon-close icon-lg"></span>
				</a>
			<?php } else { ?>
				<a data-toggle="modal" href="#modal-login"><span class="avatar avatar-sm"><img alt="<?php echo $global_username; ?>" src="assets/images/users/avatar.jpg"></span></a>
			<?php } ?>
			</li>
		</ul>
	</header>
	