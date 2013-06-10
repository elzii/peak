<?php 

/* Required Methods
================================================== */
require_once 'Config.php';

class Helpers extends Config {

  /* TIME DIFFERENCE (FILE MODIFIED ATTR)
  ================================================== */
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


  /* MODIFIED TIME DEBUGGING
  ================================================== */
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

  /* MODIFIED TIME
  ================================================== */
	public function modifiedTime() {

		$time = $this->timeDifference();
    $time_difference = $time['time_difference_rounded'];

		if ($time_difference >= $GLOBALS['refresh_time'] && $time_difference != 0 && $GLOBALS['refresh_time'] != 0) {
			return false;
		} else {
			return true;
		}
	}


  /* TIME ELAPSED PERCENT
  ================================================== */
  public function timeElapsedPercent(){
    $time = $this->timeDifference();

    echo $time['time_elapsed_percent'];

  }

  /* TIME TIL REFRESH
  ================================================== */
	public function timeTilRefresh() {

    $refresh_time     = $GLOBALS['refresh_time'];
    $time             = $this->timeDifference();
    $time_elapsed     = $time['time_difference_rounded'];

    echo $time_elapsed . ' / ' . $refresh_time . ' Hrs';

	}

  /* JSON MERGE
  ================================================== */
  public function JSONMerge() {
    $sources = array(
      'reddit',
      'redditdesign',
      'hackernews',
      'designernews',
      'vice',
      'theverge',
      'eztv',
      'github',
      'medium',
      'stackoverflow',
      'svbtle',
      'tpb'
    );

    $output = array();

    foreach ($sources as $key => $source) {
      $src = "assets/json/".$source.".json";
      $source_json  = file_get_contents($src);
      $source_array = json_decode($source_json, TRUE);

      $output[$key] = $source_array;
      
    }

    $res = array_merge_recursive( 
      $output[0], 
      $output[1], 
      $output[2], 
      $output[3], 
      $output[4],
      $output[5],
      $output[6],
      $output[7],
      $output[8],
      $output[9],
      $output[10],
      $output[11]
    );


    $json_arr = array_chunk($res, 5);

    $json_arr['reddit']          = $json_arr[0]; unset($json_arr[0]);
    $json_arr['redditdesign']    = $json_arr[1]; unset($json_arr[1]);
    $json_arr['hackernews']      = $json_arr[2]; unset($json_arr[2]);
    $json_arr['designernews']    = $json_arr[3]; unset($json_arr[3]);
    $json_arr['vice']            = $json_arr[4]; unset($json_arr[4]);
    $json_arr['theverge']        = $json_arr[5]; unset($json_arr[5]);
    $json_arr['eztv']            = $json_arr[6]; unset($json_arr[6]);
    $json_arr['github']          = $json_arr[7]; unset($json_arr[7]);
    $json_arr['medium']          = $json_arr[8]; unset($json_arr[8]);
    $json_arr['stackoverflow']   = $json_arr[9]; unset($json_arr[9]);
    $json_arr['svbtle']          = $json_arr[10]; unset($json_arr[10]);
    $json_arr['tpb']             = $json_arr[11]; unset($json_arr[11]);


    // print_r(json_encode($json_arr));

    // return json_encode($json_arr);

    return json_encode($json_arr, JSON_PRETTY_PRINT);


    // $sources_merged = implode(", ", $output);
    // print_r($sources_merged);

  }


  /* LOAD ALL CLASSES
  ================================================== */
  public function loadAllClasses() {

    $classes = array(
        $scraper_github,
        $scraper_designernews,
        $scraper_siteinspire,
        $scraper_awwwards,
        $scraper_medium,
        $scraper_svbtle,
        $scraper_eztv,
        $scraper_tpb,
        $scraper_gogogst,
        
        $api_hackernews,
        $api_redditdev,
        $api_redditdesign,
        $api_dribbble,
        $api_stackoverflow,
        $xml_theverge,
        $xml_vice,

        $xml_nettuts,
      );
  }



}
?>