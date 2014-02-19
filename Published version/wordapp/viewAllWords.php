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

$alphabet = array('a','b','c','d','e','f','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

//title
echo 'List of all raw words:<br />';
//quick look
for($j = 0;$j<sizeof($alphabet);$j++) {
  $letter = $alphabet[$j];
  echo '<a href="#'.$letter.'">'.strtoupper($letter).'</a> ';
}
echo '<br />';
echo '<a href="/wordapp/index.php">Home</a>';
echo '<hr />';

//print all rawwords
$sql = "SELECT rawword FROM _wordapp_rawword ORDER BY rawword ASC";
$result = mysql_query($sql);

$i = 1;//current word #
$letterIndex = 0;//current letter index
while($row = mysql_fetch_array($result)) {
  $word = $row['rawword'];
  echo $i.'. ';
  if(substr($word,0,1)==$alphabet[$letterIndex]) {//add anchor if the first of the new starting letter word
    echo '<a name="'.$alphabet[$letterIndex].'">'.$row['rawword'].'</a>';
	$letterIndex++;
  } else {
    echo $row['rawword'];
  }
  echo '<br />';
  $i++;
}
?>