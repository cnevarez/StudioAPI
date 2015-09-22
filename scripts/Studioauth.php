<?php

$guid = $_GET['guid'];
$pass = $_GET['pass'];
$email= $_GET['email'];
$mfpass = $_GET['mfpass'];
$accid = $_GET['accid'];
//Load the function to call the API
function callService($endpoint, $request)
{
    $request_string = json_encode($request); 

    $service = curl_init('http://studio.mdl.io/REST/'.$endpoint);                                                                      
    curl_setopt($service, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($service, CURLOPT_POSTFIELDS, $request_string);                                                                  
    curl_setopt($service, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($service, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($request_string))                                                                       
    );                                                                                                                   
    $response_string = curl_exec($service);

    $response = json_decode($response_string);
    return($response);
}

//creating the request object for "Authenticate" method
$authRequest = array
(
   "SelectedAccountID" => $accid,
	"Email" => "$email",
    "Password" => "$mfpass",
    "PartnerGuid" => "$guid",
    "PartnerPassword" => "$pass"
);

//This should be always the first call to get a ticket and use it in all other methods.
//NOTE: endpoint in CallService() is case-sensitive
$authResponse = callService("userservice/Authenticate", $authRequest);
$authCredentials = $authResponse->{"Credentials"};
//the following statement might be only used for testing perposes to see if a ticket has been returned.
//Or else, you only need authCredentials to call other service methods.
$authToken = $authResponse->{"Credentials"}->{"Ticket"};


echo "<center><strong>Success! </strong>Your ticket is:<strong> ".$authResponse->{'Credentials'}->{'Ticket'}."</strong></center>";


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
	<?php highlight_file('code/authenticate.php');?>
</div>
<center><p><strong> Returned array </strong></center><br  />
<div id="array">
<?php
print_r($authResponse);
?>
</div>
</p>
</body>

</html>
