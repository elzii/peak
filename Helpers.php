<?php 

/* Required Methods
================================================== */
require_once 'Config.php';

class Helpers extends Config {

	public function modifiedTimeDebugging(){
		$path = $GLOBALS['json_url_nettuts'];
		
		if ($path && $GLOBALS['debug_toggle']) {

			$time_now 			= time();
			$time_modified 		= filemtime($path);
			$time_diff_format   = abs($time_modified - $time_now)/60/60;
			//echo $modified_date = date ("F d Y H:i:s.", filemtime($path));

			echo 	'<pre style="margin:0 0 20px 0;">' .
						'<h4 style="color:#d48749;margin:0 0 0 0;">TIME CACHE DEBUGGING</h4>' .
						'<small style="color:#999999;margin:0 0 5px 0;display:block;">Refreshing every ' .$GLOBALS['refresh_time'] . ' hours </small>' .
						'<b>Time Now</b>: ' . $time_now  . 
						'<br/><b>Time Modified</b>: ' . $time_modified . 
						'<br/><b>Difference</b>: ' . $time_diff_format . ' Hours' .
					'</pre>';

		} else {

			return false;
		}
	}

	public function modifiedTime() {

		$path 				= $GLOBALS['json_url_nettuts'];
		$time_now 			= time();
		$time_modified 		= filemtime($path);
		$time_difference    = abs($time_modified - $time_now)/60/60;

		if ($time_difference >= $GLOBALS['refresh_time']) {
			return false;
		} else {
			return true;
		}
	} 

}
?>