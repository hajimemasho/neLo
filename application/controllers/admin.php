<?php
	
	/***
		-- Clasa Admin se ocupa cu adaugare proprietatilor in baza de date. --
	***/
	class Admin extends CI_Controller{
		// variabila care contine functiile xquery folosite de majoritatea
		// interogarilor
		private $generalXql;
		function __construct()
		{
			parent::__construct();			
			// asociem modelul adminModel
			$this->load->model('admin/adminModel');
			// preluam codul xquery pentru functiile generale
			$this->generalXql = $this->load->view('xquery/general', '' , true);
		}

		/** ADAUGAREA UNEI PROPRIETATI **/
		
		// incarca formularul ce contine detalii despre proprietar 
		// si o anumita proprietate 
		function details(){
			// titlul, heading-ul, fisierele css si fisierele javascript si alte
			// variabile necesare in documentul html
			$data = array(				
				'title'		=> 'Adauga o proprietate',
				'heading'	=> 'Adauga o proprietate', 				
				'css_file'	=> css_url() . 'details.css',
				'generaljs_file'	=> js_url() . 'general.js',
				'addpropertyjs_file'   => js_url() . 'addProperty.js',
				'js_file'   => js_url() . 'details.js',
				'base_url'	=> base_url()
			);						
			// incarca pagina html ce afiseaza form-ul cu detaliile
			$this->load->view('admin/addProperty/details.php', $data);			
		}
		
		// incarca formularul care contine caracteristicile unei proprietati
		function characteristics(){
			//session_start();
			// titlul, heading-ul, fisierele css si fisierele javascript si alte
			// variabile necesare in documentul html
			$data = array(
				'title'		=> 'Adauga o proprietate',
				'heading'	=> 'Adauga o proprietate', 				
				'css_file'	=> css_url() . 'characteristics.css',
				'generaljs_file'	=> js_url() . 'general.js',
				'addpropertyjs_file'   => js_url() . 'addProperty.js',
				'js_file'   => js_url() . 'characteristics.js',
				'base_url'	=> base_url()
			);
			// incarca pagina html ce contine formul cu caracteristicile
			// proprietatii
			$this->load->view('admin/addProperty/characteristics.php', $data);			
		}

		// incarca formularul care contine facilitatile pe care le poate
		// avea o proprietate
		function facilities(){				
			// incarca codul xquery pentru preluare afacilitatilor din fiserul 
			// facilities.xml
			$xql = $this->generalXql . $this->load->view('xquery/property', '', true);						
			// preia toate facilitatile existente si le afiseaza
			$facilities = $this->adminModel->getFacilitiesData($xql);				
			// titlul, heading-ul, fisierele css si fisierele javascript si alte
			// variabile necesare in documentul html
			$data = array(
				'title'		=> 'Adauga o proprietate',
				'heading'	=> 'Adauga o proprietate', 				
				'css_file'	=> css_url() . 'facilities.css',				
				'generaljs_file'	=> js_url() . 'general.js',
				'addpropertyjs_file'   => js_url() . 'addProperty.js',
				'js_file'   => js_url() . 'facilities.js',
				'base_url'	=> base_url(),								
			);
			// incarca pagina html ce permite adaugarea de facilitati pentru o 
			// proprietate
			$this->load->view('admin/addProperty/facilities.php', $data);
		}
		// incarca formularul care contine facilitatile pe care le poate
		// avea o proprietate
		function images(){				
			// incarca codul xquery pentru preluare afacilitatilor din fiserul 
			// facilities.xml
			$xql = $this->generalXql . $this->load->view('xquery/property', '', true);						
			// preia toate facilitatile existente si le afiseaza
			$facilities = $this->adminModel->getFacilitiesData($xql);				
			// titlul, heading-ul, fisierele css si fisierele javascript si alte
			// variabile necesare in documentul html
			$data = array(
				'title'		=> 'Adauga o proprietate',
				'heading'	=> 'Adauga o proprietate', 				
				'css_file'	=> css_url() . 'images.css',				
				'generaljs_file'	=> js_url() . 'general.js',
				'addpropertyjs_file'   => js_url() . 'addProperty.js',
				'js_file'   => js_url() . 'images.js',
				'base_url'	=> base_url(),								
			);
			// incarca pagina html ce permite adaugarea de facilitati pentru o 
			// proprietate
			$this->load->view('admin/addProperty/images.php', $data);
		}
		// incarca formularul cu camerele proprietatii
		function rooms(){
			// titlul, heading-ul, fisierele css si fisierele javascript si alte
			// variabile necesare in documentul html
			$data = array(
				'title'		=> 'Adauga o proprietate',
				'heading'	=> 'Adauga o proprietate', 				
				'css_file'	=> css_url() . 'rooms.css',
				'generaljs_file'	=> js_url() . 'general.js',
				'addpropertyjs_file'   => js_url() . 'addProperty.js',
				'js_file'   => js_url() . 'rooms.js',
				'base_url'	=> base_url()
			);
			// incarca pagina html ce permite adaugarea de camere
			$this->load->view('admin/addProperty/rooms.php', $data);			
		}

		// incarca formularul care permite adaugarea de optiuni pentru fiecare camera 
		// inserata anterior 
		function options(){
			// titlul, heading-ul, fisierele css si fisierele javascript si alte
			// variabile necesare in documentul html
			$data = array(
				'title'		=> 'Adauga o proprietate',
				'heading'	=> 'Adauga o proprietate', 				
				'css_file'	=> css_url() . 'options.css',
				'generaljs_file'	=> js_url() . 'general.js',
				'addpropertyjs_file'   => js_url() . 'addProperty.js',
				'js_file'   => js_url() . 'options.js',
				'base_url'	=> base_url()
			);
			// incarca pagina html ce permite adaugarea de optiuni pentru o 
			// proprietate
			$this->load->view('admin/addProperty/options.php', $data);			
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