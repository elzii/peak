<?php 

/* Required Methods
================================================== */
require_once 'Helpers.php';
require_once 'lib/HTML5/Parser.php';

/* GITHUB
================================================== */

class Github extends Helpers {

	private $ch;

  public function __construct() {}

	public function scrapeTrendingRepos( $timeframe ){

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

  		// cURL
  		$this->ch 	= curl_init("https://github.com/explore/");
  					        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
  		$output 	  = curl_exec($this->ch);
  				  	      curl_close($this->ch);

  		// Check if it even exists
  		if(empty($output)) exit('Couldn\'t download the page');		

  		$dom = new DOMDocument();
  		$dom->loadHTML(str_ireplace(array("<br>", "<br />"), "",$output));

  		$xpath = new DOMXPath($dom);
  		 
  		// Find stuff
  		$classname="ranked-repositories context-loader-overlay";
  		$result = $xpath->query("
  				//ol[@class='$classname']/li/h3/a[1]/@href |
  				//ol[@class='$classname']/li/h3/a[1] |
  				//ol[@class='$classname']/li/h3/a[2]/@href |
  				//ol[@class='$classname']/li/h3/a[2] |
  				//ol[@class='$classname']/li/ul[@class='repo-stats']/li[@class='watchers']/a/@href |
  				//ol[@class='$classname']/li/ul[@class='repo-stats']/li[@class='watchers']/a |
  				//ol[@class='$classname']/li/ul[@class='repo-stats']/li[@class='forks']/a/@href |
  				//ol[@class='$classname']/li/ul[@class='repo-stats']/li[@class='forks']/a |
  				//ol[@class='$classname']/li/p
  			");

  		// Get all the data, store them into 1d array
  		$data = array();
  		if (!is_null($result)) {

  		  foreach ($result as $key => $element) {
  		    $nodes = $element->textContent;
  		    //$nodes = $element->nodeValue;

  		    $data[$key] = $nodes;

  		  }
  		}

      //var_dump($data);
  		return $repos = array_chunk($data, 9);

    } else {
      //Do nothing
    }
	}


	public function writeJSON( $items, $limit ) {
	  $modified_time 	= $this->modifiedTime();

	  if (!$modified_time) {  
      
        $json_file  = $GLOBALS['json_url_github'];
        $file       = file_get_contents($json_file);
        unset($file); //prevent memory leaks for large json.
        
        //print_r($items);

        $itemsArr = array();
        for($i = 0; $i < $limit; $i++) {  
          $itemsArr[] = array(
            'watchers'        => $items[$i][0],
            'url_watchers'    => $items[$i][1],
            'forks'      	  => $items[$i][2],
            'url_forks'       => $items[$i][3],
            'author'          => $items[$i][4],
            'url_author'      => $items[$i][5],
            'repo'      	  => $items[$i][6],
            'url_repo'        => $items[$i][7],
            'desc'            => $items[$i][8],
          );
        }

        file_put_contents($json_file,json_encode($itemsArr));
        unset($itemsArr);//release memory

      } else {
        //Do nothing
      }

    }


  public function readJSON() {

		$json_string 	= file_get_contents($GLOBALS['json_url_github']);
		$json_array 	= json_decode($json_string, true);

      foreach($json_array as $json_article) {

          $str = '<div class="feed-item">';
    			$str .= '<h4>';
    			$str .= '<a class="github_author" href="http://github.com'.$json_article['url_author'].'" target="_blank">'.$json_article['author'].'</a> / ';
        	$str .= '<a class="github_repo" href="http://github.com'.$json_article['url_repo'].'" target="_blank">'.$json_article['repo'].'</a>';
          $str .= '</h4>';
    			$str .= '<p class="github_description">'.$json_article['desc'].'</p>';
          $str .= '<a style="color:#1c1c1c;margin-right:10px;" href="http://github.com'.$json_article['url_watchers'].'" class="github_watchers"><b>'.$json_article['watchers'].'</b> watchers</a>';
          $str .= '<a style="color:gray;" href="http://github.com'.$json_article['url_forks'].'" class="github_forks"><b>'.$json_article['forks'].'</b> forks</a>';
    			$str .= '</div>';

    			echo $str;
      }
	}


	public function displayTrendingRepos( $reposArr ) {

    //var_dump($reposArr);

		for($i = 0; $i < 5; $i++) {
			$str = '<div class="feed-item">';
			$str .= '<h4>';
			$str .= '<a class="github_author" href="http://github.com'.$reposArr[$i][5].'" target="_blank">'.$reposArr[$i][4].'</a> / ';
  		$str .= '<a class="github_repo" href="http://github.com'.$reposArr[$i][7].'" target="_blank">'.$reposArr[$i][6].'</a>';
  		$str .= '</h4>';
			$str .= '<p class="github_description">'.$reposArr[$i][8].'</p>';
  		$str .= '<a style="color:#1c1c1c;margin-right:10px;" href="http://github.com'.$reposArr[$i][1].'" class="github_watchers"><b>'.$reposArr[$i][0].'</b> watchers</a>';
  		$str .= '<a style="color:gray;" href="http://github.com'.$reposArr[$i][3].'" class="github_forks"><b>'.$reposArr[$i][2].'</b> forks</a>';
			$str .= '</div>';

			echo $str;
		}

	}
}




/* DESIGNER NEWS
================================================== */

class DesignerNews extends Helpers {

	private $ch;

  public function __construct() {
  	
  }

	public function scrapeStories( $limit ){

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

  		// cURL
  		$this->ch 	= curl_init("https://news.layervault.com/stories");
  					        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  		$output 	  = curl_exec($this->ch);
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
  				'url' 		  => 	$storyArr[$i][1],
  				'title'  	  => 	$storyArr[$i][0],
  				'points'    => 	$storyArr[$i][2],
  				'time'      => 	$storyArr[$i][3],
  				'comments'  => 	$storyArr[$i][4]
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








/* Medium
================================================== */

class Medium extends Helpers {

  private $ch;

  public function __construct() {
    
  }

  public function scrapeArticles( $limit ){

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      // cURL
      $this->ch   = curl_init("https://medium.com/editors-picks/latest");
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
          //article[contains(concat(' ',@class,' '),' post-item ')
               and not(contains(concat(' ',@class,' '),' post-status '))]/a[2]/img/@src |
          //article[contains(concat(' ',@class,' '),' post-item ')
               and not(contains(concat(' ',@class,' '),' post-status '))]/h3[@class='post-item-title']/a/@href | 
          //article[contains(concat(' ',@class,' '),' post-item ')
               and not(contains(concat(' ',@class,' '),' post-status '))]/h3[@class='post-item-title']/a | 
          //article[contains(concat(' ',@class,' '),' post-item ')
               and not(contains(concat(' ',@class,' '),' post-status '))]/div[@class='post-item-meta']/a[@class='post-item-author'] |
          //article[contains(concat(' ',@class,' '),' post-item ')
               and not(contains(concat(' ',@class,' '),' post-status '))]/a[@class='post-item-snippet']/p
      ");

      // Get all the data, store them into 1d array
      $data = array();
      if (!is_null($result)) {

        foreach ($result as $key => $element) {
          $nodes = $element->nodeValue;

          $data[$key] = $nodes;

        }
      }
      
      //print_r($data);
      return $articles = array_chunk($data, $limit);


    } else {
      //Do nothing
    } 
  }

  public function writeJSON( $articlesArr, $limit ) {

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $file = file_get_contents($GLOBALS['json_url_medium']);
      $data = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $jsonArr = array();

      for($i = 0; $i < $limit; $i++) {

        $jsonArr[] = array(
          'avatar'    =>  $articlesArr[$i][0],
          'title'     =>  $articlesArr[$i][1],
          'url'       =>  'https://medium.com'.$articlesArr[$i][2],
          'author'    =>  $articlesArr[$i][3],
          'excerpt'   =>  $articlesArr[$i][4]
        );

      }

      file_put_contents('json/medium.json',json_encode($jsonArr));
      unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

  }

  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_medium']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div class="feed-item">';
          $str .= '<h4 style="clear:both;display:block;margin-bottom:4px;"><img class="medium_avatar" src="'.$result['avatar'].'"/><a class="medium_link" href="'.$result['url'].'" target="_blank">'.$result['title'].'</a></h4>';
          $str .= '<span class="medium_author" style="margin-right:10px;"><i>'.$result['author'].'</i> </span>';
          //$str .= '<p class="medium_excerpt"><b>'.$result['excerpt'].'</b> </span>';
          $str .= '</div>';

          echo $str;
      }
  }
}






class SiteInspire extends Helpers {

	private $ch;

  public function __construct() {
  }

  public function scrapeSites(){
    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $this->ch   = curl_init("http://www.siteinspire.com/");
                    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
      $output     = curl_exec($this->ch);
                    curl_close($this->ch);

    	// Check if it even exists
    	if(empty($output)) exit('Couldn\'t download the page');		

    	$dom = new DOMDocument();
    	libxml_use_internal_errors(true);
    	$dom->loadHTML($output);
    	libxml_clear_errors();
    	$xpath = new DOMXPath($dom);
    	

    	// Find stuff
    	$classname="thumbnail";
    	$result = $xpath->query("
    			//*[@id='grid']/div[@class='thumbnail']/div[1]/div[1]/a[1]/@href |
    			//*[@id='grid']/div[@class='thumbnail']/div[1]/div[1]/a[1]/img/@src");

    	// Get all the data, store them into 1d array
    	$data = array();
    	if (!is_null($result)) {

    	  foreach ($result as $key => $element) {
    	    $nodes = $element->nodeValue;

    	    $data[$key] = $nodes;

    	  }
    	}
    	return $stories = array_chunk($data, 2);

    } else {
      //Do nothing
    }
	}


  public function writeJSON( $imgArr, $limit ) {

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $file = file_get_contents($GLOBALS['json_url_siteinspire']);
      $data = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $jsonArr = array();

      for($i = 0; $i < $limit; $i++) {

        $jsonArr[] = array(
          'url'     =>  $imgArr[$i][0],
          'url_img' =>  $imgArr[$i][1]
        );

      }

      file_put_contents($GLOBALS['json_url_siteinspire'],json_encode($jsonArr));
      unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

  }

  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_siteinspire']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div class="siteinspire_thumb">';
          $str .= '<a class="siteinspire_url" href="http://www.siteinspire.com/'.$result['url'].'" target="_blank">';
          $str .= '<img src='.$result['url_img'].'>';
          $str .= '</a>';
          $str .= '</div>';

          echo $str;
      }
  }

}





class EZTV extends Helpers {

  private $ch;

  public function __construct() {
  }

  public function scrapeTorrents(){
    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $this->ch   = curl_init("http://eztv.it/");
                    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
      $output     = curl_exec($this->ch);
                    curl_close($this->ch);

      // Check if it even exists
      if(empty($output)) exit('Couldn\'t download the page');   

      $dom = new DOMDocument();
      libxml_use_internal_errors(true);
      $dom->loadHTML($output);
      libxml_clear_errors();
      $xpath = new DOMXPath($dom);
      

      // Find stuff
      $classname="thumbnail";
      $result = $xpath->query("
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[2]/a/@href |
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[2]/a/@title |
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[3]/a[1]/@href |
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[3]/a[3]/@href");

      // print_r($result);

      // Get all the data, store them into 1d array
      $data = array();
      if (!is_null($result)) {

        foreach ($result as $key => $element) {
          $nodes = $element->nodeValue;

          $data[$key] = $nodes;

        }
      }
      // print_r($data);
      // print_r(json_encode(array_chunk($data, 4));
      return $stories = array_chunk($data, 4);

    } else {
      //Do nothing
    }
  }


  public function writeJSON( $torrArr, $limit ) {

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $file = file_get_contents($GLOBALS['json_url_eztv']);
      $data = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $jsonArr = array();

      for($i = 0; $i < $limit; $i++) {

        
        
        $shortname =  preg_replace("/\([^)]+\)/", "", $torrArr[$i][1]);
                      preg_match("/\([^)]+\)/", $torrArr[$i][1], $size);

        $jsonArr[] = array(
          'url_eztv'      =>  $torrArr[$i][0],
          'name'          =>  $shortname,
          'size'          =>  $size,
          'url_mag'       =>  $torrArr[$i][2],
          'url_tpb'       =>  $torrArr[$i][3]
        );

      }

      file_put_contents($GLOBALS['json_url_eztv'],json_encode($jsonArr));
      unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

  }

  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_eztv']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div class="feed-item">';
          $str .= '<h4><a class="eztv_url" href="http://www.eztv.it/'.$result['url_eztv'].'" target="_blank">'.$result['name'].'</a></h4>';
          $str .= '<span style="margin-right:10px" class="eztv_size">'.$result['size'][0].'</span>';
          $str .= '<a style="margin-right:10px" href='.$result['url_mag'].' class="eztv_magnet"> Magnet </a>';
          $str .= '<a style="margin-right:10px" href='.$result['url_tpb'].' class="eztv_tpb"> Torrent</a>';
          $str .= '</div>';

          echo $str;
      }
  }

}











class Awwwards extends Helpers {

  private $ch;

  public function __construct() {
  }

  public function scrapeTorrents(){
    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $this->ch   = curl_init("http://assdd.it/");
                    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
      $output     = curl_exec($this->ch);
                    curl_close($this->ch);

      // Check if it even exists
      if(empty($output)) exit('Couldn\'t download the page');   

      $dom = new DOMDocument();
      libxml_use_internal_errors(true);
      $dom->loadHTML($output);
      libxml_clear_errors();
      $xpath = new DOMXPath($dom);
      

      // Find stuff
      $classname="thumbnail";
      $result = $xpath->query("
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[2]/a/@href |
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[2]/a/@title |
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[3]/a[1]/@href |
        /html/body/div[@id='header_holder']/*/table[@class='forum_header_border'][5]/tr[@class='forum_header_border']/td[3]/a[3]/@href");

      // print_r($result);

      // Get all the data, store them into 1d array
      $data = array();
      if (!is_null($result)) {

        foreach ($result as $key => $element) {
          $nodes = $element->nodeValue;

          $data[$key] = $nodes;

        }
      }
      // print_r($data);
      // print_r(json_encode(array_chunk($data, 4));
      return $stories = array_chunk($data, 4);

    } else {
      //Do nothing
    }
  }


  public function writeJSON( $torrArr, $limit ) {

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

      $file = file_get_contents($GLOBALS['json_url_awwwards']);
      $data = json_decode($file);
      unset($file); //prevent memory leaks for large json.

      $jsonArr = array();

      for($i = 0; $i < $limit; $i++) {

        
        
        $shortname =  preg_replace("/\([^)]+\)/", "", $torrArr[$i][1]);
                      preg_match("/\([^)]+\)/", $torrArr[$i][1], $size);

        $jsonArr[] = array(
          'url_eztv'      =>  $torrArr[$i][0],
          'name'          =>  $shortname,
          'size'          =>  $size,
          'url_mag'       =>  $torrArr[$i][2],
          'url_tpb'       =>  $torrArr[$i][3]
        );

      }

      file_put_contents($GLOBALS['json_url_awwwards'],json_encode($jsonArr));
      unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

  }

  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_awwwards']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div class="feed-item">';
          $str .= '<h4><a class="eztv_url" href="http://www.eztv.it/'.$result['url_eztv'].'" target="_blank">'.$result['name'].'</a></h4>';
          $str .= '<span style="margin-right:10px" class="eztv_size">'.$result['size'][0].'</span>';
          $str .= '<a style="margin-right:10px" href='.$result['url_mag'].' class="eztv_magnet"> Magnet </a>';
          $str .= '<a style="margin-right:10px" href='.$result['url_tpb'].' class="eztv_tpb"> Torrent</a>';
          $str .= '</div>';

          echo $str;
      }
  }

}







?>