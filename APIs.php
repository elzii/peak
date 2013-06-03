<?php 

/* Required Methods
================================================== */
require_once 'Helpers.php';


// Load all API files in the APIs folder
define('api_folder', 'apis');
  
$dir = opendir(api_folder);
while( ($currentFile = readdir($dir)) !== false ) {
  $ext = explode('.', $currentFile);
  if ( end($ext) !== 'php')
  continue;
  
  require_once( api_folder . '/' . $currentFile );
}
closedir($dir);



?>