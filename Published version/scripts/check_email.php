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
$email = $_GET['email'];

//check if email is in proper syntax

if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
  echo 'invalid';
} else {
  //sql
  $sql = 'SELECT * FROM users WHERE email="' . $email . '"';
  $result = mysql_query($sql);
  $num_matches = mysql_num_rows($result);

  if($num_matches>0) {//email already taken
    echo 'true';
  } else {
    echo 'false';
  }
}
?>