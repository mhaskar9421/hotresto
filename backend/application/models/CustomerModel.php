<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerModel extends CI_Model{
    
     function AddCustomer($customerdata)
        {
            $data = array(
                'customer_name' => $customerdata['customername'],
                'customer_idtype' => $customerdata['custid'],
                'customer_idnumber' => $customerdata['idnumber'],
                'customer_mobile' => $customerdata['phonenumber'],
                'customer_address' => $customerdata['address'] 
            );
            $query = $this->db->insert('hr_customers', $data);
            if($query) {
                return true;
            } else {
                return false; 
            }     
        }

        function ViewRoom() 
        {
            $query = $this->db->get('hr_rooms');
            if($query->result()) {
                return $query->result();
            } else {
                return false; 
            }   
        }
}
?>