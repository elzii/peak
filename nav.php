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
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Debugging <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a id="toggle-debug_time" class="debug-toggle" href="#">Time &amp; Cache Info</a></li>
                <li><a href="tests.php">Debugging Console</a></li>
                <li class="divider"></li>
                <li class="nav-header">Documentation</li>
                <li><a href="#">API</a></li>
                <li><a href="#">Examples</a></li>
              </ul>
            </li>
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

  