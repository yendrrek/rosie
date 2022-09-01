<?php

namespace Rosie\PayPal\PayPalSDK;

use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpResponse;
use Rosie\Utils\Logging;
use Sample\PayPalClient;

class OrderCreation
{
    public function __construct(
        private OrdersCreateRequest $ordersCreateRequest,
        private Logging $logging
    ) {
    }

    public function getOrder(): void
    {
        $payPalClient = PayPalClient::client();

        echo json_encode($this->getHttpResponse($payPalClient)->result);
    }

    private function getHttpResponse($payPalClient): HttpResponse
    {
        return $payPalClient->execute($this->setHttpRequest());
    }

    private function setHttpRequest(): OrdersCreateRequest
    {
        $this->ordersCreateRequest->prefer('return=representation');
        $this->ordersCreateRequest->body = $this->buildRequestBody();
        return $this->ordersCreateRequest;
    }

    private function buildRequestBody(): array
    {
        $currency_code = 'GBP';
        $request_body['purchase_units'][] = $this->getPurchaseUnits($currency_code);
        $request_body['intent'] = 'CAPTURE';

        return $request_body;
    }

    private function getPurchaseUnits($currency_code): array
    {
        $purchase_units['amount'] = $this->getPurchaseUnitsAmount($currency_code);
        $purchase_units['items'] = $this->getPurchaseUnitsItems($currency_code);

        $this->makeProductsDetailsAvailableForCaptureTransactionFile($purchase_units['items']);

        return $purchase_units;
    }

    private function getPurchaseUnitsAmount($currency_code): array
    {
        if (!isset($_SESSION['orderTotal'])) {
            $this->logging->logMessage('alert', 'No order total price. Cannot create PayPal order');
            return [];
        }

        $total_price = number_format($_SESSION['orderTotal'], 2);

        $purchaseUnitsAmount['currency_code'] = $currency_code;
        $purchaseUnitsAmount['value'] = $total_price;
        $purchaseUnitsAmount['breakdown']['item_total']['currency_code'] = $currency_code;
        $purchaseUnitsAmount['breakdown']['item_total']['value'] = $total_price;
        $this->logging->logMessage('info', "Prepared purchase units amount of PayPal order.");

        return $purchaseUnitsAmount;
    }

    private function getPurchaseUnitsItems($currency_code): array
    {
        $purchaseUnitsItems = [];

        if (empty($_SESSION['basket'])) {
            $this->logging->logMessage('alert', 'No products in the basket. Cannot create PayPal order.');
            return [];
        }

        foreach ($_SESSION['basket'] as $index => $product) {
            $productDetail['id'] = $product['productId'];
            $productDetail['name'] = $product['productName'] . ' Card';
            $productDetail['quantity'] = $product['productQuantity'];
            $productDetail['unit_amount']['currency_code'] = $currency_code;
            $productDetail['unit_amount']['value'] = $product['productsRetailPrices'][$index];
            $purchaseUnitsItems[] = $productDetail;
        }
        $this->logging->logMessage('info', "Prepared purchase units items of PayPal order");

        return $purchaseUnitsItems;
    }

    private function makeProductsDetailsAvailableForCaptureTransactionFile($purchaseUnitsItems): void
    {
        $_SESSION['itemsDetails'] = $purchaseUnitsItems;
    }
}

/* PayPal order schema
  array(
      "intent" =>
      "purchase_units" =>
          array(
              0 =>
                  array(
                      "amount" =>
                          array(
                              "currency_code" =>
                              "value" =>
                              "breakdown" =>
                                  array(
                                      "item_total" =>
                                          array(
                                              "currency_code" =>
                                              "value" =>
                                          )
                                  )
                          )
                      "items" =>
                          array(
                              0 =>
                                  array(
                                      "id" =>
                                      "name" =>
                                      "quantity" =>
                                      "unit_amount" =>
                                          array(
                                              "currency_code" =>
                                              "value" =>
                                          )
                                  )
                          )
                  )
          )
  )

  https://developer.paypal.com/docs/checkout/reference/server-integration/set-up-transaction/#full-parameters
*/
