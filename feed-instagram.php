<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';
  require_once 'XMLParser.php';

  $helpers              = new Helpers();

  $scraper_ig           = new Instagram();


?>
<!-- ROW 1
=================================================== -->
 <div class="row flex-row">
  <!-- *-====-* Instagram *-====-* -->
  <div id="instagram" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="assets/img/icon-eztv.png" alt="Instagram">
      Instagram
    </h2>
      <div class="feed-inner">
        <?php 
         
                    $scraper_ig->readJSON();
        ?>
      </div>
  </div>


</div>

