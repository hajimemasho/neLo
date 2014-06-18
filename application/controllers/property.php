<?php
	class Property extends CI_Controller{
		
		// variabila ce contine functiile generale folosite, din limbajul xquery
		private $generalXql;
		function __construct()
		{
			parent::__construct();
			$this->load->model('property/propertyModel');
			// incarcam codul xquery apelat in model
			$this->generalXql = $this->load->view('xquery/general', '' , true);		
		}

		function availability()
		{
						
			$xql = $this->generalXql . $this->load->view('xquery/property', '', true);
			$options = $this->propertyModel->getOptionsData($xql);

			$data = array(							
    			'title'		=>	'Camere disponibile',
    			'heading'	=>  'Camere disponibile',
    			'css_file'	=>   css_url() . 'availability.css',
    			'datepickrCss' => css_url() . 'datepickr.css',
    			'js_file'   =>   js_url() . 'availability.js',
    			'datepickr'	=>	 js_url() . 'datepickr.js', 
    			'base_url'	=>   base_url(), 
    			'options'	=>	 $options
			);

			//$this->load->view('templates/header', $data);
			$this->load->view('property/availability', $data);
			//$this->load->view('templates/footer');

		}		

		function checkAvailability()
		{
			echo "Am dat submit la formul 'Check avalaible rooms'";
		}	

	}
?>
