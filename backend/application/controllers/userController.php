<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/encodeDecodeToken.php';

class userController extends CI_Controller{

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
				header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

			exit(0);
		}
        parent::__construct();
        $this->objOfJwt = new encodeDecodeToken();
        header('Content-Type: application/json');
        $this->load->helper('form');
        $this->load->model('userModel');
        $this->load->helper('url');
    }
    
    public function loginUser()
    {
        $data =  json_decode(file_get_contents('php://input'), TRUE);
        $username = $data['username'];
        $password = $data["password"];
        $user = $this->userModel->login($username, $password);
        if($user){
            $tokenData['uniqueId'] = $user->id;
            $tokenData['status'] = true;
            $tokenData['name'] = $user->username;
            $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
            $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
            echo json_encode(array('Token'=>$jwtToken));
        }
    }

    public function logout()
    { 
        echo json_encode("Deepti");
    }

}
?>