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

//ALL CODE
$fileName = strrchr($_SERVER['SCRIPT_NAME'], '/');
$len = strlen($fileName);
$uniqueTitle = substr($fileName,1,$len-5);

require $parent . 'scripts/connect.inc.php';

$sql = 'SELECT title FROM code WHERE unique_title="' . $uniqueTitle . '"';
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) {
  $title = $row['title'];
}
//END ALL CODE

require $parent . 'scripts/class.Page.php';

$page = new Page();
$page->setTitle($title);
//$page->setDescription('Hi');
//$page->setKeywords('no');
$page->setCode($uniqueTitle);
$page->setType('code');
$page->display();

?>