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

        
        function getAvaliableRoomsList($checkindate, $checkoutdate)
        { 
            $sql="SELECT DISTINCT `booked_room_id` FROM `hr_booked_rooms` WHERE ((`room_checkin_date` BETWEEN '".$checkindate."' AND '".$checkoutdate."') OR (`room_checkout_date` BETWEEN '".$checkindate."' AND '".$checkoutdate."'))";
            $result = $this->db->query($sql);
            $query1_result = $result->result();
            $getIds = array();
            foreach ($query1_result as $row) {
                $getIds[] =  $row->booked_room_id;           
            }
            $room_id = implode(",",$getIds);
            if(!empty($room_id)) {
                $avaliable_rooms = "SELECT * FROM `hr_rooms` WHERE `room_id` NOT IN(".$room_id.")";
                $result = $this->db->query($avaliable_rooms);
                $query2_result = $result->result();  
            } else {
                $avaliable_rooms = "SELECT * FROM `hr_rooms` WHERE 1";
                $result = $this->db->query($avaliable_rooms);
                $query2_result = $result->result();  
            }        
            return $query2_result;    
        }

        function BookRoom($bookingformdata, $customerdata)
        {
            if(!empty($customerdata)) { 
                $this->db->insert('hr_customers', $customerdata);
                $customer_id = $this->db->insert_id(); 
            }   
            $this->db->insert('hr_bookings', $bookingformdata);
            $booking_id = $this->db->insert_id(); 
            $data = array('customer_id'=> $booking_id);
            $this->db->set('customer_id','customer_id',false);
            $this->db->where('customer_id',$booking_id);
            $this->db->update('hr_bookings',$data);
        }
}
?>