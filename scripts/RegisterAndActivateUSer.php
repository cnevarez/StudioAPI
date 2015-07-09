<?php
$guid = $_GET['guid'];
$pass = $_GET['pass'];
$email= $_GET['email'];
$mfpass = $_GET['mfpass'];
$accid = $_GET['accid'];


//Load the function to call the API
require('callAPI.php');


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
$authResponse = callService("userservice/Authenticate", $authRequest);

//adding the ticket into a variable for later use
$ticket =  $authResponse->{'Credentials'}->{'Ticket'};


$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone = $_POST['phone'];
$state = $_POST['state'];
$title = $_POST['title'];
$zip = $_POST['zip'];
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
$registerResponse = callService("userservice/RegisterAndActivateUser", $registerRequest);

//Printing the reponse
echo "<center>";
	if( $registerResponse->{'Result'}->{'ErrorCode'} ==""){//If there are no errors
		echo "<h2>".$firstname. " " . $lastname. " added to AccountID " .$accid."</h2>";
	}
	else{
		echo "<h2>".$firstname. " " . $lastname." was not added to account " .$accid . " due to the following error <strong>'" . $registerResponse->{'Result'}->{'ErrorMessage'} ."'</strong></h2>";
	};
echo "</center>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
<center><strong>PHP</strong></center>
<div id="code">
	<?php highlight_file('code/RegisterAndActivateUser.php');?>
</div>
<center><p><strong> Returned array </strong></center><br  />
<div id="array">
<?php
print_r($registerResponse);
?>
</div>
</p>
</body>

</html>
