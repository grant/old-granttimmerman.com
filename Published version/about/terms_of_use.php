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

require $parent . 'scripts/class.Page.php';

$page = new Page();
$page->setTitle('Terms Of Use');
$page->setDescription('Hi');
$page->setKeywords('no');
$page->setType('terms_of_use');
$page->display();

?>