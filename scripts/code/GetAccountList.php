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

//setting up the JSON for the API
$getAccountRequest  = array 
	 		("Credentials" => array
				(
					"Ticket" => $ticket,
				),
			  "SearchString"=>"",
			  "Status" => 255,
			  "MaxRows" => 1000,
			  "SortExpression" => "",
			  "StartRowIndex" => 0
			);		
	
//Call the API using our base URL, Endpoint and JSON array
$getaccountResponse = callService($environment, "REST/accountservice/GetAccountList", $getAccountRequest);

//creating a variable for the account array
$accountList =$getaccountResponse['response_string']->{'AccountList'};

//Printing the reponse
	if( $getaccountResponse['response_string']->{'Result'}->{'ErrorCode'} =="" && $accountList ){//If the array has not error and has sub-accounts
		echo "<table border='1'><th>ID</th><th>Name</th>";//Build a table and list the ids and names
		foreach($accountList as $accounts){
			echo "<tr><td>" . $accounts->{'AccountID'}."</td><td>".$accounts->{'Name'}."</td></tr>";
		}
		echo "</table>";
	}
			elseif(!$accountList){//If the account array is empty, make sure it is the parent account
				echo "<h2>This account has no sub-accounts. Are you sure this is the parent account?</h2>";
			}
	
	else{//if any errors return
		echo "<h2>Could not find account due to the error <strong>'" . $addResponse['response_string']->{'Result'}->{'ErrorMessage'} ."'</strong></h2>";
	};	
?>