<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';
  require_once 'XMLParser.php';

  $helpers              = new Helpers();

  $scraper_github       = new Github();
  $scraper_designernews = new DesignerNews();
  $scraper_siteinspire  = new SiteInspire();
  $scraper_medium       = new Medium();
  
  $api_hackernews       = new HackerNews();
  $api_dribbble         = new Dribbble();
  $api_stackoverflow    = new StackOverflow();

  $xml_nettuts          = new Envato();          

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Peak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/oticons.css" rel="stylesheet">

    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="img/favicon.png">
  
  <!-- jQuery -->
  <script src="assets/js/jquery-1.9.1.min.js"></script>
  <!-- Vendor JS -->
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/midway.min.js"></script>
  <!-- App -->
  <script src="assets/js/app.js"></script>

 
  </head>
<body>


    <div id="content" class="container">


      <?php /* Time Debugging */ $helpers->modifiedTimeDebugging(); ?>
        
      <?php 

      /* HACKERNEWS */
      // $hn_items =   $api_hackernews->getJSON();
      //               $api_hackernews->writeJSON( $hn_items, 5 );

      // /* REDDIT */
      // $items =      $api_redditdev->getJSON(5);
      //               $api_redditdev->writeJSON( $items, 5 );
      
      // /* GITHUB */
      // $repos =      $scraper_github->scrapeTrendingRepos('today');
      //               $scraper_github->writeJSON( $repos, 5);

      // /* NETTUTS */
      // $nt_articles =  $xml_nettuts->getXML('http://feeds.feedburner.com/nettuts-summary?fmt=xml'); 
      //                 $xml_nettuts->writeJSON( $nt_articles, 5 );

      // /* STACKOVERFLOW */
      // $questions =  $api_stackoverflow->getJSON(5); 
      //               $api_stackoverflow->writeJSON( $questions, 5 );

      // /* MEDIUM */
      // $articles =   $scraper_medium->scrapeArticles(5);
      //               $scraper_medium->writeJSON( $articles, 5);

      // /* DRIBBBLE */
      // $shots =      $api_dribbble->getJSON(6);
      //               $api_dribbble->writeJSON( $shots, 6 );    

      // /* DESIGNERNEWS */
      // $dn_stories = $scraper_designernews->scrapeStories(5);
      //               $scraper_designernews->writeJSON( $dn_stories, 5);

      // /* SITEINSPIRE */
      // $si_thumbs  = $scraper_siteinspire->scrapeSites();
      //               $scraper_siteinspire->writeJSON( $si_thumbs, 6 );

    ?>

    <h1>View JSON file contents</h1>

    <select name="json_files" id="json-files">
      <option value="hackernews">hackernews</option>
      <option value="github">github</option>
      <option value="medium">medium</option>
      <option value="designernews">designernews</option>
      <option value="dribbble">dribbble</option>
      <option value="nettuts">nettuts</option>
      <option value="siteinspire">siteinspire</option>
      <option value="stackoverflow">stackoverflow</option>
    </select>
    
    

    <br><br>

    <pre id="test"></pre>
  
    <script>
      jQuery(document).ready(function($) {

        $("select#json-files").change(function () {
          var str = "";
          $("select option:selected").each(function () {
            str += "assets/json/" + $(this).text() + ".json";
          });

          //$("pre#test").text(str);

          $("pre#test").load(str, function() {
              
          });
        })
        .trigger('change');

      });
    </script>







    <?php $helpers->JSONMerge(); ?>

  




    </div> <!-- /container -->


  </body>
</html>
