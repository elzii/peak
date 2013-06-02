<?php 

class TheVerge extends Helpers {

  public function __construct() {
        
    }

  public function getXML($feed_url) {
    $modified_time  = $this->modifiedTime();

    if (!$modified_time) {

      $content  = file_get_contents($feed_url);
      $x        = new SimpleXmlElement($content);
      $item     = $x->entry;

      return $item;

    } else {
      // Do nothing - not enough time has passed.
    }
  }



  public function writeJSON( $articles, $limit ) {
    $modified_time  = $this->modifiedTime();

    if (!$modified_time) {


      $json_file  = $GLOBALS['json_url_theverge'];
      $file     = file_get_contents($json_file);
      $data     = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $articlesArr = array();

      //print_r($articlesArr);

      for($i = 0; $i < $limit; $i++) {  
        $articlesArr[] = array(
          'link'    => $articles[$i]->id,
          'title'   => $articles[$i]->title,
          'author'  => $articles[$i]->author->name
        );
      }

      file_put_contents($json_file,json_encode($articlesArr));
      unset($articlesArr);//release memory
      
    } else {
      // Do nothing - not enough time has passed.
    }



  }
 
  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_theverge']);
    $json_array   = json_decode($json_string, true);

        foreach($json_array as $json_article) {

            $str = '<div class="feed-item">';
            $str .= '<h4><a class="xmlfeed_link" href="'.$json_article['link'][0].'" target="_blank">'.$json_article['title'][0].'</a></h4>';
            //$str .= '<p class="xmlfeed_desc">'.$json_article['desc'][0].'</p>';
            $str .= '<span class="xmlfeed_author" style="margin-right:10px;">'.$json_article['author'][0].'</span>';
            // $str .= '<span class="xmlfeed_date" style="margin-right:10px;"><i>'.substr(($json_article['pubDate'][0]), 0, 16).'</i></span>';
            $str .= '</div>';

      echo $str;
        }

  }
} 


 ?>