<?php 

class Instagram extends Helpers {

  private $ch;

  public function __construct() {
  }

  public function scrapeThumbs( $user ){
    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $this->ch   = curl_init("http://instagram.com/".$user);
                    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
      $output     = curl_exec($this->ch);
                    curl_close($this->ch);

      // Check if it even exists
      if(empty($output)) exit('Couldn\'t download the page');   

      $dom = new DOMDocument();
      libxml_use_internal_errors(true);
      $dom->loadHTML($output);
      libxml_clear_errors();
      $xpath = new DOMXPath($dom);
      

      // Find stuff
      $result = $xpath->query("//*/div[@class='feed-photos']/*/div[@class='photo-grid']/ul[@class='photo-feed']/li[@class='photo']");

      print_r($result);

      // Get all the data, store them into 1d array
      $data = array();
      if (!is_null($result)) {

        foreach ($result as $key => $element) {
          $nodes = $element->nodeValue;

          $data[$key] = $nodes;

        }
      }
      print_r($data);
      // print_r(json_encode(array_chunk($data, 4));
      // return $stories = array_chunk($data, 4);

    } else {
      //Do nothing
    }
  }


  public function writeJSON( $photoArr, $limit ) {

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $file = file_get_contents($GLOBALS['json_url_tpb']);
      $data = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $jsonArr = array();

      for($i = 0; $i < $limit; $i++) {

        $jsonArr[] = array(
          'photo_url'     =>  $photoArr[$i][0]
        );

      }

      file_put_contents($GLOBALS['json_url_instagram'],json_encode($jsonArr));
      unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

  }

  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_instagram']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div class="feed-item">';
          $str .= '<h4>'.$result['photo_url'].'</h4>';
          $str .= '</div>';

          echo $str;
      }
  }

}


 ?>