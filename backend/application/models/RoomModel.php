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

        
        function getAvaliableRoomsList($searchAvaliableDays)
          { 
            $query1 = $this->db->get('hr_booked_rooms');
            if($query1->result()) {
                $data =  $query1->result();
                $getIds = array();
                foreach ($data as $row) {
                    $getDatesBooked =  explode(" ",$row->booked_dates);
                    $modified = str_replace(',','',$getDatesBooked);
                    $array1 = str_split($modified[0], 10);
                    $array2 = $searchAvaliableDays;
                    $result = array_intersect($array1, $array2);                     
                        if($result) {
                        $getIds[] = $row->booked_room_id;
                        }           
                    }
                    if($getIds) {
                        $this->db->select("*");
                        $this->db->from('hr_rooms');
                        $this->db->where_not_in('room_id', $getIds);
                        $query2 = $this->db->get();
                        return $query2->result();
                    } else {
                        $query3 = $this->db->get('hr_rooms');
                        return $query3->result();
                    }            
                    } else {
                        $query4 = $this->db->get('hr_rooms');
                        return $query4->result(); 
                    }                    
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
            return $bookingformdata;
        }

        function updateBookingInfo($data) {
            $this->db->where('booking_id', $data['updatedform']['booking_id']); 
            $dbdata = array(
                 "paid_amount" => $data['updateFormData']['paidamount'],
                 "payment_mode" => $data['updateFormData']['paymenttype'],
                 "payment_status" => $data['updateFormData']['paymentstatus']
            ); 
            return $this->db->update('hr_bookings', $dbdata);
        }
}
?>