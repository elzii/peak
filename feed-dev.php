<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';
  require_once 'XMLParser.php';

  $helpers              = new Helpers();

  $scraper_github       = new Github();
  $scraper_medium       = new Medium();
  $scraper_svbtle       = new Svbtle();
  
  $api_hackernews       = new HackerNews();
  $api_redditdev        = new Reddit();
  $api_stackoverflow    = new StackOverflow();

  $xml_nettuts          = new Envato();

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
  <!-- <div id="stackoverflow" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-stackoverflow.png" alt="Stack Overflow">
      Stack Overflow
    </h2>
    <div class="feed-inner">
      <?php //$api_stackoverflow->readJSON(); ?>
    </div>
  </div> -->
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
