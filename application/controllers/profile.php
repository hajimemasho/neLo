<?php
	/* Clasa care se ocupa cu partea de inregistrare/logare a utilizatorilor 
		care doresc sa rezerve camere. */
	class Profile extends CI_Controller{
		
		// variabila ce contine functiile generale in limbajul xquery
		private $generalXql;						

		function __construct()
		{
			parent::__construct();	
			// modelul folosit cu controlerul Profile		
			$this->load->model('profile/profileModel');
			// se incarca functiile xquery apelate in modelul atasat
			$this->generalXql = $this->load->view('xquery/general', '' , true);						
		}

		/** INREGISTRAREA UNUI USER **/
		// functie care afiseaza formularul de inregistrare
		public function register()
		{						
			$data = array(
				'title'		=> 'Creare cont',
				'heading'	=> 'Creare cont', 
				'css_file'	=> css_url() . 'register.css',
				'generaljs_file'	=> js_url() . 'general.js',
				'js_file'   => js_url() . 'register.js',
				'base_url'	=> base_url(), 
				'userExistError' => 'hiddenSubmitError'
			);			
						
				// load the header template
				//$this->load->view('templates/registerHeader', $data);
				// load the register form
				$this->load->view('profile/register', $data);
				// load the footer template
				//$this->load->view('templates/footer');				
		}
		
		// functie care incarca pagina contului utilizatorului dupa inregistrare
		public function yourAccount(){
			
			$data = array(
				'title'		=> 'Contul tau',
				'heading'	=> 'Contul tau', 
				'css_file'	=> css_url() . 'yourAccount.css',
				'js_file'   => js_url() . 'yourAccount.js',
				'base_url'	=> base_url(), 
				'personalInfo' => base_url() . 'yourAccount/personal',
				'reservationsHistory' => base_url() . 'yourAccount/history',				
				'logoutPage' => base_url() . 'yourAccount/logout'				
			);			

				// load the header template
				//$this->load->view('templates/header', $data);
				// load the register form
				$this->load->view('user/yourAccountPage', $data);
				// load the footer template
				//$this->load->view('templates/footer');							
					
		}

		// functie care redirecteaza utilizatorul in functie de cum a avut loc inregistrarea: 
		//	- daca inregistrarea a avut loc cu succes, este redirectat spre contul sau,
		//	- altfel este redirectat spre pagina de inregistrare afisand un mesaj de eroare
		
		public function doregister(){			
			// codul xquery folosit pentru a introduse datele noului utilizator in baza de date
			$userXql = $this->generalXql . $this->load->view('xquery/user', '', true);			
			// se apeleaza metoda insertUser din modelul atasat si se returneaza rezultatul
			$result = $this->profileModel->insertUser($userXql);	
			// daca inregistrarea a avut loc cu succes
			if($result == true){				
				// se redirecteaza utilizatorul spre contul sau
				redirect(base_url() . 'profile/yourAccount', 'location');
			}else{	
				// altfel se redirecteaza spre formularul de inregistrare
				redirect(base_url() . 'profile/register', 'location');
			}

		}

		// functie care verifica daca emailul trimis prin metoda ajax exista deja in baza de date
		public function emailExistence(){
			// se retine emailul trimis
			$email = trim($_POST['email']);
			// se incarca codul xquery care verifica existenta unui email in baza de date
			$userXql = $this->generalXql . $this->load->view('xquery/user', '', true);
			// si se apeleaza metoda din model responsabila care verifica existenta emailului
			$result = $this->profileModel->checkEmailExistence($email, $userXql);			
			// daca exista returneaza 1, altfel returneza 0
			echo $result[0];		
		}
				
		/** LOGAREA UNUI USER **/
		// functie care afiseaza formularul pentru logarea unui user
		public function login()
		{
			$data = array(
				'title'		=> 'Autentificare',
				'heading'	=> 'Autentificare', 
				'css_file'	=> css_url() . 'login.css',
				'generaljs_file'	=> js_url() . 'general.js',
				'js_file'   => js_url() . 'login.js',
				'base_url'	=> base_url()				
			);			
				// load the header template
				//$this->load->view('templates/header', $data);
				// load the register form
				$this->load->view('profile/login', $data);
				// load the footer template
				//$this->load->view('templates/footer');							
		}

		// functie care returneaza 0 sau 1 in functie de existenta credentialelor in baza de date
		public function credentials()
		{	
			// luam emailul si parola trimise prin ajax
			$email = trim($_POST["email"]);
			$password = trim($_POST['password']);

			// incarcam codul xquery care verifica existenta emailului si a parolei in 
			// baza de date 
			$userXql = $this->generalXql . $this->load->view('xquery/user', '', true);
			// si apelam metoda din model care verifica prin xquery daca exista credentialele
			$result = $this->profileModel->checkCredentials($email, $password, $userXql);
			// daca utilizatorul este inregistrat in baza de date
			if($result[0] == 1){
				// se deschide o sesiune 
				session_start();
				// si se retine emailul spre a putea fi folosit mai tarziu
				$_SESSION['email'] = $email;
			}
			// daca exista returneaza 1, altfel returneza 0
			echo $result[0];			
		}
	}
?>
