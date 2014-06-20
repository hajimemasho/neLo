<?php

	/***
		Clasa care contine, in principal, interogari si inserari in baza de date
		privitoare la adaugarea unei proprietati
	***/
	class AdminModel extends CI_Model{

		// variabila in care se incarca modelul existDb ce permite conexiunea la 
		// baza de date
		private $CI;
		// numele fisierelor xml folosite pentru interogari
		public $facilitiesFile;		

		function __construct()
		{			
			parent::__construct();			
			// fisierul facilities.xml contine facilitatile existente pentru proprietati			
			$this->facilitiesFile = 'facilities.xml';			
			// pentru a putea incarca un model(existDb) intr-un alt model(cel curent), 
			// Codeigniter pune la dispozitie o functie care returneaza o referinta 
			//la obiecul Codeigniter prin care se va incarca modelul existDb. 
			$this->CI =& get_instance();
			// se incarca modelul existDb:
			// - primul param: calea spre fisierul existDBModel
			// - exist: numele prin care va putea fi accesat in program		
		    $this->CI->load->model('database/existDBModel','exist');  			
		    // projectNeLo - numele colectiei din baza de date eXist
		    $this->CI->exist->init('projectNeLo/');		     
		    // ne conectam la baza de date
		    $this->CI->exist->connect();
		}

		/** ADAUGAREA UNEI PROPRIETATI **/
		
		// functie care extrage facilitatile din fisierul "facilities.xml", si le afiseaza
		function getFacilitiesData($xql){							
			// apelam functia care se ocupa cu extragerea si afisarea facilitatilor
			$xql = $xql . 'local:display-facilities()';	
			$this->CI->exist->prepareQuery($xql);			
			// executam interogarea
			$this->CI->exist->execute();
			$results = $this->CI->exist->getResults();									
			return $results;
		}		
		// functie care preia datele introduse in timpul wizard-ului si le insereaza in 
		// fisierul properties.xml
		// - $generalXqL contine functii xquery aplicate in toate celelalte xql-uri
		// - $propertyXql contine functii xquery pentru inserarea unei proprietati		
		function insertPropertyData($generalXql, $propertyXql){							
			// continuam sesiunea deja deschisa
			session_start();			
			// daca sesiunea inca nu a expirat
			if(isset($_SESSION['property'])){
				echo "session is sert";
				// inserarea caracteristicilor
				// cream un array din caracteristicile proprietatii introduse de admin
				if(isset($_SESSION['property']['propertyType']) && isset($_SESSION['property']['propertyName'])
					&& isset($_SESSION['property']['propertyAddress']) && isset($_SESSION['property']['propertyTown'])
					&& isset($_SESSION['property']['starsNumber']) && isset($_SESSION['property']['totalRooms'])
					&& isset($_SESSION['property']['presentation']) && isset($_SESSION['property']['accommodRules'])){
					
					$charactArray = array('propertyType'=> $_SESSION['property']['propertyType'],
										  'propertyName' => $_SESSION['property']['propertyName'],
										  'propertyAddress' => $_SESSION['property']['propertyAddress'],
										  'propertyTown' => $_SESSION['property']['propertyTown'],
										  'starsNumber' => floatval($_SESSION['property']['starsNumber']),
										  'totalRooms' => floatval($_SESSION['property']['totalRooms']),
										  'presentation' => $_SESSION['property']['presentation'],
										  'accommodRules' => $_SESSION['property']['accommodRules']
										);				
					$charactXql = $propertyXql . 'local:insert-property-charact($propertyType, $propertyName, 
						$propertyAddress, $starsNumber, $totalRooms, $presentation, $accommodRules)';
					//$charactXql = $propertyXql . "local:insert-property-charact('hotel', 'cea mai tare proprietate', 'Alexandru cel Bun, nr 13',  3, 10, 'Frumoasa prezentare', 'Reguli: ziua hoteliera incepe la 12.00 AM')";

					// apelam functia care adauga o proprietate si caracteristicile ei
					$this->CI->exist->prepareQuery($charactXql);				
					// facem accesibil array-ul cu caracteristici in codul xquery
					$this->CI->exist->bindVariables($charactArray);		
					// executam interogarea xquery
					$this->CI->exist->execute();						
					$results = $this->CI->exist->getResults();				
				
					// preluam id-ul proprietatii introduse mai sus pentru a-l folosi la 
					// adaugarea camerelor si optiunilor				
					$pidXql = $generalXql . 'local:last-property-id()';
					$this->CI->exist->prepareQuery($pidXql);				
					$this->CI->exist->execute();		
					$propertyId = $this->CI->exist->getResults();

					// inserarea facilitatilor						
					// daca au fost introduse facilitati pentru hotelul curent
					if(isset($_SESSION['property']['facility'])){						
						$len = count($_SESSION['property']['facility']);						
						// pentru fiecare facilitate
						for($i = 0; $i < $len; $i++){
							$facilityXql = $propertyXql . 'local:insert-facilities(xs:string($facility))';
							// apelam functia care adauga o proprietate si caracteristicile ei
							$this->CI->exist->prepareQuery($facilityXql);	
							//echo "<br /> " . $_SESSION['property']['facility'][$i];
							// legam valoarea din input la variabila $facility din xquery
							$this->CI->exist->bindVariable('facility', $_SESSION['property']['facility'][$i]);		
							// executam interogarea xquery
							$this->CI->exist->execute();
						}					
					}				 
					
					// inserarea camerelor
					// fiecare valoare din roomType si roomPrice determina crearea unei 
					// camere cu aceste valori
					if(isset($_SESSION['property']['roomType']) && isset($_SESSION['property']['roomPrice'])){
						$len = count($_SESSION['property']['roomType']);						
						for($i = 0; $i < $len; $i++){							
							// apelam functia care adauga o camera
							$roomXql = $propertyXql . 'local:insert-room(xs:decimal($propertyId), $roomType, $roomPrice)';
							$this->CI->exist->prepareQuery($roomXql);				
							// adaugam variabilele propertyId, roomType si roomPrice pentru a putea fi accesate din interogare		
							$this->CI->exist->bindVariable('propertyId', $propertyId[0]);
							$this->CI->exist->bindVariable('roomType', $_SESSION['property']['roomType'][$i]);
							$this->CI->exist->bindVariable('roomPrice', floatval($_SESSION['property']['roomPrice'][$i]));		
							// executam interogarea xquery
							$this->CI->exist->execute();
							
						}
					}

					// inserarea optiunilor				
					$optionXql = $propertyXql . 'local:insert-option( xs:decimal($roomId) + 1, $option)';
					//$optionXql = $propertyXql . 'local:insert-option(1, "valoare")';				
					// apelam functia care se ocupa cu inserarea unei optiuni pentru o 
					// anumita camera
					$this->CI->exist->prepareQuery($optionXql);	
					// facem accesibila variabila propertyId din codul xquery				
		        	// pentru fiecare camera
		        	foreach($_POST as $key => $optionArray){	        			        		
		        		// facem accesibila variabila roomId din codul xquery(contine id-ul camerei)	        		
		        		$this->CI->exist->bindVariable('roomId', $this->_getRoomIndex($key));	        	
		        		// pentru fiecare optiune ale camerei curente
		        		foreach($optionArray as $value){
		        			// facem accesibila variabila option din xquery
		        			//(contine valoarea unei optiuni)
		        			$this->CI->exist->bindVariable('option', $value);
		        			// executam interogarea	        			
		        			$this->CI->exist->execute();	
		        		}					        			        	
		       		}
				}
				session_destroy();		
			}else{
					echo "eroare la sesiuni";
				}
		}

		// functie care extrage din cheia campului, indexul camerei si-l returneaza
		private function _getRoomIndex($key){
			// determina pozitia caracterului underscore
			$underscoreOcc = strpos($key, '_');			
			// preia numarul aflat dupa underscore
			$indexRoom = substr($key, $underscoreOcc + 1);		
			return (int)$indexRoom;
		}

		// functie care extrage caracteristicile unei proprietati din baza de date		
		function getCharactData($propertyId, $xql){					
			$this->CI->exist->prepareQuery($xql);
			$this->CI->exist->bindVariable('propertyId', floatval($propertyId));			
			$this->CI->exist->execute();
			$results = $this->CI->exist->getResults();					

			return $results;			
		}		

		function savePropertyData(){

		}
	}
?>