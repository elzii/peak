<?php 

/* Required Methods
================================================== */
require_once 'Config.php';

class Helpers extends Config {

	public function timeDifference(){
		$path 				            = $GLOBALS['json_url_hackernews'];
    $refresh_time             = $GLOBALS['refresh_time'];
		$time_now                 = time();
		$time_modified 		        = filemtime($path);
		$time_difference          = abs($time_modified - $time_now)/60/60;
    $time_difference_rounded  = round($time_difference, 2);
    $time_elapsed_percent     = (($time_difference_rounded / $refresh_time) * 100);

    return array(
      'path'                    =>   $path,
      'refresh_time'            =>   $refresh_time,
      'time_now'                =>   $time_now,
      'time_modified'           =>   $time_modified,
      'time_difference'         =>   $time_difference,
      'time_difference_rounded' =>   $time_difference_rounded,
      'time_elapsed_percent'    =>   $time_elapsed_percent
    );

	}


  public function modifiedTimeDebugging(){
    
    $time = $this->timeDifference();
    $path = $time['path'];

    if ($path && $GLOBALS['debug_toggle']) {

      $time = $this->timeDifference();
      
      //echo $modified_date = date ("F d Y H:i:s.", filemtime($path));

      echo  '<pre id="debug-time" style="display:none;margin:0 0 30px 0;">' .
            '<h4 style="color:#d48749;margin:0 0 0 0;">TIME CACHE DEBUGGING</h4>' .
            '<small style="color:#999999;margin:0 0 5px 0;display:block;">Refreshing every ' .$GLOBALS['refresh_time'] . ' hours </small>' .
            '<b>Time Now</b>: ' . $time['time_now']  . 
            '<br/><b>Time Modified</b>: ' . $time['time_modified'] . 
            '<br/><b>Difference</b>: ' . $time['time_difference_rounded'] . ' Hours' .
          '</pre>';

    } else {

      return false;
    }
  }

	public function modifiedTime() {

		$time = $this->timeDifference();
    $time_difference = $time['time_difference_rounded'];

		if ($time_difference >= $GLOBALS['refresh_time'] && $time_difference >= 0.025) {
			return false;
		} else {
			return true;
		}
	}


  public function timeElapsedPercent(){
    $time = $this->timeDifference();

    echo $time['time_elapsed_percent'];

  }


	public function timeTilRefresh() {

    $refresh_time     = $GLOBALS['refresh_time'];
    $time             = $this->timeDifference();
    $time_elapsed     = $time['time_difference_rounded'];

    echo $time_elapsed . ' / ' . $refresh_time . ' Hrs';

	}

}
?>