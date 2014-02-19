<?php
//////////////////////////////////////////////////////////
//INCLUDE THIS FOR EVERY SCRIPT//
//////////////////////////////////////////////////////////
$thisUrl = $_SERVER['SCRIPT_NAME'];
$numDirectory = substr_count($thisUrl,"/")-1;
$this->parent = '';
for($i = 0;$i<$numDirectory;$i++) {
 $this->parent .= '../';
}
//////////////////////////////////////////////////////////
//END/////////////////////////////////////////////////
//////////////////////////////////////////////////////////

//SQL
require $parent . 'scripts/connect.inc.php';

$sql = 'SELECT title, data FROM news ORDER BY id DESC';
$result = mysql_query($sql);

echo '<div class="padding">';
echo '&nbsp;&nbsp;';
echo '<img width="85" height="85" src="http://www.granttimmerman.com/images/main/icons/newsIcon.png" alt="News" />';
echo '<b class="news">News</b>';
echo '<br />';

$i = 0;
while($row = mysql_fetch_array($result)) {
  echo '&nbsp;&nbsp;';
  echo '<b class="title">';
  echo $row['title'];
  echo '</b>';
  echo '<br />';
  echo '<hr class="small"/>';
  $dropLetter = substr($row['data'],0,1);
  echo '<span class="dropCap">' . $dropLetter . '</span>';
  $restOfData = substr($row['data'],1,strlen($row['data']));
  echo $restOfData;
  echo '<br /><br /><br />';
  $i++;
}
echo '</div>';

mysql_close($db);
?>