<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/encodeDecodeToken.php';

class RoomController extends CI_Controller{

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
        $this->load->model('RoomModel');
        $this->load->helper('url');
	}
	
	public function addRoom() {
		//$roomdata =  json_decode(file_get_contents('php://input'), TRUE);
		$roomdata = array(
			'roomname' => 'side_left',
			'roomnumber' => '1',
			'noofbeds' => '2',
			'roomimage' => 'image'
		);
		$response = $this->RoomModel->AddRoom($roomdata);
		if($response){
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}
}
?>