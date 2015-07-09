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
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div>
        <h1 style="text-align: center;">Domain Add</h1>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <form method="post"  action="../../../scripts/addDomain.php?guid=<?php echo $guid?>&pass=<?php echo $pass?>&email=<?php echo $email?>&mfpass=<?php echo $mfpass?>&accid=<?php echo $accid?>">
        <div class="form-group">
          <label>Domain</label>
          <span style="color:red;"> &#42</span>
          <input class="form-control " type="text" name="domain" placeholder="example.m.mdl.io" required>
          <span class="help-block">The domain you would like to add to Studio</span></div>
        <div class="form-group">
          <label>Description</label>
          <span style="color:red;"> &#42</span>
          <input class="form-control " type="text" name="desc" placeholder="A description for your domain" required>
          <span class="help-block">A description for your domain</span></div>
      <button class="btn btn-primary  " type="submit">Submit</button>
      </form>
    </div>
    <div class="col-md-4"></div>
  </div>
</div>
</body>
</html>