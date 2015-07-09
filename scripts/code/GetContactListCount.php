<?php
//Load the function to call the API
require('callAPI.php');

//Setting up our base URL	
$environment = "https://studio.mdl.io/"; 

//Creating the JSON to pass to our endpoint. 
$authRequest = array
(
    "SelectedAccountID" =>$accid,
	"Email" => "$email",
	"Password" => "$mfpass",
	"PartnerGuid" => "$guid",
	"PartnerPassword" => "$pass"
);

//Call the API using our base URL, Endpoint and JSON array
$authResponse = callService($environment, "REST/userservice/Authenticate", $authRequest);


//adding the ticket into a variable for later use
$ticket =  $authResponse['response_string']->{'Credentials'}->{'Ticket'};

//creating the JSON array
$contactCountRequest = array
("Credentials" => array
				(
					"Ticket" => $ticket,
				),
		"Filter"=>"<Filter/>"
);

//Callin the API
$contactCountResponse = callService($environment, "REST/contactservice/GetContactListCount", $contactCountRequest);

//Printing the response
echo "<h2>Found ". $contactCountResponse['response_string']->{'Count'} . " Contacts</h2>";


?>