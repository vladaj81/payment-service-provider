<?php

declare(strict_types=1);

namespace App\Service;

class InvoiceRequestValidator
{
    /**
     * METHOD FOR VALIDATING REQUEST DATA
     */
    public function validateRequestData($requestData, $signature) 
    {
        $response = [
            'status' => 201,
            'message' => 'SUCCESS',
        ];

        if ($this->isMissingSignature($signature)) {

            $response['status'] = 400;
            $response['message'] = 'MISSING SIGNATURE';
        }

        if ($this->isEmptyAmmount($requestData->amount)) {
            
            $response['status'] = 400;
            $response['message'] = 'EMPTY AMOUNT';
        }

        return $response;
    }

    public function isMissingSignature($signature)
    {
        return empty($signature);
    }

    public function isEmptyAmmount($ammount)
    {
        return empty($ammount);
    }
}