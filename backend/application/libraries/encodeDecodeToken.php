<?php
require APPPATH . '/libraries/JWT.php';

class encodeDecodeToken
{
       
    // ******* The function generate token *********//

    PRIVATE $key = "Ge9UKHRNjs7cYckS2yul"; 
    public function GenerateToken($data)
    {          
        $jwt = JWT::encode($data, $this->key);
        return $jwt;
    }
    
   // ********* This function decode the token ******//

    public function DecodeToken($token)
    {          
        $decoded = JWT::decode($token, $this->key, array('HS256'));
        $decodedData = (array) $decoded;
        return $decodedData;
    }
}
?> 