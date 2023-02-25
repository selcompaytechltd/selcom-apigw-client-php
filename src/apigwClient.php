<?php
namespace Selcom\ApigwClient;
class Client{
    protected String $baseUrl;
    protected String $apiKey;
    protected String $apiSecret; 

    public function __construct($baseUrl, $apiKey, $apiSecret){
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }
    public function computeHeader( $arrayData){
        date_default_timezone_set('Africa/Dar_es_Salaam');
        $authToken = "SELCOM" .' '.base64_encode($this->apiKey);

        $signedFields  =implode(',', array_keys($arrayData));
        $fieldOrder = explode(',', $signedFields);
        $timestamp = date('c');
        $data = "timestamp=$timestamp";
        foreach ($fieldOrder as $key) {
        $data .= "&$key=".strval($arrayData[$key]);
        }
        $digest = base64_encode(hash_hmac('sha256', $data, $this->apiSecret, true));
        return [$authToken, $timestamp, $digest, $signedFields ];

    }

    public function postFunc($path, $arrayData){
        [$authToken, $timestamp, $digest, $signedFields ] = $this->computeHeader($arrayData);
        $urls = $this->baseUrl . $path;
        $jsonData = json_encode($arrayData);
        $headers = array(
        "Content-type: application/json", 
        "Authorization: $authToken",
        "Digest-Method: HS256",
        "Digest: $digest",
        "Timestamp: $timestamp",
        "Signed-Fields: $signedFields",
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urls);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch,CURLOPT_TIMEOUT,90);
        curl_setopt($ch,CURLOPT_VERBOSE,true);
        $result = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($result, true);
        return $resp;
        
    }

    public function getFunc($path, $arrayData){
        [$authToken, $timestamp, $digest, $signedFields ] = $this->computeHeader($arrayData);
        $urls = $this->baseUrl . $path . '?' . http_build_query($arrayData);
        $headers = array(
        "Content-type: application/json", 
        "Authorization: $authToken",
        "Digest-Method: HS256",
        "Digest: $digest",
        "Timestamp: $timestamp",
        "Signed-Fields: $signedFields",
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urls);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch,CURLOPT_TIMEOUT,90);
        curl_setopt($ch,CURLOPT_VERBOSE,true);
        $result = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($result, true);
        return $resp;
        
    }

    public function deleteFunc($path, $arrayData){
        [$authToken, $timestamp, $digest, $signedFields ] = $this->computeHeader($arrayData);
        $urls = $this->baseUrl . $path . '?' . http_build_query($arrayData);
        $headers = array(
        "Content-type: application/json", 
        "Authorization: $authToken",
        "Digest-Method: HS256",
        "Digest: $digest",
        "Timestamp: $timestamp",
        "Signed-Fields: $signedFields",
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urls);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch,CURLOPT_TIMEOUT,90);
        curl_setopt($ch,CURLOPT_VERBOSE,true);
        $result = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($result, true);
        return $resp;
        
    }


}
 ?>