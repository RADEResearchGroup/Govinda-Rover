<?php
	//Start Sesi User
	require_once('include/common.php');	
	//Sertakan fungsi user
	require_once('include/user.php');
	//Sertakan file text antarmuka
	require_once('include/lang.php');
	//Sertakan fungsi updater.php
	require_once('include/updater.php');
	//Sertakan fungsi display.php
	require_once('include/display.php');
	
	//Cek status user
	user_check_login(0);
	//Set judul halaman
	$title = $text[24] . " | " . $text[3];
	//Sertakan file header
	require_once('include/header.php');

?>
<script src="/js/keypress/keypress.js"></script>
<script src="/js/key.js"></script>	
<script src="/js/rotate.js"></script>	
        <div id="page-wrapper">
                <?php if(isset($_SESSION['pesan'])){
					print display_print_message($_SESSION['pesan']);
					//Unset variable pesan setelah selesai digunakan
					unset($_SESSION['pesan']);
				} ?>
            <!-- /.row -->
            <div class="row padding-top-20">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-video-camera fa-fw"></i> <?php print $text[28];?>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        <?php print $text[29];?>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a id="ambil-foto" href="#"><?php print $text[30];?></a>
                                        </li>
										<li><a id="ambil-video" href="#"><?php print $text[97];?></a>
                                        </li>
										<li><a id="stop-video" href="#"><?php print $text[98];?></a>
                                        </li>
										<li class="divider"></li>
										<li><a id="lihat-foto" href="#"><?php print $text[64];?></a>
                                        </li>
                                        <li><a id="rotasi-kanan" href="#"><?php print $text[31];?></a>
                                        </li>
                                        <li><a id="rotasi-kiri" href="#"><?php print $text[32];?></a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a id="cam-matikan" href="#"><?php print $text[33];?></a>
										<li><a id="cam-nyalakan" href="#"><?php print $text[34];?></a>
										<li><a id="muat-ulang" href="#"><?php print $text[93];?></a>
										<li class="divider"></li>
										<li><a id="camera-editor" href="#"><?php print $text[140];?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="wireless-camera" class="loader-bg">
								
								<img id="cam-feed" src="/media/poster.jpg" class="cam"/>
							</div>
							<hr>
							
							<div id="panel-camera-editor" class="panel panel-default">
								<div id="form-kamera" class="panel-body">
									<div class="row">
										<div class="col-sm-3 col-md-3">
											<div class="form-group input-group">
												<label>Sharpness</label>
												<input id="sharpness" type="range" value="<?php print display_print_config_cam('sh');?>" name="sharpness" min="0" max="100">
											</div>
										</div>
										<div class="col-sm-3 col-md-3">
											<div class="form-group input-group">
												<label>Contrast</label>
												<input id="contrast" type="range" value="<?php print display_print_config_cam('co');?>" name="contrast" min="0" max="100">
											</div>
										</div>
										<div class="col-sm-3 col-md-3">
											<div class="form-group input-group">
												<label>Brightness</label>
												<input id="brightness" type="range" value="<?php print display_print_config_cam('br');?>" name="brightness" min="0" max="100">
											</div>
										</div>
										<div class="col-sm-3 col-md-3">
											<div class="form-group input-group">
												<label>Saturation</label>
												<input id="saturation" type="range" value="<?php print display_print_config_cam('sa');?>" name="saturation" min="0" max="100">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3 col-lg-3">
											<div class="form-group">
												<label>ISO</label>
												<select name="iso" id="iso" class="form-control">
													<option value="<?php print display_print_config_cam('iso');?>"><?php print display_print_config_cam('iso')?></option>
													<option value="100">100</option>
													<option value="200">200</option>
													<option value="300">300</option>
													<option value="400">400</option>
													<option value="500">500</option>
													<option value="600">600</option>
													<option value="700">700</option>
													<option value="800">800</option>
												</select>
											</div>
										</div>
										<div class="col-md-3 col-lg-3">
											<div class="form-group input-group">
												<label>Exposure Mode</label>
												<select name="em" id="em" class="form-control">
													  <option value="<?php print display_print_config_cam('em');?>"><?php print display_print_config_cam('em')?></option>
													  <option value="off">Off</option>
													  <option value="auto">Auto</option>
													  <option value="night">Night</option>
													  <option value="nightpreview">Nightpreview</option>
													  <option value="backlight">Backlight</option>
													  <option value="spotlight">Spotlight</option>
													  <option value="sports">Sports</option>
													  <option value="snow">Snow</option>
													  <option value="beach">Beach</option>
													  <option value="verylong">Verylong</option>
													  <option value="fixedfps">Fixedfps</option>
												</select>
											</div>
										</div>
										<div class="col-md-3 col-lg-3">
											<div class="form-group input-group">
												<label>White Balance</label>
												<select name="wb" id="wb" class="form-control">
													  <option value="<?php print display_print_config_cam('wb');?>"><?php print display_print_config_cam('wb')?></option>
													  <option value="off">Off</option>
													  <option value="auto">Auto</option>
													  <option value="night">Night</option>
													  <option value="nightpreview">Nightpreview</option>
													  <option value="backlight">Backlight</option>
													  <option value="spotlight">Spotlight</option>
													  <option value="sports">Sports</option>
													  <option value="snow">Snow</option>
													  <option value="beach">Beach</option>
													  <option value="verylong">Verylong</option>
													  <option value="fixedfps">Fixedfps</option>
												</select>
											</div>
										</div>
										<div class="col-md-3 col-lg-3">
											<div class="form-group input-group">
												<label>Image Effect</label>
												<select id="ie" name="ie" class="form-control">
												  <option value="<?php print display_print_config_cam('ie');?>"><?php print display_print_config_cam('ie')?></option>
												  <option value="none">None</option>
												  <option value="negative">Negative</option>
												  <option value="solarise">Solarise</option>
												  <option value="sketch">Sketch</option>
												  <option value="denoise">Denoise</option>
												  <option value="emboss">Emboss</option>
												  <option value="oilpaint">Oilpaint</option>
												  <option value="hatch">Hatch</option>
												  <option value="gpen">Gpen</option>
												  <option value="pastel">Pastel</option>
												  <option value="watercolour">Watercolour</option>
												  <option value="film">Film</option>
												  <option value="blur">Blur</option>
												  <option value="saturation">Saturation</option>
												  <option value="colourswap">Colourswap</option>
												  <option value="washedout">Washedout</option>
												  <option value="posterise">Posterise</option>
												  <option value="colourpoint">Colourpoint</option>
												  <option value="colourbalance">Colourbalance</option>
												  <option value="cartoon">Cartoon</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
							<i class="fa fa-cogs fa-fw"></i> <?php print $text[27];?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
										<div class="row">
											<div class="col-lg-4 col-lg-offset-4 margin-bottom-10">
												<button id="tombol-maju" type="button" class="btn btn-outline btn-warning tombol-width-200"><?php print $text[48];?></button>
											</div>
										</div>
										<div class="row row-centered margin-bottom-10">
												<div class="col-lg-4 row-centered">
													<button id="tombol-kiri" type="button" class="btn btn-outline btn-warning tombol-width-200"><?php print $text[49];?></button>
												</div>
												<div class="col-lg-4 row-centered">
													<div class="tombol-tengah">
													<button id="tombol-stop" type="button" class="btn btn-danger btn-circle btn-lg"><i class="fa fa-stop"></i></button>
													</div>
												</div>											
												<div class="col-lg-4 row-centered">
													<button id="tombol-kanan" type="button" class="btn btn-outline btn-warning tombol-width-200"><?php print $text[50];?></button>
												</div>									
										</div>
										<div class="row">
											<div class="col-lg-4 col-lg-offset-4 margin-bottom-10">
												<button id="tombol-mundur" type="button" class="btn btn-outline btn-warning tombol-width-200"><?php print $text[51];?></button>												
											</div>
										</div>
                                </div>
								<div class="col-lg-4">
										<!-- OUR FORM -->
								<form id="form-pwm" action="/control.php?pwm=w" method="POST">
									
									<!-- NAME -->
									<div id="name-group" class="form-group">
										<?php print $text[46];?>: <input type="range" value="<?php print display_print_status("pwm");?>" name="pwm" min="0" max="255">
										<!-- errors will go here -->
									</div>


									<button id="submit-pwm" type="submit" class="btn btn-success"><?php print $text[47];?> <span class="fa fa-arrow-right"></span></button>

								</form>
								</div>
                                <!-- /.col-lg-4 (nested) -->
                                <!--<div class="col-lg-8">
                                    <div id="morris-bar-chart"></div>
                                </div>-->
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->					
                    <!--<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i><?php //print $text[38];?>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        <?php //rint $text[29];?>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#"><?php //print $text[39];?></a>
                                        </li>
                                        <li id="menu-update-lingkungan"><a href="#"><?php //print $text[40];?></a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#"><?php //print $text[41];?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <!--<div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive loader-bg">
                                        <table id="tabel-lingkungan" class="table table-bordered table-hover table-striped">
											<?php //print display_get_lingkungan(); ?>

										</table>
                                    </div>
                                    <!-- /.table-responsive 
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <!--<div class="col-lg-8">
                                    <div id="morris-bar-chart"></div>
                                </div>-->
                                <!-- /.col-lg-8 (nested) 
                            </div>
                            <!-- /.row 
                        </div>-->
                        <!-- /.panel-body 
                    </div>-->
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-cogs fa-fw"></i> <?php print $text[56];?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form id="form-servo" action="/control.php?kamera=w" method="POST">
									
									<!-- SERVO X -->
									<div id="name-group" class="form-group">
										<?php print $text[58];?>: <input type="range" value="<?php print display_print_status("servoX");?>" name="servoX" min="1" max="180">
										<!-- errors will go here -->
									</div>
									<!-- SERVO Y -->
									<div id="name-group" class="form-group">
										<?php print $text[57];?>: <input type="range" value="<?php print display_print_status("servoY");?>" name="servoY" min="1" max="180">
										<!-- errors will go here -->
									</div>
									<div class="row row-centered margin-bottom-10">
												<div class="col-lg-4 row-centered">
													<button id="servo-reset" type="button" class="btn btn-outline btn-warning tombol-width-200"><i class="fa fa-undo"></i></button>
												</div>
												<div class="col-lg-4 row-centered">
													<button id="submit-servo" type="submit" class="btn btn-success"><?php print $text[47];?> <span class="fa fa-arrow-right"></span></button>
												</div>									
									</div>
							</form>
                            <!-- /#form-servo -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-cogs fa-fw"></i> <?php print $text[59];?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <label class="switch-light switch-ios">
								<input id="tombol-flash" type="checkbox" <?php print display_print_status('flash');?>>
								<span>
									<?php print $text[60];?>
									<span><?php print $text[63];?></span>
									<span><?php print $text[62];?></span>
								</span>

								<a class="btn btn-primary"></a>
							</label>
							 <label class="switch-light switch-ios">
								<input id="tombol-laser" type="checkbox" <?php print display_print_status('laser');?>>
								<span>
									<?php print $text[61];?>
									<span><?php print $text[63];?></span>
									<span><?php print $text[62];?></span>									
								</span>

								<a class="btn btn-primary"></a>
							</label>						
                            <!-- /#form-servo -->
                        </div>
                        <!-- /.panel-body -->
                    </div>					
                    <!-- /.panel -->					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> <?php print $text[26];?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-sitemap fa-fw"></i> Mekanik: 
                                    <span class="pull-right text-muted small"><em><?php print $_SESSION['dev'];?></em>
                                    </span>
                                </a>
				<div class="col-xs-12 margin-top-10">
			            <i class="fa fa-exclamation-triangle fa-fw"></i> Log: 
                                    <em id="pesan"></em>
				</div>
                            </div>
                            <!-- /.list-group -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->	
<?php
	//Sertakan file footer
	require_once('include/footer.php');
?>
