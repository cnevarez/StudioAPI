
<?php
function callURL($url) 
{
  $getURL = curl_init();
	$timeout = 5;
	curl_setopt($getURL, CURLOPT_URL, $url);
	curl_setopt($getURL, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($getURL, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($getURL, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt ($getURL, CURLOPT_COOKIEJAR, "cookie.txt"); 
	curl_setopt ($getURL, CURLOPT_COOKIEFILE, "cookie.txt");
	
	$page = curl_exec($getURL);
	$info = curl_getinfo($getURL);
	$URLresponse=array();
    $URLresponse['html'] = $page;
    $URLresponse['curl_info'] = $info;
	curl_close($getURL);
    return($URLresponse);
	
	
	
}

$micrositeURLs=array(
    array('URL' => 'http://www.mindfirewebinars.com/demo','String'=>'The Ultimate Multi-channel Marketing Automation Campaign', 'Description' =>'GURL, need to find the type of page'),
	array('URL' => 'http://qa.m.mdl.io/smoke','String'=>'form method', 'Description' => 'GURL, add contact page'),
	array('URL' => 'http://troyglaus.qa.m.mdl.io/smoke','String'=>'mfismoketest@gmail.com', 'Description' => 'PURL, login page'),
    array('URL' => 'http://onboarding.m.mdl.io/','String'=>'Welcome to Onboarding', 'Description' => 'GURL, login page'),
    array('URL' => 'http://chrisistesting.m.mdl.io/wizard','String'=>'All rights reserved', 'Description' => 'NEED TO FIND'),
	array('URL' => 'http://amir111.jv.m.s.mdl.io/daverosendahl','String'=>'Dave', 'Description' => 'This is a microsite on Staging; PURL, blank page'),
	array('URL' => 'http://onboarding.m.mdl.io/','String'=>'Welcome to Onboarding', 'Description' => 'GURL, login page'),
	array('URL' => 'http://janejones.edu.m.mdl.io/','String'=>'Event', 'Description' => 'Kushal example, need details'),
);

$errorMessage=array(
  array('message' => 'Your session has expired', 'value' => '1'),
	array('message' => 'Could not obtain the security token', 'value' => '0'),
	array('message' => 'Oops! Something unexpected happened', 'value' => '-1'),
);
$resultCount = 0;
echo "<table border='1' style='float:left;'>";
foreach ($micrositeURLs as $microsite) {
  $value="";
	echo "<tr><td>\nTested \"".$microsite['URL']. "</br>";
	$urlResponse = callURL($microsite['URL']);
	echo 'Microsite loaded in '.$urlResponse['curl_info']['total_time']*1000 .' milliseconds with HTTP response code '.$urlResponse['curl_info']['http_code'].'</br><br/>'; 
  // Verify the right content appears
  if (strpos($urlResponse['html'], $microsite['String']) !== false) {
		$value="2"; 
		
		echo "<strong>\n$value: OK, expected content returned. <img src='https://s3-us-west-1.amazonaws.com/mfisupport/onboarding/images/Check_mark.png' width='25px;'/>\n</strong></td></tr>";
		} 
    
	if (strpos($urlResponse['html'], $microsite['String']) == false && $value=="") {
  	foreach ($errorMessage as $error) {
			echo "\nChecking for: \"".$error['message']."\"";
			if (strpos($urlResponse['html'], $error['message']) !== false ) {
				$value=$error['value'];
				echo "\n$value: We are getting error message \"".$error['message'] ." <img src='https://s3-us-west-1.amazonaws.com/mfisupport/onboarding/images/red-x.png' width='25px;'/>";
				$resultCount ++;
}}}}
echo "</table>";
  echo "<p style='text-align:center;'>Over all result: </p>";
	if($resultCount < 2){
		echo "<img src='http://myreactiongifs.com/gifs/thumbsupcomputerkid.gif' style='float:right;' />";
		}
		else{
			echo "<img src='http://soundmigration.files.wordpress.com/2014/02/nothing_to_see_here-60260.gif' style='float:right;'/>";
		};
		

?>
