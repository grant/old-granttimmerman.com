<?php

//GET
$password = $_GET['password'];

if(strlen($password)<4) {//less than 4 characters
  echo 'short';
} else if(strlen($password)>20) {//more than 20 character
  echo 'long';
} else if(!eregi("^[A-Za-z0-9_-]{3,20}$", $password)) {//letters, numbers, underscore, and dash
  echo 'characters';
} else {
  echo 'false';
}

?>