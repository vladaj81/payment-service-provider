<?php

declare(strict_types=1);

namespace App\Service;

class MockResponseService
{
    /**
     * METHOD FOR GENERATING MOCK RESPONSE
     */
    public function createMockResponse($validationResult, $requestData) 
    {
        if ($validationResult['message'] == 'MISSING SIGNATURE') {

            return '{
                "error":"Invalid signature",
                "message":"Invalid signature",
                "status" : 400
            }';

        }

        if ($validationResult['message'] == 'EMPTY AMOUNT') {

            return '{
                "error":"Amount required",
                "message":"Amount is not set",
                "status" : 400
            }';

        }

        if ($validationResult['message'] == 'SUCCESS') {

            return '{
                "redirect_url": "https://localhost/notification-page",
                "deposit_id": 300642187,
                "user_id": "1",
                "merchant_order_id": "1000001",
                "payment_info": {
                    "merchant_order_id": ' .$requestData->merchant_order_id. ',
                    "payment_method": "CARD",
                    "payment_method_name": "VISA",
                    "amount": ' .$requestData->amount. ',
                    "currency": "EUR",
                    "expiration_date": "2024-05-20 23:48:34",
                    "created_at": "2024-05-20 20:41:33",
                    "metadata": {
                        "description": "test description",
                        "qr_code": "data:image/png;base64,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",
                        "code_to_display_or_copy": "some_code_to_copy_123567"
                    }
                },
                "status" : 201
            }';
        }
    }
}