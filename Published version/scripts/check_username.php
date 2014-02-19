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

//GET
$username = $_GET['username'];

//sql
$sql = 'SELECT * FROM users WHERE username="' . $username . '"';
$result = mysql_query($sql);
$num_matches = mysql_num_rows($result);

if($num_matches>0) {//username already taken
  echo 'true';
} else {
  if(strlen($username)<4) {//less than 4 characters
    echo 'short';
  } else if(strlen($username)>20) {//more than 20 character
    echo 'long';
  } else if(!eregi("^[A-Za-z0-9_-]{3,20}$", $username)) {//letters, numbers, underscore, and dash
    echo 'characters';
  } else {
    echo 'false';
  }
}

?>