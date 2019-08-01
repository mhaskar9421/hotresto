<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TaxModel extends CI_Model{
    
     function AddTax($Taxdata)
        {
            $data = array(
                'tax_amount' => $Taxdata['taxAmount'],
                'tax_type' => $Taxdata['taxType']
            );
            $query = $this->db->insert('hr_tax', $data);
            if($query) {
                return true;
            } else {
                return false; 
            }     
        }

        function ViewTax() 
        {
            $query = $this->db->get('hr_tax');
            if($query->result()) {
                return $query->result();
            } else {
                return false; 
            }   
        }

        function DeleteTax($id) 
        {
            $this->db->where('Tax_id', $id);
            $query = $this->db->delete('hr_tax'); 
            if($query) {
                return true;
            } else {
                return false; 
            }   
        }
}
?>