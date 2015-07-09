<?php
 $guid = $_GET['guid'];
$pass = $_GET['pass'];
$email= $_GET['email'];
$mfpass = $_GET['mfpass'];
$accid = $_GET['accid'];
//Load the function to call the API
require('callAPI.php');
	
$environment = "https://studio.mdl.io/"; 

//Authenticating
$authRequest = array
(
    "SelectedAccountID" =>$accid,"Email" => "$email","Password" => "$mfpass","PartnerGuid" => "$guid","PartnerPassword" => "$pass"
);

$authResponse = callService($environment, "REST/userservice/Authenticate", $authRequest);

//Placing my ticket into a variable
$ticket =  $authResponse['response_string']->{'Credentials'}->{'Ticket'};

//Creating variables from what user submitted
$dom = $_POST['domain'];
$desc = $_POST['desc'];

//Creating the add domain API call
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
echo "<center>";
	if( $addResponse['response_string']->{'Result'}->{'ErrorCode'} ==""){
		echo "<h2>".$dom. " added to AccountID " .$authResponse['response_string']->{'AccountID'}."</h2>";
	}
	else{
		echo "<h2>".$dom ." was not added due to the following error <strong>'" . $addResponse['response_string']->{'Result'}->{'ErrorMessage'} ."'</strong></h2>";
	};
echo "</center>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>add Domain</title>
<style>
#code{
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
<center>
  <strong>PHP Code</strong>
</center>
<br/>
<div id="code"> 
	<?php highlight_file('code/addDomain.php');?>
</div>
</body>
</html>
