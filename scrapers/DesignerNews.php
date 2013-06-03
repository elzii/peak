<?php 

class DesignerNews extends Helpers {

  private $ch;

  public function __construct() {
    
  }

  public function scrapeStories( $limit ){

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      // cURL
      $this->ch   = curl_init("https://news.layervault.com/stories");
                    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
      $output     = curl_exec($this->ch);
                    curl_close($this->ch);

      // Check if it even exists
      if(empty($output)) exit('Couldn\'t download the page');   

      $dom = new DOMDocument();
      libxml_use_internal_errors(true);
      $dom->loadHTML($output);
      libxml_use_internal_errors(false);
      $xpath = new DOMXPath($dom);
       

      $ol = $xpath->query("/html/body/div[2]/div/ol");

      // Find stuff
      $classname="Story";
      $result = $xpath->query("
          /html/body/div[2]/div/ol/li/a[1]/@href |
          /html/body/div[2]/div/ol/li/a[1] | 
          /html/body/div[2]/div/ol/li/div[@class='Below']/span[1] |
          /html/body/div[2]/div/ol/li/div[@class='Below']/span[2] |
          /html/body/div[2]/div/ol/li/div[@class='Below']/a[2]");

      // Get all the data, store them into 1d array
      $data = array();
      if (!is_null($result)) {

        foreach ($result as $key => $element) {
          $nodes = $element->nodeValue;

          $data[$key] = $nodes;

        }
      }

      // print_r(json_encode($data));
      return $stories = array_chunk($data, $limit);

    } else {
      //Do nothing
    } 
  }

  public function displayStories( $storyArr, $limit ) {

    for($i = 0; $i < $limit; $i++) {
      $str = '<div class="feed-item">';
      $str .= '<h4><a class="designernews_link" href="'.$storyArr[$i][0].'" target="_blank">'.$storyArr[$i][1].'</a></h4>';
      $str .= '<span class="designernews_points" style="margin-right:10px;"><b>'.$storyArr[$i][2].'</b> </span>';
      $str .= '<span class="designernews_timeago" style="margin-right:10px;"><i>'.$storyArr[$i][3].'</i> </span>';
      $str .= '<a style="color:gray;" href="#" class="designernews_comments"><b>'.$storyArr[$i][4].'</b> </a>';
      $str .= '</div>';

      echo $str;
    }
  }

  public function writeJSON( $storyArr, $limit ) {

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $file = file_get_contents($GLOBALS['json_url_designernews']);
      $data = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $jsonArr = array();

      for($i = 0; $i < $limit; $i++) {

        $jsonArr[] = array(
          'url'       =>  $storyArr[$i][1],
          'title'     =>  $storyArr[$i][0],
          'points'    =>  $storyArr[$i][2],
          'time'      =>  $storyArr[$i][3],
          'comments'  =>  $storyArr[$i][4]
        );

      }

      file_put_contents($GLOBALS['json_url_designernews'],json_encode($jsonArr));
      unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

  }


  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_designernews']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div class="feed-item">';
          $str .= '<h4><a class="designernews_link" href="'.$result['url'].'" target="_blank">'.$result['title'].'</a></h4>';
          $str .= '<span class="designernews_points" style="margin-right:10px;"><b>'.$result['points'].'</b> </span>';
          $str .= '<span class="designernews_comments" style="margin-right:10px;"><i>'.$result['time'].'</i> </span>';
          $str .= '<a style="color:gray;" href="#" class="designernews_comments"><b>'.$result['comments'].'</b> </a>';
          $str .= '</div>';

          echo $str;
      }
  }
}


 ?>