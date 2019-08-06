<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/encodeDecodeToken.php';

class TaxController extends CI_Controller{

    public function __construct($config = 'rest')
    {  
		if (isset($_SERVER['HTTP_ORIGIN'])){
		header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 0');    // cache for 1 day
		}
		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') 
		{
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST,OPTIONS");         
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
			exit(0);
		}
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('TaxModel');
        $this->load->helper('url');
	}
	
	public function addTax() {
		$tax = json_decode(file_get_contents('php://input'), TRUE);
		$response = $this->TaxModel->AddTax($tax);
		if($response){
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}

	public function viewTax() {
		$response = $this->TaxModel->ViewTax();
		if($response){
			echo json_encode($response);
		} else {
			echo json_encode(false);
		}
	}

	public function deleteTax($id) {
		$result = $this->TaxModel->deleteTax($id);
		if($result){
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}
}
?>