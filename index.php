<?php

// Including pear stuff, so we can use HTTP REQUEST class
$path = '/home/htmldk/php/';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

// HTTP Request stuff for Servage
require_once "HTTP/Request.php";

// Stuff we check for
$generator = "Ikke fundet";
$htmlType = "Ikke angivet";
$responseCode = "";


function checkTech($website){	

	global $generator, $htmlType, $responseCode;

	if (strtolower(substr($website, 0, 4)) != "http"){
		$website = "http://" . $website;
	}
	
	// Defining what a html5 doctype looks like
	$html5Doctype = "<!doctype html>";

	$req =& new HTTP_Request($website);
	

	if (!PEAR::isError($req->sendRequest())) 
	{

		$code = $req->getResponseCode();
		
		$responseCode = $code;
	
		$returnData = $req->getResponseBody();
		$returnData = trim($returnData);
		$doctype = strtolower(substr($returnData, 0, 15));
		
	
		if (strpos($returnData, '<meta name="Generator" content="Dynamicweb 8"') === false){
			// Not found
		}else{
			$generator = "Dynamicweb 8";
		}
		
		if (strpos($returnData, '<meta name="Generator" content="Dynamicweb 7"') === false){
		}else{
			$generator = "Dynamicweb 7";
		}
	
		if (strpos($returnData, '/wp-content/themes/') === false){
		}else{
			$generator = "Wordpress";
		}
	
		if ($html5Doctype == $doctype){
			$htmlType = "HTML5";
		}else{
			$htmlType = "Gammeldaws";
		}

	}


}


?>

<!DOCTYPE html> 
<html lang="da"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=0.3, maximum-scale=0.3, user-scalable=0;">
	<link rel="shortcut icon" href="/favicon.ico"> <!-- Add favicon -->
	<link rel="apple-touch-icon" href="/apple-touch-icon.png"> <!-- Add Apple iPhone/iPad/iPod icon -->
	<link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
	
	<title>Hvad kører websitet? - Powered by HTML24</title> 
	<meta name="description" content="Er det HTML5? er et website der kan fortælle dig om andre websites er HTML5 eller gammeldaws HTML." />
	<meta name="keywords" content="Er det html5?, HTML24, HTML, Webudvikling" />
	
	<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
	
	<script type="text/javascript">
	// <!--
	
	jQuery.fn.center = function () {
		this.css("position","absolute");
		this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
		this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
		return this;
	}
	
	$(document).ready(function()
	{
		$('#container').center();
		$('#container').fadeIn("slow");
				
	});
	
	// -->
	</script>
	
</head>
<body>

	<div id="container">
	
		<form action="#" method="get" autocomplete="off">
		
			<div id="search">
			<?php
				if (isset($_REQUEST['url'])){
					$urlValue = $_REQUEST['url'];
				}
			?>
				<input name="url" autocomplete="off" placeholder="Indtast url her :-)" type="text" id="url" value="<?php echo $urlValue; ?>"/>
			</div>
		
		</form>
		
		<?php if (isset($_REQUEST["url"])){
			$website = $_REQUEST["url"];
			checkTech($website);
		?>
		<div id="result">
			<div class="result_container">System: <?php echo $generator; ?></div>
			<div class="result_container">HTML: <?php echo $htmlType; ?></div>
			<div class="result_container">Server svar: <?php echo $responseCode; ?></div>
		</div>
		
		<?php
		} // If not set
		?>
	
	</div>
	
	<div id="logo">
		<a title="Powered by HTML24" href="http://www.html24.dk"><img src="images/html24.png" alt="HTML24"/></a>
	</div>	
	
</body>
</html>