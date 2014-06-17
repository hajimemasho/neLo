<!-- fisier php ce contine formularul pentru logarea unui utilizator -->
<html>
	<head>
		<title><?php echo $title; ?></title>				
		<link rel="stylesheet" type="text/css" href=<?php echo $css_file; ?> />
		<script type="text/javascript" src=<?php echo $js_file; ?>></script>
	</head>
	<body>				
		<section>				
			<form id="loginForm" name="loginForm" method="post" accept-charset="utf-8" 
				action=<?php echo $base_url . 'profile/yourAccount'; ?>>
				<!-- div care momentan este ascuns si devine vizibil cand apare o eroare la logare -->
				<div id="error" class="hiddenSubmitError">
					<div id="xIcon"></div>
					<div id="errorMessage">A aparut o eroare<span class="normal">Eroare</span></div>
				</div>
				<legend><?php echo $heading; ?></legend>
				<div>					
					<label for="email">Adresa email:</label>
					<input name="email" id="email"  placeholder="utilizator@yahoo.com"/>
				</div>
				<div>					
					<label for="password">Parola:</label>
					<input name="password" id="password" type="password" placeholder="******"/>							
				</div>		
				<div>			
					<input name="enterAccount" id="enterAccount" type="button" value="Intra in cont" />	
				</div>				
			</form>	
		</section>
		<p id="footer">&copy; 2011 </p>
	</body>
</html>