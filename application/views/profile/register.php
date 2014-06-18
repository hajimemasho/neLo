<!-- fisier php ce contine formularul pentru inregistrarea unui utilizator -->
<html>
	<head>
		<title><?php echo $title; ?></title>		
		<link rel="stylesheet" type="text/css" href=<?php echo $css_file; ?> />
		<script type="text/javascript" src=<?php echo $generaljs_file; ?>></script>
		<script type="text/javascript" src=<?php echo $js_file; ?>></script>
	</head>
	<body onload="document.registerForm.email.focus();">				
		<section>				
			<form id="registerForm" name="registerForm" method="post" accept-charset="utf-8" 
				action=<?php echo $base_url . 'profile/doregister'; ?>>	   
				<!-- div care este ascuns si devine vizibil cand apare o eroare cand 
				se da click pe submit -->    
				<div id="error" class="hiddenSubmitError">
					<div id="xIcon"></div>
					<div id="errorMessage">A aparut o eroare<span class="normal">Eroare</span></div>
				</div>
				<legend><?php echo $heading; ?></legend>
				<div>					
					<label for="email">Adresa email:</label>
					<input name="email" id="email"  placeholder="utilizator@yahoo.com"/>	
					<!-- paragraf ascuns, devine vizibil cand apare o eroare la email-->
					<p class="hiddenSignUpError">Error</p>
				</div>
				<div>					
					<label for="password">Parola:</label>
					<input name="password" id="password" type="password" placeholder="******"/>				
					<!-- paragraf ascuns, devine vizibil cand apare o eroare la parola-->
					<p class="hiddenSignUpError">Eroare</p>
				</div>
				<div>					
					<label for="passwordconf">Confirmare parola:</label>
					<input name="passwordconf" id="passwordconf" type="password" placeholder="******" />
					<!-- paragraf ascuns, devine vizibil cand apare o eroare la campul confirmarea parolei 
					sau cand cele doua parole nu coincid -->
					<p class="hiddenSignUpError">Eroare</p>
				</div>
				<div>					
					<label for="firstname">Prenume:</label>
					<input name="firstname" id="firstname" placeholder="prenume" />	
					<!-- paragraf ascuns, devine vizibil cand apare o eroare la prenume -->
					<p class="hiddenSignUpError">Eroare</p>
				</div>
				<div>					
					<label for="lastname">Nume:</label>
					<input name="lastname" id="lastname" placeholder="nume" />
					<!-- paragraf ascuns, devine vizibil cand apare o eroare la nume -->
					<p class="hiddenSignUpError">Eroare</p>
				</div>		
				<div>									
					<input name="createAccount" id="createAccount" type="button" value="Creaza cont" />				
				</div>				 				
			</form>	
		</section>
		<p id="footer">&copy; 2011 </p>
	</body>
</html>