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
echo "<center>";
	if( $addContactResponse['response_string']->{'Result'}->{'ErrorCode'} ==""){//If there are no errors
		echo "<h2>".$fname. $lname. " added to AccountID " .$addContactResponse['response_string']->{'AccountID'}. "with the PURL of" .$addContactResponse['response_string']->{'Purl'}."</h2>";
	}
	else{
		echo "<h2>".$fname. $lname." was not added due to the following error <strong>'" . $addContactResponse['response_string']->{'Result'}->{'ExceptionMessage'} ."'</strong></h2>";
	};
echo "</center>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>add Contact</title>
<style>
#code, #array{
	width:900px;
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
<center>
  <strong>PHP Code</strong>
</center>
<br/>
<div id="code"> 
	<?php highlight_file('code/CreateContact.php');?>
</div>
<center><strong>Returned Array</strong></center><br/>
<div id="array">
<?php print_r($addContactResponse);?>
</div>
</body>
</html>


