<?php

namespace Rosie\PayPal\PayPalSDK;

use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Rosie\Utils\Logging;
use Sample\PayPalClient;

class CaptureOrder
{
    public function __construct(private Logging $logging)
    {
    }

    public string $orderId = '';
    public string $totalPrice = '';
    public string $buyerName = '';
    public string $buyerFirstName = '';
    public string $buyerEmail = '';
    public string $buyerFullAddress = '';

    public function captureOrder($orderId): bool
    {
        $request = new OrdersCaptureRequest($orderId);
        $client = PayPalClient::client();
        $response = $client->execute($request);

        if (empty($response)) {
            $this->logging->logMessage('alert', 'Error getting response from PayPal. Order not captured.');
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
