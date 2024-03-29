<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/encodeDecodeToken.php';

class AuthController extends CI_Controller{

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
        $this->objOfJwt = new encodeDecodeToken();
        header('Content-Type: application/json');
        $this->load->helper('form');
        $this->load->model('AuthModel');
        $this->load->helper('url');
    }
    
    public function login()
    {
        $data =  json_decode(file_get_contents('php://input'), TRUE);
        $username = $data['username'];
        $password = $data["password"];
        $user = $this->AuthModel->getUserData($username, $password);
        if($user){
            $tokenData['uniqueId'] = $user->login_id;
            $tokenData['status'] = true;
            $tokenData['name'] = $user->login_username;
            $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
            $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
            echo json_encode(array('Token'=>$jwtToken));
        } else {
            echo json_encode(false);
        }
    }
}
?>