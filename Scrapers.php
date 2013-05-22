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


?>