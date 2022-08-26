<?php

// Variables using snake case belong to PayPal API and must stay this way.

namespace Sample\CaptureIntentExamples;

use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

session_start();

require '../../vendor/autoload.php';
require 'paypal-client.php';

class CreateOrder
{
    public function getOrder(): void
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = $this->buildRequestBody();

        // Call PayPal to set up a transaction.
        $client = PayPalClient::client();
        $response = $client->execute($request);

        echo json_encode($response->result);
    }

    // Pretty print version of the request body settings is at the bottom of the page.
    private function buildRequestBody(): array
    {
        $items = [];
        $currency_code = 'GBP';
        // Without formatting the price, for example 17.90 will be converted to 17.89999999,
        // and PayPal SKD will throw an error.
        $total_price = number_format($_SESSION['orderTotal'], 2);

        $purchaseUnitsAmount['currency_code'] = $currency_code;
        $purchaseUnitsAmount['value'] = $total_price;
        $purchaseUnitsAmount['breakdown']['item_total']['currency_code'] = $currency_code;
        $purchaseUnitsAmount['breakdown']['item_total']['value'] = $total_price;
        $purchase_units['amount'] = $purchaseUnitsAmount;

        if (!empty($_SESSION['basket'])) {
            foreach ($_SESSION['basket'] as $i => $product) {
                $productDetail['id'] = $product['productId'];
                $productDetail['name'] = $product['productName'] . ' Card';
                $productDetail['quantity'] = $product['productQuantity'];
                $productDetail['unit_amount']['currency_code'] = $currency_code;
                $productDetail['unit_amount']['value'] = $product['productsRetailPrices'][$i];
                $items[] = $productDetail;
            }
        }

        $purchase_units['items'] = $items;
        // Make products' details available in $_SESSION for 'capture-transaction.php'.
        $_SESSION['itemsDetails'] = $purchase_units['items'];
        $request_body['purchase_units'][] = $purchase_units;
        $request_body['intent'] = "CAPTURE";

        // Return the request body to the client side.
        return $request_body;
    }
}

if (!count(debug_backtrace())) {
    $createOrder = new CreateOrder();
    $createOrder->getOrder();
}

/*
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
