<?php		
	session_start();		
	session_unset();
	// distrugem sesiunea
	session_destroy(); 	
?>
<html>
	<head>
		<title><?php echo $title; ?></title>		
		<link rel="stylesheet" type="text/css" href=<?php echo $css_file; ?> />
		<script type="text/javascript" src=<?php echo $js_file; ?>></script>
	</head>
	<body>		
		<h2><?php echo $heading; ?></h2>
		<section>
			Logout page
		</section>	
		<p id="footer">&copy; 2011 </p>
	</body>
</html>