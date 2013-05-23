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






?>