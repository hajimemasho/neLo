<!-- fisier php ce afiseaza datele personale ale utilizatorului logat -->
<?php	
	session_start(); 
	// timpul minim de viata al sesiunii
	$timeRange = 20;
	// verificam daca exista lipsa de activitate
	if(isset($_SESSION['timeout'])){
		// calculeaza timpul de inactivitate
		$sessionTime = time() - $_SESSION['timeout'];
		echo "session time = " . $sessionTime;
		echo "time range = " . $timeRange;
		// si daca este mai mare decat timpul permis atunci
		if($sessionTime > $timeRange){
			// cand userul revine si incearca sa acceseze pagina, sesiunea se distruge
			session_destroy();
			// iar userul este delogat
			header("Location: " . $logoutPage);
		}
	}
	// stocheaza timpul in care a fost accesata ultima data pagina
	$_SESSION['timeout'] = time();	
?>
<html>
	<head>
		<title><?php echo $title; ?></title>		
		<link rel="stylesheet" type="text/css" href=<?php echo $css_file; ?> />
		<script type="text/javascript" src=<?php echo $js_file; ?>></script>
	</head>
	<body>				
		<section>
			
		</section>
		<p id="footer">&copy; 2011 </p>
	</body>
</html>
	

