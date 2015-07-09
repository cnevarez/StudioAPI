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

//Check out JSON array
$checkOutRequest  = array 
	 		("Credentials" => array
				(
					"Ticket" => $ticket,
				),
			"MamlFormat" => null, 
			"ProgramID" => 1
			);		
//If checked out already, lets check it back in so we can edit	
$undoProgramChanges = callService($environment,"REST/programservice/UndoProgramChanges", $checkOutRequest);	

//Enable edits	
$checkOutResponse = callService($environment, "REST/programservice/CheckoutProgram", $checkOutRequest);

//Print the resoponse	 
	if ($checkOutResponse['response_string']->{'Maml'} == "") {
		$response="0"; 
		echo "<strong>FAIL</strong>: We were not able enable editing because of the error: <br/> 
			  <strong> \"".$checkOutResponse['response_string']->{'Result'}->{'ErrorMessage'}."\".</strong> <br/><br/>";
		} 
	else {
		$response="1"; 
		echo "<strong>SUCCESS</strong>: We were able enable editing!.<br/><br/>";
		echo 'Enable Editing took '.$checkOutResponse['curl_info']['total_time']*1000 .' milliseconds.';
		}
?>