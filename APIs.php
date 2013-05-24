<?php 


class HackerNews {

	  // http://api.ihackernews.com/page?format=jsonp&callback=hnJSON

    private $ch;

    public function __construct() {
		    $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    }

    public function getJSON() {
    	$url = "http://api.thriftdb.com/api.hnsearch.com/items/_search?pretty_print=true&filter[fields][create_ts]=[NOW-5HOURS%20TO%20NOW]&filter[queries][]=points:[2+TO+*]&limit=5&start=0";
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $output = curl_exec($this->ch);
        return $output;
    }

    public function writeJSON() {
    	$url = "http://api.thriftdb.com/api.hnsearch.com/items/_search?pretty_print=true&filter[fields][create_ts]=[NOW-5HOURS%20TO%20NOW]&filter[queries][]=points:[2+TO+*]&limit=5&start=0";
        curl_setopt($this->ch, CURLOPT_URL, $url);

    	$fp = fopen('json/hackernews.json', "w");
       	curl_setopt($this->ch, CURLOPT_FILE, $fp);

       	$output = curl_exec($this->ch);

		fwrite($fp, $output);

		fclose($fp);
    }

    public function getPosts( $items ){
    	  $itemsArr   = array();
        $itemsArr   = json_decode($items, true);
        $results    = $itemsArr['results'];

        foreach($results as $result){
          $result_item = $result['item'];

          $str = '<div style="margin-bottom:30px;">';
          $str .= '<h4><a class="hackernews_link" href="'.$result_item['url'].'" target="_blank">'.$result_item['title'].'</a></h4>';
          $str .= '<span class="hackernews_points" style="margin-right:10px;"><b>'.$result_item['points'].' points </b></span>';
          $str .= '<a style="color:gray;" href="#" class="hackernews_comments">'.$result_item['num_comments'].' comments </a>';
          $str .= '</div>';

          echo $str;
        }
    }
}



class RedditDev {

    // http://api.ihackernews.com/page?format=jsonp&callback=hnJSON

    private $ch;

    public function __construct() {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    }

    public function getJSON( $limit ) {
      $url = "http://www.reddit.com/r/webdev/.json?limit=".$limit;
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $output = curl_exec($this->ch);
        return $output;
    }

    public function writeJSON() {
      $url = "http://www.reddit.com/r/webdev/.json";
        curl_setopt($this->ch, CURLOPT_URL, $url);

      $fp = fopen('json/hackernews.json', "w");
        curl_setopt($this->ch, CURLOPT_FILE, $fp);

        $output = curl_exec($this->ch);

    fwrite($fp, $output);

    fclose($fp);
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

          $str = '<div style="margin-bottom:30px;">';
          $str .= '<h4><a class="hackernews_link" href="'.$result_data['url'].'" target="_blank">'.$result_data['title'].'</a></h4>';
          $str .= '<span class="hackernews_points" style="margin-right:10px;"><b>'.$result_data['score'].' points </b></span>';
          $str .= '<a style="color:gray;" href="#" class="hackernews_comments">'.$result_data['num_comments'].' comments </a>';
          $str .= '</div>';

          echo $str;
        }
    }
}



class Dribbble {

    // http://api.ihackernews.com/page?format=jsonp&callback=hnJSON

    private $ch;

    public function __construct() {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    }

    public function getJSON( $limit ) {
      if (is_null($limit)) $limit = 5;

      $url = "http://api.dribbble.com/shots/popular?per_page=".$limit;
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $output = curl_exec($this->ch);
        return $output;
    }

    public function getShots( $items ){
        $itemsArr         = array();
        $itemsArr         = json_decode($items, true);
        $results          = $itemsArr['shots'];

        foreach($results as $result){


          $str = '<div class="dribbble_shot">';
          $str .= '<a class="dribbble_url" href="'.$result['url'].'" target="_blank">';
            $str .= '<img class="dribbble_shot_thumb" src='.$result['image_teaser_url'].'>';
          $str .= '</a>';
          // $str .= '<span class="hackernews_points" style="margin-right:10px;"><b>'.$result_data['score'].' points </b></span>';
          // $str .= '<a style="color:gray;" href="#" class="hackernews_comments">'.$result_data['num_comments'].' comments </a>';
          $str .= '</div>';

          echo $str;
        }
    }
}



class StackOverflow {

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

      $url = "https://api.stackexchange.com/2.1/questions?pagesize=".$limit."&order=desc&sort=activity&site=stackoverflow";
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $output = curl_exec($this->ch);
        return $output;
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
            $yesno = '<span class="answered">Answered</span>';
          } else {
            $yesno = '<span class="unanswered">No Answers</span>';
          }

          $str = '<div class="stackoverflow_shot">';
          $str .= '<h4><a class="stackoverflow_url" href="'.$result['link'].'" target="_blank">'.$result['title'].'</a></h4>';
          $str .= '<span class="stackoverflow_answered" style="margin-right:10px;">'.$yesno.'</span>';
          $str .= '<span class="stackoverflow_tags" style="margin-right:10px;">'.$tags.'</span>';
          $str .= '<span class="stackoverflow_points" style="margin-right:10px;"><b>'.$result['score'].' points </b></span>';
          $str .= '<a style="color:gray;" href="#" class="stackoverflow_answers">'.$result['answer_count'].' answers </a>';
          $str .= '</div>';

          echo $str;
        }
    }
}





?>