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
			  "FieldNames"=>array("FirstName","LastName","Email","Password"),
    		  "Filter"=>"<Filter/>",
    		  "OutputType"=>0
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
/*
//Showing the bytes that get returned
$commaData = json_encode($getContactLisResponse['response_string']->{'Contacts'});
echo $commaData;
*/
//showing the bytes for the .zip file
$bytes = $getContactListResponse->{'Contacts'};
$string = "";
foreach ($bytes as $chr) {
    $string .= chr($chr);
}

//placing my contact into a file
date_default_timezone_set('America/Los_Angeles');

$date = date("YmdGis");
$filename = $guid."_".$date.'.zip';

file_put_contents('zips/'.$filename, $string);

//checking if the file was succesfully created
$zip = new ZipArchive;
echo "<center>";
if ($zip->open('zips/'.$filename) === TRUE) {
	echo "<strong> ".$filename." </strong> created successfully! Click <a href='http://studioapi.netau.net/scripts/zips/".$filename."' target='_blank'>here</a> to download<br/><br />";
}
else{ echo "File failed to be created";}
echo "</center>";

//unzipping the file into a folder

$zip = new ZipArchive;
if ($zip->open('zips/'.$filename) === TRUE) {
    $zip->extractTo('zips/unzipped');
    $zip->close();
    echo 'ok<br/>';
} else {
    echo 'failed<br/>';
}
//getting contents of the file

$file = file_get_contents('zips/unzipped/data.txt');
echo "<br />" .$file."<br/>";


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

<body>hello
<center><strong>PHP6579859</strong></center>
<div id="code">
	<?php highlight_file('code/GetContactList.php');?>
</div>
<center><strong> Returned contact array </strong></center><br  />
<div id="array">
<?php
//print_r($getContactLisResponse);
print_r($getContactListResponse->{'Contacts'});
echo $authResponse->{'Credentials'}->{'Ticket'};
?>
</div>
</p>
</body>

</html>