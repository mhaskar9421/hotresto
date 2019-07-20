<?php
class loginModel extends CI_Model
{
 function userLogin($username, $password)
 {
  //$this->db->where('username', $username);
  //$this->db->where('password', $password);
  //$query = $this->db->get('hr_login');
  
 // if($query->num_rows() == 1) {
    $row = $this->db->get_Where('hr_login', array('username'=>'sachin'))->row();
    return $row;
  // } else {
  //   return false;
  // }
 }
}
?>