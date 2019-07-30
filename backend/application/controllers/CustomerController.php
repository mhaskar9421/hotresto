<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/encodeDecodeToken.php';

class CustomerController extends CI_Controller{

    public function __construct($config = 'rest')
    {  
		if (isset($_SERVER['HTTP_ORIGIN'])){
		header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 86400');    // cache for 1 day
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
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('CustomerModel');
        $this->load->helper('url');
	}
	
	public function addCustomer() {
		$customerdata = json_decode(file_get_contents('php://input'), TRUE);
		$data = array(
			'customername' => $customerdata['customername'],
			'custid' => $customerdata['custid'],
			'idnumber' => $customerdata['idnumber'],
            'phonenumber' => $customerdata['phonenumber'],
            'address' => $customerdata['address']            
        );
		$response = $this->CustomerModel->AddCustomer($data);
		if($response){
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}

	public function viewCustomer() {
		$response = $this->CustomerModel->ViewCustomer();
		if($response){
			echo json_encode($response);
		} else {
			echo json_encode(false);
		}
	}
}
?>