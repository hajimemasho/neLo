<?php
	class PropertyModel extends CI_Model{

		private $CI;
		public $propertiesFile;		

		function __construct()
		{			
			parent::__construct();			
			//$this->propertiesFile = 'propertiesDb.xml';		

			// se incarca modelul existDb
			$this->CI =& get_instance();
			/*
				Se incarca 
				 primul param - calea spre fisierul existDBModel
				 exist - numele prin care va putea fi accesat in program
			*/
		    $this->CI->load->model('database/existDBModel','exist');  

		    // projectNeLo - numele colectiei din baza de date eXist
		    $this->CI->exist->init('projectNeLo/');		     

		    // ne conectam la baza de date
		    $this->CI->exist->connect();				
		}

		function getOptionsData($xql){

			$xql = $xql . "local:list-options()";		
			$this->CI->exist->prepareQuery($xql);			
			$this->CI->exist->execute();
			$results = $this->CI->exist->getResults();						
			
			return $results;
		}

	}

?>