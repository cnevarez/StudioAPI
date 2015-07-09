<?php
//Load the function to call the API
require('callAPI.php');

//Setting up our base URL	
$environment = "https://studio.mdl.io/"; 

//Creating the JSON to pass to our Authenticate endpoint. 
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

//Creating variables from what user submitted
$dom = $_POST['domain'];
$desc = $_POST['desc'];

//Creating the JSON for AddDomain endpoint
$addDomainRequest = array
(
	"Description"=>$desc,
	"IsHidden"=>true,
	"OnlyWithSSL"=>true,
	"Credentials"=>array
	   (
		"Ticket"=>$ticket
	   ),
  "Name"=>$dom
);

//Calling the API to add the domain
$addResponse = callService($environment, "REST/configurationservice/AddDomain", $addDomainRequest);

//Printing the reponse
	if( $addResponse['response_string']->{'Result'}->{'ErrorCode'} =="")//If there are no errors
	{
		echo "<h2>".$dom. " added to AccountID " .$authResponse['response_string']->{'AccountID'}."</h2>";
	}
	else{
		echo "<h2>".$dom ." was not added due to the following error <strong>'" . $addResponse['response_string']->{'Result'}->{'ErrorMessage'} ."'</strong></h2>";
	};
?>