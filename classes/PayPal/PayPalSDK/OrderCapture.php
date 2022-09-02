<?php

namespace Rosie\PayPal\PayPalSDK;

use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Rosie\Utils\Logging;

class OrderCapture
{
    public string $orderId = '';
    public string $totalPrice = '';
    public string $buyerName = '';
    public string $buyerFirstName = '';
    public string $buyerEmail = '';
    public string $buyerFullAddress = '';

    public function __construct(private Logging $logging)
    {
    }

    public function captureOrder($orderId): bool
    {
        $error = 'Error capturing order.';

        if (!isset($orderId)) {
            $this->logging->logMessage('alert', "No order id. $error");
            return  false;
        }

        if (is_null(PayPalClient::getPayPalClient())) {
            $this->logging->logMessage('alert', "PayPal Client is null. $error");
            return false;
        }

        $request = new OrdersCaptureRequest($orderId);
        $payPalClient = PayPalClient::getPayPalClient();
        $response = $payPalClient->execute($request);

        if (!isset($response)) {
            $this->logging->logMessage('alert', "No response from PayPal. $error");
            return false;
        }

        $this->getOrderDetails($response);

        echo json_encode($response->result);
        $this->logging->logMessage('info', "Order $orderId captured successfully.");
        return true;
    }

    private function getOrderDetails($response): void
    {
        $this->logging->logMessage('info', "Getting order details for orderID {$response->result->id}");

        $this->orderId = $response->result->id;
        $this->totalPrice = $response->result->purchase_units[0]->payments->captures[0]->amount->value;
        $this->buyerName = $response->result->purchase_units[0]->shipping->name->full_name;
        $this->buyerFirstName = $response->result->payer->name->given_name;
        $this->buyerEmail = $response->result->payer->email_address;
        $this->buyerFullAddress = join(', ', (array) $response->result->purchase_units[0]->shipping->address);
    }
}
