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
	
	//Set judul halaman
	$title = $text[69] . " | " . $text[3];
	//Sertakan file header
	require_once('include/header.php');
	
	//Inisialisasi variabel data dan pesan error untuk respon json
	$errors = array();
	$data = array();

	//Jalankan block program berikut jika fungsi yang diminta
	//adalah fungsi konfigurasi system
	if(isset($_GET['view'])){
		if ($_GET['view'] == 'pindai-wlan'){			
			print display_print_page_wrapper_top();
			//tampilkan wlan yg tersedia
			/**print '<pre>';
			print_r(common_wlan_scan());
			print '</pre>';**/
			print display_print_ap_config();
			print '<div id="wlan-scan"></div>';
			print display_print_page_wrapper_bottom();
		}
		else if($_GET['view'] == 'set-wlan'){
			print display_print_page_wrapper_top();
			//tampilkan wlan yg tersedia
			print display_print_config_wlan();
			print display_print_page_wrapper_bottom();
		}
		else if($_GET['view'] == 'user'){
			print display_print_page_wrapper_top();
			//tampilkan form konfigurasi bahasa
			print display_print_user_lang();
			//tampilkan form konfigurasi pengguna
			print display_print_user_config();
			print display_print_page_wrapper_bottom();
		}
	}

	//Sertakan file footer
	require_once('include/footer.php');
}