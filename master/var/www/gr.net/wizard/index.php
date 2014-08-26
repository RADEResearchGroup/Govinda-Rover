<?php
	//Start Sesi User
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/common.php');	
	//Sertakan fungsi user
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/user.php');
	//Sertakan file text antarmuka
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/lang.php');
	//Sertakan fungsi updater.php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/updater.php');
	//Sertakan fungsi display.php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/display.php');
	
	//Cek status user
	//user_check_login(0);
	if(user_check_wizard() || user_check_login(1)) :
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Govinda Rover Setup Wizard</title>
    <!-- Bootstrap -->
    <link href="/wizard/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
	<script src="/js/jquery-1.10.2.js"></script>
    <script src="/wizard/bootstrap/js/bootstrap.min.js"></script>
	<script src="/wizard/jquery.bootstrap.wizard.js"></script>	
	<style type="text/css">
		.thumbnail {
		width: 100%;
		}
	</style>
  </head>
  <body>
    <div class='container'>
		
		<div class="row">
		<div class="col-md-12">
			<section id="wizard">
			  <div class="page-header">
	            <h1 class="text-center text-primary"><i class="fa fa-magic"></i> Govinda Rover Setup Wizard</h1>
	          </div>
	
				<div id="rootwizard">
					<div class="navbar">
					  <div class="navbar-inner">
					    <div class="container">
					<ul>
					  	<li><a href="#tab1" data-toggle="tab"><i class="fa fa-home"></i> <?php print $text[150];?></a></li>
						<li><a href="#tab2" data-toggle="tab"><i class="fa fa-signal"></i> <?php print $text[151];?></a></li>
						<li><a href="#tab3" data-toggle="tab"><i class="fa fa-sitemap"></i> <?php print $text[152];?></a></li>
						<li><a href="#tab4" data-toggle="tab"><i class="fa fa-user"></i> <?php print $text[153];?></a></li>
						<li><a href="#tab5" data-toggle="tab"><i class="fa fa-space-shuttle"></i> <?php print $text[154];?></a></li>
					</ul>
					 </div>
					  </div>
					</div>
					<div id="bar" class="progress progress-striped progress-success active">
					  <div class="bar"></div>
					</div>
					<div class="tab-content">
					    <div class="tab-pane" id="tab1">
							<img class="image-responsive thumbnail" src="/img/gr1.jpg">
							<hr>
							<h3 class="text-center text-primary"><?php print $text[155];?></h3>
							<hr>
							<?php print display_print_user_lang();?>
							<hr>
							<p class="text-center text-success">
								<?php print $text[156];?>
							</p>
					    </div>
					    <div class="tab-pane" id="tab2">
							<img class="image-responsive thumbnail" src="/img/gr2.jpg">
							<hr>					
							<?php
							print display_print_ap_config();
							print '<div id="wlan-scan"></div>';
							?>
					    </div>
						<div class="tab-pane" id="tab3">
							<img class="image-responsive thumbnail" src="/img/gr3.jpg">
							<hr>					
							<?php print display_print_config_wlan();?>
					    </div>
						<div class="tab-pane" id="tab4">
							<img class="image-responsive thumbnail" src="/img/gr4.jpg">
							<hr>			
							<?php print display_print_user_config();?>
					    </div>
						<div class="tab-pane" id="tab5">
							<h2 class="text-center text-primary"><?php print $text[157];?></h2>
							<hr>
							<p><h4 class="text-center text-success"><?php print $text[158];?></h4></p>
							<?php
								$_SESSION['wizard'] = 0;
							?>
					    </div>
						<ul class="pager wizard">
							<li class="previous first" style="display:none;"><a href="#">First</a></li>
							<li class="previous"><a href="#">Previous</a></li>
							<li class="next last" style="display:none;"><a href="#">Last</a></li>
						  	<li class="next"><a href="#">Next</a></li>
							<li class="next finish" style="display:none;"><a href="javascript:;">Finish</a></li>
						</ul>
					</div>	
				</div>
			</section>
 		</div>
	</div>
	</div>
	<script>
	$(document).ready(function() {
		//Pilih bahasa
		$('#lang').change(function(){
			var value = $('#lang :selected').val();
			var loadUrl = "/control_user.php?save=lang&val=" + value;
			//console.log(loadUrl);
			$("#pesan").html();
			$.get(
				loadUrl,
				{language: "php", version: 5},
					function(responseText){
						$("#pesan").html(responseText);
					},
			"html"
			);		
			$('.form-kamera').remove(); // remove the error text
			$('#group-lang').prepend('<div class="form-kamera alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Language : ' + value + '</div>');			
			window.location.href = "/wizard";
		});
		$(".pesan-hide").hide();
	  	$('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
			$(".pesan-hide").hide();
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = ($current/$total) * 100;
			$('#rootwizard').find('.bar').css({width:$percent+'%'});
			
			// If it's the last tab then hide the last button and show the finish instead
			if($current >= $total) {
				$('#rootwizard').find('.pager .next').hide();
				$('#rootwizard').find('.pager .finish').show();
				$('#rootwizard').find('.pager .finish').removeClass('disabled');
			} else {
				$('#rootwizard').find('.pager .next').show();
				$('#rootwizard').find('.pager .finish').hide();
			}
		}});

		$('#rootwizard .finish').click(function() {
				window.location.href = "/auth.php";
			});		
	//Tombol scan AP
	$('#tombol-scan-ap').click(function(){
				var loadUrl = "/control_wlan.php?scan";
				$("#wlan-scan").html('<p class="text-center text-primary">Scanning...</p>');
				$.get(
					loadUrl,
					{language: "php", version: 5},
					function(responseText){
						$("#wlan-scan").html(responseText);
					},
					"html"
				);
	});

	//Fungsi form pengaturan pengguna
	$('#form-set-user').submit(function(event) {
			$('#group-old-username').removeClass('has-error'); // remove the error class
			$('#group-old-pass').removeClass('has-error'); // remove the error class
			$('#group-new-username').removeClass('has-error'); // remove the error class
			$('#group-new-pass').removeClass('has-error'); // remove the error class
			$('#group-new-passc').removeClass('has-error'); // remove the error class
			$('.help-block').remove(); // remove the error text
			$(".pesan-hide").hide();
		var old_username = $('input[name=old-username]').val();
		var old_pass = $('input[name=old-pass]').val();
		var new_username = $('input[name=new-username]').val();
		var new_pass = $('input[name=new-pass]').val();
		var new_passc = $('input[name=new-passc]').val();
			// get the form data
			// there are many ways to get this data using jQuery (you can use the class or id also)
			var formData = {
				'old-username' 		: old_username,
				'old-pass'			: old_pass,
				'new-username'		: new_username,
				'new-pass'			: new_pass,
				'new-passc'			: new_passc
			};
			console.log(formData);
			
			// process the form
			$.ajax({
				type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url 		: '/control_user.php?save=set-user', // the url where we want to POST
				data 		: formData, // our data object
				dataType 	: 'json', // what type of data do we expect back from the server
				encode 		: true
			})
				// using the done promise callback
				.done(function(data) {
					// log data to the console so we can see
					console.log(data); 
					// here we will handle errors and validation messages
					if ( ! data.success) {
					// handle errors for name ---------------
						if (data.errors.new_username) {
							$('#group-new-username').addClass('has-error'); // add the error class to show red input
							$('#group-new-username').append('<div class="help-block">' + data.errors.new_username + '</div>'); // add the actual error message under our input
						}
						if (data.errors.new_pass) {
							$('#group-new-pass').addClass('has-error'); // add the error class to show red input
							$('#group-new-pass').append('<div class="help-block">' + data.errors.new_pass + '</div>'); // add the actual error message under our input
						}
						if (data.errors.new_passc) {
							$('#group-new-passc').addClass('has-error'); // add the error class to show red input
							$('#group-new-passc').append('<div class="help-block">' + data.errors.new_passc + '</div>'); // add the actual error message under our input
						}
						if (data.errors.old_username) {
							$('#group-old-username').addClass('has-error'); // add the error class to show red input
							$('#group-old-username').append('<div class="help-block">' + data.errors.old_username + '</div>'); // add the actual error message under our input
						}
						if (data.errors.old_pass) {
							$('#group-old-pass').addClass('has-error'); // add the error class to show red input
							$('#group-old-pass').append('<div class="help-block">' + data.errors.old_pass + '</div>'); // add the actual error message under our input
						}

					} else {
					// ALL GOOD! just show the success message!
					$('.pesan-hide').show(); // remove the error text
					$('.pesan-hide').html(data.pesan);
					// usually after form submission, you'll want to redirect
					// window.location = '/thank-you'; // redirect a user to another page
					}
				})

				// using the fail promise callback
				.fail(function(data) {
					// show any errors
					// best to remove for production
					//console.log(data);
				});			
			event.preventDefault();
		});

	//Fungsi form pengaturan wlan
	$('#form-set-wlan').submit(function(event) {
			$('#group-ip').removeClass('has-error'); // remove the error class
			$('#group-subnet').removeClass('has-error'); // remove the error class
			$('#group-gw').removeClass('has-error'); // remove the error class
			$('#group-dns').removeClass('has-error'); // remove the error class
			$('.help-block').remove(); // remove the error text
			$(".pesan-hide").hide();
		var ip = $('input[name=ip]').val();
		var subnet = $('select[name=subnet]').val();
		var gw = $('input[name=gw]').val();
		var dns = $('input[name=dns]').val();
			// get the form data
			// there are many ways to get this data using jQuery (you can use the class or id also)
			var formData = {
				'ip' 		: ip,
				'subnet'	: subnet,
				'gw'		: gw,
				'dns'		: dns
			};

			
			// process the form
			$.ajax({
				type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url 		: '/control_wlan.php?save=set-wlan', // the url where we want to POST
				data 		: formData, // our data object
				dataType 	: 'json', // what type of data do we expect back from the server
				encode 		: true
			})
				// using the done promise callback
				.done(function(data) {
					// log data to the console so we can see
					//console.log(data); 
					// here we will handle errors and validation messages
					if ( ! data.success) {
					// handle errors for name ---------------
						if (data.errors.ip) {
							$('#group-ip').addClass('has-error'); // add the error class to show red input
							$('#group-ip').append('<div class="help-block">' + data.errors.ip + '</div>'); // add the actual error message under our input
						}
						if (data.errors.subnet) {
							$('#group-subnet').addClass('has-error'); // add the error class to show red input
							$('#group-subnet').append('<div class="help-block">' + data.errors.ip + '</div>'); // add the actual error message under our input
						}
						if (data.errors.gw) {
							$('#group-gw').addClass('has-error'); // add the error class to show red input
							$('#group-gw').append('<div class="help-block">' + data.errors.ip + '</div>'); // add the actual error message under our input
						}
						if (data.errors.dns) {
							$('#group-dns').addClass('has-error'); // add the error class to show red input
							$('#group-dns').append('<div class="help-block">' + data.errors.ip + '</div>'); // add the actual error message under our input
						}

					} else {
					// ALL GOOD! just show the success message!
					$('.pesan-hide').show(); // remove the error text
					$('.pesan-hide').html(data.pesan);
					// usually after form submission, you'll want to redirect
					// window.location = '/thank-you'; // redirect a user to another page
					}
				})

				// using the fail promise callback
				.fail(function(data) {
					// show any errors
					// best to remove for production
					//console.log(data);
				});			
			event.preventDefault();
		});
		
	//Fungsi form pengaturan ap
	$('#form-set-ap').submit(function(event) {
			$('#group-ssid').removeClass('has-error'); // remove the error class
			$('#group-psk').removeClass('has-error'); // remove the error class
			$('#group-ssid-b').removeClass('has-error'); // remove the error class
			$('#group-psk-b').removeClass('has-error'); // remove the error class
			$('.help-block').remove(); // remove the error text
			$(".pesan-hide").hide();
		var ssid = $('input[name=ssid]').val();
		var psk = $('input[name=psk]').val();
		var ssidb = $('input[name=ssid-b]').val();
		var pskb = $('input[name=psk-b]').val();
			// get the form data
			// there are many ways to get this data using jQuery (you can use the class or id also)
			var formData = {
				'ssid' 		: ssid,
				'psk'		: psk,
				'ssid-b'	: ssidb,
				'psk-b'		: pskb
			};

			
			// process the form
			$.ajax({
				type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url 		: '/control_wlan.php?save=set-ap', // the url where we want to POST
				data 		: formData, // our data object
				dataType 	: 'json', // what type of data do we expect back from the server
				encode 		: true
			})
				// using the done promise callback
				.done(function(data) {
					// log data to the console so we can see
					console.log(data); 
					// here we will handle errors and validation messages
					if ( ! data.success) {
					// handle errors for name ---------------
						if (data.errors.ssid) {
							$('#group-ssid').addClass('has-error'); // add the error class to show red input
							$('#group-ssid').append('<div class="help-block">' + data.errors.ssid + '</div>'); // add the actual error message under our input
						}
						if (data.errors.psk) {
							$('#group-psk').addClass('has-error'); // add the error class to show red input
							$('#group-psk').append('<div class="help-block">' + data.errors.psk + '</div>'); // add the actual error message under our input
						}
						if (data.errors.ssidb) {
							$('#group-ssid-b').addClass('has-error'); // add the error class to show red input
							$('#group-ssid-b').append('<div class="help-block">' + data.errors.ssidb + '</div>'); // add the actual error message under our input
						}
						if (data.errors.pskb) {
							$('#group-psk-b').addClass('has-error'); // add the error class to show red input
							$('#group-psk-b').append('<div class="help-block">' + data.errors.pskb + '</div>'); // add the actual error message under our input
						}

					} else {
					// ALL GOOD! just show the success message!
					$('.pesan-hide').show(); // remove the error text
					$('.pesan-hide').html(data.pesan);
					// usually after form submission, you'll want to redirect
					// window.location = '/thank-you'; // redirect a user to another page
					}
				})

				// using the fail promise callback
				.fail(function(data) {
					// show any errors
					// best to remove for production
					//console.log(data);
				});			
			event.preventDefault();
		});			
		
		
	});	
	</script>
  </body>
</html>
<?php 
else:
header('Location /auth.php');

endif;
?>