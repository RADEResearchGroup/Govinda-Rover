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

	//Jalankan block program berikut jika fungsi yang diminta
	//adalah fungsi pwm
	if(isset($_GET['pwm']) && $_GET['pwm'] == 'w'){
		//Cek apakah data yg diinput melalui get (digunakan pada keyboard shortcut)
		if(isset($_GET['data']) && !empty($_GET['data'])){
			//Update konfigurasi database
			$query = sprintf("UPDATE tbl_konfigurasi SET konfigurasi_pwm = '%s'",mysql_real_escape_string($_GET['data']));
			mysql_query($query);
			//Set PWM ke mekanik
			common_serial_write('p'.$_GET['data'].'o', $_SESSION['dev']);
		}
		else{
			//cek apakah input yang dikirim valid
			if(empty($_POST['pwm'])){
				$errors['pwm'] = $text[66];
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
				$data['message'] = 'PWM : ' . $_POST['pwm'];
				//Update konfigurasi database
				$query = sprintf("UPDATE tbl_konfigurasi SET konfigurasi_pwm = '%s'",mysql_real_escape_string($_POST['pwm']));
				mysql_query($query);
				//Set PWM ke mekanik
				common_serial_write('p'.$_POST['pwm'].'o', $_SESSION['dev']);
			}
			//cetak respon ke client
			print json_encode($data);
		}
	}
	//Fungsi kontrol arah gerak
	else if(isset($_GET['kontrol']) && $_GET['kontrol'] != ''){
		if($_GET['kontrol'] == 'w'){
			//Kirim perintah maju
			common_serial_write('k1o', $_SESSION['dev']);
		}
		else if($_GET['kontrol'] == 's'){
			//Kirim perintah mundur
			common_serial_write('k2o',$_SESSION['dev']);
		}
		else if($_GET['kontrol'] == 'a'){
			//Kirim perintah mundur
			common_serial_write('k3o',$_SESSION['dev']);
		}
		else if($_GET['kontrol'] == 'd'){
			//Kirim perintah mundur
			common_serial_write('k4o',$_SESSION['dev']);
		}
		else {
			//Kirim perintah stop
			common_serial_write('k5o',$_SESSION['dev']);
		}		
	}
	//Fungsi kontrol servo kamera
	else if(isset($_GET['kamera']) && $_GET['kamera'] != ''){
		//cek apakah permintaan adalah get (untuk shortcut keyboard)
		if($_GET['kamera'] == 'w'){
			if(isset($_GET['x']) && !empty($_GET['x'])  && isset($_GET['y']) && !empty($_GET['y']) ){
				//Update konfigurasi database
				$query = sprintf("UPDATE tbl_konfigurasi SET konfigurasi_servoX = '%s', konfigurasi_servoY = '%s'",
					mysql_real_escape_string($_GET['x']),mysql_real_escape_string($_GET['y']));
				mysql_query($query);
				//Set Posisi servo ke mekanik
				common_serial_write('m'.$_GET['x'].'o'.$_GET['y'].'o',$_SESSION['dev']);
				print "X: " . $_GET['x'] . " Y: " . $_GET['y'];
				exit();
			}
		}
			//Cek apakah permintaan adalah reset servo
		else if($_GET['kamera'] == 'r'){
				//Reset servo ke home
				common_serial_write('m83o100o',$_SESSION['dev']);
				//Update konfigurasi database
				$query = "UPDATE tbl_konfigurasi SET konfigurasi_servoX= '90', konfigurasi_servoY = '90'";
				mysql_query($query);
		}
		//Yang diminta adalah set servo secara manual
		else{
				//cek apakah input yang dikirim valid
				if(empty($_POST['servoX']) || empty($_POST['servoY']) || !is_numeric($_POST['servoX']) || !is_numeric($_POST['servoY'])){
					$errors['pwm'] = $text[65];
				}
				
				//Jika ada error, kirim pesan error ke client
				if(! empty($errors)){
					$data['success'] = false;
					$data['errors'] = $errors;
				}
				//jika tidak, kirimkan kembali nilai Servo yg diset
				else{
					//Siapkan respon
					$data['success'] = true;
					$data['message'] = 'X: ' . $_POST['servoX'] . ' Y: ' . $_POST['servoY'];
					//Update konfigurasi database
					$query = sprintf("UPDATE tbl_konfigurasi SET konfigurasi_servoX= '%s', konfigurasi_servoY = '%s'",
						mysql_real_escape_string($_POST['servoX']),mysql_real_escape_string($_POST['servoY']));
					mysql_query($query);
					//Set Posisi servo ke mekanik
					common_serial_write('m'.$_POST['servoX'].'o'.$_POST['servoY'].'o',$_SESSION['dev']);
				}
				//cetak respon ke client
				print json_encode($data);
			}
	}
	//Cek apakah permintaan on off modul laser
	else if(isset($_GET['laser']) && $_GET['laser'] == 'w'){
		//Set status laser ke database
		$laser = common_serial_read('l', $_SESSION['dev']);
		$laser = explode(':',$laser);
		$flag = $laser[0];
		$status = $laser[1];
		print $status;
		//Cek apakah yg direturn benar-benar data laser
		if($flag == 'f_laser'){
			$query = sprintf("UPDATE tbl_konfigurasi SET konfigurasi_laser = '%s'",mysql_real_escape_string($status));
			mysql_query($query);
		}
	}
	else if(isset($_GET['flash']) && $_GET['flash'] == 'w'){
		//Set status flash ke database
		$laser = common_serial_read('c', $_SESSION['dev']);
		$laser = explode(':',$laser);
		$flag = $laser[0];
		$status = $laser[1];
		print $status;
		
		//Cek apakah yg direturn benar-benar data flash
		if($flag == 'f_flash'){
			$query = sprintf("UPDATE tbl_konfigurasi SET konfigurasi_flash = '%s'",mysql_real_escape_string($status));
			mysql_query($query);
		}
	}
	//Lakukan fungsi sistem, seperti shutdown restart dan lainnya
	else if(isset($_GET['sys'])){
		//Shutdown system dengan aman
		if($_GET['sys'] == 'halt'){
			//stop mekanik
			common_serial_write('k5o',$_SESSION['dev']);
			//matikan lighting
			if(display_print_status('laser') == 'checked'){
				common_serial_read('l', $_SESSION['dev']);
				$query = sprintf("UPDATE tbl_konfigurasi SET konfigurasi_laser = '%s'",mysql_real_escape_string('0'));
				mysql_query($query);
			}
			if(display_print_status('flash') == 'checked'){
				common_serial_read('c', $_SESSION['dev']);
				$query = sprintf("UPDATE tbl_konfigurasi SET konfigurasi_flash = '%s'",mysql_real_escape_string('0'));
				mysql_query($query);
			}
			shell_exec('sudo /sbin/halt');
		}
		print $text[67];
	}
	//Set kecepatan servo kamera
	else if(isset($_GET['servoSpeed']) && $_GET['servoSpeed'] != '' && is_numeric($_GET['servoSpeed'])){
		common_serial_write('s' . $_GET['mek'].'o', $_SESSION['dev']);
		print $_GET['mek'];
	}
	//Set interrupt
	else if(isset($_GET['interrupt'])){
		common_serial_write('i', $_SESSION['dev']);
		print $text[68];
	}
	//perekaman video
	else if(isset($_GET['vid'])){
		//mulai perekaman
		if($_GET['vid'] == 'start'){
			//shell_exec('sudo /etc/init.d/rpicam.sh stop');
			$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
			file_put_contents($file, 'ca 1');
			//$respon = shell_exec('sudo /etc/init.d/rpicam.sh rec');
			print $text[100];
		}
		//hentikan perekaman
		else if($_GET['vid'] == 'stop'){
			$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
			file_put_contents($file, 'ru 0');
			sleep(1);
			file_put_contents($file, '');
			//Proses file RAW hasil perekaman, convert ke MP4
			$filename = date('YmdHis');
			shell_exec('sudo /etc/init.d/rpicam.sh rec');
			//shell_exec('MP4Box -add ' . $_SERVER['DOCUMENT_ROOT'] . '/media/vid_tmp.h264 ' . $_SERVER['DOCUMENT_ROOT'] . '/media/video/' . $filename .  '.mp4');
			print $text[99];
		}		
	}
}
?>