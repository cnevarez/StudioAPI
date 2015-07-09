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


$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$userEmail = $_POST['userEmail'];
//Setup the Json for the call
$registerRequest = array
(

	"FirstName"=>"$firstname",
	"LastName"=>"$lastname",
    "Account_ID"=>$accid,
	"ContactScope"=>"1",
	"Credentials"=> array(
		"Ticket"=>$ticket
	),
	"Email"=>"$userEmail",
	"RoleIds" => array(1),
	"SharedPrograms"=>array(
		"ProgramID"=>1,
		"PermissionIDs"=>array(1),
	)

);

//make the call
$registerResponse = callService($environment, "REST/userservice/RegisterAndActivateUser", $registerRequest);

//Printing the reponse
	if( $registerResponse['response_string']->{'Result'}->{'ErrorCode'} ==""){//If there are no errors
		echo "<h2>".$firstname. " " . $lastname. " added to AccountID " .$accid."</h2>";
	}
	else{
		echo "<h2>".$firstname. " " . $lastname." was not added due to the following error <strong>'" . $registerResponse['response_string']->{'Result'}->{'ExceptionMessage'} ."'</strong></h2>";
	};


?>