<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="initial-scale=1.0, width=device-width" name="viewport">
	<title><?php echo $title; ?> -PCM </title>

	<link rel="icon" href="favicon.png" type="image/x-icon" sizes="16x16">	
	<!-- css -->
	<link href="assets/css/base.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">

    <link href="assets/css/capture.css" rel="stylesheet">
	<!--<link href="assets/plugins/bootstrap/bootstrap.min.css" rel="stylesheet"> -->
	<link href="assets/plugins/footable/footable.core.css" rel="stylesheet">

    <link href="assets/plugins/autocomplete/jquery.easy-autocomplete.css" rel="stylesheet">

	<!-- ie -->
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.js" type="text/javascript"></script>
        <script src="assets/js/respond.js" type="text/javascript"></script>
    <![endif]-->
</head>
<body class="avoid-fout" <?php echo ($page ==='10' or $s==='v' or ($s==='g' and $page!=='12')) ?' style="background:url(assets/images/bg.png);background-repeat: no-repeat;background-attachment: scroll;"':''; ?>>
	<div class="avoid-fout-indicator avoid-fout-indicator-fixed">
		<div class="progress-circular progress-circular-alt progress-circular-center">
			<div class="progress-circular-wrapper">
				<div class="progress-circular-inner">
					<div class="progress-circular-left">
						<div class="progress-circular-spinner"></div>
					</div>
					<div class="progress-circular-gap"></div>
					<div class="progress-circular-right">
						<div class="progress-circular-spinner"></div>
					</div>
				</div>
			</div>
		</div>
        <h1 class="content-sub-heading">PCM Assistant</h1>
        <p class="text-green">Telcomtrix Philippines Inc.</p>
	</div>