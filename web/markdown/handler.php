<link rel="stylesheet" type="text/css" href="/markdown/style.css"/>
<?php

require('markdown.php');

$legalExtensions = array('md', 'markdown');

$file = realpath($_SERVER['PATH_TRANSLATED']);
if($file &&
   in_array(strtolower(substr($file, strrpos($file, '.') + 1)),
	    $legalExtensions)) {
  echo Markdown(file_get_contents($file));
}
else {
  echo "<p>Bad filename given</p>";
}
?>