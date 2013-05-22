<h1>Github Test</h1>

<?php 
	require_once 'Scrapers.php';
	$scraper_github = new Github();
?>


<?php echo $scraper_github->scrapeTrendingRepos(''); ?>