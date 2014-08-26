<?php
//Sertakan fungsi database
require_once('db.php');
//Sertakan fungsi text antarmuka
require_once('lang.php');


//Fungsi untuk mengecek status wizard, dibolehkan atau tidak
function user_check_wizard(){
	$query  = 'SELECT * FROM tbl_konfigurasi';
	$status = mysql_query($query);
	$status = mysql_fetch_assoc($status);
	$status = $status['konfigurasi_wizard'];
	
	if($status == '1'){
		return true;
	}
	else{
		return false;
	}
}

//Fungsi validasi data login user
function user_data_validation($user, $pass){
	//Karakter yang diperbolehkan untuk nama pengguna
	//selain karakter alphanumeric
	$sValidUser = array('_', '@', '.'); 
	//Karakter yang diperbolehkan untuk sandi
	//selain karakter alphanumeric	
	$sValidPass = array('*', '!', '@', '#', '$', '%', '^', '&', '*');

	//Cek validitas nama pengguna
	if(ctype_alnum(str_replace($sValidUser, '', $user))) { 
		//cek validitas sandi
		if(ctype_alnum(str_replace($sValidPass, '', $pass))) { 
			//jika nama pengguna dan sandi aman, kembalikan true
			return true;
		}
	}
	//Jika satu atau dua-duanya tidak valid, kembalikan false
	return false;
}

//fungsi untuk validasi login user, kecocokan nama pengguna dan sandi
function user_login_validation($uname, $pass){
	//cek ke database
	$query = sprintf("SELECT * FROM tbl_user WHERE user_name = '%s' AND user_pass = '%s'", 
		mysql_real_escape_string($uname), mysql_real_escape_string($pass));
	$r = mysql_query($query);
	$r = mysql_num_rows($r);
	if($r == 1){
		return true;
	} 
	else{
		return false;
	}
	
}

//Fungsi login user
function user_do_login($user, $pass){
	global $text;
	//Validasi user
	if(user_data_validation($user, $pass)){
		//Jika valid, cek database
		$query = sprintf("SELECT * FROM tbl_user WHERE user_name = '%s' AND user_pass = '%s'",
			mysql_real_escape_string($user), mysql_real_escape_string($pass));
		//eksekusi query
		$result = mysql_query($query);
		//Cek hasil query, jika jumlah row yg dikembalikan sama dengan 1,
		//maka user valid
		if(mysql_num_rows($result) == 1)	{
			//Get data user yang akan login
			$data_user = mysql_fetch_assoc($result);
			//Set variable sesi
			//ID User
			$_SESSION['id'] = $data_user['id'];
			//Nama Lengkap User
			$_SESSION['full_name'] = $data_user['user_namaDepan'] . ' ' . $data_user['user_namaBlk'];
			//Username
			$_SESSION['username'] = $data_user['user_name'];
			//Role user
			$_SESSION['role'] = $data_user['user_role'];
			//Pesan login
			$_SESSION['pesan'] = array($text[7] . $_SESSION['full_name'], '1');
			//Lakukan inisialisasi perangkat
			common_device_init();
			//Alihkan user ke halaman utama
			header('Location: /index.php');
		}
		else{
			$_SESSION['pesan'] = array($text[6], 4);
		}
	}
	else {
		$_SESSION['pesan'] = array($text[8], 4);
	}
}

//Fungsi untuk logout user dan clean up
function user_do_logout(){
	shell_exec('sudo /etc/init.d/rpicam.sh stop');
	session_destroy();
	unset($_SESSION);
}

//Fungsi untuk mengecek status user
function user_check_login($role){
	global $text;
	//Valid jika session id terset
	if(isset($_SESSION['id']) || user_check_wizard()){
		//cek wizard
		if(user_check_wizard()){
			header('Location: /wizard');
		}
		//cek role
		if($role > 0){
			if($_SESSION['role'] > $role) {
				return false;
			}
		}
		return true;
	}
	$_SESSION['pesan'] = array($text[25], 3);
	header('Location: /auth.php');
}

?>