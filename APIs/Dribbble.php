<?php 

class Dribbble extends Helpers {

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

          $str = '<div class="thumb">';
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

 ?>