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

/*
//session
session_start(); 
$increment = 50;
if(!isset($_SESSION['currentIndex'])) {
	$_SESSION['currentIndex'] = 0; // store session data
} else {//increase current index
	$_SESSION['currentIndex'] += $increment;
}
*/
echo 'Testing all rawwords<br />';

//sql
$startIndex = $_SESSION['currentIndex'];
$sql = "SELECT rawword FROM _wordapp_rawword ORDER BY rawword ASC";// LIMIT 0,7";//".$startIndex.",".$increment;

echo 'SQL: '.$sql.'<br />';

//result
$searchQuery = "<vcom:wordfamily";
$result = mysql_query($sql);
$i = 1;
while($row = mysql_fetch_array($result)) {
	echo $i.'. '.$row['rawword'].' - ';
	//
	$url = "http://www.vocabulary.com/definition/".$row['rawword'];
	$html = file_get_contents($url);
	foreach(explode("\n",$html) as $line) {
		$line = trim($line);
        if(substr($line,0,strlen($searchQuery))==$searchQuery) {
			//found it
			echo 'Uploaded';
			$sql2 = "INSERT INTO `_wordapp_frequency` (`id`,`word`,`data`) VALUES (NULL,'".$row['rawword']."','".$line."')";
			mysql_query($sql2);
		}
	}
	//
	echo '<br />';
	$i++;
}
echo '<br />';
echo 'End';
?>