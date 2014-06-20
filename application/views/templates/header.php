<html>
	<head>
		<title><?php echo $title; ?></title>				
		<link rel="stylesheet" type="text/css" href=
		<?php 
			if(isset($css_file)){
				echo $css_file; 
			}else{
				echo "no file";
			}
		?>>
		<script type="text/javascript" src=
		<?php 
			if(isset($generaljs_file)){
				echo $generaljs_file;
			}
		?>>
		</script>
		<script type="text/javascript" src=
		<?php 
			if(isset($addpropertyjs_file)){
				echo $addpropertyjs_file; 
			}
		?>>
		</script>
		<script type="text/javascript" src=
		<?php 
			if(isset($js_file)){
				echo $js_file;
			}
 	    ?>>
 	    </script>
	</head>
	<body>	