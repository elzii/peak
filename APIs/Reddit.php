<?php 

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
      $modified_time  = $this->modifiedTime();

      if (!$modified_time) {
        $url = "http://www.reddit.com/r/".$subreddits."/.json?limit=".$limit;
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $output = curl_exec($this->ch);
        return $output;

      } else {
         // Do nothing
      }  
    }

    public function writeJSON( $jsonfile, $items, $limit ) {
      $modified_time  = $this->modifiedTime();

      if (!$modified_time) {
        $json_file  = $jsonfile;
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
            'subreddit'     => $items[$i]['data']['subreddit'],
            'permalink'     => 'http://reddit.com'.$items[$i]['data']['permalink']
          );
        }

        file_put_contents($json_file,json_encode($itemsArr));
        unset($itemsArr);//release memory

      } else {
         // Do nothing
      }  
    }


    public function readJSON( $jsonfile ) {

      $json_array  = file_get_contents($jsonfile);
      $php_array   = json_decode($json_array, true);

      foreach($php_array as $result){

          $str = '<div class="feed-item">';
          $str .= '<h4><a class="reddit_link" href="'.$result['url'].'" target="_blank">'.$result['title'].'</a></h4>';
          $str .= '<span class="reddit_points" style="margin-right:10px;"><b>'.$result['score'].' points </b></span>';
          $str .= '<a style="color:gray;margin-right:10px;" href="'.$result['permalink'].'" target="_blank" class="reddit_comments">'.$result['num_comments'].' comments </a>';
          $str .= '<span class="reddit_subreddit" style="margin-right:10px;">'.$result['subreddit'].'</span>';
          $str .= '</div>';

          echo $str;
      }
    }

}


 ?>