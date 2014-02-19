<?php
//register.inc.php
//Purpose: Contains functions for checking the submitted fields

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

function check_confirm_password($pass1,$pass2) {
  if(strlen($pass1)<4) {//less than 4 characters
    return 'short';
  } else if(strlen($pass1)>20) {//more than 20 character
    return 'long';
  } else if(!eregi("^[A-Za-z0-9_-]{3,20}$", $pass1)) {//letters, numbers, underscore, and dash
    return 'characters';
  } else {//all good so far (password 1 is valid)
    if($pass1==$pass2) {
      return 'true';
    } else {
      return 'false';
    }
  }
}

function check_email($email) {
  //check if email is in proper syntax
  if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
    return 'invalid';
  } else {
    //sql
    $sql = 'SELECT * FROM users WHERE email="' . $email . '"';
    $result = mysql_query($sql);
    $num_matches = mysql_num_rows($result);

    if($num_matches>0) {//email already taken
      return 'true';
    } else {
      return 'false';
    }
  }
}

function check_password($password) {
  if(strlen($password)<4) {//less than 4 characters
    return 'short';
  } else if(strlen($password)>20) {//more than 20 character
    return 'long';
  } else if(!eregi("^[A-Za-z0-9_-]{3,20}$", $password)) {//letters, numbers, underscore, and dash
    return 'characters';
  } else {
    return 'false';
  }
}

function check_username($username) {
  //sql
  $sql = 'SELECT * FROM users WHERE username="' . $username . '"';
  $result = mysql_query($sql);
  $num_matches = mysql_num_rows($result);

  if($num_matches>0) {//username already taken
    return 'true';
  } else {
    if(strlen($username)<4) {//less than 4 characters
      return 'short';
    } else if(strlen($username)>20) {//more than 20 character
      return 'long';
    } else if(!eregi("^[A-Za-z0-9_-]{3,20}$", $username)) {//letters, numbers, underscore, and dash
      return 'characters';
    } else {
      return 'false';
    }
  }
}

?>