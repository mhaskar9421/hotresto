<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model{
    
     function getUserData($username, $password)
    {
        $this->db->where('login_username', $username);
        $this->db->where('login_password', $password);
        $query = $this->db->get('hr_login');

        if($query->num_rows() == 1) {
            return $query->row();
        }

        return false;
                
    }
}
?>