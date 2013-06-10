<?php 
  require_once 'Scrapers.php'; 
  require_once 'APIs.php';
  require_once 'XMLParser.php';

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


<div id="debug-subnav">

  <div class="container">
    <ul class="nav nav-tabs">
      <li class="nav-label">Debug Subnav</li>
      <li><a href="#debug-json_viewer">JSON Viewer</a></li>
      <li><a href="#debug-json_merge">JSON Merge Array</a></li>
    </ul>
  </div>

</div>


<div id="content" class="debug container">


  <?php include 'classes-all.php'; ?>



  <!-- JSON Viewer 
  ================================================= -->
  <div id="debug-json_viewer" class="row debug-row flex-row">
    <div class="row-content">
      <header class="span12" style="">
        <h1 class="header-title" style="float:left;margin:0;line-height:1;">View JSON File Contents</h1>

        <!-- value must match json filename without extension -->
        <select style="margin-bottom:15px;float:right" name="json_files" id="json-files">
          <option value="hackernews">Hacker News</option>
          <option value="reddit">Reddit</option>
          <option value="github">Github</option>
          <option value="nettuts">Nettuts</option>
          <option value="stackoverflow">Stack Overflow</option>
          <option value="svbtle">Svbtle</option>
          <option value="dribbble">Dribbble</option>
          <option value="siteinspire">Site Inspire</option>
          <option value="awwwards">Awwwards</option>
          <option value="designernews">Designer News</option>
          <option value="redditdesign">Reddit Design</option>
          <option value="medium">Medium</option>
          <option value="eztv">EZTV</option>
          <option value="tpb">TPB</option>
          <option value="gogogst">GoGoGST</option>
          <option value="theverge">The Verge</option>
          <option value="vice">Vice</option>
        </select>
      </header>
      
      <div id="json_viewer" class="span12">
        <pre class="json_viewer_str" style="display:none;"></pre>
        <div class="json_viewer_pp" style="width:100%"></div>
      </div>
    </div>
  </div>


  <!-- JSON Merge 
  ================================================= -->
  <div id="debug-json_merge" -class="row debug-row flex-row">
    <div class="row-content">
    
    <h1 class="header-title">JSONMerge()</h1>
    
    <pre>
      <?php echo $helpers->JSONMerge(); ?>
    </pre>
  
    </div>
  </div>

  


</div> <!-- /#content.debug -->


  </body>
</html>
