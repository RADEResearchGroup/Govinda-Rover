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

//Cek apakah yang meminta akses adalah user
//yang memiliki cukup hak akses
if(user_check_login(1)){
	
	//update konfigurasi jaringan
	//Inisialisasi variabel data dan pesan error untuk respon json
	$errors = array();
	$data = array();
		if(isset($_GET['save'])) {
			if($_GET['save'] == 'set-wlan'){
				//cek apakah input yang dikirim valid
				if(!isset($_POST['ip']) || !filter_var($_POST['ip'], FILTER_VALIDATE_IP)){
					$errors['ip'] = $text[133];
				}
				if(!isset($_POST['subnet']) || !filter_var($_POST['subnet'], FILTER_VALIDATE_IP)){
					$errors['subnet'] = $text[133];
				}
				if(!isset($_POST['gw']) || !filter_var($_POST['gw'], FILTER_VALIDATE_IP)){
					$errors['gw'] = $text[133];
				}
				if(!isset($_POST['dns']) || !filter_var($_POST['dns'], FILTER_VALIDATE_IP)){
					$errors['dns'] = $text[133];
				}
				//Jika ada error, kirim pesan error ke client
				if(! empty($errors)){
					$data['success'] = false;
					$data['errors'] = $errors;
				}
				//jika tidak, kirimkan kembali nilai PWM yg diset
				else{
					//Siapkan respon
					$data['success'] = true;
					$data['pesan'] = $text[134];
					//Update konfigurasi database
					//...
					$add = array($_POST['ip'],$_POST['subnet'],$_POST['gw'],$_POST['dns']);
					updater_update_network_address($add);
				}
				//cetak respon ke client
				print json_encode($data);
			}
			//Set Access Point
			else if($_GET['save'] == 'set-ap'){
				//cek apakah input yang dikirim valid
				if(!isset($_POST['ssid']) || empty($_POST['ssid']) || strlen($_POST['ssid']) > 20 || strlen($_POST['ssid']) < 1){
					$errors['ssid'] = $text[133];
				}
				if(!isset($_POST['psk']) || empty($_POST['psk']) || strlen($_POST['psk']) > 64 || strlen($_POST['psk']) < 8 ){
					$errors['psk'] = $text[133];
				}
				if(!isset($_POST['ssid-b']) || empty($_POST['ssid-b']) ||  strlen($_POST['ssid-b']) > 20 || strlen($_POST['ssid-b']) < 1){
					$errors['ssidb'] = $text[133];
				}
				if(!isset($_POST['psk-b']) || empty($_POST['psk-b']) || strlen($_POST['psk-b']) > 64 || strlen($_POST['psk-b']) < 8 ){
					$errors['pskb'] = $text[133];
				}
				//Jika ada error, kirim pesan error ke client
				if(! empty($errors)){
					$data['success'] = false;
					$data['errors'] = $errors;
				}
				//jika tidak, kirimkan kembali nilai PWM yg diset
				else{
					//Siapkan respon
					$data['success'] = true;
					$data['pesan'] = $text[134];
					//Update konfigurasi database
					//...
					$add = array($_POST['ssid'],$_POST['psk'],$_POST['ssid-b'],$_POST['psk-b']);
					updater_update_network_ap($add);
				}
				//cetak respon ke client
				print json_encode($data);
			}
		}
		else if(isset($_GET['scan'])){
			//cetak list ap yg tersedia
			print display_print_scan_wlan(common_wlan_scan());
		}
}
?>