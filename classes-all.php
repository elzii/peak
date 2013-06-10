<?php /* Time Debugging */ $helpers->modifiedTimeDebugging(); ?>
        
<?php 

/* FEED-DEV
================================================== */

/* HACKERNEWS */
$hn_items =   $api_hackernews->getJSON();
              $api_hackernews->writeJSON( $hn_items, 5 );

/* REDDIT DEV */
$items =      $api_redditdev->getJSON('webdev+programming+javascript+jquery', 5);
              $api_redditdev->writeJSON( $GLOBALS['json_url_reddit'], $items, 5 );

/* GITHUB */
$repos =      $scraper_github->scrapeTrendingRepos('today');
              $scraper_github->writeJSON( $repos, 5);

/* NETTUTS */
$nt_articles =  $xml_nettuts->getXML('http://feeds.feedburner.com/nettuts-summary?fmt=xml'); 
                $xml_nettuts->writeJSON( $nt_articles, 5 );

/* STACKOVERFLOW */
$questions =  $api_stackoverflow->getJSON(5); 
              $api_stackoverflow->writeJSON( $questions, 5 );

/* MEDIUM */
$articles =   $scraper_medium->scrapeArticles(5);
              $scraper_medium->writeJSON( $articles, 5);

/* SVBTLE */
$sv_articles =   $scraper_svbtle->scrapeArticles();
                 $scraper_svbtle->writeJSON( $sv_articles, 5);



/* FEED-DESIGN
================================================== */

/* DRIBBBLE */
$shots =  $api_dribbble->getJSON(6);
          $api_dribbble->writeJSON( $shots, 6 ); 

/* SITEINSPIRE */
$si_thumbs  = $scraper_siteinspire->scrapeSites();
              $scraper_siteinspire->writeJSON( $si_thumbs, 6 );

/* AWWWARDS */
$wwws       = $scraper_awwwards->scrapeSites();
              $scraper_awwwards->writeJSON( $wwws, 6 );

/* DESIGNERNEWS */
$dn_stories = $scraper_designernews->scrapeStories(5);
              $scraper_designernews->writeJSON( $dn_stories, 5);

/* REDDIT DESIGN */
$items_design = $api_redditdesign->getJSON('web_design+design+design_critiques', 5);
                $api_redditdesign->writeJSON( $GLOBALS['json_url_redditdesign'], $items_design, 5 );




/* FEED-MEDIA
================================================== */

/* EZTV */
$eztv   =   $scraper_eztv->scrapeTorrents(); 
            $scraper_eztv->writeJSON( $eztv, 5 );

/* THE PIRATE BAY */
$tpb    =   $scraper_tpb->scrapeTorrents(); 
            $scraper_tpb->writeJSON( $tpb, 5 );

/* GO GO GST */
$gsts   =   $scraper_gogogst->scrapeGSTs(); 
            $scraper_gogogst->writeJSON( $gsts, 6 );

/* THEVERGE */
$verge_articles =   $xml_theverge->getXML('http://www.theverge.com/rss/index.xml'); 
                    $xml_theverge->writeJSON( $verge_articles, 5 );

/* VICE */
$vice_articles  =   $xml_vice->getXML('http://www.vice.com/rss'); 
                    $xml_vice->writeJSON( $vice_articles, 5 );

?>