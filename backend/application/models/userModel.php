<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class userModel extends CI_Model{
    
     function login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('hr_login');

        if($query->num_rows() == 1) {
            return true;
        }

        return false;
                
    }
}
?>