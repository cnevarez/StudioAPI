<?php

 $guid = $_GET['guid'];
$pass = $_GET['pass'];
$email= $_GET['email'];
$mfpass = $_GET['mfpass'];
$accid = $_GET['accid'];

 ?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta name="og:type" content="website">
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
<style>
.rz-video {
	position: relative;
	padding-bottom: 56.25%; /* 16:9 */
	padding-top: 25px;
	height: 0;
}
.rz-video iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}
</style>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div>
        <h1 style="text-align: center;">Contact Add</h1>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <form method="post"  action="../../../scripts/CreateContact.php?guid=<?php echo $guid?>&pass=<?php echo $pass?>&email=<?php echo $email?>&mfpass=<?php echo $mfpass?>&accid=<?php echo $accid?>">
        <div class="form-group">
          <label>First Name</label>
          <span style="color:red;"> &#42</span>
          <input class="form-control " type="text" name="firstname" placeholder="John" required>
          </div>
        <div class="form-group">
          <label>Last Name</label>
          <span style="color:red;"> &#42</span>
          <input class="form-control " type="text" name="lastname" placeholder="Sample" required>
          </div>
          <div class="form-group">
          <label>Email</label>
          <span style="color:red;"> &#42</span>
          <input class="form-control " type="text" name="email" placeholder="john@Sample.com" required>
          </div>
      <button class="btn btn-primary  " id="sub" type="submit">Submit</button>
      </form>
    </div>
    <div class="col-md-4"></div>
  </div>
</div>
<script>
$(document).ready(function() {
	$('#sub').click(function(){		
			$('#sub').html('<img src="https://s3-us-west-1.amazonaws.com/mfisupport/onboarding/images/loadingGif.gif" width="40px" height="40px"/>')
		});	
});

</script>
</body>
</html>