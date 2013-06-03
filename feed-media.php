<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';
  require_once 'XMLParser.php';

  $helpers              = new Helpers();

  $scraper_eztv         = new EZTV();
  $scraper_tpb          = new TPB();
  $scraper_gogogst      = new GoGoGST();

  $xml_theverge         = new TheVerge();
  $xml_vice             = new Vice();

?>
<!-- ROW 1
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


<!-- ROW 2
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




