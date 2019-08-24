<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RoomModel extends CI_Model{
    
     function AddRoom($roomdata)
        {
            $data = array(
                'room_name' => $roomdata['roomname'],
                'room_number' => $roomdata["roomnumber"],
                'room_bed_count' => $roomdata['noofbeds'],
                'room_image' => $roomdata["roomimage"]
            );
            $query = $this->db->insert('hr_rooms', $data);
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

        function DeleteRoom($id) 
        {
            $this->db->where('room_id', $id);
            $query = $this->db->delete('hr_rooms'); 
            if($query) {
                return true;
            } else {
                return false; 
            }   
        }
}
?>