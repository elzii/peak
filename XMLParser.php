<?php 

/* Required Methods
================================================== */
require_once 'Helpers.php';


// Load all XML files in the XML folder
define('xml_folder', 'xml');
  
$dir = opendir(xml_folder);
while( ($currentFile = readdir($dir)) !== false ) {
  $ext = explode('.', $currentFile);
  if ( end($ext) !== 'php')
  continue;
  
  require_once( xml_folder . '/' . $currentFile );
}
closedir($dir);


?>