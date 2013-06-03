<?php 

class Svbtle extends Helpers {

  private $ch;

  public function __construct() {
    
  }

  public function scrapeArticles(){

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      // cURL
      $this->ch   = curl_init("https://svbtle.com/magazine");
                    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
      $output     = curl_exec($this->ch);
                    curl_close($this->ch);

      // Check if it even exists
      if(empty($output)) {
        exit('Couldn\'t download the page');
        return;
      }

      $dom = new DOMDocument();
      libxml_use_internal_errors(true);
      $dom->loadHTML($output);
      libxml_use_internal_errors(false);
      $xpath = new DOMXPath($dom);
      
      // $dom = HTML5_Parser::parse($output);
      // $nodelist = HTML5_Parser::parseFragment('<b>Boo</b><br>');


      // Find stuff
      $result = $xpath->query("
        /html/body/section[@id='major']/article/a/@href |
        /html/body/section[@id='major']/article/a/header/h1 |
        /html/body/section[@id='major']/article/a/header/h2 |
        /html/body/section[@id='major']/article/a/section[@class='post_content']/p 
      ");

      // Get all the data, store them into 1d array
      $data = array();
      if (!is_null($result)) {

        foreach ($result as $key => $element) {
          $nodes = $element->nodeValue;

          $data[$key] = $nodes;

        }
      }
      
      // print_r($data);
      return $articles = array_chunk($data, 4);


    } else {
      //Do nothing
    } 
  }

  public function writeJSON( $articlesArr, $limit ) {

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $file = file_get_contents($GLOBALS['json_url_svbtle']);
      $data = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $jsonArr = array();

      for($i = 0; $i < $limit; $i++) {

        $jsonArr[] = array(
          'url'       =>  $articlesArr[$i][0],
          'title'     =>  $articlesArr[$i][1],
          'author'    =>  $articlesArr[$i][2],
          'excerpt'   =>  $articlesArr[$i][3]
        );

      }

      file_put_contents($GLOBALS['json_url_svbtle'],json_encode($jsonArr));
      unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

  }

  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_svbtle']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div class="feed-item">';
          $str .= '<h4 style="clear:both;display:block;margin-bottom:4px;"><a class="svbtle_link" href="'.$result['url'].'" target="_blank">'.$result['title'].'</a></h4>';
          $str .= '<span class="svbtle_author" style="margin-right:10px;"><i>'.$result['author'].'</i> </span>';
          //$str .= '<p class="svbtle_excerpt"><b>'.$result['excerpt'].'</b> </span>';
          $str .= '</div>';

          echo $str;
      }
  }
}


 ?>