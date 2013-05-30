<?php 

/* Required Methods
================================================== */
require_once 'Helpers.php';


class Envato extends Helpers {

	public function __construct() {
        
    }

	public function getXML($feed_url) {
		$modified_time 	= $this->modifiedTime();

		if (!$modified_time) {

			$content 	= file_get_contents($feed_url);
			$x 			= new SimpleXmlElement($content);
			$item 		= $x->channel->item;

			return $item;

		} else {
			// Do nothing - not enough time has passed.
		}
	}

    public function writeXMLtoJSON( $php_array, $json_file, $limit, $params ) {
		$file		= $json_file;
		$file 		= file_get_contents($file);
		unset($file); //prevent memory leaks for large json.

		for($i = 0; $i < $limit; $i++) {	
			$items[] = $params;
		}

		file_put_contents($file,json_encode($items));
		unset($items);//release memory
	}

	public function displayFeed( $articles, $limit ) {

		foreach($articles as $article) {
			$str = '<div style="margin-bottom:30px;">';
			$str .= '<h4><a class="xmlfeed_link" href="'.$article->link.'" target="_blank">'.$article->title.'</a></h4>';
			$str .= '<p class="xmlfeed_desc">'.$article->description.'</p>';
			$str .= '<span class="xmlfeed_date" style="margin-right:10px;"><i>'.$article->pubDate.'</i></span>';
			$str .= '</div>';

			echo $str;
		}
	}

	public function writeJSON( $articles, $limit ) {
		$modified_time 	= $this->modifiedTime();

		if (!$modified_time) {


			$json_file	= $GLOBALS['json_url_nettuts'];
			$file 		= file_get_contents($json_file);
			$data 		= json_decode($file);
			unset($file); //prevent memory leaks for large json.

			$articlesArr = array();

			for($i = 0; $i < $limit; $i++) {	
				$articlesArr[] = array(
					'link' 		=> $articles[$i]->link,
					'title' 	=> $articles[$i]->title,
					'desc' 		=> $articles[$i]->description,
					//'desc' 		=> substr($articles[$i]->description, 0, 100),
					'pubDate' 	=> $articles[$i]->pubDate
				);
			}

			file_put_contents($json_file,json_encode($articlesArr));
			unset($articlesArr);//release memory
			
		} else {
			// Do nothing - not enough time has passed.
		}



	}
 
	public function readJSON() {

		$json_string 	= file_get_contents($GLOBALS['json_url_nettuts']);
		$json_array 	= json_decode($json_string, true);

        foreach($json_array as $json_article) {

            $str = '<div style="margin-bottom:30px;">';
			$str .= '<h4><a class="xmlfeed_link" href="'.$json_article['link'][0].'" target="_blank">'.$json_article['title'][0].'</a></h4>';
			$str .= '<p class="xmlfeed_desc">'.$json_article['desc'][0].'</p>';
			$str .= '<span class="xmlfeed_date" style="margin-right:10px;"><i>'.$json_article['pubDate'][0].'</i></span>';
			$str .= '</div>';

			echo $str;
        }

	}
} 










// class Medium extends Helpers {

// 	public function __construct() {
        
//     }

// 	public function getXML($feed) {
// 		$modified_time 	= $this->modifiedTime();

// 		if (!$modified_time) {

// 			$content 	= file_get_contents("https://medium.com/feed/".$feed);
// 			$x 			= new SimpleXmlElement($content);
// 			$item 		= $x->channel->item;

// 			return $item;

// 		} else {
// 			// Do nothing - not enough time has passed.
// 		}
// 	}


// 	public function writeJSON( $articles, $limit ) {
// 		$modified_time 	= $this->modifiedTime();

// 		if (!$modified_time) {

// 			$json_file	= $GLOBALS['json_url_medium'];
// 			$file 		= file_get_contents($json_file);
// 			$data 		= json_decode($file);
// 			unset($file); //prevent memory leaks for large json.

// 			$articlesArr = array();

// 			for($i = 0; $i < $limit; $i++) {	

// 				$article_desc = simplexml_load_string($articles[$i]->description);
// 				$article_desc = simplexml_load_string($articles[$i]->description);

// 				$articlesArr[] = array(
// 					'link' 		=> $articles[$i]->link,
// 					'title' 	=> $articles[$i]->title,
// 					'desc' 		=> (string) trim(),
// 					'pubDate' 	=> $articles[$i]->pubDate
// 				);
// 			}

// 			file_put_contents($json_file,json_encode($articlesArr));
// 			unset($articlesArr);//release memory
			
// 		} else {
// 			// Do nothing - not enough time has passed.
// 		}
// 	}
 
// 	public function readJSON() {

// 		$json_string 	= file_get_contents($GLOBALS['json_url_medium']);
// 		$json_array 	= json_decode($json_string, true);

//         foreach($json_array as $json_article) {

//             $str = '<div style="margin-bottom:30px;">';
// 			$str .= '<h4><a class="xmlfeed_link" href="'.$json_article['link'][0].'" target="_blank">'.$json_article['title'][0].'</a></h4>';
// 			$str .= '<p class="xmlfeed_desc">'.$json_article['desc'][0].'</p>';
// 			$str .= '<span class="xmlfeed_date" style="margin-right:10px;"><i>'.$json_article['pubDate'][0].'</i></span>';
// 			$str .= '</div>';

// 			echo $str;
//         }

// 	}
// } 

?>