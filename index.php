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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Peak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- styles -->
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

  <!-- Google Analytics -->
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-41401809-1', 'pagodabox.com');
    ga('send', 'pageview');
  </script>

  </head>
<body>
  
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">
            Peak
          </a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a class="feed-loader" id="fl-all" href="#all">All</a></li>
              <li><a class="feed-loader" id="fl-dev" href="#dev">Dev</a></li>
              <li><a class="feed-loader" id="fl-design" href="#design">Design</a></li>
              <li><a class="feed-loader" id="fl-media" href="#media">Media / Tech</a></li>
              <li><a id="toggle-debug_time" class="debug-toggle" href="#">Debug</a></li>
              <!-- <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li> -->
            </ul>
          </div> 
          <!--/.nav-collapse -->
          <div class="navbar-progress-wrap">
            <div id="progress-refresh" class="progress">
              <div class="bar" style="width: <?php $helpers->timeElapsedPercent(); ?>%;">
                <span><?php $helpers->timeTilRefresh(); ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="loading"></div>

    <div id="content" class="container">


      <?php /* Time Debugging */ $helpers->modifiedTimeDebugging(); ?>
        
      

      <div id="feed"></div>


    </div> <!-- /container -->


<!--     <div class="container">
      <hr>
      <footer>
        <p>&copy; Alexander Zizzo 2013</p>
      </footer>
    </div> -->

  </body>
</html>
