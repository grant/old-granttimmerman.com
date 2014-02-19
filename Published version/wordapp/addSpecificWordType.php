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
$wordtype_id = $_POST['wordtype_id'];
$description = $_POST['description'];
$examples = $_POST['examples'];
$usage = $_POST['usage'];
$signals = $_POST['signals'];

//get wordtype
$sql = "SELECT title FROM _wordapp_wordtype WHERE id = ".$wordtype_id;
$result = mysql_query($sql);
if($row = mysql_fetch_array($result)) {
  $wordtype = $row['title'];
}


//User information
echo 'Here is the query you submitted:<br />';
echo 'Title: '.$title.'<br />';
echo 'General word type: '.$wordtype.'<br />';
echo 'Description: '.$description.'<br />';
echo 'Examples: '.$examples.'<br />';
echo 'Usage: '.$usage.'<br />';
echo 'Signal words: '.$signals.'<br />';
echo '<br />';

//Query
$sql = "INSERT INTO `_wordapp_specificwordtype` (`id`,`wordtype_id`,`title`,`description`,`examples`,`usage`,`signals`) VALUES ('','".$wordtype_id."','".$title."','".$description."','".$examples."','".$usage."','".$signals."')";
$result = mysql_query($sql);

//Show query
echo 'Sql: '.$sql;
echo '<br />';


//Done
echo 'Done!';
echo '<br />';
echo '<a href="/wordapp/index.php">Home</a>';
?>