<?php
//Load the function to call the API
require('callAPI.php');

//Setting up our base URL	
$environment = "https://studio.mdl.io/REST"; 

//Creating the JSON to pass to our endpoint
$authRequest = array
(
    "SelectedAccountID" =>$accid,
	"Email" => "$email",
	"Password" => "$mfpass",
	"PartnerGuid" => "$guid",
	"PartnerPassword" => "$pass"
);


//This should be always the first call to get a ticket and use it in all other methods.
//NOTE: endpoint in CallService() is case-sensitive
$authResponse = callService("userservice/Authenticate", $authRequest);
$authCredentials = $authResponse->{"Credentials"};

//the following statement might be only used for testing perposes to see if a ticket has been returned.
//Or else, you only need authCredentials to call other service methods.
$authToken = $authResponse->{"Credentials"}->{"Ticket"};

//Printing out what we found.
echo "<center><strong>Success! </strong>Your ticket is:<strong> ".$authToken."</strong></center>";




?>