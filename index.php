<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';

  $scraper_github       = new Github();
  $scraper_designernews = new DesignerNews();
  $api_hackernews       = new HackerNews();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Scraper</title>
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
                                   <link rel="shortcut icon" href="ico/favicon.png">
  
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
          <a class="brand" href="#">Scraper</a>
          <!-- <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
              <li class="dropdown">
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
              </li>
            </ul>
          </div> -->
          <!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <!-- <div class="hero-unit">
        <h1>Hello, world!</h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <p><a href="#" class="btn btn-primary btn-large">Learn more &raquo;</a></p>
      </div> -->

      <div class="row">


        <div id="hacker_news" class="span6">
          <h2 class="hr">HackerNews</h2>
          
          <?php 
            // write new JSON results to hackernews.json
            //$api_hackernews->writeJSON();
            $items =  $api_hackernews->getJSON();
                      $api_hackernews->getPosts( $items );
          ?>

        </div>
        <div id="designer_news" class="span6">
          <h2 class="hr">DesignerNews</h2>

          <?php 
              $stories =  $scraper_designernews->scrapeStories();
                          $scraper_designernews->displayStories($stories, 5);
          ?>

        </div>
      </div>


      <div class="row">
        
        <div id="github" class="span6">
          <h2 class="hr">Github Trending Repos</h2>
          <?php echo $scraper_github->scrapeTrendingRepos(''); ?>
        </div>

        <div id="r_webdev" class="span6">
          <h2 class="hr">/r/webdev</h2>
        </div>

      </div>



      <hr>

      <footer>
        <p>&copy; Scraper 2013</p>
      </footer>

    </div> <!-- /container -->
   
    <!-- App -->
    <script src="js/app.js"></script>

  </body>
</html>
