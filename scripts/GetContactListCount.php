<?php
$guid = $_GET['guid'];
$pass = $_GET['pass'];
$email= $_GET['email'];
$mfpass = $_GET['mfpass'];
$accid = $_GET['accid'];
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contact Count</title>
<style>
#code, #array{
	width:1000px;
	border:medium;
	 background-color:#E1E1E1;
	 margin:auto;
	 padding-top: 10px;
	 padding-left: 15px;
	 padding-bottom: 10px;
}
</style>
</head>

<body>

<center><strong>PHP</strong></center>
<div id="code">
	<?php highlight_file('code/GetContactListCount.php');?>
</div>
<center><strong> Returned array </strong></center><br  />
<div id="array">
<?php
print_r($contactCountResponse);
?>
</div>
</p>
</body>

</html>