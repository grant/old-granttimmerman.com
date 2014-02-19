<?php

//GET
$passes = $_GET['passwords'];
$pass_list = explode(",",$passes);
$pass1 = $pass_list[0];
$pass2 = $pass_list[1];

if(strlen($pass1)<4) {//less than 4 characters
  echo 'short';
} else if(strlen($pass1)>20) {//more than 20 character
  echo 'long';
} else if(!eregi("^[A-Za-z0-9_-]{3,20}$", $pass1)) {//letters, numbers, underscore, and dash
  echo 'characters';
} else {//all good so far (password 1 is valid)
  if($pass1==$pass2) {
    echo 'true';
  } else {
    echo 'false';
  }
}

?>