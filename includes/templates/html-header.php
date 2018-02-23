<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="initial-scale=1.0, width=device-width" name="viewport">
	<title><?php echo $title; ?> -PCM <?php if($DEBUG===true){ echo $page; } ?></title>

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
<body <?php echo ($page ==='10' or $s==='v' or ($s==='g' and $page!=='12')) ?' style="background:url(assets/images/bg.png);background-repeat: no-repeat;background-attachment: scroll;"':''; ?>>
	