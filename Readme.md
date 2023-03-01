# Selcom API Gateway Client - PHP

<p align='center'>

<img src="https://img.shields.io/badge/php-%3D%3E7-blue">

</p >

## Homepage
https://developers.selcommobile.com/

## Description
This is a library containing functions that aid in the accessing of selcom api. IT is made up pf 4 functions.
computeHeader 

## Installation

composer require selcom/selcom-apigw-client
## Usage
```php
require_once __DIR__ .'/vendor/autoload.php';
// use modeule
use Selcom\ApigwClient\Client;
//iniiatialize new Client with values of the base url, api key and api secret
$client = new Client($baseUrl, $apiKey, $apiSecret);
// computeHeader takes an array containing data to bes submitted
// computeHeader returns an array with values for the following header fields: 
//  Authorization, Timestamp, Digest, Signed-Fields
$client->computeHeader( $arrayData):

// postFuct takesa path relative to baseUrl. array containing data of query  
// It performs a POST request of the submitted data to the destniation url generatingg the header internally
// IT returns a json containing the response to the request
$client->postFunc($path, $arrayData)

// getFuct takes a path relative to baseUrl. array containing data of query 
// It performs a GET request adding the query to the  url and generatingg the header internally
// IT returns a json containing the response to the request
$client->getFunc($path, $arrayData)

// deletetFuct takes a path relative to baseUrl. array containing data of query 
// It performs a DELETE request adding the query to the  url and generatingg the header internally
// IT returns a json containing the response to the request
$client->deleteFunc($path, $arrayData)
```

## Example

```php
require_once __DIR__ .'/vendor/autoload.php';

// 
use Selcom\ApigwClient\Client;

# initalize a new apiAccess instace with values of the base url, api key and api secret

$apiKey = '202cb962ac59075b964b07152d234b70';
$apiSecret = '81dc9bdb52d04dc20036dbd8313ed055';
$baseUrl = "http://example.com";


$client = new Client($baseUrl, $apiKey, $apiSecret);


//order data
$orderArray = array(
"vendor"=>"VENDORTILL",
"order_id"=>"1218d5Qb",
"buyer_email"=> "john@example.com",
"buyer_name"=> "John Joh",
"buyer_phone"=> "255682555555",
"amount"=>  8000,
"currency"=>"TZS",
"buyer_remarks"=>"None",
"merchant_remarks"=>"None",
"no_of_items"=>  1

)

// path relatiive to base url
$orderPath = "/v1/checkout/create-order-minimal"
// crate new order

$response = $client->postFunc($orderPath,$orderArray);

echo json_encode($response);

```
