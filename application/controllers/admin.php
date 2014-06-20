<?php
	
	/***
		-- Clasa Admin se ocupa cu adaugare proprietatilor in baza de date. --
	***/
	class Admin extends CI_Controller{
		// variabila care contine functiile xquery folosite de majoritatea
		// interogarilor
		private $generalXql;
		// variabila ce contine clasele butoanelor		
		private $wizardData;
		// variabila care contine titlul, heading-ul si linkurile introduse 
		// in header-ul paginii(caile catre fisierul css, javascript etc)
		private $headerData;
		// variabila care contine datele incarcate dinamic in pagina 
		// principala
		private $mainData;
		function __construct()
		{
			parent::__construct();			
			// asociem modelul adminModel
			$this->load->model('admin/adminModel');
			// preluam codul xquery pentru functiile generale
			$this->generalXql = $this->load->view('xquery/general', '' , true);			
			// initial, toate butoanele au aceeasi clasa
			$this->wizardData = array(
				"classButton1"	=>	"defaultWizardButton",
				"classButton2"	=>	"defaultWizardButton", 
				"classButton3"	=>	"defaultWizardButton", 
				"classButton4"	=>	"defaultWizardButton", 
				"classButton5"	=>	"defaultWizardButton", 
				"classButton6"	=>	"defaultWizardButton"
			);
			$this->headerData = array(				
				'title'		=> 'Adauga o proprietate',
				'heading'	=> 'Adauga o proprietate', 				
				'css_file'	=> css_url() . 'details.css',
				'generaljs_file'	=> js_url() . 'general.js',
				'addpropertyjs_file'   => js_url() . 'addProperty.js',
				'js_file'   => js_url() . 'details.js',				
			);	
			// contine calea catre documentul curetn
			$this->mainData = array(
				'base_url'	=> base_url()	
			);
		}

		/** ADAUGAREA UNEI PROPRIETATI **/
		
		// incarca formularul ce contine detalii despre proprietar 
		// si o anumita proprietate 
		function details(){			
			// modificam clasa butonului corespunzator pentru pagina 
			// details.php
			$this->wizardData['classButton1'] = "walkingWizardButton";
			// incarcam codul in variabila $wizardButtons
			$wizardButtons = $this->load->
				view('admin/addProperty/wizardButtons', $this->wizardData, true);
			// adaugam codul pentru wizardButtons
			$this->mainData['wizardButtons'] = $wizardButtons;
			// incarcam headerul paginii
			$this->load->view('templates/header.php', $this->headerData);
			// incarca pagina html ce afiseaza form-ul cu detaliile
			$this->load->view('admin/addProperty/details.php', $this->mainData);			
		}
		
		// incarca formularul care contine caracteristicile unei proprietati
		function characteristics(){
			// modificam clasa butonului corespunzator pentru pagina 
			// characteristics.php
			$this->wizardData['classButton2'] = "walkingWizardButton";
			// incarcam codul in variabila $wizardButtons
			$wizardButtons = $this->load->
				view('admin/addProperty/wizardButtons', $this->wizardData, true);
			// modificam caile spre documentul css si js
			$this->headerData['css_file'] = css_url() . 'characteristics.css';
			$this->headerData['js_file'] =  js_url() . 'characteristics.js';
			// adaugam codul pentru wizardButttons
			$this->mainData['wizardButtons'] = $wizardButtons;			
			//se incarca codul pentru sesiune
			$this->load->view('admin/addProperty/addPropertySession');
			//se incarca headerul paginii
			$this->load->view('templates/header.php', $this->headerData);
			// se incarca pagina html ce contine formul cu caracteristicile
			// proprietatii
			$this->load->view('admin/addProperty/characteristics.php', $this->mainData);			
			// se incarca footerul paginii
			$this->load->view('templates/footer.php');
		}

		// incarca formularul care contine facilitatile pe care le poate
		// avea o proprietate
		function facilities(){		
			// modificam clasa butonului corespunzator pentru pagina 
			// facilities.php
			$this->wizardData['classButton3'] = "walkingWizardButton";
			// incarcam codul in variabila $wizardButtons
			$wizardButtons = $this->load->
				view('admin/addProperty/wizardButtons', $this->wizardData, true);
			// modificam caile spre fisierul css si javascript
			$this->headerData['css_file'] = css_url() . 'facilities.css';
			$this->headerData['js_file']  =  js_url() . 'facilities.js';
			// adaugam codul pentru wizardButtons
			$this->mainData['wizardButtons'] =	$wizardButtons;									
			//se incarca codul pentru sesiune
			$this->load->view('admin/addProperty/addPropertySession');
			//se incarca headerul paginii
			$this->load->view('templates/header.php', $this->headerData);			
			// incarca pagina html ce permite adaugarea de facilitati pentru o 
			// proprietate
			$this->load->view('admin/addProperty/facilities.php', $this->mainData);
			// se incarca footerul paginii
			$this->load->view('templates/footer.php');
		}
		// incarca formularul care contine facilitatile pe care le poate
		// avea o proprietate
		function images(){				
			// modificam clasa butonului corespunzator pentru pagina
			// images.php
			$this->wizardData['classButton4'] = "walkingWizardButton";
			// incarcam codul in variabila $wizardButtons
			$wizardButtons = $this->load->
				view('admin/addProperty/wizardButtons', $this->wizardData, true);
			// modificam caile pentru fisierele css si javascript
			$this->headerData['css_file'] = css_url() . 'images.css';
			$this->headerData['js_file'] =  js_url() . 'images.js';
			// adaugam codul pentru wizardButtons
			$this->mainData['wizardButtons'] = $wizardButtons;			
			//se incarca codul pentru sesiune
			$this->load->view('admin/addProperty/addPropertySession');
			// incarcam headerul paginii
			$this->load->view('templates/header.php', $this->headerData);						
			// incarca pagina html ce permite adaugarea de imagini pentru o 
			// proprietate
			$this->load->view('admin/addProperty/images.php', $this->mainData);
			// se incarca footerul paginii
			$this->load->view('templates/footer.php');
		}
		// incarca formularul cu camerele proprietatii
		function rooms(){
			// modificam clasa butonului corespunzator pentru pagina
			// images.php
			$this->wizardData['classButton5'] = "walkingWizardButton";
			// incarcam codul in variabila $wizardButtons
			$wizardButtons = $this->load->
				view('admin/addProperty/wizardButtons', $this->wizardData, true);
			// modificam caile pentru fisierele css si javascript
			$this->headerData['css_file'] = css_url() . 'rooms.css';
			$this->headerData['js_file'] =  js_url() . 'rooms.js';
			// adaugam codul pentru wizardButtons
			$this->mainData['wizardButtons'] = $wizardButtons;			
			//se incarca codul pentru sesiune
			$this->load->view('admin/addProperty/addPropertySession');
			// incarcam headerul paginii
			$this->load->view('templates/header.php', $this->headerData);
			// incarca pagina html ce permite adaugarea de imagini pentru o 
			// proprietate
			// incarca pagina html ce permite adaugarea de camere
			$this->load->view('admin/addProperty/rooms.php', $this->mainData);			
			// se incarca footerul paginii
			$this->load->view('templates/footer.php');
		}
		// incarca formularul care permite adaugarea de optiuni pentru fiecare camera 
		// inserata anterior 
		function options(){
			// modificam clasa butonului corespunzator pentru pagina
			// images.php
			$this->wizardData['classButton6'] = "walkingWizardButton";
			// incarcam codul in variabila $wizardButtons
			$wizardButtons = $this->load->
				view('admin/addProperty/wizardButtons', $this->wizardData, true);
			// modificam caile pentru fisierele css si javascript
			$this->headerData['css_file'] = css_url() . 'options.css';
			$this->headerData['js_file'] =  js_url() . 'options.js';
			// adaugam codul pentru wizardButtons
			$this->mainData['wizardButtons'] = $wizardButtons;			
			//se incarca codul pentru sesiune
			$this->load->view('admin/addProperty/addPropertySession');
			// incarcam headerul paginii
			$this->load->view('templates/header.php', $this->headerData);
			// incarca pagina html ce permite adaugarea de optiuni pentru o 
			// proprietate
			$this->load->view('admin/addProperty/options.php', $this->mainData);			
			// se incarca footerul paginii
			$this->load->view('templates/footer.php');			
		}

		//	functie care introduce o proprietate in baza de date
		function saveProperty(){							
			// incarca fisierul ce contine codul xquery pentru adaugarea unei proprietati			
			// se concateneaza cu generalXql deoarece pot fi folosite si acete functii
			$propertyXql = $this->generalXql . $this->load->view('xquery/property', '', true);					
			// incarca fisierul ce contine codul xquery pentru inserarea
			// camerelor			
			// se apeleaza functia din model care executa codul xquery
			$this->adminModel->insertPropertyData($this->generalXql, $propertyXql);			
		}
		
	}
?>