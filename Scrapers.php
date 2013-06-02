<?php 

/* Required Methods
================================================== */
require_once 'Helpers.php';
require_once 'lib/HTML5/Parser.php';



// Load all scraper files in the scrapers folder
define('scraper_folder', 'Scrapers');
  
$dir = opendir(scraper_folder);
while( ($currentFile = readdir($dir)) !== false ) {
  $ext = explode('.', $currentFile);
  if ( end($ext) !== 'php')
  continue;
  
  require_once( scraper_folder . '/' . $currentFile );
}
closedir($dir);


?>