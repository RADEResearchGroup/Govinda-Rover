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
//Inisialisasi variabel data dan pesan error untuk respon json
$errors = array();
$data = array();

	//Update data lingkungan
	if(isset($_GET['lingkungan']) && $_GET['lingkungan'] == 'r'){
		updater_update_data_lingkungan();
		print display_get_lingkungan('js');
	}
	//Kirim repon untuk data grafik lingkungan dan sistem
	else if(isset($_GET['grafik'])){
		if($_GET['grafik'] == 'lingkungan'){
			updater_update_data_lingkungan();
			print display_get_lingkungan('js');
		}
		else if($_GET['grafik'] == 'sistem'){
			//kirim respon update
			print display_print_data_sistem();
		}
	}
}
?>