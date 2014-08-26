<?php
//Start sesi user
	session_start();
//Fungsi untuk inisialisasi serial port

function common_init_serial($dev){
	//Set permission ke 777 (Read, Write, Execute) Untuk semua orang
	shell_exec('sudo chmod 777 ' . $dev);
	//Siapkan parameter komunikasi serial
	shell_exec('sudo /bin/stty -F ' . $dev . ' cs8 9600 ignbrk -brkint -imaxbel -opost -onlcr -isig -icanon -iexten -echo -echoe -echok -echoctl -echoke noflsh -ixon -crtscts');	
}


//Fungsi untuk mencetak bahasa yg sedang digunakan
function common_current_language(){
	if($_SESSION['lang'] == 'id'){
		return 'Bahasa Indonesia';
	}
	else if($_SESSION['lang'] == 'en'){
		return 'English';
	}
}

//Fungsi untuk menscan serial port yang tersedia
function common_serial_scan() {
	//Daftar perangkat serial, untuk Linux akan dimulai dengan ttyACMx atau ttyUSBx
	$acm = "ttyACM";
	$usb = "ttyUSB";
	//Dapatkan daftar perangkat yang terhubung ke komputer
	$cmd = shell_exec('ls /dev/');
	//Cari perangkat serial yang tersedia
	//cari ACM
	$flagACM = strpos($cmd, $acm);
	//cari USB
	$flagUSB = strpos($cmd, $usb);
	
	//Buat array untuk menyimpan daftar perangkat dengan alamat serial
	//yang tersedia
	$devList = array();
	
	//Query perangkat
	if($flagACM == true){
		//Pisahkan nilai raw berdasarkan string acm
		$rawACM = explode($acm, $cmd);
		
		//Cek string hasil explode untuk mencari nomer ACM
		foreach($rawACM as $raw){
			//Variabel untuk menyimpan nomer ACM yang terdeteksi
			$buildDev = '';
			//Get karakter pertama dari hasil explode
			$firstChar = substr($raw, 0, 1);
			//Cek karakter kesatu apakah numerik		
			if(is_numeric($firstChar)){
				//Jika iya, simpan ke nomer digit pertama
				$buildDev .= $firstChar; 
				//Get karakter kedua
				$secondChar = substr($raw, 1, 1);
				//Cek karakter kedua apakah numerik
				if(is_numeric($secondChar)){
					//Jika iya, simpan digit kedua
					$buildDev .= $secondChar; 
					//Get karakter ketiga apakah numerik
					$thirdChar = substr($raw, 2, 1);
					//Cek karakter ketiga
					if(is_numeric($thirdChar)){
						//Jika iya, simpan digit ketiga
						$buildDev .= $thirdChar; 
					}
				}
				//Selesai, sekarang tambahkan alamat lengkap port serial
				//diikuti digit nomer port
				$devList[] = '/dev/ttyACM' . $buildDev;
			}
		}
	}
	if($flagUSB == true) {
		//Pisahkan nilai raw berdasarkan string usb
		$rawUSB = explode($usb, $cmd);
		
		//Cek string hasil explode untuk mencari nomer USB
		foreach($rawUSB as $raw){
			//Variabel untuk menyimpan nomer USB yang terdeteksi
			$buildDev = '';
			//Get karakter pertama dari hasil explode
			$firstChar = substr($raw, 0, 1);
			//Cek karakter kesatu apakah numerik		
			if(is_numeric($firstChar)){
				//Jika iya, simpan ke nomer digit pertama
				$buildDev .= $firstChar; 
				//Get karakter kedua
				$secondChar = substr($raw, 1, 1);
				//Cek karakter kedua apakah numerik
				if(is_numeric($secondChar)){
					//Jika iya, simpan digit kedua
					$buildDev .= $secondChar; 
					//Get karakter ketiga apakah numerik
					$thirdChar = substr($raw, 2, 1);
					//Cek karakter ketiga
					if(is_numeric($thirdChar)){
						//Jika iya, simpan digit ketiga
						$buildDev .= $thirdChar; 
					}
				}
				//Selesai, sekarang tambahkan alamat lengkap port serial
				//diikuti digit nomer port
				$devList[] = '/dev/ttyUSB' . $buildDev;
			}
		}
	}
	//Kembalikan daftar perangkat serial yang terdeteksi
	return $devList;
}


//Fungsi untuk mengecek perangkat serial yang merupakan
//perangkat mekanik robot
function common_serial_get_connected_device($query,$pass){
//Inisialisasi serial port
	//Sertakan library php serial untuk menggunakan fungsi
	//php yang mendukung komunikasi serial
	require_once("php_serial.class.php");
	//Inisialisasi parameter serial
	$serial = new phpSerial();	
	//baud rate
	$serial->confBaudRate(9600);
	$devList = common_serial_scan();
	foreach($devList as $dev){
		//Siapkan port arduino untuk bisa digunakan
		common_init_serial($dev);	
		//Alamat perangkat
		$serial->deviceSet($dev);
		//Buka koneksi (tulis)
		$serial->deviceOpen('w+');
		//kirim query (delay 1 detik)
		$serial->sendMessage($query,1);
		//baca balasan
		$mp = $serial->readPort();
		//tutup koneksi
		$serial->deviceClose();	

		//cek hasil query
		if($mp == $pass){
			//Jika respon sama dengan query
			//kembalikan alamat perangkat terkoneksi
			return $dev;
		}
		else{
			return false;
		}
	}
}

//Fungsi untuk mengirim perintah ke serial tampa memperdulikan feedbacknya
function common_serial_write($query, $dev){
	//Inisialisasi serial port
	//Siapkan port arduino untuk bisa digunakan
	//common_init_serial($dev);
	//Sertakan library php serial untuk menggunakan fungsi
	//php yang mendukung komunikasi serial
	require_once("php_serial.class.php");
	//Inisialisasi parameter serial
	$serial = new phpSerial();	
	//Alamat perangkat
	$serial->deviceSet($dev);
	//baud rate
	$serial->confBaudRate(9600);
	//Buka koneksi (tulis)
	$serial->deviceOpen('w+');
	//kirim query (delay 1 detik)
	$serial->sendMessage($query,0);
	//baca balasan
	$mp = $serial->readPort();
	//tutup koneksi
	$serial->deviceClose();
	//kembalikan hasil
	return null;
}

//Fungsi untuk mengirim perintah ke serial dan mendapatkan feedbacknya
function common_serial_read($query, $dev){
	//Inisialisasi serial port
	//Siapkan port arduino untuk bisa digunakan
	//common_init_serial($dev);
	//Sertakan library php serial untuk menggunakan fungsi
	//php yang mendukung komunikasi serial
	require_once("php_serial.class.php");
	//Inisialisasi parameter serial
	$serial = new phpSerial();	
	//Alamat perangkat
	$serial->deviceSet($dev);
	//baud rate
	$serial->confBaudRate(9600);
	//Buka koneksi (tulis)
	$serial->deviceOpen('w+');
	//kirim query (delay 1 detik)
	$serial->sendMessage($query,1);
	//baca balasan
	$mp = $serial->readPort();
	//tutup koneksi
	$serial->deviceClose();
	//kembalikan hasil
	return $mp;
}


//Fungsi untuk inisialisasi parameter perangkat,
//dan menyimpan parameter perangkat pada database
function common_device_init(){
	//Get perangkat mekanik yang terhubung
	//Get query dan pass
	$query = "SELECT * FROM tbl_konfigurasi";
	$conf = mysql_fetch_assoc(mysql_query($query));
	//Reset FIFO Camera
	$file = $_SERVER['DOCUMENT_ROOT'] . '/FIFO';
	file_put_contents($file, '');
	//Get parameter mekanik yang diambil dari database
	$query = $conf['konfigurasi_query'];
	$pass = $conf['konfigurasi_pass'];
	$pwm = $conf['konfigurasi_pwm'];
	$servoX = $conf['konfigurasi_servoX'];
	$servoY = $conf['konfigurasi_servoY'];
	$laser = $conf['konfigurasi_laser'];
	$flash = $conf['konfigurasi_flash'];
	
	$dev = common_serial_get_connected_device($query, $pass);
	//Set variabel dev menjadi variabel sesi agar mudah diakses
	if(empty($dev) || !isset($dev)){
 		$dev = '/dev/null';
	}
	$_SESSION['dev'] = $dev;
	//Simpan alamat perangkat terhubung
	$query = sprintf("UPDATE tbl_konfigurasi SET konfigurasi_dev = '%s'", mysql_real_escape_string($dev));
	//Eksekusi query
	mysql_query($query);
	//Inisialisasi perangkat agar bisa digunakan
	common_init_serial($dev);
	//Set parameter mekanik sebelumnya
	common_serial_write('m'.$servoX.'o'.$servoY.'o',$dev);
	common_serial_write('p'.$pwm.'o',$dev);
}

//Fungsi untuk menscan jaringan wi-fi yg tersedia
function common_wlan_scan(){
	global $text;
	//get output dari iwlist
	$iw_ssid = shell_exec('sudo /sbin/iwlist wlan0 scan');
	$iw_mac = $iw_ssid;
	$iw_quality = $iw_ssid;
	
	$iw_ssid = explode('ESSID:"', $iw_ssid);
	$iw_mac = explode('Address:', $iw_mac);
	$iw_quality = explode('Quality=', $iw_quality);
	
	//get sssid
	$data_ssid = array();
	$counter = 0;
	foreach($iw_ssid as $ssid){
		$tmp = explode('"',$ssid);
		if(!empty($tmp[0]) && $counter != 0){
			$data_ssid[] = $tmp[0];
		}
		$counter++;
	}
	
	//get mac address
	$data_mac = array();
	$counter = 0;
	foreach($iw_mac as $mac){
		$tmp = explode(' ',$mac);
		if(!empty($tmp[1]) && $counter != 0){
			$data_mac[] = $tmp[1];
		}
		$counter++;
	}
	
	//get kekuatan sinyal
	$data_quality = array();
	$counter = 0;
	foreach($iw_quality as $signal){
		$tmp = explode('  ',$signal);
		if(!empty($tmp[0]) && $counter != 0){
			$tmpb = explode('/',$tmp[0]);
			$a = $tmpb[0];
			$b = $tmpb[1];
			$c = number_format(($a/$b) * 100,0,',','.');
			$data_quality[] = $c;
		}
		$counter++;
	}
	
	$result = array(
		'ssid' 		=> $data_ssid,
		'mac' 		=> $data_mac,
		'signal'	=> $data_quality
	);	
	return $result;
}

//Fungsi untuk mendapatkan konfigurasi access point perangkat
function common_get_ap_config($tipe){
	$file = '/etc/wpa_supplicant/wpa_supplicant.conf';
	$curr = file_get_contents($file);
	
	if($tipe == 'ssid'){
		//get current ssid
		$conf = explode('#ap-main-ssid',$curr);
		$conf = $conf[1];
		$conf = explode('=',$conf);
		$ssid = trim(str_replace('"','',$conf[1]));
		return $ssid;
	}
	else if($tipe == 'psk'){
		//get current pass
		$conf = explode('#ap-main-psk',$curr);
		$conf = $conf[1];
		$conf = explode('=',$conf);
		$psk = trim($conf[1]);
		return $psk;
	}
	else if($tipe == 'ssid-b'){
		//get current ssid
		$conf = explode('#ap-backup-ssid',$curr);
		$conf = $conf[1];
		$conf = explode('=',$conf);
		$ssid = trim(str_replace('"','',$conf[1]));
		return $ssid;
	}
	else if($tipe == 'psk-b'){
		//get current pass
		$conf = explode('#ap-backup-psk',$curr);
		$conf = $conf[1];
		$conf = explode('=',$conf);
		$psk = trim($conf[1]);
		return $psk;
	}	
	return null;
}


//Fungsi untuk mendapatkan konfigurasi alamat jaringan yg sedang dipakai
function common_get_network_config($net){
	$file = '/etc/network/interfaces';
	$curr = file_get_contents($file);
	if($net == 'ip'){		
		$curr_ip = explode('#ip',$curr);
		$curr_ip = $curr_ip[1];
		$curr_ip = explode(' ', $curr_ip);
		$curr_ip = trim($curr_ip[1]);
		
		return $curr_ip;
	}
	else if($net == 'subnet'){
		$curr_subnet = explode('#subnet',$curr);
		$curr_subnet = $curr_subnet[1];
		$curr_subnet= explode(' ', $curr_subnet);
		$curr_subnet = trim($curr_subnet[1]);
		
		return $curr_subnet;
	}
	else if($net == 'gw'){
		$curr_gw = explode('#gw',$curr);
		$curr_gw = $curr_gw[1];
		$curr_gw= explode(' ', $curr_gw);
		$curr_gw = trim($curr_gw[1]);
		
		return $curr_gw;
	}
	else if($net == 'dns'){
		$curr_dns = explode('#dns',$curr);
		$curr_dns = $curr_dns[1];
		$curr_dns= explode(' ', $curr_dns);
		$curr_dns = trim($curr_dns[1]);
		
		return $curr_dns;
	}	
	
	return null;
}

?>
