<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class userController extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('userModel');
    }
    
    public function loginUser()
    {
        $data =  json_decode(file_get_contents('php://input'), TRUE);
        $username = $data['username'];
        $password = $data["password"];
        $user = $this->userModel->login($username, $password);
        return json_encode($user);
    }

}
?>