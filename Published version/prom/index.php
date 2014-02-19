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

require_once $parent . 'facebook-php-sdk/src/facebook.php';

// Create our Application instance.
$facebook = new Facebook(array(
  'appId' => '192661780770623',
  'secret' => '2f55329eeddf749e63d6c7c027036c3d',
  'cookie' => true,
));
echo 'dfsd';
?>