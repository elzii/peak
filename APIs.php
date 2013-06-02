<?php 

/* Required Methods
================================================== */
require_once 'Helpers.php';


class HackerNews extends Helpers {

    private $ch;

    public function __construct() {
      $modified_time  = $this->modifiedTime();

      if (!$modified_time) {

		    $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);

      } else {
         // Do nothing
      } 
    }

    public function getJSON() {
      $modified_time  = $this->modifiedTime();

      if (!$modified_time) {
    	 
        $url = "http://api.thriftdb.com/api.hnsearch.com/items/_search?pretty_print=true&filter[fields][create_ts]=[NOW-5HOURS%20TO%20NOW]&filter[queries][]=points:[5+TO+*]&limit=5&start=0";
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



class Reddit extends Helpers {

    // http://api.ihackernews.com/page?format=jsonp&callback=hnJSON

    private $ch;

    public function __construct() {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    }

    public function getJSON( $subreddits, $limit ) {
      $url = "http://www.reddit.com/r/".$subreddits."/.json?limit=".$limit;
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $output = curl_exec($this->ch);
        return $output;
    }

    public function writeJSON( $items, $limit ) {
      $modified_time  = $this->modifiedTime();

      // if (!$modified_time) {
        $json_file  = $GLOBALS['json_url_reddit'];
        $file       = file_get_contents($json_file);
        unset($file); //prevent memory leaks for large json.


        $items_arr      = json_decode($items, true);
        $items          = $items_arr['data']['children'];

        
        //print_r(json_encode($items));

        $itemsArr = array();
        for($i = 0; $i < $limit; $i++) {  

          $itemsArr[] = array(
            'url'           => $items[$i]['data']['url'],
            'title'         => $items[$i]['data']['title'],
            'score'         => $items[$i]['data']['score'],
            'num_comments'  => $items[$i]['data']['num_comments'],
            'subreddit'     => $items[$i]['data']['subreddit']
          );
        }

        file_put_contents($json_file,json_encode($itemsArr));
        unset($itemsArr);//release memory

      // } else {
      //    // Do nothing
      // }  
    }


    public function readJSON() {

      $json_array  = file_get_contents($GLOBALS['json_url_reddit']);
      $php_array   = json_decode($json_array, true);

      foreach($php_array as $result){

          $str = '<div class="feed-item">';
          $str .= '<h4><a class="reddit_link" href="'.$result['url'].'" target="_blank">'.$result['title'].'</a></h4>';
          $str .= '<span class="reddit_points" style="margin-right:10px;"><b>'.$result['score'].' points </b></span>';
          $str .= '<a style="color:gray;margin-right:10px;" href="#" class="reddit_comments">'.$result['num_comments'].' comments </a>';
          $str .= '<span class="reddit_subreddit" style="margin-right:10px;">'.$result['subreddit'].'</span>';
          $str .= '</div>';

          echo $str;
      }
    }

    public function getPosts( $items ){
        $itemsArr         = array();
        $itemsArr         = json_decode($items, true);
        $results          = $itemsArr['data'];
        $results_children = $results['children'];

        //print_r($results_children);

        foreach($results_children as $result){
          $result_data = $result['data'];

          //print_r($result_data);

          $str = '<div class="feed-item">';
          $str .= '<h4><a class="reddit_link" href="'.$result_data['url'].'" target="_blank">'.$result_data['title'].'</a></h4>';
          $str .= '<span class="reddit_points" style="margin-right:10px;"><b>'.$result_data['score'].' points </b></span>';
          $str .= '<a style="color:gray;" href="#" class="reddit_comments">'.$result_data['num_comments'].' comments </a>';
          $str .= '<span class="reddit_subreddit" style="margin-right:10px;color:#6baec2">'.$result_data['subreddit'].'</span>';
          $str .= '</div>';

          echo $str;
        }
    }
}



class Dribbble extends Helpers {

    // http://api.ihackernews.com/page?format=jsonp&callback=hnJSON

    private $ch;

    public function __construct() {
      $modified_time  = $this->modifiedTime();

      if (!$modified_time) {

        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);

      } else {
        //Do nothing
      }
    }

    public function getJSON( $limit ) {

      $modified_time  = $this->modifiedTime();
      if (!$modified_time) {

        if (is_null($limit)) $limit = 5;

          $url = "http://api.dribbble.com/shots/popular?per_page=".$limit;
          curl_setopt($this->ch, CURLOPT_URL, $url);
          $output = curl_exec($this->ch);
          return $output;

      } else {
        //Do nothing
      }
    }


    public function writeJSON( $items, $limit ) {
      $modified_time  = $this->modifiedTime();

      if (!$modified_time) {
        $json_file  = $GLOBALS['json_url_dribbble'];
        $file       = file_get_contents($json_file);
        unset($file); //prevent memory leaks for large json.


        $items_d  = json_decode($items, true);
        $item     = $items_d['shots'];
        
        //print_r($item);

        $itemsArr = array();
        for($i = 0; $i < $limit; $i++) {  
          $itemsArr[] = array(
            'url'               => $item[$i]['url'],
            'image_teaser_url'  => $item[$i]['image_teaser_url']
          );
        }

        file_put_contents($json_file,json_encode($itemsArr));
        unset($itemsArr);//release memory

      } else {
         // Do nothing
      }  
    }


    public function readJSON() {

      $json_string  = file_get_contents($GLOBALS['json_url_dribbble']);
      $json_array   = json_decode($json_string, true);

      foreach($json_array as $result){

          $str = '<div class="dribbble_shot">';
          $str .= '<a class="dribbble_url" href="'.$result['url'].'" target="_blank">';
          $str .= '<img class="dribbble_shot_thumb" src='.$result['image_teaser_url'].'>';
          $str .= '</a>';
          $str .= '</div>';

          echo $str;
      }
    }



    public function getShots( $items ){
      $modified_time  = $this->modifiedTime();

      if (!$modified_time) {

        $itemsArr         = array();
        $itemsArr         = json_decode($items, true);
        $results          = $itemsArr['shots'];

        foreach($results as $result){


          $str = '<div class="dribbble_shot">';
          $str .= '<a class="dribbble_url" href="'.$result['url'].'" target="_blank">';
          $str .= '<img class="dribbble_shot_thumb" src='.$result['image_teaser_url'].'>';
          $str .= '</a>';
          $str .= '</div>';

          echo $str;
        }
      } else {
        //Do nothing
      }
    }
}


class StackOverflow extends Helpers {

    // http://api.ihackernews.com/page?format=jsonp&callback=hnJSON

    private $ch;

    public function __construct() {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch,CURLOPT_ENCODING , "gzip");
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($this->ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1468.0 Safari/537.36');
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    }

    public function getJSON( $limit ) {
      if (is_null($limit)) $limit = 5;

      $url = "https://api.stackexchange.com/2.1/questions?pagesize=".$limit."&order=desc&sort=activity&site=stackoverflow&tagged=php";
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $output = curl_exec($this->ch);
        return $output;
    }



    public function writeJSON( $items, $limit ) {
      $modified_time  = $this->modifiedTime();

      if (!$modified_time) {
        $json_file  = $GLOBALS['json_url_stackoverflow'];
        $file       = file_get_contents($json_file);
        unset($file); //prevent memory leaks for large json.


        $items_d  = json_decode($items, true);
        $item     = $items_d['items'];
        
        //print_r($item);

        $itemsArr = array();
        for($i = 0; $i < $limit; $i++) {  
          $itemsArr[] = array(
            'link'              => $item[$i]['link'],
            'title'             => $item[$i]['title'],
            'score'             => $item[$i]['score'],
            'answer_count'      => $item[$i]['answer_count'],
            'is_answered'       => $item[$i]['is_answered'],
            'tags'              => $item[$i]['tags']
          );
        }

        file_put_contents($json_file,json_encode($itemsArr));
        unset($itemsArr);//release memory

      } else {
         // Do nothing
      }  
    }


    public function readJSON() {

      $json_string  = file_get_contents($GLOBALS['json_url_stackoverflow']);
      $json_array   = json_decode($json_string, true);

      foreach($json_array as $result){

          $tags     = implode(', ', $result['tags']);
          $answered = $result['is_answered'];
          $yesno    = '';

          if ($answered) {
            $yesno = '<span class="answered"><b>Answered</b></span>';
          } else {
            $yesno = '<span class="unanswered"><b>Unanswered</b></span>';
          }

          $str = '<div class="feed-item">';
          $str .= '<h4><a class="stackoverflow_url" href="'.$result['link'].'" target="_blank">'.$result['title'].'</a></h4>';
          $str .= '<span class="stackoverflow_tags" style="margin-right:10px;">'.$tags.'</span>';
          $str .= '<span class="stackoverflow_points" style="margin-right:10px;"><b>'.$result['score'].'</b> points</span>';
          $str .= '<a style="color:gray;" href="#" class="stackoverflow_answers"><b>'.$result['answer_count'].'</b> answers </a>';
          $str .= '<span style="display:block;" class="stackoverflow_answered" style="margin-right:10px;">'.$yesno.'</span>';
          $str .= '</div>';

          echo $str;
      }
    }



    public function getQuestions( $items ){
        $itemsArr     = array();
        $itemsArr     = json_decode($items, true);
        $results      = $itemsArr['items'];

        // var_dump($results);

        foreach($results as $result){

          $tags     = implode(', ', $result['tags']);
          $answered = $result['is_answered'];
          $yesno    = '';

          if ($answered) {
            $yesno = '<span class="answered"><b>Answered</b></span>';
          } else {
            $yesno = '<span class="unanswered"><b>Unanswered</b></span>';
          }

          $str = '<div class="feed-item">';
          $str .= '<h4><a class="stackoverflow_url" href="'.$result['link'].'" target="_blank">'.$result['title'].'</a></h4>';
          $str .= '<span class="stackoverflow_tags" style="margin-right:10px;">'.$tags.'</span>';
          $str .= '<span class="stackoverflow_points" style="margin-right:10px;"><b>'.$result['score'].'</b> points</span>';
          $str .= '<a style="color:gray;" href="#" class="stackoverflow_answers"><b>'.$result['answer_count'].'</b> answers </a>';
          $str .= '<span style="display:block;" class="stackoverflow_answered" style="margin-right:10px;">'.$yesno.'</span>';
          $str .= '</div>';

          echo $str;
        }
    }
}



?>