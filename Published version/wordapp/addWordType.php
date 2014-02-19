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
$title = $_POST['title'];
$description = $_POST['description'];
$examples = $_POST['examples'];

//User information
echo 'Here is the query you submitted:<br />';
echo 'Title: '.$title.'<br />';
echo 'Description: '.$description.'<br />';
echo 'Examples: '.$examples.'<br />';
echo '<br />';

//Query
$sql = "INSERT INTO `_wordapp_wordtype` (`id`,`title`,`description`,`examples`) VALUES ('','".$title."','".$description."','".$examples."')";
$result = mysql_query($sql);

//Show query
echo 'Sql: '.$sql;
echo '<br />';

//Done
echo 'Done!';
echo '<br />';
echo '<a href="/wordapp/index.php">Home</a>';
?>