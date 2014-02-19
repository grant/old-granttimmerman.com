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

require $parent . 'scripts/connect.inc.php';
require $parent . 'scripts/log_out.php';

/**
 * Logs in
 * @param $username The username is not checked, it can be an email too
 * @param $password The password encoded with md5
 * Relocates url to home or sign in if there was an error
 **/
function log_in($username,$password) {
  $error = 'false';
  //prevent mysql injection
  //if not a username nor an email...
  if(!eregi("^[A-Za-z0-9_-]{3,20}$", $username)) {//username
    if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $username)) {//email
      $error = 'true';
    }
  }
  //so good so far
  if($error == 'false') {
    //log out
	log_out();
	
	//sql - username and password
	$sql = 'SELECT * FROM users WHERE username="' . $username . '" AND password="' . $password . '"';
	$result = mysql_query($sql);
	if(mysql_num_rows($result)<1) {//if there are no matches
	  //check if the user submitted an email
	  
	  //sql - email and password
	  $sql = 'SELECT username FROM users WHERE email="' . $username . '" AND password="' . $password . '"';
	  $result = mysql_query($sql);
      if(mysql_num_rows($result)<1) {//if there are no matches
	    $error = 'true';
	  } else {//email and password is good
	    //get username
	    $row = mysql_fetch_array($result);
	    $username = $row['username'];
	  
	    session_start();
	    $_SESSION['username'] = $username;
	  }
	  
	} else {//username and password is good
	  session_start();
	  $_SESSION['username'] = $username;
	}
  }
  if($error == 'true') {
    $url = '/profile/log_in.php?error=true';
    header('Location: ' . $url);
  } else {
    $url = '/index.php';
	header('Location: ' . $url);
  }
}

?>