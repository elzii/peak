<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';
  require_once 'XMLParser.php';

  $helpers              = new Helpers();

  $scraper_github       = new Github();
  $scraper_designernews = new DesignerNews();
  $scraper_siteinspire  = new SiteInspire();
  
  $api_hackernews       = new HackerNews();
  $api_redditdev        = new RedditDev();
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
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/oticons.css" rel="stylesheet">

    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

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
  <script src="js/jquery-1.9.1.min.js"></script>

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
              <li class="active"><a href="#">Dev</a></li>
              <li><a href="#about">Design</a></li>
              <li><a href="#contact">About</a></li>
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
        </div>
      </div>
    </div>

    <div class="loading"></div>

    <div id="content" class="container">


      <?php /* Time Debugging */ $helpers->modifiedTimeDebugging(); ?>


      <!-- ROW 1
      =================================================== -->
       <div class="row flex-row">
        <!-- *-====-* HACKERNEWS *-====-* -->
        <div id="hackernews" class="feed span4">
          <h2 class="hr">
            <img class="icn-header" src="img/icon-hackernews.png" alt="Hacker News">
            HackerNews
          </h2>
            <div class="feed-inner">
              <div class="feed-inner-wrap">
                
            <?php 
              $items =  $api_hackernews->getJSON();
                        $api_hackernews->writeJSON( $items, 5 );
                        $api_hackernews->readJSON();
                        //$api_hackernews->getPosts( $items );
            ?>
              </div>
            </div>
        </div>
        <!-- *-====-* DESIGNERNEWS *-====-* -->
        <div id="designernews" class="feed span4">
          <h2 class="hr">
            <img class="icn-header" src="img/icon-designernews.png" alt="Designer News">
            DesignerNews
          </h2>
            <div class="feed-inner">
              <div class="feed-inner-wrap">
                
            <?php 
              $stories =  $scraper_designernews->scrapeStories();
                          //$scraper_siteinspire->displaySites( $stories, 5 );
                          $scraper_designernews->writeJSON( $stories, 5);
                          $scraper_designernews->readJSON();
            ?>
              </div>
            </div>
        </div>
        <!-- *-====-* GITHUB *-====-* -->
        <div id="github" class="feed span4">
          <h2 class="hr">
            <img class="icn-header" src="img/icon-github.png" alt="Github">
            Github Repos
          </h2>
            <div class="feed-inner">
              <div class="feed-inner-wrap">
                
            <?php 
              $repos   =  $scraper_github->scrapeTrendingRepos('today');
                          //$scraper_github->displayTrendingRepos($repos);
                          $scraper_github->writeJSON( $repos, 5);
                          $scraper_github->readJSON();
            ?>
              </div>
            </div>
        </div>
      </div>


      <!-- ROW 2
      =================================================== -->
      <div class="row flex-row">
        <!-- *-====-* NETTUTS *-====-* -->
        <div id="nettuts" class="feed span4">
          <h2 class="hr">
            <img class="icn-header" src="img/icon-nettuts.png" alt="Nettuts">
            Nettuts
          </h2>
            <div class="feed-inner">
              <div class="feed-inner-wrap">
                
            <?php 
              $articles = $xml_nettuts->getXML('http://feeds.feedburner.com/nettuts-summary?fmt=xml'); 
                          //$xml_nettuts->displayFeed( $articles, 5 );
                          $xml_nettuts->writeJSON( $articles, 5 );
                          $xml_nettuts->readJSON();
            ?>
              </div>
            </div>
        </div>
        


      </div>





      <hr>
      <footer>
        <p>&copy; Alexander Zizzo 2013</p>
      </footer>

    </div> <!-- /container -->
   
    <!-- App -->
    <script src="js/app.js"></script>

  </body>
</html>
