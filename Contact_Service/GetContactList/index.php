<?php

 $guid = $_GET['guid'];
$pass = $_GET['pass'];
$email= $_GET['email'];
$mfpass = $_GET['mfpass'];
$accid = $_GET['accid'];

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

<title>GEtting Contacts</title>
</head>

<body>
  

<div id="content" style="width:800px;margin:auto;">
Content to load here! 
</div>
  <script>
	$(document).ready(function(){
      // Put an animated GIF image insight of content
      $("#content").empty().html('<center>Getting Contacts...<img src="https://s3-us-west-1.amazonaws.com/mfisupport/onboarding/images/loadingGif.gif" width="50px;" height="auto;" /></center>');

      // Make AJAX call
      $("#content").load("../../../scripts/GetContactList.php?guid=<?php echo $guid?>&pass=<?php echo $pass?>&email=<?php echo $email?>&mfpass=<?php echo $mfpass?>&accid=<?php echo $accid?>")
	  });
      </script>
</body>
</html>
