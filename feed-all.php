<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';
  require_once 'XMLParser.php';
  require_once 'Config.php';

  $helpers              = new Helpers();

  // Scrapers
  $scraper_github       = new Github();
  $scraper_designernews = new DesignerNews();
  $scraper_siteinspire  = new SiteInspire();
  $scraper_awwwards     = new Awwwards();
  $scraper_medium       = new Medium();
  $scraper_svbtle       = new Svbtle();
  $scraper_eztv         = new EZTV();
  $scraper_tpb          = new TPB();
  $scraper_gogogst      = new GoGoGST();
  $scraper_ig           = new Instagram();
  
  // JSON APIs
  $api_hackernews       = new HackerNews();
  $api_redditdev        = new Reddit();
  $api_redditdesign     = new Reddit();
  $api_dribbble         = new Dribbble();
  $api_stackoverflow    = new StackOverflow();
  
  // XML
  $xml_theverge         = new TheVerge();
  $xml_vice             = new Vice();
  $xml_nettuts          = new Envato(); 

?>




 <div class="row flex-row">
  <!-- *-====-* HACKERNEWS *-====-* -->
  <div id="hackernews" class="feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-hackernews.png" alt="Hacker News"> HackerNews </h2>
      <div class="feed-inner">
        <?php 
        /**
         * HackerNews
         * -----------------------
         * @since Peak 1.0
         * @author Alexander Zizzo

         */
        $hn_items =   $api_hackernews->getJSON();
                      $api_hackernews->writeJSON( $hn_items, 5 );
                      $api_hackernews->readJSON(); 
        ?>
      </div>
  </div>
  <!-- *-====-* REDDIT *-====-* -->
  <div id="reddit" class="feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-reddit.png" alt="Hacker News"> Dev Subreddits </h2>
      <div class="feed-inner">
        <?php 
        /**
         * Reddit Dev
         * -----------------------
         * @since Peak 1.0
         * @author Alexander Zizzo

         */
        $items =  $api_redditdev->getJSON('webdev+programming+javascript+jquery', 5);
                  $api_redditdev->writeJSON( $GLOBALS['json_url_reddit'], $items, 5 );
                  $api_redditdev->readJSON($GLOBALS['json_url_reddit']); 
        ?>
      </div>
  </div>
  <!-- *-====-* GITHUB *-====-* -->
  <div id="github" class="feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-github.png" alt="Github"> Github Repos </h2>
      <div class="feed-inner">
        <?php 
        /**
         * GitHub Trending
         * -----------------------
         * @since Peak 1.0
         * @author Alexander Zizzo

         */
        $repos =  $scraper_github->scrapeTrendingRepos('today');
                  $scraper_github->writeJSON( $repos, 5);
                  $scraper_github->readJSON(); ?>
      </div>
  </div>
</div>










<div class="row flex-row">

  <!-- *-====-* NETTUTS *-====-* -->
  <div id="nettuts" class="envato feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-nettuts.png" alt="Nettuts"> Nettuts </h2>
      <div class="feed-inner">
        <?php 
        /**
         * NetTuts
         * -----------------------
         * @since Peak 1.0
         * @author Alexander Zizzo

         */
        $nt_articles =  $xml_nettuts->getXML('http://feeds.feedburner.com/nettuts-summary?fmt=xml'); 
                        $xml_nettuts->writeJSON( $nt_articles, 5 );
                        $xml_nettuts->readJSON(); ?>
      </div>
  </div>
  <!-- *-====-* STACKOVERFLOW *-====-* -->
  <div id="stackoverflow" class="feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-stackoverflow.png" alt="Stack Overflow"> Stack Overflow </h2>
    <div class="feed-inner">
      <?php 
      /**
       * StackOverflow
       * -----------------------
       * @since Peak 1.0
       * @author Alexander Zizzo

       */
      $questions =  $api_stackoverflow->getJSON(5); 
                    $api_stackoverflow->writeJSON( $questions, 5 );
                    $api_stackoverflow->readJSON(); ?>
    </div>
  </div>
  <!-- *-====-* VICE *-====-* -->
  <div id="vice" class="vice feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-vice.png" alt="Nettuts"> Vice Magazine </h2>
      <div class="feed-inner">
        <?php 
        /**
         * Vice
         * -----------------------
         * @since Peak 1.0
         * @author Alexander Zizzo

         */
          $vice_articles  =   $xml_vice->getXML('http://www.vice.com/rss'); 
                              $xml_vice->writeJSON( $vice_articles, 5 );
                              $xml_vice->readJSON();  ?>
      </div>
  </div>
  
</div><!-- .row -->







<div class="row flex-row">
  <!-- *-====-* REDDIT DESIGN *-====-* -->
  <div id="reddit-design" class="feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-reddit.png" alt="Hacker News"> Design Subreddits </h2>
      <div class="feed-inner">
        <?php 
        /**
         * Reddit Design
         * -----------------------
         * @since Peak 1.0
         * @author Alexander Zizzo

         */
        $items_design = $api_redditdesign->getJSON('web_design+design+design_critiques', 5);
                        $api_redditdesign->writeJSON( $GLOBALS['json_url_redditdesign'], $items_design, 5 );
                        $api_redditdesign->readJSON($GLOBALS['json_url_redditdesign']); ?> </div>
  </div>
  <!-- *-====-* SITEINSPIRE *-====-* -->
   <div id="siteinspire" class="feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-siteinspire.png" alt="SiteInspire"> SiteInspire Sites </h2>
    <div class="feed-inner">
        <?php 
        /**
         * SiteInspire
         * -----------------------
         * @since Peak 1.0
         * @author Alexander Zizzo

         */
          $si_thumbs  = $scraper_siteinspire->scrapeSites();
                        $scraper_siteinspire->writeJSON( $si_thumbs, 6 );
                        $scraper_siteinspire->readJSON();  ?>
    </div>
  </div>
  <!-- *-====-* DRIBBBLE *-====-* -->
   <div id="dribbble" class="feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-dribbble-alt.png" alt="Dribbble"> Dribbble Shots </h2>
    <div class="feed-inner">
        <?php 
        /**
         * Dribbble
         * -----------------------
         * @since Peak 1.2
         * @author Alexander Zizzo

         */
        $shots =  $api_dribbble->getJSON(6);
                  $api_dribbble->writeJSON( $shots, 6 ); 
                  $api_dribbble->readJSON(); ?>
    </div>
  </div>
</div>



<!-- ROW 5
=================================================== -->
 <div class="row flex-row">
  <!-- *-====-* EZTV *-====-* -->
  <div id="eztv" class="feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-eztv.png" alt="EZTV"> EZTV </h2>
      <div class="feed-inner">
        <?php 
        /**
         * EZTV
         * -----------------------
         * @since Peak 1.0
         * @author Alexander Zizzo

         */
        $eztv =   $scraper_eztv->scrapeTorrents(); 
                  $scraper_eztv->writeJSON( $eztv, 5 );
                  $scraper_eztv->readJSON(); ?>
      </div>
  </div>
  <!-- *-====-* TPB *-====-* -->
  <div id="tpb" class="feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-tpb.png" alt="TPB"> TPB Top 5 </h2>
      <div class="feed-inner">
        <?php 
        /**
         * The Pirate Bay
         * -----------------------
         * @since Peak 1.0
         * @author Alexander Zizzo

         */
         $tpb =   $scraper_tpb->scrapeTorrents(); 
                  $scraper_tpb->writeJSON( $tpb, 5 ); 
                  $scraper_tpb->readJSON(); ?>
      </div>
  </div>
  <!-- *-====-* THEVERGE *-====-* -->
  <div id="theverge" class="theverge feed span4">
    <h2 class="hr"><img class="icn-header" src="assets/img/icon-theverge.png" alt="Nettuts"> The Verge </h2>
      <div class="feed-inner">
        <?php 
        /**
         * The Verge
         * -----------------------
         * @since Peak 1.0
         * @author Alexander Zizzo

         */
        $verge_articles =   $xml_theverge->getXML('http://www.theverge.com/rss/index.xml'); 
                            $xml_theverge->writeJSON( $verge_articles, 5 );
                            $xml_theverge->readJSON();  ?>
      </div>
  </div>

  

</div><!-- .row -->



































<?php 
  /**
   * 


   * U N U S E D  U N U S E D  U N U S E D  U N U S E D  U N U S E D  U N U S E D  U N U S E D  


   */
 ?>
<!-- *-====-* GOGO GST *-====-* -->
<!--   <div id="gogogst" class="feed span4">
    <h2 class="hr"> <img class="icn-header" src="assets/img/icon-gogogst.png" alt="GOGO GST"> GoGo Game Soundtracks </h2>
      <div class="feed-inner">
        <?php 
        //$gsts   =   $scraper_gogogst->scrapeGSTs(); 
                    //$scraper_gogogst->writeJSON( $gsts, 6 );
                    //$scraper_gogogst->readJSON(); ?>
      </div>
  </div> -->

  <!-- *-====-* INSTAGRAM *-====-* -->
  <!-- <div id="instagram" class="feed span4">
    <h2 class="hr"><img src="assets/img/icon-instagram.png" alt="" class="icn-header"> Instagram </h2>
    <div class="feed-inner">
      <?php
        /**
         * Instagram
         * -----------------------
         * @since Peak 1.0
         * @author Alexander Zizzo

         */
        //$ig   =     $scraper_ig->scrapeThumbs('lziz'); 
                    //$scraper_ig->writeJSON( $ig, 5 ); 
                    //$scraper_ig->readJSON(); ?>
    </div>
  </div> -->
  
<?php 
  /**
   * 


   * B R O K E N   B R O K E N   B R O K E N   B R O K E N   B R O K E N   B R O K E N   B R O K E N


   */
 ?>
<!-- *-====-* SVBTLE *-====-* -->
<!--   <div id="svbtle" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-svbtle.png" alt="Medium">
      Svbtle
    </h2>
      <div class="feed-inner">              
        <?php 
          //$sv_articles =    $scraper_svbtle->scrapeArticles();
                            //$scraper_svbtle->writeJSON( $sv_articles, 5);
                            //$scraper_svbtle->readJSON(); ?>
      </div>
  </div> -->

  <!-- *-====-* MEDIUM *-====-* -->
<!--   <div id="medium" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-medium.png" alt="Medium">
      Medium
    </h2>
      <div class="feed-inner">              
        <?php 
          //$articles =   $scraper_medium->scrapeArticles(5);
                        //$scraper_medium->writeJSON( $articles, 5);
                        //$scraper_medium->readJSON(); ?>
      </div>
  </div> -->

  <!-- *-====-* AWWWARDS *-====-* -->
<!--    <div id="awwwards" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-awwwards.png" alt="Awwwards">
      Awwwards
    </h2>
    <div class="feed-inner">
        <?php 
        //$wwws       = $scraper_awwwards->scrapeSites();
                      //$scraper_awwwards->writeJSON( $wwws, 6 );
                      //$scraper_awwwards->readJSON();  ?>
    </div>
  </div> -->

  <!-- *-====-* DESIGNERNEWS *-====-* -->
  <!-- <div id="designernews" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-designernews.png" alt="Designer News">
      DesignerNews
    </h2>
      <div class="feed-inner">

        <?php 
          //$dn_stories = $scraper_designernews->scrapeStories(5);
                        //$scraper_designernews->writeJSON( $dn_stories, 5);
                        //$scraper_designernews->readJSON(); ?>
      </div>
  </div> -->
