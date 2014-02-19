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

//MYSQL
require $parent . 'scripts/connect.inc.php';

$sql = "SELECT title, unique_title, type FROM flash";
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);

//END MYSQL

echo '<br /><br />';

//LIKE BUTTON

echo '
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>

<div class="fb-like" data-href="http://www.facebook.com/pages/granttimmermancom/217872141562191" data-send="true" data-width="450" data-show-faces="true" data-font="arial"></div>
';

echo '<br /><br />';


//TABLE

echo '
<table cellpadding="0" cellspacing="0" summary="Quick links to the most popular games and projects.">
<tr>
<td colspan="2">
<img src="http://www.granttimmerman.com/images/main/side_bar/quick_links.png" alt="Quick Links" />
</td>
</tr>
<tr>
';

echo '<td width="40" class="side" rowspan="' . $num_rows . '">&nbsp;';
echo '</td>';

$i = 1;
while($row = mysql_fetch_array($result)) {
  echo ($i%2==0)?'<tr>':'';
  if($i%2==1){//odd
    echo '<td width="243" class="odd_row"><ul style="list-style-image: url(http://www.granttimmerman.com/images/main/side_bar/lightBlueDot.png);">';
    echo '<li class="odd_title">';
    echo '<a class="odd_title" href="http://www.granttimmerman.com/' . $row['type'] . '/' . $row['unique_title'] . '.php">';
  } else {//even
    echo '<td width="243" class="even_row"><ul style="list-style-image: url(http://www.granttimmerman.com/images/main/side_bar/darkBlueDot.png);">';
    echo '<li class="even_title">';
    echo '<a class="even_title" href="http://www.granttimmerman.com/' . $row['type'] . '/' . $row['unique_title'] . '.php">';
  }
  echo $row['title'];
  echo '</a>';
  echo '</li>';
  echo '</ul></td>';

  echo ($i%2==0)?'</tr>':'';

  $i++;
}
echo '</table>';
?>