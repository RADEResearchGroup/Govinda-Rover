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
<script type="text/javascript" src="/js/chart.min.js"></script>
		<?php print display_print_page_wrapper_top();?>
			<div class="row">
				<div class="col-xm-12 col-md-12">
					<?php if (isset($_GET['view']) && $_GET['view'] != ''):?>
						<?php if($_GET['view'] == 'lingkungan'):?>
						<div class="col-md-8">
							<p class="text-center"><h4><?php print $text[106];?></h4></p>
							<hr>
							<div id="data">
								<script>
									var suhu = 0;
									var klmb = 0;
									var gas = 0;
									var waktu = '';
								</script>
							</div>
							<canvas id="lingkungan">
								
							</canvas>
							<button id="start-lingkungan" type="button" class="btn btn-outline btn-success"><?php print $text[108];?></button>
							<button id="stop-lingkungan" type="button" class="btn btn-outline btn-danger"><?php print $text[109];?></button>
						</div>
						<div class="col-md-4">
						<p class="text-center"><h4><?php print $text[110];?></h4></p>
							<hr>
							<p id="label-suhu" class="text-center text-warning">0 C</p>
							<hr>
							<p id="label-klmb" class="text-center text-primary">0 %</p>
							<hr>
							<p id="label-gas" class="text-center text-danger">0 %</p>
							<hr>
						</div>
						<script>							

							var randomScalingFactor = function(){ return 0};//return Math.round(Math.random()*100)};
							var lineChartDataLingkungan = {
								labels : ["-","-","-","-","-","-","-"],
								datasets : [
									{
										//suhu
										label: "<?php print $text[103];?>",
										fillColor : "rgba(224, 255, 0, 0)",
										strokeColor : "rgba(224, 255, 0, 1)",
										pointColor : "rgba(224, 255, 0, 1)",
										pointStrokeColor : "#fff",
										pointHighlightFill : "#fff",
										pointHighlightStroke : "rgba(220,220,220,1)",
										data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
									},
									{
										//kelembapan
										label: "<?php print $text[104];?>",
										fillColor : "rgba(151,187,205,0)",
										strokeColor : "rgba(151,187,205,1)",
										pointColor : "rgba(151,187,205,1)",
										pointStrokeColor : "#fff",
										pointHighlightFill : "#fff",
										pointHighlightStroke : "rgba(151,187,205,1)",
										data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
									},
									{
										//gas berbahaya
										label: "<?php print $text[105];?>",
										fillColor : "rgba(255, 0, 0, 0)",
										strokeColor : "rgba(255, 0, 0, 1)",
										pointColor : "rgba(255, 0, 0, 1)",
										pointStrokeColor : "#fff",
										pointHighlightFill : "#fff",
										pointHighlightStroke : "rgba(151,187,205,1)",
										data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
									}
								]

							}

						window.onload = function(){
							var ctx_lingkungan = document.getElementById("lingkungan").getContext("2d");
							window.myLingkungan = new Chart(ctx_lingkungan).Line(lineChartDataLingkungan, {
								responsive: true
							});
							var lingkunganVar;
							var lingkungan_is_on = 0;
							function timedLingkungan() {
								var loadUrl = "/control_graph.php?grafik=lingkungan";
										$("#data").html();
										$.get(
											loadUrl,
											{language: "php", version: 5},
											function(responseText){
												$("#data").html(responseText);
											},
											"html"
								);
								$('#label-suhu').html(<?php print '"' . $text[103] . ' " ';?> + suhu + ' C');
								$('#label-klmb').html(<?php print '"' . $text[104] . ' " ';?> + klmb + ' %');
								$('#label-gas').html(<?php print '"' . $text[115] . ' " ';?> + gas + ' %');
								// The values array passed into addData should be one for each dataset in the chart
								myLingkungan.addData([suhu, klmb, gas], waktu);
								// This new data will now animate at the end of the chart.
								myLingkungan.removeData();
								// The chart will remove the first point and animate other points into place
								lingkunganVar = setTimeout(function(){timedLingkungan()}, 1000);
							}

							function startLingkungan() {
								if (!lingkungan_is_on) {
									lingkungan_is_on = 1;
									timedLingkungan();
								}
							}

							function stopLingkungan() {
								clearTimeout(lingkunganVar);
								lingkungan_is_on = 0;
							}
							$('#start-lingkungan').click(function(){
									startLingkungan();
							});
							$('#stop-lingkungan').click(function(){
									stopLingkungan();
							});
						}

						</script>
						<?php elseif($_GET['view'] == 'system'):?>
						<div class="col-md-8">
							<p class="text-center"><h4><?php print $text[107];?></h4></p>
							<hr>
							<div id="data">
								<script>
									var cpu = 0;
									var mem = 0;
									var net = 0;
									var waktu = '';
								</script>
							</div>
							<canvas id="sistem">
								
							</canvas>
							<button id="start-sistem" type="button" class="btn btn-outline btn-success"><?php print $text[108];?></button>
							<button id="stop-sistem" type="button" class="btn btn-outline btn-danger"><?php print $text[109];?></button>
						</div>
						<div class="col-md-4">
						<p class="text-center"><h4><?php print $text[111];?></h4></p>
							<hr>
							<p id="label-cpu" class="text-center text-warning">0 %</p>
							<hr>
							<p id="label-ram" class="text-center text-primary">0 %</p>
							<hr>
							<p id="label-net" class="text-center text-danger">0 KBps</p>
							<hr>
						</div>
						<script>
							var randomScalingFactor = function(){ return 0};//return Math.round(Math.random()*100)};
							var lineChartDataSistem = {
								labels : ["-","-","-","-","-","-","-"],
								datasets : [
									{
										//cpu
										label: "<?php print $text[112];?>",
										fillColor : "rgba(224, 255, 0, 0)",
										strokeColor : "rgba(224, 255, 0, 1)",
										pointColor : "rgba(224, 255, 0, 1)",
										pointStrokeColor : "#fff",
										pointHighlightFill : "#fff",
										pointHighlightStroke : "rgba(220,220,220,1)",
										data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
									},
									{
										//ram
										label: "<?php print $text[113];?>",
										fillColor : "rgba(151,187,205,0)",
										strokeColor : "rgba(151,187,205,1)",
										pointColor : "rgba(151,187,205,1)",
										pointStrokeColor : "#fff",
										pointHighlightFill : "#fff",
										pointHighlightStroke : "rgba(151,187,205,1)",
										data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
									},
									{
										//net
										label: "<?php print $text[114];?>",
										fillColor : "rgba(255, 0, 0, 0)",
										strokeColor : "rgba(255, 0, 0, 1)",
										pointColor : "rgba(255, 0, 0, 1)",
										pointStrokeColor : "#fff",
										pointHighlightFill : "#fff",
										pointHighlightStroke : "rgba(151,187,205,1)",
										data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
									}
								]

							}

						window.onload = function(){
							var ctx_sistem = document.getElementById("sistem").getContext("2d");
							window.mySistem = new Chart(ctx_sistem).Line(lineChartDataSistem, {
								responsive: true
							});
							var sistemVar;
							var sistem_is_on = 0;
							function timedSistem() {
								var loadUrl = "/control_graph.php?grafik=sistem";
										$("#data").html();
										$.get(
											loadUrl,
											{language: "php", version: 5},
											function(responseText){
												$("#data").html(responseText);
											},
											"html"
								);
								$('#label-cpu').html('CPU ' + cpu + ' %');
								$('#label-ram').html('RAM ' + mem + ' %');
								$('#label-net').html('Net ' + net + ' KBps');
								// The values array passed into addData should be one for each dataset in the chart
								mySistem.addData([cpu, mem, net], waktu);
								// This new data will now animate at the end of the chart.
								mySistem.removeData();
								// The chart will remove the first point and animate other points into place
								sistemVar = setTimeout(function(){timedSistem()}, 1000);
							}

							function startSistem() {
								if (!sistem_is_on) {
									sistem_is_on = 1;
									timedSistem();
								}
							}

							function stopSistem () {
								clearTimeout(sistemVar);
								sistem_is_on = 0;
							}
							$('#start-sistem').click(function(){
									startSistem();
							});
							$('#stop-sistem').click(function(){
									stopSistem();
							});
						}

						</script>
						<?php endif;?>
					<?php endif;?>
				</div>
			</div>		
		<?php print display_print_page_wrapper_bottom();?>
<?php
	//Sertakan file footer
	require_once('include/footer.php');
?>