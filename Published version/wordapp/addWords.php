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
$words = $_POST['words'];
echo 'Here is the query you submitted:<br />'.$words;
echo '<br /><br />';
//
$splitWords = explode("\n", $words);
echo 'Splitting:';
echo '<br />';
$i = 1;
foreach ($splitWords as $word) {
	$word = trim($word);//remove extra whitespace
    if(strlen($word)>0) {//if the word exists
		$sql = "SELECT 1 FROM _wordapp_rawword WHERE rawword = '".$word."'";
		$result = mysql_query($sql);
		if(mysql_num_rows($result)<1) {
			$sql = "INSERT INTO _wordapp_rawword (id,rawword,wordgroup_id) VALUES (NULL,'".$word."','')";
			echo $i.". ".$sql.'<br />';
			$result = mysql_query($sql);
		} else {
			echo $i.". ".$word." already exists.<br />";
		}
	}
	$i++;
}
echo '<br />';
echo 'Done!';
echo '<br />';
echo '<a href="/wordapp/index.php">Home</a>';
?>