<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';
  require_once 'XMLParser.php';
  require_once 'Config.php';

  $helpers              = new Helpers();

  $scraper_github       = new Github();
  $scraper_designernews = new DesignerNews();
  $scraper_siteinspire  = new SiteInspire();
  $scraper_awwwards     = new Awwwards();
  $scraper_medium       = new Medium();
  $scraper_svbtle       = new Svbtle();
  $scraper_eztv         = new EZTV();
  $scraper_tpb          = new TPB();
  $scraper_gogogst      = new GoGoGST();
  
  $api_hackernews       = new HackerNews();
  $api_redditdev        = new Reddit();
  $api_redditdesign     = new Reddit();
  $api_dribbble         = new Dribbble();
  $api_stackoverflow    = new StackOverflow();
  $xml_theverge         = new TheVerge();
  $xml_vice             = new Vice();

  $xml_nettuts          = new Envato(); 

?>
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




<!-- ROW 1
=================================================== -->
 <div class="row flex-row">
  <!-- *-====-* HACKERNEWS *-====-* -->
  <div id="hackernews" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-hackernews.png" alt="Hacker News">
      HackerNews
    </h2>
      <div class="feed-inner">
        <?php $api_hackernews->readJSON(); ?>
      </div>
  </div>
  <!-- *-====-* REDDIT *-====-* -->
  <div id="reddit" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-reddit.png" alt="Hacker News">
      Dev Subreddits
    </h2>
      <div class="feed-inner">
        <?php $api_redditdev->readJSON($GLOBALS['json_url_reddit']); ?>
      </div>
  </div>
  <!-- *-====-* GITHUB *-====-* -->
  <div id="github" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-github.png" alt="Github">
      Github Repos
    </h2>
      <div class="feed-inner">
        <?php $scraper_github->readJSON(); ?>
      </div>
  </div>
</div>


<!-- ROW 2
=================================================== -->
<div class="row flex-row">

  <!-- *-====-* NETTUTS *-====-* -->
  <div id="nettuts" class="envato feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-nettuts.png" alt="Nettuts">
      Nettuts
    </h2>
      <div class="feed-inner">
        <?php $xml_nettuts->readJSON(); ?>
      </div>
  </div>
  <!-- *-====-* STACKOVERFLOW *-====-* -->
  <div id="stackoverflow" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-stackoverflow.png" alt="Stack Overflow">
      Stack Overflow
    </h2>
    <div class="feed-inner">
      <?php $api_stackoverflow->readJSON(); ?>
    </div>
  </div>
  <!-- *-====-* SVBTLE *-====-* -->
  <div id="svbtle" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-svbtle.png" alt="Medium">
      Svbtle
    </h2>
      <div class="feed-inner">              
        <?php $scraper_svbtle->readJSON(); ?>
      </div>
  </div>

</div>



<!-- ROW 3
=================================================== -->
 <div class="row flex-row">
  <!-- *-====-* DRIBBBLE *-====-* -->
   <div id="dribbble" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-dribbble-alt.png" alt="Dribbble">
      Dribbble Shots
    </h2>
    <div class="feed-inner">
        <?php 
           
                    $api_dribbble->readJSON(); 
        ?>
    </div>
  </div>
  <!-- *-====-* SITEINSPIRE *-====-* -->
   <div id="siteinspire" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-siteinspire.png" alt="SiteInspire">
      SiteInspire Sites
    </h2>
    <div class="feed-inner">
        <?php 
          
                        $scraper_siteinspire->readJSON(); 
        ?>
    </div>
  </div>
  <!-- *-====-* AWWWARDS *-====-* -->
   <div id="awwwards" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-awwwards.png" alt="Awwwards">
      Awwwards
    </h2>
    <div class="feed-inner">
        <?php 
          
                        $scraper_awwwards->readJSON(); 
        ?>
    </div>
  </div>
</div>





<!-- ROW 4
=================================================== -->
<div class="row flex-row">
  <!-- *-====-* DESIGNERNEWS *-====-* -->
  <div id="designernews" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-designernews.png" alt="Designer News">
      DesignerNews
    </h2>
      <div class="feed-inner">

        <?php 
          
                        $scraper_designernews->readJSON();
        ?>
      </div>
  </div>
  <!-- *-====-* REDDIT DESIGN *-====-* -->
  <div id="reddit-design" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-reddit.png" alt="Hacker News">
      Design Subreddits
    </h2>
      <div class="feed-inner">
        <?php 
          
                          $api_redditdesign->readJSON($GLOBALS['json_url_redditdesign']); ?>
      </div>
  </div>

  <!-- *-====-* MEDIUM *-====-* -->
  <div id="medium" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-medium.png" alt="Medium">
      Medium
    </h2>
      <div class="feed-inner">              
        <?php $scraper_medium->readJSON(); ?>
      </div>
  </div>
</div>



<!-- ROW 5
=================================================== -->
 <div class="row flex-row">
  <!-- *-====-* EZTV *-====-* -->
  <div id="eztv" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-eztv.png" alt="EZTV">
      EZTV
    </h2>
      <div class="feed-inner">
        <?php 
         
                    $scraper_eztv->readJSON();
        ?>
      </div>
  </div>

  <!-- *-====-* TPB *-====-* -->
  <div id="tpb" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-tpb.png" alt="TPB">
      TPB Top 5
    </h2>
      <div class="feed-inner">
        <?php 
          
                    $scraper_tpb->readJSON();
        ?>
      </div>
  </div>

  <!-- *-====-* GOGO GST *-====-* -->
  <div id="gogogst" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-gogogst.png" alt="GOGO GST">
      GoGo Game Soundtracks
    </h2>
      <div class="feed-inner">

        <?php 
          
                    $scraper_gogogst->readJSON();
        ?>
      </div>
  </div>

</div>


<!-- ROW 6
====================================================== -->
<div class="row flex-row">
  <!-- *-====-* THEVERGE *-====-* -->
  <div id="theverge" class="theverge feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-theverge.png" alt="Nettuts">
      The Verge
    </h2>
      <div class="feed-inner">
        <?php 
          
                              $xml_theverge->readJSON(); 
        ?>
      </div>
  </div>

  <!-- *-====-* VICE *-====-* -->
  <div id="vice" class="vice feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-vice.png" alt="Nettuts">
      Vice Magazine
    </h2>
      <div class="feed-inner">
        <?php 
          
                            $xml_vice->readJSON(); 
        ?>
      </div>
  </div>
</div>








