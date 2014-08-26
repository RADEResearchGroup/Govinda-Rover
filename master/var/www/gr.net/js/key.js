//Keyboard shortcut
var listener = new window.keypress.Listener();
var my_scope = this;
var key_navigasi = listener.register_many([
	//Set Kamera X -
	{
	"keys"              : "k",
    "on_keydown"        : function() {
								var servoData = {
									'servoX' 				: $('input[name=servoX]').val() - 5,
									'servoY' 				: $('input[name=servoY]').val()

								};
								if(servoData["servoX"] <= 5){
									servoData["servoX"] = 5;
								};
								$('input[name=servoX]').val(servoData["servoX"]);
								//$('#submit-servo').focus();								  
								var loadUrl = "/control.php?kamera=w&x=" + servoData["servoX"] + "&y=" + servoData["servoY"];
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
								return true
  						},
    "on_keyup"          : function() {
								return true
  						},
        "this"          : my_scope
	},
//Set Kamera X +
	{
	"keys"              : "h",
    "on_keydown"        : function() {
								var servoData = {
									'servoX' 				: $('input[name=servoX]').val() * 1 + 5,
									'servoY' 				: $('input[name=servoY]').val()

								};
								if(servoData["servoX"] >= 180){
									servoData["servoX"] = 180;
								};
								$('input[name=servoX]').val(servoData["servoX"]);
								//$('#submit-servo').focus();								  
								var loadUrl = "/control.php?kamera=w&x=" + servoData["servoX"] + "&y=" + servoData["servoY"];
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
								return true
  						},
    "on_keyup"          : function() {
								return true
  						},
        "this"          : my_scope
	},
//Set Kamera Y -
	{
	"keys"              : "j",
    "on_keydown"        : function() {
								var servoData = {
									'servoX' 				: $('input[name=servoX]').val(),
									'servoY' 				: $('input[name=servoY]').val() - 5
								};
								if(servoData["servoY"] <= 5){
									servoData["servoY"] = 5;
								};
								$('input[name=servoY]').val(servoData["servoY"]);
								//$('#submit-servo').focus();								  
								var loadUrl = "/control.php?kamera=w&x=" + servoData["servoX"] + "&y=" + servoData["servoY"];
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
								return true
  						},
    "on_keyup"          : function() {
								return true
  						},
        "this"          : my_scope
	},
//Set Kamera Y +
	{
	"keys"              : "u",
    "on_keydown"        : function() {
								var servoData = {
									'servoX' 				: $('input[name=servoX]').val(),
									'servoY' 				: $('input[name=servoY]').val() * 1 + 5

								};
								if(servoData["servoX"] >= 180){
									servoData["servoX"] = 180;
								};
								$('input[name=servoY]').val(servoData["servoY"]);
								//$('#submit-servo').focus();								  
								var loadUrl = "/control.php?kamera=w&x=" + servoData["servoX"] + "&y=" + servoData["servoY"];
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
								return true
  						},
    "on_keyup"          : function() {
								return true
  						},
        "this"          : my_scope
	},
	//Reset kamera
	{
	"keys"              : "space",
    "on_keydown"        : function() {
								$('input[name=servoX]').val(90);
								$('input[name=servoY]').val(90);
								$('#submit-servo').focus();								  
								var loadUrl = "/control.php?kamera=w&x=90&y=90";
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
								return true
  						},
    "on_keyup"          : function() {
								$('#servo-reset').focus();								  
								return true
  						},
        "this"          : my_scope
	},	
	//Set PWM -
	{
	"keys"              : "-",
    "on_keydown"        : function() {
								var pwmData = {
									'pwm' 				: $('input[name=pwm]').val() - 10
								};
								if(pwmData["pwm"] <= 10){
									pwmData["pwm"] = 10;
								};
								$('input[name=pwm]').val(pwmData["pwm"]);
								//$('#submit-pwm').focus();								  
								var loadUrl = "/control.php?pwm=w&data=" + pwmData["pwm"];
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
								return true
  						},
    "on_keyup"          : function() {
								////$('#tombol-stop').focus();								  
								return true
  						},
        "this"          : my_scope
	},
	//Set PWM +
	{
	"keys"              : "=",
    "on_keydown"        : function() {
								var pwmData = {
									'pwm' 				: $('input[name=pwm]').val() * 1 + 10
								};
								//console.log(pwmData["pwm"]);
								if(pwmData["pwm"] >= 250){
									pwmData["pwm"] = 250;
								};
								$('input[name=pwm]').val(pwmData["pwm"]);
								//$('#submit-pwm').focus();								  
								var loadUrl = "/control.php?pwm=w&data=" + pwmData["pwm"];
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
								return true
  						},
    "on_keyup"          : function() {
								////$('#tombol-stop').focus();								  
								return true
  						},
        "this"          : my_scope
	},	
	//Maju
    {
    "keys"              : "w",
    "on_keydown"        : function() {
								//$('#tombol-maju').focus();								  
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
								return true
  						},
    "on_keyup"          : function() {
								//$('#tombol-stop').focus();								  
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
								return true
  						},
        "this"          : my_scope
    },
	//Kanan
    {
	"keys"              : "d",
    "on_keydown"        : function() {
								//$('#tombol-kanan').focus();								  
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
								return true
  						},
    "on_keyup"          : function() {
								//$('#tombol-stop').focus();								  
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
								return true
  						},
        "this"          : my_scope
    },
	//Kiri
	{
    "keys"              : "a",
    "on_keydown"        : function() {
								//$('#tombol-kiri').focus();								  
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
								return true
  						},
    "on_keyup"          : function() {
								//$('#tombol-stop').focus();								  
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
								return true
  						},
        "this"          : my_scope	
	},
	//Mundur
	{
    "keys"              : "s",
    "on_keydown"        : function() {
								//$('#tombol-mundur').focus();								  
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
								return true
  						},
    "on_keyup"          : function() {
								//$('#tombol-stop').focus();								  
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
								return true
  						},
        "this"          : my_scope	
	},
	//stop
	{
    "keys"              : "z",
    "on_keydown"        : function() {
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
								return true
  						},
    "on_keyup"          : null,
        "this"          : my_scope		
	},
	//Flash
	{
    "keys"              : "c",
    "on_keydown"        : function() {
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
										console.log(responText);
									},
									"html"
								);
								return true
  						},
    "on_keyup"          : null,
        "this"          : my_scope	
	},
	{
    "keys"              : "l",
    "on_keydown"        : function() {
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
								return true
  						},
    "on_keyup"          : null,
        "this"          : my_scope	
	}
]);