<?php 

class GoGoGST extends Helpers {

  private $ch;

  public function __construct() {}

  public function scrapeGSTs(){
    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $this->ch   = curl_init("http://go-go-gst.tumblr.com/");
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
        /html/body/div[2]/div[@class='postrow']/div[@class='autopagerize_page_element']/div/a[2]/@href |
        /html/body/div[2]/div[@class='postrow']/div[@class='autopagerize_page_element']/div/a[2]/img/@src
        ");

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
      // print_r(json_encode(array_chunk($data, 2));
      return $stories = array_chunk($data, 2);

    } else {
      //Do nothing
    }
  }


  public function writeJSON( $gstArr, $limit ) {

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $file = file_get_contents($GLOBALS['json_url_gogogst']);
      $data = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $jsonArr = array();

      for($i = 0; $i < $limit; $i++) {

        $jsonArr[] = array(
          'url'      =>  $gstArr[$i][0],
          'thumb'    =>  $gstArr[$i][1]
        );

      }

      file_put_contents($GLOBALS['json_url_gogogst'],json_encode($jsonArr));
      unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

  }

  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_gogogst']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div class="thumb">';
          $str .= '<a class="gogogst_url" href="'.$result['url'].'" target="_blank">';
          $str .= '<img class="gogogst_thumb" src='.$result['thumb'].'>';
          $str .= '</a>';
          $str .= '</div>';

          echo $str;
      }
  }

}

 ?>