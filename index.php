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

<?php include 'header.php'; ?>
  
<?php include 'nav.php' ?>

  <div id="content" class="container">

      <?php /* Time Debugging */ $helpers->modifiedTimeDebugging(); ?>
        
      <?php include 'classes-all.php'; ?>

      <div id="feed"></div>


  </div> <!-- /container -->



  </body>
</html>
