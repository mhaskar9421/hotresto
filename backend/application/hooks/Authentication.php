<?php

class Authentication extends CI_Controller
{
       
    public function __construct($config = 'rest')
    {
        parent::__construct();
        $this->objOfJwt = new encodeDecodeToken();
        header('Content-Type: application/json');
    }

    // ******* The function validate the access *********//

    public function checkValidAccess()
    {          
        $received_Token = $this->input->request_headers('Authorization');
        try
            {
            $jwtData = $this->objOfJwt->DecodeToken(@$received_Token['Token']);
            }
            catch (Exception $e)
            {
            http_response_code('401');
            echo json_encode(array( "status" => false, "message" => $e->getMessage()));exit;
            }
    }
}
?> 