<?php 

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
            $yesno = '<span class="answered">2</span>';
          } else {
            $yesno = '<span class="unanswered">?</span>';
          }

          $str = '<div class="feed-item">';
          $str .= '<h4>';
          $str .= $yesno;
          $str .= '<a class="stackoverflow_url" href="'.$result['link'].'" target="_blank">';
          $str .= $result['title'].'</a>';
          $str .= '</h4>';
          $str .= '<span class="stackoverflow_tags" style="margin-right:10px;">'.$tags.'</span>';
          // $str .= '<span class="stackoverflow_points" style="margin-right:10px;"><b>'.$result['score'].'</b> points</span>';
          $str .= '<a style="color:gray;" href="#" class="stackoverflow_answers"><b>'.$result['answer_count'].'</b> answers </a>';
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
            $yesno = '2';
          } else {
            $yesno = '?';
          }

          $str = '<div class="feed-item">';
          $str .= '<h4>';
          $str .= '<span class="stackoverflow_answered" style="padding-right:10px;">'.$yesno.' </span>';
          $str .= '<a class="stackoverflow_url" href="'.$result['link'].'" target="_blank">';
          $str .= $result['title'].'</a>';
          $str .= '</h4>';
          $str .= '<span class="stackoverflow_tags" style="margin-right:10px;">'.$tags.'</span>';
          $str .= '<span class="stackoverflow_points" style="margin-right:10px;"><b>'.$result['score'].'</b> points</span>';
          $str .= '<a style="color:gray;" href="#" class="stackoverflow_answers"><b>'.$result['answer_count'].'</b> answers </a>';
          $str .= '</div>';

          echo $str;
        }
    }
}

 ?>