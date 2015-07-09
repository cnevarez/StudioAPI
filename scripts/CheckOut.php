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
		echo "<strong>FAIL</strong>: We were not able enable editing because of the error: <br/> <strong> \"".$checkOutResponse['response_string']->{'Result'}->{'ErrorMessage'}."\".</strong> <br/><br/>";
		} 
	else {
		$response="1"; 
		echo "<strong>SUCCESS</strong>: We were able enable editing!.<br/><br/>";
		echo 'Enable Editing took '.$checkOutResponse['curl_info']['total_time']*1000 .' milliseconds.';
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
#code, #array{
	width:800px;
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
	<?php highlight_file('code/CheckOutProgram.php');?>
</div>
<center><p><strong> Returned array </strong></center><br  />
<div id="array">
<?php
print_r($checkOutResponse['response_string']->{'Maml'});
?>
</div>
</p>
</body>

</html>