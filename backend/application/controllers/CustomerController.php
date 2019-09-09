<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/encodeDecodeToken.php';

class CustomerController extends CI_Controller{

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
        $this->load->model('CustomerModel');
		$this->load->helper('url');
		$this->load->library('upload');
	}     
	
	public function storeImage() {
		$customerdata = json_decode(file_get_contents('php://input'), TRUE);
		$files = $_FILES;
		$cpt = count($_FILES['afuConfig']['name']);
		for($i=0; $i<$cpt; $i++)
		{           
			$_FILES['afuConfig']['name']= $files['afuConfig']['name'][$i];
			$_FILES['afuConfig']['type']= $files['afuConfig']['type'][$i];
			$_FILES['afuConfig']['tmp_name']= $files['afuConfig']['tmp_name'][$i];
			$_FILES['afuConfig']['error']= $files['afuConfig']['error'][$i];
			$_FILES['afuConfig']['size']= $files['afuConfig']['size'][$i];    
		}
        $this->upload->initialize($this->set_upload_options());
		$data = $this->upload->do_upload();
		
		if($data){
			echo json_encode($data);
		} else {
			echo json_encode(false);
		}
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
		if($customerdata){
			echo json_encode($file);
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

	public function viewBookedCustomers() {
		$response = $this->CustomerModel->viewBookedCustomers();
		$GST = $this->CustomerModel->getGSTValue();
		foreach ($GST as $data) { 
             $GSTValues[] = $data->tax_amount; 
		}
		$totalGST = array_sum($GSTValues);
		foreach ($response as $data) {
			$totalRoomCharges = $data->room_charges + $data->extra_occupancy;
			if($totalRoomCharges > 999){
				$totalRoomCharges = $totalRoomCharges + ($totalRoomCharges * $totalGST / 100);
				$data->totalRoomCharges = $totalRoomCharges;
				$data->GST = $totalGST; 
			} else {
				$data->totalRoomCharges = $totalRoomCharges;
				$data->GST = null;
			}
			$data->grandTotal = $totalRoomCharges + $data->food_bill_amount;
		}
		if($response){
			echo json_encode($response);
		} else {
			echo json_encode(false);
		}
	}

	public function deleteCustomer($id) {
		$result = $this->CustomerModel->deleteCustomer($id);
		if($result){
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}

	public function totalCustomers() {
		$result = $this->CustomerModel->totalCustomers();
		if($result){
			echo json_encode($result);
		} else {
			echo json_encode(false);
		}
	}
}
?>