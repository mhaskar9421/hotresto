<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class loginController extends CI_Controller {

 public function __construct()
 {
  parent::__construct();
  $this->load->model('loginModel');
 }

 function loginUser()
 {
   $result = $this->loginModel->userLogin($this->input->post('username'), $this->input->post('password'));
   if($result != '')
   {
    echo json_encode($result);
    return json_encode($result);
   }
 }
}
?>