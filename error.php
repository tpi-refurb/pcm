<?php
/*
Reference :https://paulund.co.uk/use-htaccess-to-redirect-custom-error-pages
*/
$title =
$description  ='';
$error = isset($_SERVER["REDIRECT_STATUS"]) ?$_SERVER["REDIRECT_STATUS"]:'';
switch($error){
	case 400:
		$title = "400 Bad Request";
		$description = "The request can not be processed due to bad syntax";
	break;

	case 401:
		$title = "401 Unauthorized";
		$description = "The request has failed authentication";
	break;

	case 403:
		$title = "403 Forbidden";
		$description = "The server refuses to response to the request";
	break;

	case 404:
		$title = "404 Page Not Found";
		$description = "The resource requested can not be found.";
	break;

	case 500:
		$title = "500 Internal Server Error";
		$description = "There was an error which doesn't fit any other error message";
	break;

	case 502:
		$title = "502 Bad Gateway";
		$description = "The server was acting as a proxy and received a bad request.";
	break;

	case 504:
		$title = "504 Gateway Timeout";
		$description = "The server was acting as a proxy and the request timed out.";
	break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="initial-scale=1.0, width=device-width" name="viewport">
	<title><?php echo $title; ?></title>

	<!-- css -->
	<!--<link href="assets/css/base.css" rel="stylesheet">-->
	<style>
html {
    font-family: sans-serif;
    font-size: 100%;
    -webkit-text-size-adjust: 100%;
}

.col-c {
	min-height: 1px;
    position: relative;
    padding-left: 16px;
    padding-right: 16px;
}

body {
    background-color: #fafafa;
    background-image: none;
    color: #212121;
    font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 14px;
    font-weight: 400;
    line-height: 20px;
    margin: 0;
    padding: 0;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: subpixel-antialiased;
}

.h1, h1 {
    font-size: 44px;
    line-height: 48px;
}
.h2, h2 {
    font-size: 36px;
    line-height: 40px;
}
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    color: inherit;
    font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: 700;
    margin-top: 48px;
    margin-bottom: 24px;
}
p {
    margin: 24px 0;
}
.content {
    padding-bottom: 24px;
}
.content-heading {
    color: #fff;
    overflow: hidden;
    padding-top: 48px;
    z-index: 1;
    -webkit-transition: background-color .3s cubic-bezier(.4, 0, .2, 1), color .3s cubic-bezier(.4, 0, .2, 1);
    transition: background-color .3s cubic-bezier(.4, 0, .2, 1), color .3s cubic-bezier(.4, 0, .2, 1);
}
.content-heading .heading {
    font-weight: 300;
}
.content-heading, .row-fix {
    position: relative;
}
.content-heading, .page-alt .content-heading {
    background-color: #4caf50;
}
.content-sub-heading {
    color: #4caf50;
    font-size: 20px;
    font-weight: 400;
    line-height: 28px;
}

.container {
    margin-right: auto;
    margin-left: auto;
    padding-right: 16px;
    padding-left: 16px;
}
.row {
    margin-right: -16px;
    margin-left: -16px;
}
article, aside, footer, header, nav, section {
    display: block;
}

.footer {
    font-size: 8pt;
    background-color: #fafafa;
    border-top: 1px solid #e0e0e0;
    text-align: center;
    position: absolute;
    bottom: 0;
    right: 0;
    left: 0;
}
.footer, .footer a {
    color: #9e9e9e;
}
</style>


	<!-- favicon -->
	<!-- ... -->

</head>
<body>	
	
	<div class="content">
		<div class="content-heading">
			<div class="container">
				<h1 class="heading"><?php echo $title; ?></h1>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-c">
					<section class="content-inner">
						<h2 class="content-sub-heading">Oops! Something went wrong...</h2>
						<p><?php echo $description; ?> </p>
					</section>
				</div>
			</div>
		</div>
	</div>
	<footer class="footer">
		<div class="container">
			<p>Telcomtrix Phils., Inc. © 2016. All RIGHT RESERVED.</p>
		</div>
	</footer>

</body>
</html>