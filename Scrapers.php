<?php 


/* Pull entire page
================================================== */
// $ch = curl_init("https://github.com/explore");
// curl_setopt($ch, CURLOPT_HEADER, 0);
// $curlResponse = curl_exec($ch);
// curl_close($ch);

/* Selective
================================================== */
// cURL

class Github {

	private $ch;

    public function __construct() {}

	public function scrapeTrendingRepos( $sort ){
		$timeframe = '';

		if ( $sort === NULL || is_null($sort) ) {
			$timeframe = '';
		} else {
			$timeframe = $sort;
		}

		// cURL
		$this->ch 	= curl_init("https://github.com/explore/".$timeframe);
					  curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$output 	= curl_exec($this->ch);
				  	  curl_close($this->ch);

		// Check if it even exists
		if(empty($output)) exit('Couldn\'t download the page');

		// Find explore <ol>
		$pattern = '/<ol class="ranked-repositories context-loader-overlay">(([^.]|.)*?)<\/ol>/';

		preg_match_all($pattern, $output, $matches);

		$match_str = '<ul>'.($matches[1][0]).'</ul>';
		return $match_str;


	}
}


class DesignerNews {

	private $ch;

    public function __construct() {}

	public function scrapeStories(){

		// cURL
		$this->ch 	= curl_init("https://news.layervault.com/");
					  curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		$output 	= curl_exec($this->ch);
				  	  curl_close($this->ch);

		// Check if it even exists
		if(empty($output)) exit('Couldn\'t download the page');

		// Find explore <ol>
		// $pattern = '/<ol>(.*)<\/ol>/isU';

		// preg_match_all($pattern, $output, $matches);

		// if (preg_match_all($pattern, $output, $matches)) {
		// 	$match_str = '<ul>'.($matches[1][0]).'</ul>';
		// 	return $match_str;
		// } else {
		// 	return 'No matches';
		// }
		

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