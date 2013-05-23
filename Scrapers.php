<?php 


class Github {

	private $ch;

    public function __construct() {}

	public function scrapeTrendingRepos( $timeframe ){

		// cURL
		$this->ch 	= curl_init("https://github.com/explore/");
					  curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$output 	= curl_exec($this->ch);
				  	  curl_close($this->ch);

		// Check if it even exists
		if(empty($output)) exit('Couldn\'t download the page');		

		$dom = new DOMDocument();
		$dom->loadHTML($output);
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
		    $nodes = $element->nodeValue;

		    $data[$key] = $nodes;

		  }
		}

    //var_dump($data);
    //return $data;
		return $repos = array_chunk($data, 9);
	}

	public function displayTrendingRepos( $reposArr ) {

    //var_dump($reposArr);

		for($i = 0; $i < 5; $i++) {
			$str = '<div style="margin-bottom:30px;">';
			$str .= '<h4>';
			  $str .= '<a class="github_author" href="http://github.com'.$reposArr[$i][5].'" target="_blank">'.$reposArr[$i][4].'</a>';
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


class DesignerNews {

	private $ch;

    public function __construct() {
    	
    }

	public function scrapeStories(){

		// cURL
		$this->ch 	= curl_init("https://news.layervault.com/");
					  curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$output 	= curl_exec($this->ch);
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
}






?>