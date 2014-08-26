// magic.js
$(document).ready(function() {
//START--------------------- TOMBOL KONTROL 

//Sembunyikan menu stop perekaman
//$("#stop-video").hide();


$(".pesan-hide").hide();
$('#panel-camera-editor').hide();

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
	window.location.href = "/config.php?view=user";
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

//timer kamera feed
var camVar;
var cam_is_on = 0;

function timedCam() {
    $("#cam-feed").attr("src", "/stream.php?cache=" + new Date().getTime());
    camVar = setTimeout(function(){timedCam()}, 100);
}

function startCam() {
    if (!cam_is_on) {
        cam_is_on = 1;
        timedCam();
    }
}

function stopCam() {
    clearTimeout(camVar);
    cam_is_on = 0;
}


//Pengaturan kamera
$('input').click(function(){
		if($(this).attr('id') == 'sharpness'){
			var value = $('input[name=sharpness]').val();
			var loadUrl = "/control_cam.php?pipe=sh&val=" + value;
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
			$('#form-kamera').prepend('<div class="form-kamera alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Sharpness: ' + value + '</div>');		
		}
		else if($(this).attr('id') == 'contrast'){
			var value = $('input[name=contrast]').val();
			var loadUrl = "/control_cam.php?pipe=co&val=" + value;
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
			$('#form-kamera').prepend('<div class="form-kamera alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Contrast: ' + value + '</div>');		
		}		
		else if($(this).attr('id') == 'brightness'){
			var value = $('input[name=brightness]').val();
			var loadUrl = "/control_cam.php?pipe=br&val=" + value;
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
			$('#form-kamera').prepend('<div class="form-kamera alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Brightness: ' + value + '</div>');		
		}		
		else if($(this).attr('id') == 'saturation'){
			var value = $('input[name=saturation]').val();
			var loadUrl = "/control_cam.php?pipe=sa&val=" + value;
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
			$('#form-kamera').prepend('<div class="form-kamera alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Saturation: ' + value + '</div>');		
		}									
});

//Kamera select box iso
$('#iso').change(function(){
    var value = $('#iso :selected').val();
	var loadUrl = "/control_cam.php?pipe=iso&val=" + value;
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
	$('#form-kamera').prepend('<div class="form-kamera alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>ISO: ' + value + '</div>');			
});

//Exposure Mode
$('#em').change(function(){
    var value = $('#em :selected').val();
	var loadUrl = "/control_cam.php?pipe=em&val=" + value;
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
	$('#form-kamera').prepend('<div class="form-kamera alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Exposure Mode: ' + value + '</div>');			
});

//White Balance
$('#wb').change(function(){
    var value = $('#wb :selected').val();
	var loadUrl = "/control_cam.php?pipe=wb&val=" + value;
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
	$('#form-kamera').prepend('<div class="form-kamera alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>White Balance: ' + value + '</div>');			
});

//Image effect
$('#ie').change(function(){
    var value = $('#ie :selected').val();
	var loadUrl = "/control_cam.php?pipe=ie&val=" + value;
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
	$('#form-kamera').prepend('<div class="form-kamera alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Image Effect: ' + value + '</div>');			
});

//Rotasi gambar
$('a').click(function(){
    var a = $('#cam-feed').getRotateAngle();
    var d = Math.abs(90);
    
    if($(this).attr('id') == 'rotasi-kiri'){
       //d = -Math.abs(+a - +d);
        d = a - d;
		$('#cam-feed').rotate({animateTo:d});
    }
	else if($(this).attr('id') == 'camera-editor'){
		$.fn.isVisible = function() {
		return $.expr.filters.visible(this[0]);
		};
		if($('#panel-camera-editor').isVisible()) {
			$('#panel-camera-editor').hide();
		}
		else{
			$('#panel-camera-editor').show();
		}
		
	}
	else if($(this).attr('id') == 'shutdown'){
		if (confirm("Are you sure to shutdown the systems ?")) {
				var loadUrl = "/control.php?sys=halt";
				$("#pesan").html();
				$.get(
					loadUrl,
					{language: "php", version: 5},
					function(responseText){
						$("#pesan").html(responseText);
					},
					"html"
				);
				window.location = '/auth.php';
			} else {
				// Do nothing!
			}
	}
	else if($(this).attr('id') == 'muat-ulang'){
		stopCam();
		startCam();
	}
	else if($(this).attr('id') == 'rotasi-kanan'){
		d = +a + +d;
		$('#cam-feed').rotate({animateTo:d});		
	}
	else if($(this).attr('id') == 'cam-nyalakan'){
		$("#cam-feed").show();
		var loadUrl = "/control_cam.php?cam=start";
        	$("#pesan").html();
	        $.get(
	            loadUrl,
	            {language: "php", version: 5},
	            function(responseText){
	                $("#pesan").html(responseText);
	            },
	            "html"
	        );
			startCam();
	}
	else if($(this).attr('id') == 'cam-matikan'){
		//clearInterval(camInterval);
            $("#cam-feed").hide();
                var loadUrl = "/control_cam.php?cam=stop";
        	$("#pesan").html();
	        $.get(
	            loadUrl,
        	    {language: "php", version: 5},
	            function(responseText){
	                $("#pesan").html(responseText);
	            },
        	    "html"
	        );
			stopCam();
        }
	else if($(this).attr('id') == 'ambil-foto'){
				//clearInterval(camInterval);
				stopCam();
                $("#cam-feed").show();
                var loadUrl = "/control_cam.php?cam=shot";
        	$("#pesan").html();
	        $.get(
	            loadUrl,
        	    {language: "php", version: 5},
	            function(responseText){
	                $("#pesan").html(responseText);
	            },
        	    "html"
	        );
			setTimeout(function(){
				$("#cam-feed").attr("src", "/media/shot.jpg?time=" + new Date().getTime());
			}, 7000);
        }	
	else if($(this).attr('id') == 'ambil-video'){
			stopCam();
			//Mulai merekam
			//$("#stop-video").show();
			//$("#ambil-video").hide();
			var loadUrl = "/control_cam.php?vid=start";
        	$("#pesan").html();
	        $.get(
	            loadUrl,
        	    {language: "php", version: 5},
	            function(responseText){
	                $("#pesan").html(responseText);
	            },
        	    "html"
	        );
			
        }
	else if($(this).attr('id') == 'stop-video'){
		//$("#ambil-video").show();
		//$("#stop-video").hide();
		var loadUrl = "/control_cam.php?vid=stop";
        	$("#pesan").html();
	        $.get(
	            loadUrl,
        	    {language: "php", version: 5},
	            function(responseText){
	                $("#pesan").html(responseText);
	            },
        	    "html"
	        );
		
     }
		else if($(this).attr('id') == 'lihat-foto'){
			stopCam();
            $("#cam-feed").show();
			$("#cam-feed").attr("src", "/media/shot.jpg?time=" + new Date().getTime());
        }		

});

//  $.get() refresh data lingkungan
    $("#menu-update-lingkungan").click(function(){
		var loadUrl = "/control_graph.php?lingkungan=r";
        $("#pesan").html();
        $.get(
            loadUrl,
            {language: "php", version: 5},
            function(responseText){
                $("#tabel-lingkungan").html(responseText);
            },
            "html"
        );
    });

//  $.get() untuk tombol on off flash
    $("#tombol-flash").click(function(){
		var loadUrl = "/control.php?flash=w";
        $("#pesan").html();
        $.get(
            loadUrl,
            {language: "php", version: 5},
            function(responseText){
                $("#pesan").html(responseText);
				if(responseText == "1"){
					$("#tombol-flash").prop('checked', true);
				}
				else{
					$("#tombol-flash").prop('checked', false);
				};				
            },
            "html"
        );
    });
		
//  $.get() untuk tombol on off laser
    $("#tombol-laser").click(function(){
		var loadUrl = "/control.php?laser=w";
        $("#pesan").html();
        $.get(
            loadUrl,
            {language: "php", version: 5},
            function(responseText){
                $("#pesan").html(responseText);
				if(responseText == "1"){
					$("#tombol-laser").prop('checked', true);
				}
				else{
					$("#tombol-laser").prop('checked', false);
				};
            },
            "html"
        );
    });
	
	//  $.get() untuk tombol reset servo
    $("#servo-reset").click(function(){
		$('input[name=servoX]').val(90);
                $('input[name=servoY]').val(90);
		var loadUrl = "/control.php?kamera=r";
        $("#pesan").html();
        $.get(
            loadUrl,
            {language: "php", version: 5},
            function(responseText){
                $("#pesan").html(responseText);
            },
            "html"
        );
    });
	//  $.get() untuk tombol maju
    $("#tombol-maju").click(
	function nav_maju(){
		var loadUrl = "/control.php?kontrol=w";
        $("#pesan").html();
        $.get(
            loadUrl,
            {language: "php", version: 5},
            function(responseText){
                $("#pesan").html(responseText);
            },
            "html"
        );
    });
	//  $.get() untuk tombol kiri
    $("#tombol-kiri").click(function(){
		var loadUrl = "/control.php?kontrol=a";
        $("#pesan").html();
        $.get(
            loadUrl,
            {language: "php", version: 5},
            function(responseText){
                $("#pesan").html(responseText);
            },
            "html"
        );
    });
	//  $.get() untuk tombol stop
    $("#tombol-stop").click(function(){
		var loadUrl = "/control.php?kontrol=z";
        $("#pesan").html();
        $.get(
            loadUrl,
            {language: "php", version: 5},
            function(responseText){
                $("#pesan").html(responseText);
            },
            "html"
        );
    });	//  $.get() untuk tombol kanan
    $("#tombol-kanan").click(function(){
		var loadUrl = "/control.php?kontrol=d";
        $("#pesan").html();
        $.get(
            loadUrl,
            {language: "php", version: 5},
            function(responseText){
                $("#pesan").html(responseText);
            },
            "html"
        );
    });
	//  $.get() untuk tombol mundur
    $("#tombol-mundur").click(function(){
		var loadUrl = "/control.php?kontrol=s";
        $("#pesan").html();
        $.get(
            loadUrl,
            {language: "php", version: 5},
            function(responseText){
                $("#pesan").html(responseText);
            },
            "html"
        );
    });	
//STOP--------------------- TOMBOL KONTROL 

//START--------------------- FORM PWM
	// form set PWM
	$('#form-pwm').submit(function(event) {

		$('.form-group').removeClass('has-error'); // remove the error class
		$('.help-block').remove(); // remove the error text

		// get the form data
		// there are many ways to get this data using jQuery (you can use the class or id also)
		var formData = {
			'pwm' 				: $('input[name=pwm]').val()
			//'email' 			: $('input[name=email]').val(),
			//'superheroAlias' 	: $('input[name=superheroAlias]').val()
		};

		// process the form
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: '/control.php?pwm=w', // the url where we want to POST
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


				} else {

// ALL GOOD! just show the success message!
$('.form-pwm').remove(); // remove the error text
$('#form-pwm').append('<div class="form-pwm alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>' + data.message + '</div>');

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

		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});
//STOP--------------------- FORM PWM


//START--------------------- FORM SERVO
	// form set PWM
	$('#form-servo').submit(function(event) {

		$('.form-group').removeClass('has-error'); // remove the error class
		$('.help-block').remove(); // remove the error text

		// get the form data
		// there are many ways to get this data using jQuery (you can use the class or id also)
		var formData = {
			'servoX' 				: $('input[name=servoX]').val(),
			'servoY'				: $('input[name=servoY]').val()
			//'email' 			: $('input[name=email]').val(),
			//'superheroAlias' 	: $('input[name=superheroAlias]').val()
		};

		// process the form
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: '/control.php?kamera=x', // the url where we want to POST
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
				if (data.errors.name) {
					$('#name-group').addClass('has-error'); // add the error class to show red input
					$('#name-group').append('<div class="help-block">' + data.errors.name + '</div>'); // add the actual error message under our input
				}

				} else {

				// ALL GOOD! just show the success message!
				$('.form-servo').remove(); // remove the error text
				$('#form-servo').append('<div class="form-servo alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>' + data.message + '</div>');

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

		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});
//STOP--------------------- FORM SERVO
});
