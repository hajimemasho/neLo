<html>
	<head>
		<title><?php echo $title; ?></title>				
		<link rel="stylesheet" type="text/css" href=<?php echo $css_file; ?> />
		<script type="text/javascript" src=<?php echo $generaljs_file; ?>></script>
		<script type="text/javascript" src=<?php echo $addpropertyjs_file; ?>></script>
		<script type="text/javascript" src=<?php echo $js_file; ?>></script>
	</head>
	<body>		
		<section>
			<div id="wizardButtons">
				<input  name="button0" id="button0" value="Menu" type="button" />	
				<input  class="walkingWizardButton" name="button1" id="button1" value="Detalii" type="button" />	
				<input  class="defaultWizardButton" name="button2" id="button2" value="Caracteristici" type="button" />	
				<input  class="defaultWizardButton" name="button3" id="button3" value="Facilitati" type="button" />	
				<input  class="defaultWizardButton" name="button4" id="button4" value="Imagini" type="button" />
				<input  class="defaultWizardButton" name="button5" id="button5" value="Camere" type="button" />
				<input  class="defaultWizardButton" name="button6" id="button6" value="Optiuni" type="button" />						
			</div>			
			<div id="tabs">		
				<form id="addPropertyForm" method="post" accept-charset="utf-8" action=<?php echo $base_url . 'admin/characteristics'; ?>>	       
						<legend>Detalii</legend>
						<fieldset>
							<legend>Detalii proprietate</legend>
							<div>
								<label for="propertyName">Denumire:</label>
								<input name="propertyName" id="propertyName", placeholder="Numele proprietatii"/>
							</div> 
							<div>
								<label for="propertyTown">Oras:</label>
								<input name="propertyTown" id="propertyTown" type="town" placeholder="Oras"/>
							</div> 
							<div>
							   <label for="propertyAddress">Adresa</label>
							   <textarea name="propertyAddress" id="propertyAddress" rows="1" cols="50"
							   placeholder="Adresa proprietatii"/></textarea>
							</div>                 
						</fieldset>
						<fieldset>
							<legend>Detalii proprietar</legend>
							<div>
								<label for="ownerName">Nume:</label>
								<input name="ownerName" id="ownerName" placeholder="Numele proprietarului"/>
							</div>
							<div>
								<label for="ownerEmail">Email:</label>
								<input name="ownerEmail" id="ownerEmail" type="email" placeholder="Adresa de email"/>
							</div>
							<div>
								<label for="ownerTown">Oras:</label>
								<input name="ownerTown" id="ownerTown" type="town" placeholder="Oras"/>
							</div>           
							<div>
								<label for="ownerAddress">Adresa</label>
								<textarea name="ownerAddress" id="ownerAddress" rows="1" cols="50"
								placeholder="Adresa proprietarului"/></textarea>
							</div>     
						</fieldset>
						<div id="traverse">
							<input id="hiddenButton" value="Inapoi" type="button" />
							<input id="next" value="Inainte" type="submit" />
						</div>
			    </form>
			</div>			
		</section>
		<p id="footer">&copy; 2011 </p>
	</body>
</html>