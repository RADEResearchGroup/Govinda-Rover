<?php
require_once('lang.php');
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	
	<!-- Core Scripts - Include with every page -->
    <script src="/js/jquery-1.10.2.js"></script>
	<script src="/js/magic.js"></script>
	<script src="/js/jQueryRotate.js"></script>
	<script src="/js/jquery.easing.min.js"></script>

    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Dashboard -->
    <script src="/js/plugins/morris/raphael-2.1.0.min.js"></script>
    <!--<script src="js/plugins/morris/morris.js"></script>-->
	<script src="/js/video.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="/js/sb-admin.js"></script>	

    <title><?php print $title?></title>
	<link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
	
    <!-- Core CSS - Include with every page -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Dashboard -->
    <link href="/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="/css/plugins/timeline/timeline.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/blueimp-gallery.min.css">
	<link rel="stylesheet" href="/css/bootstrap-image-gallery.min.css">
	<link href="/css/video-js.css" rel="stylesheet" type="text/css">

    <!-- SB Admin CSS - Include with every page -->
    <link href="/css/sb-admin.css" rel="stylesheet">
	<link href="/css/toggle-switch.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
	<?php if(isset($_SESSION['id'])): ?>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><?php print $text[9];?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>Update Veri 1.0</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Kami dengan bangga mempersembahkan rilis versi 1 untuk Platform Govinda Rover. Klik disini untuk memperbaharui versi anda...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Batere Mekanik</strong>
                                        <span class="pull-right text-muted">70% Tersisa</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                            <span class="sr-only">70% Tersisa</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
						<li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Batere Komputer</strong>
                                        <span class="pull-right text-muted">90% Tersisa</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                            <span class="sr-only">90% Tersisa</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>	
                        <li class="divider"></li>						
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Sinyal WLAN</strong>
                                        <span class="pull-right text-muted">80% Kuat</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Kuat</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
						<li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Sinyal 3G</strong>
                                        <span class="pull-right text-muted">60% Kuat</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Kuat</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> <?php print $text[22];?></a>
                        </li>
                        <li class="divider"></li>
						<li><a id="shutdown" href="#"><i class="fa fa-exclamation-triangle"></i> <?php print $text[135];?></a>
                        </li>
						<li class="divider"></li>
						<li>
							<a href="/config.php?view=user"><i class="fa fa-language"></i> <?php print common_current_language();?></a>
                        </li>
						<li class="divider"></li>
                        <li><a href="/auth.php"><i class="fa fa-sign-out fa-fw"></i> <?php print $text[23];?></a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="/index.php"><i class="fa fa-dashboard fa-fw"></i> <?php print $text[10];?></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> <?php print $text[11];?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/grafik.php?view=lingkungan"><i class="fa fa-home"></i> <?php print $text[12];?></a>
                                </li>
                                <li>
                                    <a href="/grafik.php?view=system"><i class="fa fa-tasks"></i> <?php print $text[102];?></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-camera fa-fw"></i> <?php print $text[14];?><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="/media/foto"><i class="fa fa-picture-o"></i> <?php print $text[80];?></a>
								</li>	
								<li>
									<a href="/media/video"><i class="fa fa-video-camera"></i> <?php print $text[83];?></a>
								</li>	
							</ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> <?php print $text[15];?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#"><i class="fa fa-signal"></i> <?php print $text[119];?><span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="/config.php?view=set-wlan"><?php print $text[53];?></a>
										</li>
										<li>
											<a href="/config.php?view=pindai-wlan"><?php print $text[120];?></a>
										</li>
									</ul>	
                                </li>
								<!--<li>
                                    <a href="config.php?view=kamera"><?php print $text[70];?></a>
                                </li>
                                <li>
                                    <a href="config.php?view=wwan"><?php print $text[17];?></a>
                                </li>
                                <li>
                                    <a href="config.php?view=control"><?php print $text[18];?></a>
                                </li>
                                <li>
                                    <a href="config.php?view=system"><?php print $text[19];?></a>
                                </li>
                                <li>
                                    <a href="config.php?view=interface"><?php print $text[20];?></a>
                                </li>-->
                                <li >
                                    <a href="/config.php?view=user"><i class="fa fa-user"></i> <?php print $text[21];?></a>
                                </li>
								<li>
									<a href="/wizard"><i class="fa fa-magic"></i> Wizard </a>
								</li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
		<?php endif; ?>