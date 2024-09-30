<?php

namespace App\Service;

class CurlSender
{
    /**
     * METHOD FOR SENDING CALLBACK REQUEST
     */
    public function sendCallbackRequest($data, $signature)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://payment-app.localhost/callback-handle");

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-signature: ' .$signature));

        $response = curl_exec($ch);
    
        curl_close($ch);    
        
        return $response;
    }
}