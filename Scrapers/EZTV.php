<?php 

class EZTV extends Helpers {

  private $ch;

  public function __construct() {
  }

  public function scrapeTorrents(){
    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $this->ch   = curl_init("http://eztv.it/");
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
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[2]/a/@href |
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[2]/a/@title |
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[3]/a[1]/@href |
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[3]/a[3]/@href");

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

      $file = file_get_contents($GLOBALS['json_url_eztv']);
      $data = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $jsonArr = array();

      for($i = 0; $i < $limit; $i++) {

        
        
        $shortname =  preg_replace("/\([^)]+\)/", "", $torrArr[$i][1]);
                      preg_match("/\([^)]+\)/", $torrArr[$i][1], $size);

        $jsonArr[] = array(
          'url_eztv'      =>  $torrArr[$i][0],
          'name'          =>  $shortname,
          'size'          =>  $size,
          'url_mag'       =>  $torrArr[$i][2],
          'url_tpb'       =>  $torrArr[$i][3]
        );

      }

      file_put_contents($GLOBALS['json_url_eztv'],json_encode($jsonArr));
      unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

  }

  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_eztv']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div class="feed-item">';
          $str .= '<h4><a class="eztv_url" href="http://www.eztv.it/'.$result['url_eztv'].'" target="_blank">'.$result['name'].'</a></h4>';
          $str .= '<a class="icon icon-magnet" style="margin-right:10px" href="'.$result['url_mag'].'" class="eztv_magnet"> </a>';
          $str .= '<a class="icon icon-torrent" style="margin-right:10px" href="'.$result['url_tpb'].'" class="eztv_tpb"> </a>';
          $str .= '<span style="margin-right:10px" class="eztv_size">'.$result['size'][0].'</span>';
          $str .= '</div>';

          echo $str;
      }
  }

}


 ?>