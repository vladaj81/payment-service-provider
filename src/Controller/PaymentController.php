<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\InvoiceRequestValidator;
use App\Service\MockResponseService;
use App\Service\CurlSender;

class PaymentController extends AbstractController
{
    /**
     * METHOD FOR SIMULATING INVOICE CREATION
     */
    #[Route('/invoice-create', name: 'invoice_create')]
    public function index(Request $request)
    {
        $signature = $request->headers->get('X-signature');
        $requestData = json_decode($request->getContent());

        $requestValidator = new InvoiceRequestValidator();
        $validationResult = $requestValidator->validateRequestData($requestData, $signature);

        $mockResponse = new MockResponseService();
        $response = $mockResponse->createMockResponse($validationResult, $requestData);

        return new Response($response, $validationResult['status']);
    }

    /**
     * METHOD FOR SIMULATING PAYMENT CONFIRMATION
     */
    #[Route('/payment-confirm', name: 'payment_confirm')]
    public function confirmPayment(Request $request)
    {  
        //HARDCODED JUST FOR TESTING PURPOSES(IT CAN BE ASSOCIATED WITH EVERY INVOICE AND SENT ON PAYMENT CONFIRMATION)
        $signature = 'NzUzOTRhYWJkZDk1YmZkOGMwN2RjNzViZTExNzY5MTA5M2IyZTBhMGYzYTRhODRjYTE0N2RkN2Y5NTBhYjA1Mw==';

        $merchantOrderId = $request->request->get('merchant_order_id');
        $amount = $request->request->get('amount');
        $currency = $request->request->get('currency');
        $currentTimestamp = time();

        $data = [
            "merchant_order_id" => $merchantOrderId,
            "amount" => $amount,
            "currency" => $currency,
            "status" => "SUCCESSFUL",
            "timestamp" => $currentTimestamp, 
            "notification_url" => "https://www.your_domain.com/your/notification/url"
        ];

        $curlSender = new CurlSender();
        $callbackResponse = $curlSender->sendCallbackRequest($data, $signature);   
        
        return new JsonResponse($callbackResponse);
    }
}
