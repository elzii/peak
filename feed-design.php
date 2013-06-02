<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';
  require_once 'XMLParser.php';

  $helpers              = new Helpers();

  $scraper_designernews = new DesignerNews();
  
  $api_dribbble         = new Dribbble();


?>
<!-- ROW 1
=================================================== -->
 <div class="row flex-row">
  <!-- *-====-* DESIGNERNEWS *-====-* -->
  <div id="designernews" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="img/icon-designernews.png" alt="Designer News">
      DesignerNews
    </h2>
      <div class="feed-inner">

        <?php 
          // $stories =    $scraper_designernews->scrapeStories();
          //               $scraper_designernews->displayStories($stories, 5);

          $scraper_designernews->readJSON();
        ?>
      </div>
  </div>
  <!-- *-====-* DRIBBBLE *-====-* -->
   <div id="dribbble" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="img/icon-dribbble-alt.png" alt="Dribbble">
      Dribbble Shots
    </h2>
    <div class="feed-inner">
      <div class="dribbble_shots">
        <?php $api_dribbble->readJSON(); ?>
      </div>
    </div>
</div>


