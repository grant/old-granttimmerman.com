<?php
//////////////////////////////////////////////////////////
//INCLUDE THIS FOR EVERY SCRIPT//
//////////////////////////////////////////////////////////
$thisUrl = $_SERVER['SCRIPT_NAME'];
$numDirectory = substr_count($thisUrl,"/")-1;
$parent = '';
for($i = 0;$i<$numDirectory;$i++) {
 $parent .= '../';
}
//////////////////////////////////////////////////////////
//END/////////////////////////////////////////////////
//////////////////////////////////////////////////////////

//constants
define("DEFAULT_AUTHORITY_LEVEL","3");

require $parent . 'scripts/register.inc.php';

//$ip = $_SERVER['REMOTE_ADDR'];

$username = strtolower($_POST['username']);
$pass = md5(strtolower($_POST['password']));
$confirm_pass = md5(strtolower($_POST['confirm_password']));
$email = strtolower($_POST['email']);
$maillist = $_POST['maillist'];//'on' or ''
if($maillist=='on') {
  $maillist = 1;
} else {
  $maillist = 0;
}

if(check_username($username)=='false') {//username is good
  if(check_password($pass)=='false') {//password is good
    if(check_confirm_password($pass,$confirm_pass)=='true') {//confirm password is good
	  if(check_email($email)=='false') {//email is good 
	    $error = 'false';
	  }
	}
  }
}

if($error=='true') {//if there was an error in the form
  $url = $parent . 'profile/register.php?error=true';
  header('Location: ' . $url);
} else { //if there was no error in the form
  if(isset($_COOKIE["registered"])) {//the user already registered
    $url = $parent . 'profile/register.php?error=already_registered';
    header('Location: ' . $url);
	echo $url;
  } else {
    setcookie("registered",'yes', time()+3600*18);//expires in 18 hours
	
	require $parent . 'scripts/connect.inc.php';
	
	//sql - create account
	$sql = 'INSERT INTO users ( id , username , email , password , maillist , authority_level ) VALUES ( NULL , "';
	$sql .= $username;
	$sql .= '", "';
	$sql .= $email;
	$sql .= '", "';
	$sql .= $pass;
	$sql .= '", "';
	$sql .= $maillist;
	$sql .= '", "';
	$sql .= DEFAULT_AUTHORITY_LEVEL;
	$sql .= '")';
	
	$result = mysql_query($sql);
	
	//log in	
	require $parent . 'scripts/log_in.php';
	log_in($username,$pass);
	
	$url = $parent . 'index.php';
    header('Location: ' . $url);
  }
}
?>