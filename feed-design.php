<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';
  require_once 'XMLParser.php';

  $helpers              = new Helpers();

  $scraper_designernews = new DesignerNews();
  $scraper_siteinspire  = new SiteInspire();
  $scraper_awwwards     = new Awwwards();
  
  $api_dribbble         = new Dribbble();
  $api_redditdesign     = new Reddit();

?>
<!-- ROW 1
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

<!-- ROW 2
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
</div>


