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

//ALL ART
$fileName = strrchr($_SERVER['SCRIPT_NAME'], '/');
$len = strlen($fileName);
$uniqueTitle = substr($fileName,1,$len-5);

require $parent . 'scripts/connect.inc.php';
$sql = 'SELECT title FROM art WHERE unique_title="' . $uniqueTitle . '"';
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) {
  $title = $row['title'];
}
//END ALL ARR

require $parent . 'scripts/class.Page.php';

$page = new Page();
$page->setTitle($title);
//$page->setDescription('Hi');
//$page->setKeywords('no');
$page->setFlash($uniqueTitle);
$page->setType('art');
$page->display();

?>