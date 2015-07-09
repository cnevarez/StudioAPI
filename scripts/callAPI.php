<?php

/*
This sample shows you how to call a MindFire Studio REST service from within your PHP code using POST method.

For each call, you need to:
1- Find out the service name and its required parameters
2- create the service request object
3- Pass the service name and request object to callService() to receive the response object
4- Parse Result object in the response to see if any error has occurred. You can do so by evaluating ErrorCode value to be non-empty
5- Take appropriate action if there is an error or process the respond opject if it is supposed to return any data.

The first service to be call is "userservice/Authenticate" to get the authentication ticket. This ticket must be used in all request objects.
*/

//this function is used to call any API method by passing the method name (endpoint) and its request opbject.
function callService($endpoint, $request)
{
    $request_string = json_encode($request); 

    $service = curl_init('http://studio.mdl.io/REST/'.$endpoint);                                                                      
    curl_setopt($service, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($service, CURLOPT_POSTFIELDS, $request_string);                                                                  
    curl_setopt($service, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($service, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($request_string))                                                                       
    );                                                                                                                   
    $response_string = curl_exec($service);

    $response = json_decode($response_string);
    return($response);
}

?>