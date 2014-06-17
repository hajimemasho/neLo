<?php
	/* Clasa cu ajutorul careia se realizeaza conexiunea la baza de date 
	din eXist, se executa interogarile si se updateaza fisierele xml.*/
	class ExistDBModel extends CI_Model{

		public $conn;
		public $connConfig;		
		public $stmt;
		public $resultPool;
		
		function __construct()
		{
			parent::__construct();						
			// incarca librariile pentru eXist
			$this->load->library('exist/lib/Client');
			$this->load->library('exist/lib/Query');
			$this->load->library('exist/lib/ResultSet');
			$this->load->library('exist/lib/SimpleXMLResultSet');
			$this->load->library('exist/lib/DOMResultSet');
		
		}

		public function init($pathToCollection)
	    {
	        $this->connConfig = array(
				'protocol'=>'http',
				'host'=>'localhost',
				'port'=>'8080',
				'user'=> 'admin',
				'password'=> 'Lumineaza-maD0amne',		
				'collection' => $pathToCollection
			);
	    }

		function sayHi(){
			echo "I said hi";
		}

		function connect()
		{
			//$this->conn = new \ExistDB\Client($this->connConfig);			
			$this->conn = new \CI_Client;
			$this->conn->init($this->connConfig);
			
		}

		/* returns a Query object used for binding variables, 
			for executing the query, for setting the retun type etc 
		*/
		public function prepareQuery($xqlQuery)
		{
			$this->stmt = $this->conn->prepareQuery($xqlQuery);

		}

		/* function that binds all variables given as arguments 
			the variables become available and can be used in queries
		*/ 
		public function bindVariables($arrayVars)
		{
			//if(is_array($arrayVars)){
				$this->stmt->bindVariables($arrayVars);	
		//	}
		}

		public function bindVariable($key, $value)
		{
			$this->stmt->bindVariable($key, $value);			
		}

		/* function that executes the query inserted */
		public function execute(){
			//echo "execute";
			$this->resultPool = $this->stmt->execute();			
		}

		/*
			function that returns the results when xquery is used
				when xquery update extensions is used the function returns an empty array				  
		*/
		public function getResults()
		{
			$results = $this->resultPool->getAllResults();			
			//echo "<results>" . count($results) . "</results>";
			return $results;
		}


	}
?>
