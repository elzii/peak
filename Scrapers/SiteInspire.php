<?php 

class SiteInspire extends Helpers {

  private $ch;

  public function __construct() {
  }

  public function scrapeSites(){
    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $this->ch   = curl_init("http://www.siteinspire.com/");
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
      $classname="thumbnail";
      $result = $xpath->query("
          //*[@id='grid']/div[@class='thumbnail']/div[1]/div[1]/a[1]/@href |
          //*[@id='grid']/div[@class='thumbnail']/div[1]/div[1]/a[1]/img/@src");

      // Get all the data, store them into 1d array
      $data = array();
      if (!is_null($result)) {

        foreach ($result as $key => $element) {
          $nodes = $element->nodeValue;

          $data[$key] = $nodes;

        }
      }
      return $stories = array_chunk($data, 2);

    } else {
      //Do nothing
    }
  }


  public function writeJSON( $imgArr, $limit ) {

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $file = file_get_contents($GLOBALS['json_url_siteinspire']);
      $data = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $jsonArr = array();

      for($i = 0; $i < $limit; $i++) {

        $jsonArr[] = array(
          'url'     =>  $imgArr[$i][0],
          'url_img' =>  $imgArr[$i][1]
        );

      }

      file_put_contents($GLOBALS['json_url_siteinspire'],json_encode($jsonArr));
      unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

  }

  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_siteinspire']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div class="thumb">';
          $str .= '<a class="siteinspire_url" href="http://www.siteinspire.com/'.$result['url'].'" target="_blank">';
          $str .= '<img src='.$result['url_img'].'>';
          $str .= '</a>';
          $str .= '</div>';

          echo $str;
      }
  }

}

 ?>