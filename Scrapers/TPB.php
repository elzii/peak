<?php 

class TPB extends Helpers {

  private $ch;

  public function __construct() {
  }

  public function scrapeTorrents(){
    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $this->ch   = curl_init("http://thepiratebay.sx/top/all");
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
      $result = $xpath->query("
        /html/body/div[@id='content']/div[@id='main-content']/table[@id='searchResult']/*/td/div[@class='detName']/a/@href |
        /html/body/div[@id='content']/div[@id='main-content']/table[@id='searchResult']/*/td/div[@class='detName']/a |
        /html/body/div[@id='content']/div[@id='main-content']/table[@id='searchResult']/*/td/a[1]/@href |
        /html/body/div[@id='content']/div[@id='main-content']/table[@id='searchResult']/*/td/font[@class='detDesc']");

      // print_r($result);

      // Get all the data, store them into 1d array
      $data = array();
      if (!is_null($result)) {

        foreach ($result as $key => $element) {
          $nodes = $element->nodeValue;

          $data[$key] = $nodes;

        }
      }
      // print_r($data);
      // print_r(json_encode(array_chunk($data, 4));
      return $stories = array_chunk($data, 4);

    } else {
      //Do nothing
    }
  }


  public function writeJSON( $torrArr, $limit ) {

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $file = file_get_contents($GLOBALS['json_url_tpb']);
      $data = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $jsonArr = array();

      for($i = 0; $i < $limit; $i++) {

        // $shortname =  preg_replace("/\([^)]+\)/", "", $torrArr[$i][1]);
        preg_match("/([+-]?\\d*\\.\\d+)(?![-+0-9\\.])/", $torrArr[$i][3], $size);
        preg_match("/(MiB)|(GiB)/", $torrArr[$i][3], $unit);

        $jsonArr[] = array(
          'tor_name'     =>  $torrArr[$i][0],
          'url'          =>  'http://thepiratebay.sx'.$torrArr[$i][1],
          'url_mag'      =>  $torrArr[$i][2],
          'desc'         =>  $torrArr[$i][3],
          'size'         =>  $size,
          'unit'         =>  $unit
        );

      }

      file_put_contents($GLOBALS['json_url_tpb'],json_encode($jsonArr));
      unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

  }

  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_tpb']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div class="feed-item">';
          $str .= '<h4><a class="tpb_url" href="'.$result['url'].'" target="_blank">'.$result['tor_name'].'</a></h4>';
          $str .= '<a class="icon icon-magnet" style="margin-right:10px" href="'.$result['url_mag'].'" class="tpb_magnet"> </a>';
          $str .= '<span style="margin-right:10px" class="tpb_size">('.$result['size'][0].' '.$result['unit'][0].')</span>';
          $str .= '</div>';

          echo $str;
      }
  }

}


 ?>