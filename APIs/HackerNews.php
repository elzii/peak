<?php 

class HackerNews extends Helpers {

    private $ch;

    public function __construct() {}

    public function getJSON() {
      $modified_time  = $this->modifiedTime();

      if (!$modified_time) {

        $this->ch = curl_init();
                    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
                    curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);  
       
        $url = "http://api.thriftdb.com/api.hnsearch.com/items/_search?pretty_print=true&filter[fields][create_ts]=[NOW-10HOURS%20TO%20NOW]&filter[queries][]=points:[5+TO+*]&limit=5&start=0";
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $output = curl_exec($this->ch);
        return $output;

      } else {
         // Do nothing
      }  
    }

    public function writeJSON( $items, $limit ) {
      $modified_time  = $this->modifiedTime();

      if (!$modified_time) {
        $json_file  = $GLOBALS['json_url_hackernews'];
        $file       = file_get_contents($json_file);
        unset($file); //prevent memory leaks for large json.


        $items_d  = json_decode($items, true);
        $item     = $items_d['results'];
        
        //print_r($item);

        $itemsArr = array();
        for($i = 0; $i < $limit; $i++) {  
          $itemsArr[] = array(
            'url'           => $item[$i]['item']['url'],
            'title'         => $item[$i]['item']['title'],
            'points'        => $item[$i]['item']['points'],
            'num_comments'  => $item[$i]['item']['num_comments'],
            'url_comments'  => 'https://news.ycombinator.com/item?id='.$item[$i]['item']['id']
          );
        }

        file_put_contents($json_file,json_encode($itemsArr));
        unset($itemsArr);//release memory

      } else {
         // Do nothing
      }  
    }


    public function readJSON() {

      $json_string  = file_get_contents($GLOBALS['json_url_hackernews']);
      $json_array   = json_decode($json_string, true);

      foreach($json_array as $result){

        $str = '<div class="feed-item">';
        $str .= '<h4><a class="hackernews_link" href="'.$result['url'].'" target="_blank">'.$result['title'].'</a></h4>';
        $str .= '<span class="hackernews_points" style="margin-right:10px;"><b>'.$result['points'].' points </b></span>';
        $str .= '<a style="color:gray;" href="'.$result['url_comments'].'" class="hackernews_comments">'.$result['num_comments'].' comments </a>';
        $str .= '</div>';

        echo $str;
      }

    }



    public function getPosts( $items ){
        $itemsArr   = array();
        $itemsArr   = json_decode($items, true);
        $results    = $itemsArr['results'];

        foreach($results as $result){
          $result_item = $result['item'];

          $str = '<div class="feed-item">';
          $str .= '<h4><a class="hackernews_link" href="'.$result_item['url'].'" target="_blank">'.$result_item['title'].'</a></h4>';
          $str .= '<span class="hackernews_points" style="margin-right:10px;"><b>'.$result_item['points'].' points </b></span>';
          $str .= '<a style="color:gray;" href="#" class="hackernews_comments">'.$result_item['num_comments'].' comments </a>';
          $str .= '</div>';

          echo $str;
        }
    }

}


 ?>