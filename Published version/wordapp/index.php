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

echo'<html>';
echo'<head>';
echo'<script src="ajax.js"></script>';
echo'<title>Word App</title>';
echo'<style>
textarea {
	max-width:600px !important;
	max-height:400px !important;
}
</style>';
echo'</head>';

//BODY//
echo'<body>';
echo'<b>Word App</b>';
echo'<br />';

////////////////////////////////////////
//Add words delimited by a new line (\n)
////////////////////////////////////////
echo '<form name="addWords" action="addWords.php" method="post">
Add new words. Separate with new line:<br />
<textarea rows="5" cols="30" name="words"></textarea>
<br />
<input type="submit" value="Add words" />
</form>';
//done with form

echo '<hr />';

//////////////////
//Search for words
//////////////////
echo 'Search for a word:';
echo '<br />';
echo '<form name="searchWord">
<input type="text" name="word" onchange="check_word(this.value)" />
<button type="button">Check</button>
<br />
<span id="existance">Word does not exist.</span>
</form>';
//done with form

echo '<hr />';

//////////////////
//Add a general word type
//////////////////
echo 'Add a general word type:';
echo '<br />';
echo '<form name="addWordType" action="addWordType.php" method="post">
Title:<input type="text" name="title" /><br />
Description:<input type="text" name="description" /><br />
Examples:<input type="text" name="examples" /><br />
<input type="submit" value="Add general word" /><br />
</form>';
//done with form

echo '<hr />';

//////////////////
//Add a specific word type
//////////////////
echo 'Add a specific word type:';
echo '<br />';
echo '<form name="addWordType" action="addSpecificWordType.php" method="post">
Title:<input type="text" name="title" /><br />';
//drop down box for general word type
echo 'General word type: ';
echo '<select name="wordtype_id" style="width:100px">';
$sql = "SELECT id, title FROM _wordapp_wordtype ORDER BY title ASC";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)) {
  echo '<option value="'.$row['id'].'">'.$row['title'].'</option>';
}
echo '</select>';
echo '<br />';
//end drop down box
echo 'Description:<input type="text" name="description" /><br />
Examples:<input type="text" name="examples" /><br />
When to use:<input type="text" name="usage" /><br />
Signal phrases:<input type="text" name="signals" /><br />
<input type="submit" value="Add specific word" /><br />
</form>';
//done with form

echo '<hr />';

////////////////
//View all words
////////////////
echo 'View all words:<form name="viewAllWords" action="viewAllWords.php" method="post">
<input type="submit" value="View all words" /></form>';
//done with form

echo '<hr />';

////////
//Syntax
////////
echo 'Syntax:<br />';
echo '<textarea rows="20" cols="60" name="words">';
echo '
Herel.sdfsdf
';
echo '</textarea>';
//end textarea

echo '<hr />';

///////
//Notes
///////
echo 'Notes:<br />';
echo '<textarea rows="20" cols="60" name="words">Title: Word app

-Problem: synonyms cannot be interchanged with one another because of meaning

-Define the problem and already solved possible solutions.

-Solve it like a hacker. Make it better anyway possible.

-make extending the app via WEB FORMS/FLASH FORMS ONLY!!! Make the progress of the success of the app be from USER extensions.

-eventually add a forum
----------
Features:
----------
-replacement for words (synonyms based on whole sentence (maybe paragraph))
-definition
-examples
-rhyming (groups and syllables)
-simplification (translate a paragraph to simple English)
-word usage and possible word combinations (with common word links) (ie to play [a sport])
-reverse dictionary (based off of many words)
-adjective scales (0-1000 how strong the adj/v/adv is)
-describable adjectives branching
----------------
Style guidelines:
----------------
-ultramodern minimalist color scheme
-light weight
-separate data from visualizations (create own API)
-2 click max to feature use
-able to use on non-flash and mobile
-----------------
Data structures:
-----------------
SQL:
-must use full RDB
Tables:
(word (entered by user or linked) (ie run | ran | running | hop)
(genword_id (linked) (ie run,ran,running,runs)
(genword_word_index (linked) (ie 2))
(meaning (linked) (ie run [a company]))
-word : genword_id
-genword_id : meaning array
-genword_id_index : meaning
-meaning : partofspeech_id : definition

Useful websites:
http://www.ego4u.com/en/cram-up/grammar/tenses
http://www.englishpage.com/verbpage/simplepresent.html
http://www.meredith.edu/grammar/plural.htm
</textarea>';
//end textarea

//end
echo '<hr /><br />';
echo 'more stuff here...';

//Very end
echo'</body>';
echo'</html>';
?>