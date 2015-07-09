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

$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$formEmail = $_POST['email'];
//Creating the JSON to add the goal
$addContactRequest = array
(		
  "Credentials"=> array (
		"Ticket"=>$ticket,
   		"SelectedAccountID"=>$accid  
	),
	"KeyValueList"=> array(array("Key"=>"firstname",
								  "Value"=>"$fname"
								  ),
							array("Key"=>"lastname",
								  "Value"=>"$lname"
								  ),     
						 	array("Key"=>"email",                  
								  "Value"=>"$formEmail"
								   )
							)
	);



//Making the call
$addContactResponse = callService($environment, "REST/contactservice/CreateContact", $addContactRequest);

//Printing the reponse
	if( $addContactResponse['response_string']->{'Result'}->{'ErrorCode'} ==""){//If there are no errors
		echo "<h2>".$fname. $lname. " added to AccountID " .$addContactResponse['response_string']->{'AccountID'}. "with the PURL of" .$addContactResponse['response_string']->{'Purl'}."</h2>";
	}
	else{
		echo "<h2>".$fname. $lname." was not added due to the following error <strong>'" . $addContactResponse['response_string']->{'Result'}->{'ExceptionMessage'} ."'</strong></h2>";
	};
?>