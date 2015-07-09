<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
.code {
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
$ticket =  $authResponse->{"Credentials"}->{"Ticket"};

//setting up the JSON for the API
$getContactListRequest  = array 
	 		("Credentials" => array
				(
					"Ticket" => $ticket,
				),
			  "FieldNames"=>array("FirstName","LastName","Email","Purl"),
    		  "Filter"=>"<Filter/>",
    		  "OutputType"=>1
			);		
	
//Making the API call	
$getContactListResponse = callService("contactservice/GetContactList", $getContactListRequest);

$contactList =$getContactListResponse->{'Contacts'};
//Printing the reponse
echo "<center>";
	if( $getContactListResponse->{'Result'}->{'ErrorCode'} ==""){
		echo "<h2>Success!</h2>";		
	}
	
	else{
		echo "<h2>Could not find account due to the error <strong>'" . $getContactListResponse->{'Result'}->{'ErrorMessage'} ."'</strong></h2>";
	};
echo "</center>";



//showing the bytes in the byte array
echo "<div id='contacts' style='display:none;'>";
$bytes = $getContactListResponse->{'Contacts'};
$string = "";
foreach ($bytes as $chr) {
    $string = chr($chr);
	echo $string;
}
echo "</div>";
echo "<br/><br/>";

?>
<center>
  <strong>PHP</strong>
</center>
<div class="code">
  <?php  highlight_file('code/GetContactList.php');?>
</div>
<center>
  <strong> Returned contact array </strong>
</center>
<br  />
<div class="code">
  <?php
//print_r($getContactLisResponse);
print_r($getContactListResponse->{'Contacts'});

?>
</div>
<center>
  <strong>Parsing the array and showing the bytes as a string</strong>
</center>
<div class="code">
  <?php foreach ($bytes as $chr) {
    $string .= chr($chr);
	echo $chr;
}?>
</div>
<br/>
<center>
  <strong>After decoding the array, You can format and show your contacts.</strong>
</center>
<div class="code" id="contactArray">
  <p> </p>
</div>
</p>
<script>
var ansVal = document.getElementById('contacts').textContent;
ansVal = ansVal.replace(/\n/g, "<br/>");
ansVal = ansVal.replace(/,/g, " | ");

document.getElementById('contactArray').innerHTML = ansVal;

</script>
</body>
</html>