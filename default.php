<?

$host=$_SERVER['HTTP_HOST'];

/*

Directory Listing Script - Version 2

====================================

Script Author: Ash Young <ash@evoluted.net>. www.evoluted.net

Layout: Manny <manny@tenka.co.uk>. www.tenka.co.uk

*/

$startdir = '.';

$showthumbnails = false; 

$showdirs = true;

$forcedownloads = false;

$hide = array(

				'dlf',

				'public_html',				

				'index.php',

				'Thumbs',

				'.htaccess',

				'.htpasswd',
				
				'scripts',
				
				'css',
				
				'default.php'
				

			);

$displayindex = false;

$allowuploads = false;

$overwrite = false;



$indexfiles = array (

				'index.html',

				'index.htm',

				'default.htm',

				'default.html'

			);

			

$filetypes = array (

				'png' => 'jpg.gif',

				'jpeg' => 'jpg.gif',

				'bmp' => 'jpg.gif',

				'jpg' => 'jpg.gif', 

				'gif' => 'gif.gif',

				'zip' => 'archive.png',

				'rar' => 'archive.png',

				'exe' => 'exe.gif',

				'setup' => 'setup.gif',

				'txt' => 'text.png',

				'htm' => 'html.gif',

				'html' => 'html.gif',

				'php' => 'php.gif',				

				'fla' => 'fla.gif',

				'swf' => 'swf.gif',

				'xls' => 'xls.gif',

				'doc' => 'doc.gif',

				'sig' => 'sig.gif',

				'fh10' => 'fh10.gif',

				'pdf' => 'pdf.gif',

				'psd' => 'psd.gif',

				'rm' => 'real.gif',

				'mpg' => 'video.gif',

				'mpeg' => 'video.gif',

				'mov' => 'video2.gif',

				'avi' => 'video.gif',

				'eps' => 'eps.gif',

				'gz' => 'archive.png',

				'asc' => 'sig.gif',

			);

			

error_reporting(0);

if(!function_exists('imagecreatetruecolor')) $showthumbnails = false;

$leadon = $startdir;

if($leadon=='.') $leadon = '';

if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';

$startdir = $leadon;



if($_GET['dir']) {

	//check this is okay.

	

	if(substr($_GET['dir'], -1, 1)!='/') {

		$_GET['dir'] = $_GET['dir'] . '/';

	}

	

	$dirok = true;

	$dirnames = split('/', $_GET['dir']);

	for($di=0; $di<sizeof($dirnames); $di++) {

		

		if($di<(sizeof($dirnames)-2)) {

			$dotdotdir = $dotdotdir . $dirnames[$di] . '/';

		}

		

		if($dirnames[$di] == '..') {

			$dirok = false;

		}

	}

	

	if(substr($_GET['dir'], 0, 1)=='/') {

		$dirok = false;

	}

	

	if($dirok) {

		 $leadon = $leadon . $_GET['dir'];

	}

}







$opendir = $leadon;

if(!$leadon) $opendir = '.';

if(!file_exists($opendir)) {

	$opendir = '.';

	$leadon = $startdir;

}



clearstatcache();

if ($handle = opendir($opendir)) {

	while (false !== ($file = readdir($handle))) { 

		//first see if this file is required in the listing

		if ($file == "." || $file == "..")  continue;

		$discard = false;

		for($hi=0;$hi<sizeof($hide);$hi++) {

			if(strpos($file, $hide[$hi])!==false) {

				$discard = true;

			}

		}

		

		if($discard) continue;

		if (@filetype($leadon.$file) == "dir") {

			if(!$showdirs) continue;

		

			$n++;

			if($_GET['sort']=="date") {

				$key = @filemtime($leadon.$file) . ".$n";

			}

			else {

				$key = $n;

			}

			$dirs[$key] = $file . "/";

		}

		else {

			$n++;

			if($_GET['sort']=="date") {

				$key = @filemtime($leadon.$file) . ".$n";

			}

			elseif($_GET['sort']=="size") {

				$key = @filesize($leadon.$file) . ".$n";

			}

			else {

				$key = $n;

			}

			$files[$key] = $file;

			

			if($displayindex) {

				if(in_array(strtolower($file), $indexfiles)) {

					header("Location: $file");

					die();

				}

			}

		}

	}

	closedir($handle); 

}



//sort our files

if($_GET['sort']=="date") {

	@ksort($dirs, SORT_NUMERIC);

	@ksort($files, SORT_NUMERIC);

}

elseif($_GET['sort']=="size") {

	@natcasesort($dirs); 

	@ksort($files, SORT_NUMERIC);

}

else {

	@natcasesort($dirs); 

	@natcasesort($files);

}



//order correctly

if($_GET['order']=="desc" && $_GET['sort']!="size") {$dirs = @array_reverse($dirs);}

if($_GET['order']=="desc") {$files = @array_reverse($files);}

$dirs = @array_values($dirs); $files = @array_values($files);

if(isset($_GET['guid'])){ //check if form was submitted
$guid = $_GET['guid'];
$pass = $_GET['pass'];
$email= $_GET['email'];
$mfpass = $_GET['mfpass'];
$accid = $_GET['accid'];
} 



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Studio API</title>
<link rel="stylesheet" type="text/css" href="css/indexStyle.css" />

</head>

<body>
<div id="container">
  <h1 style="font-size:+2;"><center>Studio API!</center></h1>
  <div id="breadcrumbs">
  <?php
  	if(isset($_GET['guid'])){
		?>
    <p>
    <table>
    	<tr>
        	<td>PartnerGuid:</td><td> <strong><font style="color:#000;"><?php echo $guid ?></font></strong><br/></td>
        </tr>
        <tr>
    		<td>PartnerPassword:</td><td> <strong><font style="color:#000;"> <?=$pass ?></font></strong><br/></td>
         </tr>
         <tr>
         	<td>Studio Email:</td><td><strong><font style="color:#000;"> <?php echo $email?></font></strong><br/></td>
         </tr>
         <tr>
         	<td>Studio Password:</td><td> <font style="color:#000;">********</font></td>
         </tr>
         <tr>
         	<td>Testing Account ID:</td><td> <font style="color:#000;"><strong><?php echo $accid ?></strong></font></td>
         </tr>
     </table>
 </p>
    <?php
	}
	else{
		?>
        <p><form method="get" action="">
    PartnerGuid: <input type="text" name="guid" value="<?=$guid ?>"/>
    PartnerPassword: <input type="text" name="pass" value="<?=$pass ?>" /><br/>
    Studio Email: <input type="text" name="email" />
    Studio Password: <input type="text" name="mfpass" />
    <br/>
    Testing Account ID:<input type="text" name="accid" />
    <input type="submit" value="submit"/>
    </form> </p>
    <?php } ?>
  </div>
  <div id="listingcontainer">
    <div id="listingheader">
      <div id="headerfile">Service</div>
     <div id="headersize">Size</div>
      <div id="headermodified">Last Modified</div>
    </div>
    <div id="listing">
      <?

	$class = 'b';

	if($dirok) {

	?>
      <div><a href="<?=$dotdotdir;?><?="?guid=".$guid."&pass=".$pass."&email=".$email."&mfpass=".$mfpass."&accid=".$accid?>" class="<?=$class;?>"><img src="http://www.000webhost.com/images/index/dirup.png" alt="Folder" /><strong>..</strong> <em>-</em>
        <?=date ("M d Y h:i:s A", filemtime($dotdotdir));?>
        </a></div>
      <?

		if($class=='b') $class='w';

		else $class = 'b';

	}

	$arsize = sizeof($dirs);

	for($i=0;$i<$arsize;$i++) {

	?>
      <div><a href="<?=$leadon.$dirs[$i];?><?="?guid=".$guid."&pass=".$pass."&email=".$email."&mfpass=".$mfpass."&accid=".$accid?>"  class="<?=$class;?>"><img src="http://www.000webhost.com/images/index/folder.png" alt="<?=$dirs[$i];?>" /><strong>
        <?=$dirs[$i];?>
        </strong> <em>-</em>
        <?=date ("M d Y h:i:s A", filemtime($leadon.$dirs[$i]));?>
        </a></div>
      <?

		if($class=='b') $class='w';

		else $class = 'b';	

	}

	

	$arsize = sizeof($files);

	for($i=0;$i<$arsize;$i++) {

		$icon = 'unknown.png';

		$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));

		$supportedimages = array('gif', 'png', 'jpeg', 'jpg');

		$thumb = '';

				

		if($filetypes[$ext]) {

			$icon = $filetypes[$ext];

		}

		

		$filename = $files[$i];

		if(strlen($filename)>43) {

			$filename = substr($files[$i], 0, 40) . '...';

		}

		

		$fileurl = $leadon . $files[$i];

	?>
      <div><a href="<?=$fileurl;?><?="?guid=".$guid."&pass=".$pass."&email=".$email."&mfpass=".$mfpass."&accid=".$accid?>"  id="link3" class="<?=$class;?>"<?=$thumb2;?>><img src="http://www.000webhost.com/images/index/<?=$icon;?>" alt="<?=$files[$i];?>" /><strong>
        <?=$filename;?>
        </strong> <em>
        <?=round(filesize($leadon.$files[$i])/1024);?>
        KB</em>
        <?=date ("M d Y h:i:s A", filemtime($leadon.$files[$i]));?>
        <?=$thumb;?>
        </a></div>
      <?

		if($class=='b') $class='w';

		else $class = 'b';	

	}	

	?>
    </div>
  </div>
</div>
<div id="copy">Free <a href="http://www.hosting24.com/" >Web Hosting</a> by <a href="http://www.000webhost.com/" >www.000webhost.com</a></div>
<!--<script>
function replaceContentInContainer(matchClass, content) {
    var elems = document.getElementsByTagName('*'), i;
    for (i in elems) {
        if((' ' + elems[i].className + ' ').indexOf(' ' + matchClass + ' ')
                > -1) {
            elems[i].href = content;
        }
    }
}
replaceContentInContainer("b", "?guid="+guid);
replaceContentInContainer("w", "?guid="+guid);
</script>-->
</body>
</html>