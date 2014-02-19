<?php
/*****************
 * Creates a standard page framework with customizable content
 ****************/
class Page {

  //////////////////
  //Constants//
  //////////////////

  //How to access constants: ClassName::ConstantName
  const DEFAULT_TITLE = 'Untitled';
  const DEFAULT_DESCRIPTION = 'Play games, discover new ideas, and become inspired with Grant Timmerman\'s portfolio.';
  const DEFAULT_KEYWORDS = 'Grant Timmerman';
  const DEFAULT_TYPE = 'blank';
  const DEFAULT_FLASH_DIRECTORY = 'pages';

  private $parent;

  /////////////////////////////
  //Class Properties//
  /////////////////////////////

  //General Page Data
  private $title;
  private $description;
  private $keywords;
  private $imports;
  private $footer;

  //Page Specific Data
  private $type;//Chooses what content to print
  private $hasFlash;
  private $hasNews;
  private $hasSideBar;

  private $flashTitle;
  private $codeTitle;

  public function __construct() {
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

    $this->title = Page::DEFAULT_TITLE;
    $this->description = Page::DEFAULT_DESCRIPTION;
    $this->keywords = Page::DEFAULT_KEYWORDS;
    $this->imports = array();
    $this->scripts = array();

    $this->type = Page::DEFAULT_TYPE;
    $this->hasFlash = 'false';
    $this->hasNews = 'false';
    $this->hasSideBar = 'false';

    $this->flashTitle = '';
    $this->codeTitle = '';

	// Session
	session_start();
	
    // Auto-adds
    $this->addImport('main');
    $this->addImport('sign_in');
    $this->addImport('footer');
    // Auto-creates (not impliments)
    $this->createFooter();
  }

  //Title
  public function setTitle($t = Page::DEFAULT_TITLE) {
    $this->title = $t;
  }
  private function printTitle() {
    echo '<title>' . $this->title . '</title>';
  }

  //Metadata
  public function setDescription($d = Page::DEFAULT_DESCRIPTION) {
    $this->description = $d;
  }
  public function setKeywords($k = Page::DEFAULT_KEYWORDS) {
    $this->keywords = $k;
  }
  private function printMetadata() {
    echo '<meta name="description" content="' . $this->description . '" />';
    echo '<meta name="keywords" content="' . $this->keywords . '" />';
  }

  //Type
  public function setType($t = PAGE::DEFAULT_TYPE) {
    $this->type = $t;
    switch($this->type) {
      case 'home':
        $this->hasFlash = 'true';
        $this->hasNews = 'true';
        $this->hasSideBar = 'true';
        break;
      case 'forbidden':
      case 'construction':
      case 'not_found':
        $this->addImport('error');
        break;
      case 'contact':
        $this->addImport('contact_table');
      case 'terms_of_use':
        $this->addImport('text');
        break;
      case 'flash':
        $this->hasFlash = 'true';
        $this->hasSideBar = 'true';
        $this->addImport('flash');
        break;
      case 'code':
        $this->addImport('code');
        $this->addImport('code_formatter');
        break;
      case 'games':
        $this->addImport('games');
        break;
      case 'art':
        $this->addImport('art');
        break;
      case 'projects':
        $this->addImport('projects');
        break;
      case 'about':
        $this->addImport('about');
        break;
      case 'register':
        $this->addImport('register');
        $this->importScript('register.inc');
        break;
	  case 'log_in':
	    $this->addImport('log_in');
		break;
    }
    $this->addImports();
  }

  //Imports
  private function addImport($i) {
    $this->imports[] = $i;
  }
  private function printImports() {
    foreach ($this->imports as $import) {
      echo '<link rel=StyleSheet href="'. $this->parent . 'styles/' . $import . '.css" type="text/css" media=screen />';
    }
  }
  private function addImports() {
    if($this->hasNews == 'true') {
      $this->addImport('news');
    }
    if($this->hasSideBar == 'true') {
      $this->addImport('side_bar');
    }
  }

  //Scripts
  private function importScript($i) {
    $this->scripts[] = $i;
  }
  private function printScripts() {
    //no flash backup
    echo '<!--[if IE]>';
    echo '<script language="javascript" type="text/javascript" src="http://www.granttimmerman.com/scripts/noflash.js"></script>';
    echo '<![endif]-->';
    //prints every script
    foreach ($this->scripts as $script) {
      echo '<script type="text/javascript" src="' . $this->parent . 'scripts/' . $script . '.js"></script>';
    }
  }

  //Doctype
  private function printDoctype() { 
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
  }

  //Body
  private function printTopFrame() {
    echo '<table width="100%" height="100%" cellpadding="0" cellspacing="0" align="center" bgcolor="#669900" summary="frame of website">';
    echo '<tr>';
    //TOP
    echo '<td colspan="6" height="20">&nbsp;</td>';
    echo '</tr>';
    echo '<tr>
        <td height="35" bgcolor="#FFFFFF">&nbsp;</td>
        <!--Corner-->
        <td width="35" rowspan="2" class="shadowDownRight">&nbsp;</td>
        <!--Logo-->
        <td width="375" rowspan="3"><img alt="Grant Timmerman" src="http://www.granttimmerman.com/images/main/logos/logo.png" /></td>
        <!--White-->
        <td width="700" colspan="1" bgcolor="#FFFFFF">';
    //Top part of sign in

    echo '<div class="left">';
    $this->print_top_sign_in();
    echo '</div>';

    echo '</td>
        <td width="35" bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>';
    //END OF FIRST ROW
    //SHADOWS
    echo '<tr>
           <!--Shadows-->
           <td height="35" class="shadowDown">&nbsp;</td>
           <td colspan="1" class="shadowDown">';

    //Bottom part of sign in
    echo '<div class="right">';
    $this->print_bottom_sign_in();
    echo '</div>';

    echo '</td>
           <td colspan="2" class="shadowDown">&nbsp;</td>
         </tr>';
    //END SHADOWS
    echo '<tr>
           <!--Green to the left of the logo-->
           <!--height="170"-->
           <td height="170" colspan="2">&nbsp;</td>
           <!--Buttons-->
           <td>
           <table border="0" width="100%" cellpadding="0" cellspacing="0" summary="button allignment">
             <tr>
               <!--Green above Buttons-->
               <td height="140" colspan="6">&nbsp;</td>
             </tr>
             <tr>
               <td width="35" height="60">&nbsp;</td>
               <td width="80"><a href="http://www.granttimmerman.com/index.php" onmouseover="document.home.src=\'http://www.granttimmerman.com/images/main/navigation/homeButtonHighlight.png\'"onmouseout="document.home.src=\'http://www.granttimmerman.com/images/main/navigation/homeButton.png\'"><img src="http://www.granttimmerman.com/images/main/navigation/homeButton.png" width="80" name="home" alt="Home" /></a></td>
               <td width="170"><a href="http://www.granttimmerman.com/games/index.php" onmouseover="document.games.src=\'http://www.granttimmerman.com/images/main/navigation/gamesButtonHighlight.png\'"onmouseout="document.games.src=\'http://www.granttimmerman.com/images/main/navigation/gamesButton.png\'"><img src="http://www.granttimmerman.com/images/main/navigation/gamesButton.png" width="170" name="games" alt="Games" /></a></td>
               <td width="175"><a href="http://www.granttimmerman.com/projects/index.php" onmouseover="document.projects.src=\'http://www.granttimmerman.com/images/main/navigation/projectsButtonHighlight.png\'"onmouseout="document.projects.src=\'http://www.granttimmerman.com/images/main/navigation/projectsButton.png\'"><img src="http://www.granttimmerman.com/images/main/navigation/projectsButton.png" width="175" name="projects" alt="Projects" /></a></td>
               <td width="165"><a href="http://www.granttimmerman.com/about/index.php" onmouseover="document.about.src=\'http://www.granttimmerman.com/images/main/navigation/aboutButtonHighlight.png\'"onmouseout="document.about.src=\'http://www.granttimmerman.com/images/main/navigation/aboutButton.png\'"><img src="http://www.granttimmerman.com/images/main/navigation/aboutButton.png" width="165" name="about" alt="About" /></a></td>
               <td width="75">&nbsp;</td>
             </tr>
           </table>
           </td>
           <!--Green to the right of the everything-->
           <td colspan="2">&nbsp;</td>
         </tr>';
    //END OF TOP
    echo '<tr>
           <td class="gradientDown" bgcolor="#A0E302">&nbsp;</td>
           <td class="gradientShadowLeft" bgcolor="#A0E302">&nbsp;</td>
           <!--Body-->';
    //Adds class to td if has flash
    $addFlash = '';
    if($this->hasFlash == "false"){
      $addFlash = 'class="cut_corner"';
    }
    echo '<td colspan="2" width="1075" bgcolor="#FFFFFF" ' . $addFlash . '>';
    //End has flash
  }
  private function print_top_sign_in() {

    //format
    for($i = 0;$i<66;$i++){
      echo '&nbsp;';
    }
	
	//if not logged in
    if(!isset($_SESSION['username'])) { //if not logged in, display sign in
      // Sign in
      echo '<span class="sign_in">';
      echo 'Sign In';
      echo '</span>';

      // Or
      echo '<span class="or">';
      echo ' or ';
      echo '</span>';

      // Register
      echo '<span class="register">';
      echo '<a href="' . $this->parent . 'profile/register.php">Register</a>';
      echo '</span>';
    }
  }
  private function print_bottom_sign_in() {
    echo '<table cellpadding="0" cellspacing="0" bgcolor="#ffffff" align="right" summary="sign in system">';
    
	if(isset($_SESSION['username'])) {
	  $signed_in = 'true';
	  $num_columns = 4;
	} else {
	  $signed_in = 'false';
	  $num_columns = 5;
	}
	
    // Blank white space above text fields
    echo '<tr height="5">';
    echo '<td colspan="' . $num_columns . '"></td>';
    echo '</tr>';

    // Middle of sign in
    echo '<tr>';
	if($signed_in == 'true') {//signed in
	  echo '<td width="10">&nbsp;</td>';
	  // Sign out
	  echo '<td width="250">';
	  
	  $name = ucfirst($_SESSION['username']);//capitalize first letter
	  echo '<span class="left">';
	  echo 'Welcome ' . $name . '!';
	  echo '</span>';
	  
	  echo '</td>';
	  echo '<td width="100">';
	  
	  echo '<a href="' . $this->parent . 'scripts/sign_out.php">';
	  echo '<img src="' . $this->parent . 'images/main/buttons/sign_out.png" />';
	  echo '</a>';
	  
	  echo '</td>';
	  //
	  echo '<td width="10">&nbsp;</td>';
	} else {//not signed in
	  // Text field and sign in button
      echo '<form name="form1" method="post" action="' . $this->parent . 'scripts/check_login.php">';
      echo '<td width="10">&nbsp;</td>';
      echo '<td><input name="username" type="text" id="username" /></td>';
      echo '<td width="10">&nbsp;</td>';
      echo '<td><input name="password" type="password" id="password" /></td>';
      echo '<td width="10">&nbsp;</td>';
      echo '<td><input type="image" name="submit" src="' . $this->parent . 'images/main/buttons/sign_in.png" /></td>';
      echo '<td width="10">&nbsp;</td>';
      echo '</form>';
	}
    echo '</tr>';

    // Corners and blank space
    echo '<tr>';
    echo '<td><img src="' . $this->parent . 'images/main/frame/white_bottom_left.png" /></td>';
    echo '<td colspan="' . $num_columns . '"></td>';
    echo '<td><img src="' . $this->parent . 'images/main/frame/white_bottom_right.png" /></td>';
    echo '</tr>';

    echo '</table>';
  }
  
  private function printContent() {
    switch($this->type) {
      case 'blank':
        echo 'Blank Page, "blank" type';
        break;
      case 'home':
        $this->printFlash('home',1075,400);
        $this->startSplit();
        echo '<td width = "775" class="top">';
        require $this->parent . 'scripts/news.php';
        echo '</td>';
        echo '<td width = "300" class="top">';
        require $this->parent . 'scripts/side_bar.php';
        echo '</td>';
        $this->endSplit();
        break;
      case 'forbidden':
      case 'construction':
      case 'not_found':
        $this->printError($this->type);
        break;
      case 'contact':
        $this->printDocument('contact');
        $this->printContactTable();
        break;
      case 'terms_of_use':
        $this->printDocument('terms_of_use');
        break;
      case 'flash':
        $this->printFlashContent();
        break;
      case 'code':
        $this->printCode();
        break;
      case 'games':
        $this->printGames();
        break;
      case 'projects':
        $this->printProjects();
        break;
      case 'art':
        $this->printArt();
        break;
      case 'about':
        $this->printAbout();
        break;
      case 'register':
        $this->printRegister();
        break;
	  case 'log_in':
	    $this->printLogin();
		break;
      default:
        echo 'Undefined type';
    }
  }
  private function printError($name) {
    echo '<div class="error">';
    $this->printFlash($name,480,360);
    echo '<div class="return_link">';
    echo '<a href="http://www.granttimmerman.com/index.php">';
    echo 'Click here to return to the home page.';
    echo '</a>';
    echo '</div>';
    echo '</div>';
  }
  private function printBottomFrame() {
    echo '</td>';
    echo '<td class="gradientShadowRightCut" bgcolor="#A0E302">&nbsp;</td>';
    echo '<td class="gradientDown" bgcolor="#A0E302">&nbsp;</td></tr>';
    echo '</table>';
  }

  //Splits
  private function startSplit() {
    echo '<table border="0px" width="100%" cellpadding="0" cellspacing="0" summary="The content of the page."><tr>';
  }
  private function endSplit() {
    echo '</tr></table>'; 
  }

  // Flash
  private function printFlash($name,$width,$height,$directory = PAGE::DEFAULT_FLASH_DIRECTORY) {
    $url = 'http://www.granttimmerman.com/flash/' . $directory . '/' . $name . '.swf';
    $widthHeight = 'width="' . $width . '" height="' . $height . '"';
    // Prints flash player, otherwise prints image

    // object tag
    echo '<object type="application/x-shockwave-flash" data="';
    echo $url;
    echo '" ';
    echo $widthHeight;
    echo '>';
    // end object tag
    //movie
    echo '<param name="movie" value="';
    echo $url;
    echo '">';
    //wmode
    //echo '<param name="wmode" value="transparent">';
    echo '<a href="http://www.adobe.com/go/getflashplayer">';
    // backup image
    echo '<img src="http://www.granttimmerman.com/images/main/replacements/noflash.png" alt="Flash is not supported on your system." width="1075" height="400" />
             </a>
             </object>';
  }
  public function setFlash($u) {
    $this->flashTitle = $u;
  }
  private function printFlashContent() {
    //update plays
    $sql = "UPDATE flash SET plays = plays+1 WHERE unique_title='" . $this->flashTitle . "'";
    $r = mysql_query($sql);
    //end update plays

    $this->startSplit();
    echo '<td colspan="2" class="flashbg">';
    echo '<div class="game">';
    $sql = 'SELECT title,description,instructions,devnote,width,height,type,plays FROM flash WHERE unique_title="' . $this->flashTitle . '"';
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $this->printFlash($this->flashTitle,$row['width'],$row['height'],$row['type']);
    echo '</div>';
    echo '</td>';

    // Row 2
    echo '<tr>';

    echo '<td width="775" class="top">';
    echo '<div class="padding">';
    echo '<b class="title">' . $row['title'] . '</b>';
    echo '<br />';
    echo '<hr />';
    echo '<div class="text">';
    echo '<div class="description"><b>Description:</b> ' . $row['description'] . '</div>';
    echo '<br />';
    echo '<div class="instructions"><b>Instructions:</b> ' . $row['instructions'] . '</div>';
    echo '<br />';
    echo '<div class="plays"><b>Plays:</b> ' . $row['plays'] . '</div>';
    echo '<br />';
    echo '<div class="devnote"><b>Developer\'s Note:</b> ' . $row['devnote'] . '</div>';
    echo '</div>';
    echo '</div>';
    echo '</td>';

    echo '<td width="300" class="top">';
    require $this->parent . 'scripts/side_bar.php';
    echo '</td>';
    $this->endSplit();
  }

  //Code
  public function setCode($u) {
    $this->codeTitle = $u;
  }
  private function printCode() {
    $this->startSplit();

    require $this->parent . 'scripts/connect.inc.php';
    $sql = 'SELECT title,description,data FROM code WHERE unique_title="' . $this->codeTitle . '"';
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    echo '<td>';

    echo '<div class="padding">';
    echo '<b class="title">' . $row['title'] . '</b>';
    echo '<br />';
    echo '<hr />';
    echo '<br />';
    echo '<div class="textpadding">';
    echo '<div class="description"><b>Description:</b> ' . $row['description'] . '</div>';
    echo '<br />';
    echo '</div>';
    echo '</div>';

    echo '</td>';

    echo '</tr><tr>';
    
    echo '<td>';

   echo '<div class="padding">';
    echo $row['data'];
    echo '</div>';

    echo '</td>';

    $this->endSplit();

  }

  //Art
  private function printArt() {
    $this->startSplit();

    $src = $this->parent . 'images/art/' . $this->flashTitle . '.png';

    require $this->parent . 'scripts/connect.inc.php';

    $sql = 'SELECT id FROM art';
    $result = mysql_query($sql);
    $num_rows = mysql_num_rows($result);

    $sql = 'SELECT id FROM art WHERE unique_title="' . $this->flashTitle . '"';
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $prevID = $row['id']-1;
    $nextID = $row['id']+1;

    if($prevID==0){
      $prevID = $num_rows;
    } else if($nextID>$num_rows) {
      $nextID = 1;
    }

    $sql = 'SELECT unique_title FROM art WHERE id="' . $prevID . '"';
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $prevURL = $this->parent . 'art/' . $row['unique_title'] . '.php';

    $sql = 'SELECT unique_title FROM art WHERE id="' . $nextID . '"';
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $nextURL = $this->parent . 'art/' . $row['unique_title'] . '.php';

    $sql = 'SELECT id,description,unique_title,title FROM art WHERE unique_title="' . $this->flashTitle . '"';
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    echo '<td class="bg">';
    echo '<div class="center">';
    echo '<div class="padding">';
    echo '<a class="paganate" href="' . $prevURL . '">Previous</a>';
    echo '&nbsp;&nbsp;&nbsp;';
    echo '<img src="' . $src . '" />';
    echo '&nbsp;&nbsp;&nbsp;';
    echo '<a class="paganate" href="' . $nextURL . '">Next</a>';
    echo '</div>';
    echo '</div>';
    echo '</td>';
    
    echo '</tr><tr>';
    
    echo '<td>';
    echo '<div class="padding">';
    echo '<div class="textpadding">';
    echo '<b class="title">' . $row['title'] . '</b>';
    echo '<br />';
    echo '<hr />';
    echo '<br />';
    echo '<div class="textpadding">';
    echo $row['description'];
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</td>';
    $this->endSplit();
  }

  //Games
  private function printGames() {
    echo '<div class="padding">';
    echo '&nbsp;&nbsp;';
    echo '<img width="85" height="85" src="http://www.granttimmerman.com/images/main/icons/gameIcon.png" alt="Games" />';
    echo '<b class="games">Games</b>';
    echo '<br />';
    echo '<hr />';
    echo '<br />';

    //sql
    require $this->parent . 'scripts/connect.inc.php';
    mysql_free_result($result);
    //$sql = "SELECT title,unique_title,type FROM flash";
    $sql = "SELECT title,unique_title,type FROM flash WHERE type='games'";
    $result = mysql_query($sql);
    $num_results = mysql_num_rows($result);

    // Print content
    $this->startSplit();
    $i = 1;
    while($row = mysql_fetch_array($result)) {
      if($i%3==0&&$i!=$num_results){
        echo '</tr><tr>';
      }
      echo '<td width="325">';

      echo '<div class="gamepadding">';

      echo '<table border="0px" width="285" cellpadding="0" cellspacing="0" summary="A game."><tr>';
      echo '<td width="10" height="10" class="tl"><img src="' . $this->parent . 'images/main/games/top_left.png" /></td>';
      echo '<td class="lightgray"></td>';
      echo '<td width="10" height="10" class="tr"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td class="lightgray"></td>';
      echo '<td width="265" class="lightgray">';
      echo '<a class="title" href="http://www.granttimmerman.com/' . $row['type'] . '/' . $row['unique_title'] . '.php">';
      echo $row['title'];
      echo '</a>';
      echo '</td>';
      echo '<td class="lightgray"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td class="darkgray"></td>';
      echo '<td class="darkgray">';
      echo '<div class="paddingup">';
      echo '<a class="title" href="http://www.granttimmerman.com/' . $row['type'] . '/' . $row['unique_title'] . '.php">';
      echo '<img width="265" height="200" src="' . $this->parent . 'images/thumbnails/' . $row['unique_title'] . '.png" />';
      echo '</a>';
      echo '</div>';
      echo '</td>';
      echo '<td class="darkgray"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td width="10" class="bl"></td>';
      echo '<td class="darkgray"></td>';
      echo '<td width="10" class="br"><img src="' . $this->parent . 'images/main/games/bottom_right.png" /></td>';
      $this->endSplit();

      echo '</div>';

      echo '</td>';

      $i++;
    }
    for($j = 1;$j<($num_results%3);$j++){
      echo '<td width="325">&nbsp;</td>';
    }

    $this->endSplit();
    echo '</div>';
    mysql_free_result($result);

    echo '</div>';
  }

  // Projects
  private function printProjects() {
    echo '<div class="padding">';
    echo '&nbsp;&nbsp;';
    echo '<img width="85" height="85" src="http://www.granttimmerman.com/images/main/icons/gameIcon.png" alt="Games" />';
    echo '<b class="games">Projects</b>';
    echo '<br />';
    echo '<hr />';
    echo '<br />';

    //sql
    require $this->parent . 'scripts/connect.inc.php';
    mysql_free_result($result);
    //$sql = "SELECT title,unique_title,type FROM flash";
    $sql = "SELECT title,unique_title,type FROM flash WHERE type='projects'";
    $result = mysql_query($sql);
    $num_results = mysql_num_rows($result);

    // Print content
    $this->startSplit();
    $i = 1;
    while($row = mysql_fetch_array($result)) {
      if($i%3==0&&$i!=$num_results){
        echo '</tr><tr>';
      }
      echo '<td width="325">';

      echo '<div class="gamepadding">';

      echo '<table border="0px" width="285" cellpadding="0" cellspacing="0" summary="A game."><tr>';
      echo '<td width="10" height="10" class="tl"><img src="' . $this->parent . 'images/main/games/top_left.png" /></td>';
      echo '<td class="lightgray"></td>';
      echo '<td width="10" height="10" class="tr"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td class="lightgray"></td>';
      echo '<td width="265" class="lightgray">';
      echo '<a class="title" href="http://www.granttimmerman.com/' . $row['type'] . '/' . $row['unique_title'] . '.php">';
      echo $row['title'];
      echo '</a>';
      echo '</td>';
      echo '<td class="lightgray"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td class="darkgray"></td>';
      echo '<td class="darkgray">';
      echo '<div class="paddingup">';
      echo '<a class="title" href="http://www.granttimmerman.com/' . $row['type'] . '/' . $row['unique_title'] . '.php">';
      echo '<img width="265" height="200" src="' . $this->parent . 'images/thumbnails/' . $row['unique_title'] . '.png" />';
      echo '</a>';
      echo '</div>';
      echo '</td>';
      echo '<td class="darkgray"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td width="10" class="bl"></td>';
      echo '<td class="darkgray"></td>';
      echo '<td width="10" class="br"><img src="' . $this->parent . 'images/main/games/bottom_right.png" /></td>';
      $this->endSplit();

      echo '</div>';

      echo '</td>';

      $i++;
    }
    for($j = 1;$j<($num_results%3);$j++){
      echo '<td width="325">&nbsp;</td>';
    }

    $this->endSplit();

    ////////////
    //Code//
    ////////////

    echo '<br />';

    //same as above besides sql

    echo '&nbsp;&nbsp;';
    //echo '<img width="85" height="85" src="http://www.granttimmerman.com/images/main/icons/gameIcon.png" alt="Games" />';
    echo '<b class="games">Code</b>';
    echo '<br />';
    echo '<hr />';
    echo '<br />';

    //sql
    //require $this->parent . 'scripts/connect.inc.php';
    mysql_free_result($result);
    $sql = "SELECT title,unique_title FROM code";
    $result = mysql_query($sql);
    $num_results = mysql_num_rows($result);

    // Print content
    $this->startSplit();
    $i = 1;
    while($row = mysql_fetch_array($result)) {
      if($i%3==0&&$i!=$num_results){
        echo '</tr><tr>';
      }
      echo '<td width="325">';

      echo '<div class="gamepadding">';

      echo '<table border="0px" width="285" cellpadding="0" cellspacing="0" summary="A game."><tr>';
      echo '<td width="10" height="10" class="tl"><img src="' . $this->parent . 'images/main/games/top_left.png" /></td>';
      echo '<td class="lightgray"></td>';
      echo '<td width="10" height="10" class="tr"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td class="lightgray"></td>';
      echo '<td width="265" class="lightgray">';
      echo '<a class="title" href="http://www.granttimmerman.com/code/' . $row['unique_title'] . '.php">';
      echo $row['title'];
      echo '</a>';
      echo '</td>';
      echo '<td class="lightgray"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td class="darkgray"></td>';
      echo '<td class="darkgray">';
      echo '<div class="paddingup">';
      echo '<a class="title" href="http://www.granttimmerman.com/code/' . $row['unique_title'] . '.php">';
      $thumbnail = $this->parent . 'images/thumbnails/' . $row['unique_title'] . '.png';
      if(!file_exists($thumbnail)){
        $thumbnail = $this->parent . 'images/thumbnails/code.png';
      }
      echo '<img width="265" height="200" src="' . $thumbnail . '" />';
      echo '</a>';
      echo '</div>';
      echo '</td>';
      echo '<td class="darkgray"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td width="10" class="bl"></td>';
      echo '<td class="darkgray"></td>';
      echo '<td width="10" class="br"><img src="' . $this->parent . 'images/main/games/bottom_right.png" /></td>';
      $this->endSplit();

      echo '</div>';

      echo '</td>';

      $i++;
    }
    for($j = 1;$j<($num_results%3);$j++){
      echo '<td width="325">&nbsp;</td>';
    }

    $this->endSplit();

    //end same

    ////////
    //Art//
    ////////

    echo '&nbsp;&nbsp;';
    //echo '<img width="85" height="85" src="http://www.granttimmerman.com/images/main/icons/gameIcon.png" alt="Games" />';
    echo '<b class="games">Art</b>';
    echo '<br />';
    echo '<hr />';
    echo '<br />';

    $sql = 'SELECT * FROM art';
    $result = mysql_query($sql);
    $num_results = mysql_num_rows($result);

    //Today's featured picture
    $date = date("z");
    $id = ($date%$num_results)+1;

    $sql = 'SELECT title,unique_title,id FROM art WHERE id="' . $id . '"';
    $result = mysql_query($sql);

    echo '<div class="center">';
    echo '<b class="featured">Featured Picture of the Day</b>';
    echo '<br />';
    echo '<br />';
    while($row = mysql_fetch_array($result)) {
      echo '<table border="0px" cellpadding="0" cellspacing="0" class="center" summary="A game."><tr>';
      echo '<td width="10" height="10" class="tl"><img src="' . $this->parent . 'images/main/games/top_left.png" /></td>';
      echo '<td class="lightgray"></td>';
      echo '<td width="10" height="10" class="tr"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td class="lightgray"></td>';
      echo '<td width="265" class="lightgray">';
      echo '<a class="title" href="http://www.granttimmerman.com/art/' . $row['unique_title'] . '.php">';
      echo $row['title'];
      echo '</a>';
      echo '</td>';
      echo '<td class="lightgray"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td class="darkgray"></td>';
      echo '<td class="darkgray">';
      echo '<div class="paddingup">';
      echo '<a class="title" href="http://www.granttimmerman.com/art/' . $row['unique_title'] . '.php">';
      $thumbnail = $this->parent . 'images/art/' . $row['unique_title'] . '.png';
      echo '<img src="' . $thumbnail . '" />';
      echo '</a>';
      echo '</div>';
      echo '</td>';
      echo '<td class="darkgray"></td>';
      echo '</tr>';

      echo '<tr>';
      echo '<td width="10" class="bl"></td>';
      echo '<td class="darkgray"></td>';
      echo '<td width="10" class="br"><img src="' . $this->parent . 'images/main/games/bottom_right.png" /></td>';
    }
    $this->endSplit();
    echo '</div>';
    echo '<br />';
    //end today's featured

    $sql = 'SELECT title,unique_title,id FROM art';
    $result = mysql_query($sql);
    $num_results = mysql_num_rows($result);

    $num_columns = 5;
    $num_rows = floor(($num_results-1)/$num_columns)+1;
    $this->startSplit();

    $i = 0;
    while($row = mysql_fetch_array($result)) {
      if($i%$num_columns==0&&$i!=0) {
        echo '</tr><tr>';
      }
      echo '<td><ul><li><a href="' . $this->parent . 'art/' . $row['unique_title'] . '.php">' . $row['title'] . '</a></li></ul></td>';
      $i++;
    }
    $this->endSplit();

    //end art
    echo '</div>';

    echo '</div>';
    mysql_free_result($result);
  }

  // About
  private function printAbout() {
    echo '<img alt="Cloud" src="http://www.granttimmerman.com/images/backgrounds/clouds.png" />';
    echo '<br />';
    echo '<div class="padding">';
    echo '<b class="title">Welcome to my world</b>';
    echo '<div class="body">';
    echo 'Here is where I post all my latest and greatest creations and projects. The work here is probably only 10% of all the work I do in programming, videography, and art. The rest of my projects are too small, hard to display on a website, or have copy write agreements that limit their publication. This website is constantly changing with the addition of new games, projects etc. Feel free to send me an e-mail of a game idea or collaboration anytime.';
    echo '</div>';
    echo '</div>';
  }

  // Register
  private function printRegister() {
    echo '<div class="padding">';
    echo '&nbsp;&nbsp;';
    echo '<b class="register">Register</b>';
    echo '<br />';
    echo '<hr />';
    echo '<br />';
	
	if($_GET['error']=='true') {
	  echo '<span class="error">There was an error when trying to create your account. Please re-enter your information.</span>';
	  echo '<br /><br />';
	} else if($_GET['error']=='already_registered') {
	  echo '<span class="error">You have already created an account! Try registering again tomorrow.</span>';
	  echo '<br /><br />';
	}
    
    echo '<table border="0" cellpadding="0" cellspacing="0" summary="Register">';
    echo '<tr>';
    echo '<td width="600">';

    echo '<form name="register" method="post" action="' . $this->parent . 'scripts/register.php">';

    echo '<table border="0" cellpadding="7" cellspacing="0" summary="form">';
    echo '<tr>';
    
    // Username
    echo '<td width="200"><div class="right"><b>Username:</b></div></td>';
    echo '<td width="120"><input name="username" type="text" maxlength="20" id="username" onchange="check_username(this.value)" /></td>';
    echo '<td width="200"><span id="check_username" class="error">&nbsp;</span></td>';
    
    echo '</tr>';
    echo '<tr>';

    // Password
    echo '<td><div class="right"><b>Password:</b></div></td>';
    echo '<td><input name="password" type="password" maxlength="20" id="password" onchange="check_password(this.value)" /></td>';
    echo '<td><span id="check_password" class="error">&nbsp;</span></td>';
    
    echo '</tr>';
    echo '<tr>';

	// Confirm Password
    echo '<td><div class="right"><b>Confirm Password:</b></div></td>';
    echo '<td><input name="confirm_password" type="password" maxlength="20" id="confirm_password" onchange="check_confirm_password(document.register.password.value,this.value)" /></td>';
    echo '<td><span id="check_confirm_password" class="error">&nbsp;</span></td>';

    echo '</tr>';
    echo '<tr>';

    // Email
    echo '<td><div class="right"><b>Email address:</b></div></td>';
    echo '<td><input name="email" type="text" id="email" maxlength="100" onchange="check_email(this.value)" /></td>';
    echo '<td><span id="check_email" class="error">&nbsp;</span></td>';

    echo '</tr>';
    echo '<tr>';

	// Mailing list
    echo '<td><div class="right"><input type="checkbox" name="maillist" checked /></div></td>';
    echo '<td colspan="2">I would like to recieve notices about new games and major updates to the website.</td>';

    echo '</tr>';
    echo '<tr>';

	// Term Agreement
    echo '<td>&nbsp;</td>';
    echo '<td colspan="2"><div class="small">By clicking "Create account" you agree to the <a target="_blank" href="' . $this->parent . 'about/terms_of_use.php">Terms of Use</a>.</div>';
    
	echo '<br />';
	
	// Create Account Button
    echo '<input type="image" name="create" src="' . $this->parent . 'images/main/buttons/create_account.png" />';
    echo '</td>';

    echo '</tr>';
    echo '</table>';

    echo '</form>';

    echo '</td>';
    echo '<td>';

    echo '<b class="title">';
    echo 'Why register?';
    echo '</b>';
    echo '<br />';
    echo '<br />';
    echo '<b>Highscores:</b> Watch yourself climb the highscores and compare yourself to other players around the world.';
    echo '<br />';
    echo '<br />';
    echo '<b>It\'s fast:</b> It takes less than 30 seconds to create an account. Ands it\'s free!';
    echo '<br />';
    echo '<br />';
    echo '<b>Privlages:</b> Be the first to know about new games and other future online games.';

    echo '<td>';
    echo '</td>';
    echo '</tr>';


    echo '</table>';
    echo '</div>';
  }
  
  // Login
  private function printLogin() {
    echo '<div class="padding">';
    echo '&nbsp;&nbsp;';
    echo '<b class="sign_in">Sign In</b>';
    echo '<br />';
    echo '<hr />';
    echo '<br />';
	if($_GET['error']) {
	  echo '<span class="error">';
	  echo 'There was an error when trying to sign you on.';
	  echo '</span>';
	  echo '<br /><br />';
	}
	
	//split into two columns
	echo '<table border="0" cellpadding="0" cellspacing="0" summary="Register">';
    echo '<tr>';
    echo '<td width="600">';
	
	//form
	echo '<form name="register" method="post" action="' . $this->parent . 'scripts/check_login.php">';

    echo '<table border="0" cellpadding="7" cellspacing="0" summary="form">';
    echo '<tr>';
    
    // Username
    echo '<td width="200"><div class="right"><b>Username:</b></div></td>';
    echo '<td width="120"><input name="username" type="text" maxlength="20" id="username" /></td>';
    
    echo '</tr>';
    echo '<tr>';

    // Password
    echo '<td><div class="right"><b>Password:</b></div></td>';
    echo '<td><input name="password" type="password" maxlength="20" id="password" /></td>';
    
    echo '</tr>';
	echo '<tr>';
	
	// Sign in
	echo '<td>&nbsp;</td>';
	echo '<td><input type="image" name="submit" src="' . $this->parent . 'images/main/buttons/sign_in.png" /></td>';
	
	echo '</tr>';
	
	echo '</table>';
	echo '</td>';
	
	//
	echo '<td>';
	
	echo '<b class="title">Don\'t have an account yet?</b>';
	echo '<br />';
	echo '<a href="' . $this->parent . 'profile/register.php">Create an account!</a>';
	
	echo '</td>';
	echo '</tr>';
	echo '</table>';
  }

  // Documents
  private function printDocument($name) {
    require $this->parent . 'scripts/connect.inc.php';
    $sql = 'SELECT * FROM documents WHERE unique_title="' . $name . '"';
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)) {
      echo '<div class="text">';
      echo '<b class="title">';
      echo $row['title'];
      echo '</b>';
      echo '<br /><br />';
      echo $row['text'];
      echo '</div>';
    }
    mysql_free_result($result);
  }

  // Contact Table
  private function printContactTable() {
    $sql = 'SELECT * FROM contact';
    $result = mysql_query($sql);
    echo '<div class="contact_table">';
    // Start Table
    echo '<table>';
    echo '<tr>';
    echo '<td class="title"></td>';
    echo '<td class="title"><b class="category_title">E-mail</b></td>';
    echo '<td class="title"><b class="category_title">Description</b></td>';
    echo '</tr>';
    
    // Data
    $i = 0;
    while($row = mysql_fetch_array($result)) {
      $i++;
      $oddEven = ($i%2==0)?'class="even_row"':'class="odd_row"';
      echo '<tr>';
      echo '<td ' . $oddEven . '><b class="name">' . $row['name'] . '</b></td>';
      echo '<td ' . $oddEven . '>' . $row['email'] . '</td>';
      echo '<td ' . $oddEven . '>' . $row['description'] . '</td>';
      echo '</tr>';
    }
    mysql_free_result($result);
    echo '</table>';
    echo '</div>';
  }

  // Footer
  private function createFooter() {
    $this->addFootLink('About','about/index.php');
    $this->addFootLink('Games','games/index.php');
    $this->addFootLink('Projects','projects/index.php');
    $this->addFootLink('Contact','about/contact.php');
    $this->addFootLink('Terms of Use','about/terms_of_use.php');
  }
  private function addFootLink($name,$path) {
    $this->footer[] = '<a href="http://www.granttimmerman.com/' . $path . '" class="foot_link">' . $name .'</a>';
  }
  private function printFooter() {
    echo '<div class="footer">';
    echo '<hr />';
    echo '<div class="footer_text">';
    //footer
    $spacing = '  ';
    echo 'Grant Timmerman' . $spacing . '-' . $spacing .date('Y');
    for($i=0;$i<count($this->footer);$i++) {
      echo $spacing;
      echo '<b class="divider">|</b>';
      echo $spacing;
      echo $this->footer[$i];
    }
    echo '</div>';
    echo '</div>';
  }

  //DISPLAY
  public function display() {
    $this->printDoctype();
    require $this->parent . 'scripts/start.php';
    $this->printTitle();
    $this->printMetadata();
    $this->printImports();
    $this->printScripts();
    require $this->parent . 'scripts/body.php';
    $this->printTopFrame();
    $this->printContent();
    $this->printFooter();
    $this->printBottomFrame();
    require $this->parent . 'scripts/end.php';
  }
}