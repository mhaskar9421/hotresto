<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/encodeDecodeToken.php';

class RoomController extends CI_Controller{

    public function __construct($config = 'rest')
    {  
	if (isset($_SERVER['HTTP_ORIGIN'])){
		header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 0');    // cache for 1 day
		}
		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') 
		{
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST,OPTIONS");         
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
			exit(0);
		}
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		parent::__construct();
        $this->load->helper('form');
        $this->load->model('RoomModel');
        $this->load->helper('url');
	}
	
	public function addRoom() {
		$roomdata = json_decode(file_get_contents('php://input'), TRUE);
		$data = array(
			'roomname' => $roomdata['roomname'],
			'roomnumber' => $roomdata['roomnumber'],
			'noofbeds' => $roomdata['noofbeds'],
			'roomimage' => 'image'
		);
		$response = $this->RoomModel->AddRoom($data);
		if($response){
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}

	public function viewRoom() {
		$response = $this->RoomModel->ViewRoom();
		if($response){
			echo json_encode($response);
		} else {
			echo json_encode(false);
		}
	}

	public function deleteRoom($id) {
		$result = $this->RoomModel->DeleteRoom($id);
		if($result){
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}

	public function updateBookingInfo() {
		$updatedInfo = json_decode(file_get_contents('php://input'), TRUE);
		$response = $this->RoomModel->updateBookingInfo($updatedInfo);
		if($response){
			echo json_encode($response);
		} else {
			echo json_encode(false);
		}
	}

	public function getAvaliableRooms() {
		$roomdata = json_decode(file_get_contents('php://input'), TRUE);
		$getCheckinDate = $roomdata['checkinDate'];
		$getCheckoutDate = $roomdata['checkoutDate'];
		date_default_timezone_set('Asia/Kolkata');
		$formattedCheckinDate = date("Y-m-d", strtotime($getCheckinDate));
		$formattedCheckoutDate = date("Y-m-d", strtotime($getCheckoutDate));
		$day = 86400; // Day in seconds  
		$format = 'Y-m-d'; // Output format (see PHP date funciton)  
		$sTime = strtotime($formattedCheckinDate); // Start as time  
		$eTime = strtotime($formattedCheckoutDate); // End as time  
		$numDays = round(($eTime - $sTime) / $day) + 1;  
		$searchAvaliableDays = array();  
		for ($d = 0; $d < $numDays; $d++) {  
			$searchAvaliableDays[] = date($format, ($sTime + ($d * $day)));  
		}
		$response = $this->RoomModel->getAvaliableRoomsList($searchAvaliableDays);
		if($response){
			echo json_encode($response);
		} else {
			echo json_encode(false);
		}
	}

	public function BookRoom() {
		$bookingdata = json_decode(file_get_contents('php://input'), TRUE);
		$BookingObj = $bookingdata['bookroomform'];
		$paymentObj = $bookingdata['bookroomform'];
		$bookingInfo = $BookingObj['bookingInfo'];
		$paymentInfo = $paymentObj['paymentInfo'];
		$customerdata = [];
		date_default_timezone_set('Asia/Kolkata');
		$CheckinDate = date("Y-m-d", strtotime($bookingInfo['checkin_date']));
		$CheckoutDate = date("Y-m-d", strtotime($bookingInfo['checkout_date']));
		if(!isset($bookingInfo['customerId'])) { 
			$bookingInfo['customerId'] = 0;
			$customerdata = array(
				'customer_name' => $bookingInfo['name'],
				'customer_mobile' => $bookingInfo['phonenumber'],
				'customer_idtype' => $bookingInfo['idtype'],
				'customer_idnumber' => $bookingInfo['idnumber'],			
				'customer_address' => $bookingInfo['address']
			); 
		} 
		    date_default_timezone_set('Asia/Kolkata');
            $start_date = date('Y-m-d', strtotime($CheckinDate));
            $end_date =  date('Y-m-d', strtotime($CheckoutDate));
            $day = 86400; // Day in seconds  
            $format = 'Y-m-d'; // Output format (see PHP date funciton)  
            $sTime = strtotime($start_date); // Start as time  
            $eTime = strtotime($end_date); // End as time  
            $numDays = round(($eTime - $sTime) / $day) + 1;  
            $days = array();  
            for ($d = 0; $d < $numDays; $d++) {  
                $days[] = date($format, ($sTime + ($d * $day)));  
            }
            $allDays = implode(",",$days);
			$bookingformdata = array(
				'customer_id' => $bookingInfo['customerId'],
				'room_id' => $bookingInfo['room_id'],
				'checkin_date' => $CheckinDate,
				'checkout_date' => $CheckoutDate,
				'booked_dates' => $allDays,
				'room_charges' => $bookingInfo['roomamount'],
				'extra_occupancy' => $bookingInfo['extraoccupancy'],			
				'food_bill_amount' => $bookingInfo['foodbillamount'],
				'food_bill_number' => $bookingInfo['foodbillnumber'],
				'paid_amount' => $paymentInfo['paidamount'],
				'payment_status' => $paymentInfo['paymentstatus'],
				'payment_mode' => $paymentInfo['paymenttype'],
				'total_amount' => $paymentInfo['totalamount'],
				'booking_date' => date('Y-m-d')
			); 
		
			$response = $this->RoomModel->BookRoom($bookingformdata, $customerdata);
			if($response){
				echo json_encode($response);
			} else {
				echo json_encode(false);
			}
	}

}
?>