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
                'customer_address' => $customerdata['address'], 
                'customer_uploadImage' => $customerdata['uploadImage']
            );
            $query = $this->db->insert('hr_customers', $data);
            if($query) {
                return true;
            } else {
                return false; 
            }     
        }

        function ViewCustomer() 
        {
            $query = $this->db->get('hr_customers');
            if($query->result()) {
                return $query->result();
            } else {
                return false; 
            }   
        }

        function viewBookedCustomers() 
        {
            $query = $this->db->get('hr_bookings');
            if($query->result()) {
                return $query->result();
            } else {
                return false; 
            }   
        }

        function getGSTValue() {
            $query = $this->db->get('hr_tax');
            if($query->result()) {
                return $query->result();
            } else {
                return false; 
            }  
        }

        function deleteCustomer($id) 
        {
            $this->db->where('customer_id', $id);
            $query = $this->db->delete('hr_customers'); 
            if($query) {
                return true;
            } else {
                return false; 
            }   
        }

        function totalCustomers() 
        {
            $this->db->select('*');
            $this->db->from('hr_customers');
            $query = $this->db->count_all_results(); 
            if($query) {
                return $query;
            } else {
                return false; 
            }   
        }
}
?>