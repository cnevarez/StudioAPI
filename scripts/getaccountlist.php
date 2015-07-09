<?php
$guid = $_GET['guid'];
$pass = $_GET['pass'];
$email= $_GET['email'];
$mfpass = $_GET['mfpass'];
$accid = $_GET['accid'];
//Load the function to call the API
require('callAPI.php');
	
$environment = "https://studio.mdl.io/"; 


$authRequest = array
(
    "SelectedAccountID" =>$accid,"Email" => "$email","Password" => "$mfpass","PartnerGuid" => "$guid","PartnerPassword" => "$pass"
);

$authResponse = callService($environment, "REST/userservice/Authenticate", $authRequest);
//print_r($authResponse);

//adding the ticket into a variable
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
	
//Making the API call	
$getaccountResponse = callService($environment, "REST/accountservice/GetAccountList", $getAccountRequest);

$accountList =$getaccountResponse['response_string']->{'AccountList'};
//Printing the reponse
echo "<center>";
	if( $getaccountResponse['response_string']->{'Result'}->{'ErrorCode'} =="" && $accountList ){
		echo "<center><h1>accounts for ID:".$authResponse['response_string']->{'AccountID'}."</h1><br/> <table border='1'><th>ID</th><th>Name</th>";
		foreach($accountList as $accounts){
			echo "<tr><td>" . $accounts->{'AccountID'}."</td><td>".$accounts->{'Name'}."</td></tr>";
		}
		echo "</table></center>";
	}
			elseif(!$accountList){
				echo "<h2>This account has no sub-accounts. Are you sure this is the parent account?</h2>";
			}
	
	else{
		echo "<h2>Could not find account due to the error <strong>'" . $addResponse['response_string']->{'Result'}->{'ErrorMessage'} ."'</strong></h2>";
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
	<?php highlight_file('code/GetAccountList.php');?>
</div>
<center><strong> Returned array </strong></center><br  />
<div id="array">
<?php
print_r($getaccountResponse);
?>
</div>
</p>
</body>

</html>