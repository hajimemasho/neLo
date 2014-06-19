<?php 		
	session_start();
	// get all values inserted into the facilities form and insert them into a $_SESSION variable
	foreach($_POST as $key => $value){

		// if the data is organized as an array assign the whole array to a $_SESSION variable
	    if(!is_array($_POST[$key])){	        
	        $_SESSION['property'][$key] = $_POST[$key];
	    }else{

	    	// otherwise, assign the values one by one
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
				<form id="addPropertyForm" method="post" accept-charset="utf-8" action=<?php echo $base_url . 'admin/options'; ?>>					
					<legend>Camere</legend>
					<fieldset id="rooms">
						<div>
							<ul>
								<li>				
									<div>
										<label for="roomType">Tip camera:</label>										
									</div>
									<div>
										<label for="roomPrice">Pret camera:</label>										
									</div>																
								</li>
							</ul>
							<div class="add">
								<input name="addButton" id="addButton" type="button" value="Adauga camera"/>
							</div>
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