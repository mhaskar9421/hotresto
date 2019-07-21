<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class userController extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
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
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('userModel');
    }
    
    public function loginUser()
    {
        $userdata = [];
        $data =  json_decode(file_get_contents('php://input'), TRUE);
        $username = $data['username'];
        $password = $data["password"];
        $user = $this->userModel->login($username, $password);
        if($user){
            $userdata = array(
                'username' => $user->username,
                'active_status' => $user->active_status
            );
        }
        $this->session->set_userdata(array('userdata' => $userdata));
        echo json_encode($user);
    }

    public function logout()
    {
        //$this->session->set_userdata(array('userdata'=>null));
        echo json_encode($this->session->userdata('userdata'));
    }

}
?>