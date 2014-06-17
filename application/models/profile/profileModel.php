<?php
	/* Clasa in care sunt efectuate interogari ale bazei de date care tin 
		de inregistrare si logare. */
	class ProfileModel extends CI_Model{

		// variabila in care se incarca modelul existDb ce permite conexiunea la 
		// baza de date
		private $CI;
		// numele fisierului xml folosit pentru interogari
		public $usersFile;		
		// variabila care va retine o instanta a clasei CI_Password responsabila cu 
		// construirea hash-ului pentru parola		
		public $passwordObj;

		function __construct()
		{			
			parent::__construct();
			// fisierul users.xml contine utilizatorii inregistrati
			$this->usersFile = 'users.xml';			
			// se incarca libraria ce contine clasa CI_Password
			$this->load->library('security/password');
			// se creaza o instanta a clasei CI_Password
			$this->passwordObj = new \CI_Password;
			// pentru a putea incarca un model(existDb) intr-un alt model(cel curent), 
			// Codeigniter pune la dispozitie o functie care returneaza o referinta la obiecul 
			// Codeigniter prin care se va incarca modelul existDb. 
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

		/** METODE PENTRU INREGISTRAREA UNUI USER **/

		// functie care verifica daca emailul utilizatorului, care incearca sa se inregistreze, 
		// exista deja in baza de date 
		function checkEmailExistence($email, $xql){			
			
			// se apeleaza functia xquery care verifica daca un email exista deja
			$xql = $xql . 'local:check-email-existence(xs:string($email))';			
			$this->CI->exist->prepareQuery($xql);							
			// legam continul lui $email la variabila email din xquery
			$this->CI->exist->bindVariable('email', $email);	
			// executam interogarea
			$this->CI->exist->execute();		
			// obtinem rezultatul(0 sau 1)
			$emailExistence = $this->CI->exist->getResults();		
			return $emailExistence;
		}

		// functie care insereaza o noua intrare in users.xml ca urmare a inregistrarii unui 
		// nou utilizator 
		function insertUser($xql){
			// deschidem o sesiune
			session_start();
			
			// retinem emailul utilizatorului curent pentru a fi folosit mai tarziu
			if(isset($_POST['email'])){
				$_SESSION['email'] = $_POST['email'];
			}
			
			// apelam functia cu parametri email, parola, prenume si nume al carei efect este 
			// inserarea unei noi intrari in users.xml
			$xql = $xql . 'local:insert-user-info($email, $password, $firstname, $lastname)';						
			$this->CI->exist->prepareQuery($xql);							
			// pentru fiecare camp din formular
			foreach($_POST as $key => $value){	        			        		
				// asignam datele unor variabile pe care le "legam" la interogarea curenta 
				// pentru a putea fi accesibile(vazute) din codul xquery
				
				// daca este vorba de campul parola
        		if($key === 'password'){	        			
        			// inseram un hash si nu parola in clar
        			$this->CI->exist->bindVariable($key, $this->securePassword($value));
        		}else{        
        			// pentru orice alt camp, asignam informatia in clar
        			$this->CI->exist->bindVariable($key, $value);       	        		        						        			       
        		}
			}
			// executa interogarea
			$this->CI->exist->execute();		
			return true;
		}

		// functie care creaza un hash pentru o parola si il returneaza pentru a fi stocat in baza de date
		function securePassword($password){
			 $hash = $this->passwordObj->password_hash($password, PASSWORD_BCRYPT, array("cost" => 10));
			 return $hash;
		}

		// functie care verifica parola din baza de date si cea introdusa de utilizator
		//	- daca este nevoie sa fie refacuta, se genereaza un nou hash care va inlocui
		//	hash-ul din baza de date					
		function verifyPassword($password, $hash){
			// daca parolele coincid
			 if ($this->passwordObj->password_verify($password, $hash)) {
			 	// si este nevoie ca hash-ul sa fie refacut
		        if ($this->passwordObj->password_needs_rehash($hash, PASSWORD_BCRYPT, array("cost" => 10))) {
		        	// se regenereaza un hash
		            $hash = $this->passwordObj->password_hash($password, PASSWORD_BCRYPT, array("cost" => 10));		            
		            // pe care il stocam in baza de date in locul celui vechi		           
		        }
		        return true;
		    }
		    return false;
		}

		/** METODE PENTRU LOGAREA UNUI USER **/

		// functie care verifica daca un utilizator este inregistrat in baza de date
		function checkCredentials($email, $password, $xql){
			// se apeleaza functia care verifica daca exista combinatia de email si parola data			
			$xql = $xql . 'local:credentials-exist($email, $password)';			
			$this->CI->exist->prepareQuery($xql);				
			// se leaga continutul variabilelor $email si $password la variabilele din mediul xquery
			$this->CI->exist->bindVariable('email', $email);
			$this->CI->exist->bindVariable('password', $password);
			// se executa interogarea
			$this->CI->exist->execute();		
			// se obtine rezultul(1 sau 0)
			$credentialsExistence = $this->CI->exist->getResults();			
			return $credentialsExistence;
		}
	}
?>