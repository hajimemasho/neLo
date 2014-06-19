<?php 
	// unset any values for $_SESSION['property']
	// sa testez daca e o sesiune deschisa sa o distrug 
// si apoi sa o deschid pe asta session_destroy();
	//unset($_SESSION['property']);	
	session_start()	;
	//$_SESSION['property'] = array();	
	// get all data inserted into the details form and insert it into a $_SESSION variable
	foreach($_POST as $key => $value){		
		/* There are inputs that associated arrays with its name attirbute return an array of data, 
			for example name="facility[]".
			In this case, the array is entirely assigned to a $_SESSION.
		*/		
	    if(!is_array($_POST[$key])){	        	    	
	        $_SESSION['property'][$key] = $_POST[$key];	        
	    }else{
	    	// otherwise, assign the data one by one
	    	foreach($_POST[$key] as $new_key => $new_value){
	    		$_SESSION['property'][$key][$new_key] = $_POST[$key][$new_key];
	    	}
	    }
    }   
  /*  foreach ($_SESSION['property'] as $key => $value) {
    	if(!is_array($_SESSION['property'][$key])){
    		echo $key . " = " . $_SESSION['property'][$key] . "<br />";
    	}else{
    		var_dump($_SESSION['property'][$key]);
    	}
    }*/    
   /* unset($_SESSION);
    session_destroy();
    if(isset($_SESSION['property'])){
    	echo "property is set";
    }else{
    	echo "property is not set";
    }*/
?>
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
				<input  class="defaultWizardButton" name="button1" id="button1" value="Detalii" type="button" />	
				<input  class="defaultWizardButton" name="button2" id="button2" value="Caracteristici" type="button" />	
				<input  class="defaultWizardButton" name="button3" id="button3" value="Facilitati" type="button" />	
				<input  class="defaultWizardButton" name="button4" id="button4" value="Imagini" type="button" />
				<input  class="defaultWizardButton" name="button5" id="button5" value="Camere" type="button" />
				<input  class="defaultWizardButton" name="button6" id="button6" value="Optiuni" type="button" />		
			</div>			
			<div id="tabs">		
				<form id="addPropertyForm" method="post" accept-charset="utf-8" action=<?php echo $base_url . 'admin/facilities'; ?>>
					<legend>Caracteristici</legend>
					<fieldset>
						<div>
							<label for="propertyType">Tip proprietate:</label>
							<input name="propertyType" list="propertyTypes" placeholder="Hotel"/>
							<datalist id="propertyTypes">
							  <option value="Hotel">
							  <option value="Cripta">
							  <option value="Pensiune">
							</datalist>
						</div>
						<div>
							<label for="starsNumber">Numar stele:</label>
							<input name="starsNumber" id="starsNumber" type="number" min="2" max="5" placeholder="2"/>
						</div>
						<div>
							<label for="totalRooms">Numar total camere:</label>
							<input name="totalRooms" id="totalRooms" type="number" min="1" placeholder="1"/>
						</div>
						<div>
							<label for="presentation">Prezentare</label>
							<textarea name="presentation" id="presentation" rows="10" cols="50" placeholder="
								Servicii oferite, localizare, puncte de reper, spatii de cazare, facilitati" />
							</textarea>
						</div>
						<div>
							<label for="accommodRules">Reguli de cazare:</label>
							<textarea name="accommodRules" id="accommodRules" rows="5" cols="50" placeholder="
								Detalii legate de ziua hoteliera, termenul limita de plata, conditiile cu 
								privire la anularea rezervarii, alte restrictii.">
							</textarea>
						</div>
					</fieldset>   
					<div id="traverse">
						<input id="previous" value="Inapoi" type="button" />
						<input id="next" value="Inainte" type="submit" />
					</div>
				</form>		
			</div>			
		</section>
		<p id="footer">&copy; 2011 </p>
	</body>
</html>