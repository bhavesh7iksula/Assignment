<?php
require_once 'api.php';

// The URL to your Magento 2 instance (ending with /index.php/rest/V1)
$api_url = 'http://127.0.0.1/magentoroot/index.php/rest/V1';
// Set the integrations access token.
$token = 'kgr4xeqmfofpspli5ayxput4m98vf8aj';
// Fill in the SKU of the product which should be ordered.
$sku = '24-MB02';

$magento = new MagentoClient($token, $api_url);

$product = $magento->getProduct($sku);
$cart = $magento->createCart();
$cart = str_replace('"', '', $cart);

$order_filled = $magento->addToCart($cart, $sku, 1);

$order_filled = json_decode($order_filled);
$order_filled->price = 90;
$order_filled = json_encode($order_filled);
//var_dump($order_filled);

$ship_to = array (
  'addressInformation' =>
    array (
      'shippingAddress' =>
        array (
          //'address_type' => 'shipping',
          'city' => 'Mumbai',
          'country_id' => 'IN',
          'email' => 'bhavesh7.iksula@gmail.com',
          'region' => 'Maharashtra',
          'region_id' => 553,
          'street' =>
            array (
              0 => 'Fillgradergasse 12-14/1a',
            ),
          'company' => 'acolono GmbH',
          'telephone' => '1111111',
          'postcode' => '400071',
          'firstname' => 'Martin',
          'lastname' => 'Testman',
          //'region_code' => 'MH',
          'same_as_billing' => 1,
        ),
        'billingAddress' =>
          array (
          'city' => 'Mumbai',
          'country_id' => 'IN',
          'email' => 'bhavesh7.iksula@gmail.com',
          'region' => 'Maharashtra',
          'region_id' => 553,
          'street' =>
            array (
              0 => 'Fillgradergasse 12-14/1a',
            ),
          'company' => 'acolono GmbH',
          'telephone' => '1111111',
          'postcode' => '400071',
          'firstname' => 'Martin',
          'lastname' => 'Testman',
          ),
      'shippingMethodCode' => 'freeshipping',
      'shippingCarrierCode' => 'freeshipping',
    )
);

$order_shipment = $magento->setShipping($cart, $ship_to);
//var_dump($order_shipment);exit;

$payment = $magento->getPaymentMethods($cart);
//var_dump($payment);

$ordered = $magento->placeOrder($cart, 'cashondelivery');
echo "\nordered:\n";
var_dump($ordered);