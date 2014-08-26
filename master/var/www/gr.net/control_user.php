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
	
	//update konfigurasi pengguna
	//Inisialisasi variabel data dan pesan error untuk respon json
	$errors = array();
	$data = array();
		if(isset($_GET['save'])) {
			if($_GET['save'] == 'set-user'){
				//cek apakah input yang dikirim valid
				if(!isset($_POST['old-username']) || empty($_POST['old-username'])){
					$errors['old_username'] = $text[133];
				}
				if(!isset($_POST['old-pass']) || empty($_POST['old-pass'])){
					$errors['old_pass'] = $text[133];
				}
				if(!isset($_POST['new-username']) || empty($_POST['new-username'])){
					$errors['new_username'] = $text[133];
				}
				if(!isset($_POST['new-pass']) || empty($_POST['new-pass'])){
					$errors['new_pass'] = $text[133];
				}
				if(!isset($_POST['new-passc']) || empty($_POST['new-passc'])){
					$errors['new_passc'] = $text[133];
				}
				if($_POST['new-pass'] != $_POST['new-passc']){
					$errors['new_pass'] = $text[133];
					$errors['new_passc'] = $text[133];
				}
				if(!user_login_validation($_POST['old-username'], $_POST['old-pass'])){
					$errors['old_username'] = $text[133];
					$errors['old_pass'] = $text[133];
				}
				if(!user_data_validation($_POST['new-username'], $_POST['new-pass'])){
					$errors['new_username'] = $text[133];
					$errors['new_pass'] = $text[133];
					$errors['new_passc'] = $text[133];
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
					$add = array($_POST['old-username'],$_POST['old-pass'],$_POST['new-username'],$_POST['new-pass']);
					updater_update_data_user($add);
				}
				//cetak respon ke client
				print json_encode($data);
			}
			//Set bahasa
			else if($_GET['save'] == 'lang'){
				if(isset($_GET['val']) && !empty($_GET['val'])){
					//Sesi
					$_SESSION['lang'] = $_GET['val'];
					unset($text);
					///lang logic
					if(isset($_SESSION['lang'])){
						//Bahasa Indonesia
						if($_SESSION['lang'] == 'id'){
							$text = $id;
						}	
						//English
						else if($_SESSION['lang'] == 'en'){
							$text = $en;
						}
						//Default English
						else{
							$text = $en;
						}
					}
					//database
					$query = sprintf("UPDATE tbl_konfigurasi SET konfigurasi_lang = '%s'",mysql_real_escape_string($_GET['val']));
					mysql_query($query);
				}
			}
		}
}
?>