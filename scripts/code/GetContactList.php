<?php 
//Creating the JSON to Authenticate
$authRequest = array
(
    "SelectedAccountID" =>$accid,
	"Email" => "$email",
	"Password" => "$mfpass",
	"PartnerGuid" => "$guid",
	"PartnerPassword" => "$pass"
);

//Call the API using our base URL, Endpoint and JSON array
$authResponse = callService("userservice/Authenticate", $authRequest);


//adding the ticket into a variable for later use
$ticket =  $authResponse->{"Credentials"}->{"Ticket"};

//setting up the JSON for the GetContactList call
$getContactListRequest  = array 
	 		("Credentials" => array
				(
					"Ticket" => $ticket,
				),
			  "FieldNames"=>array("FirstName","LastName","Email","Purl"),
    		  "Filter"=>"<Filter/>",
    		  "OutputType"=>1//Use 1 to return a contact array. Use 0 to return a .zip file array.
			);		
	
//Making the API call	
$getContactListResponse = callService("contactservice/GetContactList", $getContactListRequest);

$contactList =$getContactListResponse->{'Contacts'};
//Printing if successful
	if( $getContactListResponse->{'Result'}->{'ErrorCode'} ==""){
		echo "<h2>Success!</h2>";		
	}
	
	else{
		echo "<h2>Could not find account due to the error <strong>'" . $getContactListResponse->{'Result'}->{'ErrorMessage'} ."'</strong></h2>";
	};


//decoding the bytes into meaningful data
$bytes = $getContactListResponse->{'Contacts'};
$string = "";
foreach ($bytes as $chr) {
    $string = chr($chr);
}


// format the data however you want
?>
