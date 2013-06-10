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

  