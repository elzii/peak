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

          $str = '<div style="margin-bottom:30px;">';
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
			$str = '<div style="margin-bottom:30px;">';
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

	public function scrapeStories(){

    $modified_time  = $this->modifiedTime();

    if (!$modified_time) { 

  		// cURL
  		$this->ch 	= curl_init("https://news.layervault.com/");
  					        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
  		$output 	  = curl_exec($this->ch);
  				  	      curl_close($this->ch);

  		// Check if it even exists
  		if(empty($output)) exit('Couldn\'t download the page');		

  		$dom = new DOMDocument();
  		$dom->loadHTML($output);
  		$xpath = new DOMXPath($dom);
  		 
  		// Find stuff
  		$classname="Story";
  		$result = $xpath->query("
  				//li[@class='$classname']/a[@class='StoryUrl'] |
  				//li[@class='$classname']/a[@class='StoryUrl']/@href|//td[@class='name'] |
  				//li[@class='$classname']/*/span[@class='PointCount'] |
  				//li[@class='$classname']/*/span[@class='Timeago'] | 
  				//li[@class='$classname']/*/a[@class='CommentCount']
  			");

  		// Get all the data, store them into 1d array
  		$data = array();
  		if (!is_null($result)) {

  		  foreach ($result as $key => $element) {
  		    $nodes = $element->nodeValue;

  		    $data[$key] = $nodes;

  		  }
  		}
  		
  		return $stories = array_chunk($data, 5);

    } else {
      //Do nothing
    } 
	}

	public function displayStories( $storyArr, $limit ) {

		for($i = 0; $i < $limit; $i++) {
			$str = '<div style="margin-bottom:30px;">';
			$str .= '<h4><a class="designernews_link" href="'.$storyArr[$i][1].'" target="_blank">'.$storyArr[$i][0].'</a></h4>';
			$str .= '<span class="designernews_points" style="margin-right:10px;"><b>'.$storyArr[$i][2].'</b> </span>';
			$str .= '<span class="designernews_comments" style="margin-right:10px;"><i>'.$storyArr[$i][3].'</i> </span>';
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

  		file_put_contents('json/designernews.json',json_encode($jsonArr));
  		unset($jsonArr);//release memory

    } else {
      //Do nothing
    }

	}


  public function readJSON() {

    $json_string  = file_get_contents($GLOBALS['json_url_designernews']);
    $json_array   = json_decode($json_string, true);

      foreach($json_array as $result) {

          $str = '<div style="margin-bottom:30px;">';
          $str .= '<h4><a class="designernews_link" href="'.$result['url'].'" target="_blank">'.$result['title'].'</a></h4>';
          $str .= '<span class="designernews_points" style="margin-right:10px;"><b>'.$result['points'].'</b> </span>';
          $str .= '<span class="designernews_comments" style="margin-right:10px;"><i>'.$result['time'].'</i> </span>';
          $str .= '<a style="color:gray;" href="#" class="designernews_comments"><b>'.$result['comments'].'</b> </a>';
          $str .= '</div>';

          echo $str;
      }
  }
}




class SiteInspire {

	private $ch;

    public function __construct() {
		// cURL
    }

	public function scrapeSites(){
		$this->ch 	= curl_init("http://www.siteinspire.com/");
					  curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$output 	= curl_exec($this->ch);
				  	  curl_close($this->ch);

		// Check if it even exists
		if(empty($output)) exit('Couldn\'t download the page');		

		$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML($output);
		libxml_clear_errors();
		$xpath = new DOMXPath($dom);
		
		// Use HTML5Parser

		// Find stuff
		$classname="thumbnail";
		$result = $xpath->query("

				//li[@class='$classname']/div[@class='wrapper']/div[@class='image']/a |
				//li[@class='$classname']/div[@class='wrapper']/div[@class='image']/a/img
			");

		// Get all the data, store them into 1d array
		$data = array();
		if (!is_null($result)) {

		  foreach ($result as $key => $element) {
		    $nodes = $element->nodeValue;

		    $data[$key] = $nodes;

		  }
		}
		
		return $stories = array_chunk($data, 2);
		
	}

	public function displaySites( $storyArr, $limit ) {

		return $storyArr;

		// for($i = 0; $i < $limit; $i++) {
		// 	$str = '<div style="margin-bottom:30px;">';
		// 	$str .= '<h4><a class="designernews_link" href="'.$storyArr[$i][1].'" target="_blank">'.$storyArr[$i][0].'</a></h4>';
		// 	$str .= '<span class="designernews_points" style="margin-right:10px;"><b>'.$storyArr[$i][2].'</b> </span>';
		// 	$str .= '<span class="designernews_comments" style="margin-right:10px;"><i>'.$storyArr[$i][3].'</i> </span>';
		// 	$str .= '<a style="color:gray;" href="#" class="designernews_comments"><b>'.$storyArr[$i][4].'</b> </a>';
		// 	$str .= '</div>';

		// 	echo $str;
		// }
	}
}



?>