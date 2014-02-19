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
$word = $_GET['word'];
$sql = 'SELECT * FROM _wordapp_rawword WHERE rawword="' . $word . '"';
$result = mysql_query($sql);
$num_matches = mysql_num_rows($result);
if($num_matches==0) {
  echo '!'.$word;
} else {
  echo $word;
}
?>