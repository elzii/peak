<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';
  require_once 'XMLParser.php';

  $helpers              = new Helpers();

  $scraper_eztv         = new EZTV();

?>
<!-- ROW 1
=================================================== -->
 <div class="row flex-row">
  <!-- *-====-* DESIGNERNEWS *-====-* -->
  <div id="eztv" class="feed span4">
    <h2 class="hr">
      <img class="icn-header" src="img/icon-eztv.png" alt="Designer News">
      EZTV
    </h2>
      <div class="feed-inner">

        <?php 
          $eztv   = $scraper_eztv->scrapeTorrents(); 
                    $scraper_eztv->writeJSON( $eztv, 5 );
                    $scraper_eztv->readJSON(); 
        ?>
      </div>
  </div>
</div>




