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
		print display_get_lingkungan();
	}
	//Umpan kamera, nyalakan kamera
	else if(isset($_GET['cam']) && $_GET['cam'] == 'start'){
		//cek folder stream tmp apakah ada, jika tidak buat satu agar ada
		/**if(!file_exists('/tmp/stream')){
			shell_exec('mkdir /tmp/stream');
		}**/		
		$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
		file_put_contents($file, '');
		//Jalankan camera daemon
		$respon = shell_exec('sudo /etc/init.d/rpicam.sh start');
		//Jalankan mjpg streamer
		//$responb = shell_exec('sudo /etc/init.d/mjpg_streamer.sh start');
		
		print $respon;// . $responb;
	}
	//Umpan kamera, matikan kamera
	else if(isset($_GET['cam']) && $_GET['cam'] == 'stop'){	
		//hentikan camera daemon
		$respon = shell_exec('sudo /etc/init.d/rpicam.sh stop');
		$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
		file_put_contents($file, 'ru 0');
		sleep(1);
		file_put_contents($file, '');
		//hentikan mjpg streamer
		//$responb = shell_exec('sudo /etc/init.d/mjpg_streamer.sh stop');
		
		print $respon;// . $responb;
	}
	//Ambil foto shot dengan resolusi tinggi 5MP
	else if(isset($_GET['cam']) && $_GET['cam'] == 'shot'){
		//hentikam camera daemon
		$respon = shell_exec('sudo /etc/init.d/rpicam.sh stop');
		//hentikan mjpg streamer
		//$responb = shell_exec('sudo /etc/init.d/mjpg_streamer.sh stop');
		//Start cam.py untuk ambil foto 
		$responc = shell_exec('sudo /etc/init.d/rpicam.sh shot');
		//$responc = shell_exec('sudo python ' . $_SERVER['DOCUMENT_ROOT'] . '/media/cam.py');
		print $respon . $responc;// . $responb . $responc;
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
	//Pengaturan kamera
	else if(isset($_GET['pipe']) && $_GET['val']){
		//Set sharpness
		if($_GET['pipe'] == 'sh'){
			$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
			if(is_numeric($_GET['val'])){
				file_put_contents($file, 'sh ' . $_GET['val']);
				print "Sharpness: " . $_GET['val'];
				//Query update database
				$query = sprintf("UPDATE tbl_kamera SET kam_sh = '%s'",mysql_real_escape_string($_GET['val']));
				mysql_query($query);
			}
			else{
				print "Sharpness: " . $text[101];
			}
		}
		//Set contrast
		else if($_GET['pipe'] == 'co'){
			$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
			if(is_numeric($_GET['val'])){
				file_put_contents($file, 'co ' . $_GET['val']);
				print "Contrast: " . $_GET['val'];
				//Query update database
				$query = sprintf("UPDATE tbl_kamera SET kam_co = '%s'",mysql_real_escape_string($_GET['val']));
				mysql_query($query);
			}
			else{
				print "Contrast: " . $text[101];
			}
		}
		//Set brightness
		else if($_GET['pipe'] == 'br'){
			$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
			if(is_numeric($_GET['val'])){
				file_put_contents($file, 'br ' . $_GET['val']);
				print "Brightness: " . $_GET['val'];
				//Query update database
				$query = sprintf("UPDATE tbl_kamera SET kam_br = '%s'",mysql_real_escape_string($_GET['val']));
				mysql_query($query);
			}
			else{
				print "Brightness: " . $text[101];
			}
		}
		//Set saturation
		else if($_GET['pipe'] == 'sa'){
			$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
			if(is_numeric($_GET['val'])){
				file_put_contents($file, 'sa ' . $_GET['val']);
				print "Brightness: " . $_GET['val'];
				//Query update database
				$query = sprintf("UPDATE tbl_kamera SET kam_sa = '%s'",mysql_real_escape_string($_GET['val']));
				mysql_query($query);
			}
			else{
				print "Saturation: " . $text[101];
			}
		}
		//Set ISO		
		else if($_GET['pipe'] == 'iso'){
			$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
			if(is_numeric($_GET['val'])){
				file_put_contents($file, 'is ' . $_GET['val']);
				print "ISO: " . $_GET['val'];
				//Query update database
				$query = sprintf("UPDATE tbl_kamera SET kam_iso = '%s'",mysql_real_escape_string($_GET['val']));
				mysql_query($query);
			}
			else{
				print "ISO: " . $text[101];
			}
		}		
		//Set Exposure Mode
		else if($_GET['pipe'] == 'em'){
			$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
				file_put_contents($file, 'em ' . $_GET['val']);
				print "Exposure Mode: " . $_GET['val'];
				//Query update database
				$query = sprintf("UPDATE tbl_kamera SET kam_exp = '%s'",mysql_real_escape_string($_GET['val']));
				mysql_query($query);
		}				
		//Set White balance
		else if($_GET['pipe'] == 'wb'){
			$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
				file_put_contents($file, 'wb ' . $_GET['val']);
				print "White Balance: " . $_GET['val'];
				//Query update database
				$query = sprintf("UPDATE tbl_kamera SET kam_wb = '%s'",mysql_real_escape_string($_GET['val']));
				mysql_query($query);
		}						
		//Set Image effect
		else if($_GET['pipe'] == 'ie'){
			$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
				file_put_contents($file, 'ie ' . $_GET['val']);
				print "Image Effect: " . $_GET['val'];
				//Query update database
				$query = sprintf("UPDATE tbl_kamera SET kam_eff = '%s'",mysql_real_escape_string($_GET['val']));
				mysql_query($query);
		}	
	}
}
?>