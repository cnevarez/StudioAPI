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

$name = $_POST['goal'];
$desc = $_POST['desc'];
//Creating the JSON to add the goal
$addGoalRequest = array
(
    "Category_ID" =>255,
	"Description" =>$desc,
	"Name" =>$name,
	"Credentials" => array(
		"Ticket" => $ticket
	),
  
);

//Making the call
$addGoalResponse = callService($environment, "REST/configurationservice/AddGoal", $addGoalRequest);

//Printing the reponse
	if( $addGoalResponse['response_string']->{'Result'}->{'ErrorCode'} ==""){//If there are no errors
		echo "<h2>".$name. " added to AccountID " .$addGoalResponse['response_string']->{'AccountID'}."</h2>";
	}
	else{
		echo "<h2>".$name ." was not added due to the following error <strong>'" . $addGoalResponse['response_string']->{'Result'}->{'ErrorMessage'} ."'</strong></h2>";
	};
?>