<?php 

	/** Acest cod va fi introdus in fiecare din documentele html care fac parte 
	din wizard-ul pentru adaugarea unei proprietati: details.php, characteristics.php, 
	facilities.php, images.php, rooms.php si options.php. 
	Creaza sau continua sesiunea creata si retine datele proprietatii in variabila
	$_SESSION['property'] pentru a fi adaugate deodata in baza de date.
	**/

	// deschidem sesiunea	
	session_start()	;
	
	// preia toate datele din variabila $_POST(campurile din formularul curent)
	// si le retine in variabila $_SESSION 
	foreach($_POST as $key => $value){				
		// daca exista campuri al caror nume este de forma "nume[]"
	    if(is_array($_POST[$key])){	        	    	
	    	// se extrag informatiile si se asigneaza una cate una
	    	foreach($_POST[$key] as $new_key => $new_value){
	    		$_SESSION['property'][$key][$new_key] = $_POST[$key][$new_key];
	    	}	        
	    }else{
	    	// se asigneaza avand ca identificator numele cheii
	    	$_SESSION['property'][$key] = $_POST[$key];	        
	    }
    }   
?>