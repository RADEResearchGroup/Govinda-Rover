<?php
//Sertakan file database (db.php) untuk menggunakan fungsi database
require_once('db.php');
//Sertakan file fungsi umum (common.php)
require_once('common.php');


//Fungsi untuk mengupdate data pengguna ke database
function updater_update_data_user($data){	
	//	id	user_name	user_pass	user_namaDepan	user_namaBlk	user_role	user_registTimestam
	$old_uname = $data[0];
	$old_pass = $data[1];
	
	//Dapatkan data pengguna baru
	$new_uname = $data[2];
	$new_pass = $data[3];
	
	//Update data pengguna
	$query = sprintf("UPDATE tbl_user SET user_name = '%s', user_pass = '%s' WHERE user_name = '%s' AND user_pass = '%s'",
		mysql_real_escape_string($new_uname), mysql_real_escape_string($new_pass), mysql_real_escape_string($old_uname),
			mysql_real_escape_string($old_pass));
	mysql_query($query);
}


//Fungsi untuk mengupdate data lingkungan ke database
function updater_update_data_lingkungan(){
	//Dapatkan data lingkungan
	$raw = common_serial_read('t', $_SESSION['dev']);
	$raw = explode(':',$raw);	
	$suhu = $raw[0];
	$klmb = $raw[1];
	$gas = ($raw[2] / 1024) * 100 ;
	
	//Update database
	//Build insert query
	/**$query = sprintf("INSERT INTO `tbl_kondisi_lingkungan` (`id`, `lingkungan_suhu`, `lingkungan_kelembapan`, `lingkungan_gas`,
		`lingkungan_waktu`) VALUES (NULL, '%s', '%s', '%s', CURRENT_TIMESTAMP)", mysql_real_escape_string($suhu), 
							mysql_real_escape_string($klmb),mysql_real_escape_string($gas));**/
	if(is_numeric($klmb) && is_numeric($suhu) && is_numeric($gas)){
		$query = sprintf("UPDATE tbl_kondisi_lingkungan SET lingkungan_suhu = '%s', lingkungan_kelembapan = '%s', lingkungan_gas = '%s', lingkungan_waktu = CURRENT_TIMESTAMP WHERE 1",
			mysql_real_escape_string($suhu),mysql_real_escape_string($klmb),mysql_real_escape_string($gas));
		//eksekusi insert query
		mysql_query($query);
	}
	
}

//Fungsi untuk mengupdate konfigurasi alamat jaringan
function updater_update_network_address($add){
	$file = '/etc/network/interfaces';
	$conf_old = file_get_contents($file);
	
	//pengaturan lama
	$curr_ip = common_get_network_config('ip');
	$curr_subnet = common_get_network_config('subnet');
	$curr_gw = common_get_network_config('gw');
	$curr_dns = common_get_network_config('dns');
	
	//pengaturan baru
	$new_ip = $add[0];
	$new_subnet = $add[1];
	$new_gw = $add[2];
	$new_dns = $add[3];
	
	//replace
	//ip
	$conf_new = str_replace($curr_ip, $new_ip, $conf_old);
	//subnet
	$conf_new = str_replace($curr_subnet, $new_subnet, $conf_new);
	//gw
	$conf_new = str_replace($curr_gw, $new_gw, $conf_new);
	//dns
	$conf_new = str_replace($curr_dns, $new_dns, $conf_new);
	
	//Tulis pengaturan
	file_put_contents($file, $conf_new);
}

//Fungsi untuk mengupdate konfigurasi access point
function updater_update_network_ap($add){
	$file = '/etc/wpa_supplicant/wpa_supplicant.conf';
	$conf_old = file_get_contents($file);
	
	//pengaturan lama
	$curr_ssid = common_get_ap_config('ssid');
	$curr_psk = common_get_ap_config('psk');
	$curr_ssidb = common_get_ap_config('ssid-b');
	$curr_pskb = common_get_ap_config('psk-b');
	
	//pengaturan baru
	$new_ssid = $add[0];
	$new_psk = $add[1];
	$r = shell_exec('/usr/bin/wpa_passphrase ' . $new_ssid . ' ' . $new_psk);
	$psk = explode('psk=',$r);
	$psk = explode('
',$psk[2]);
	$new_psk = $psk[0];
	
	//print $new_psk;
	
	$new_ssidb = $add[2];
	$new_pskb = $add[3];
	$r = shell_exec('/usr/bin/wpa_passphrase ' . $new_ssidb . ' ' . $new_pskb);
	$psk = explode('psk=',$r);
	$psk = explode('
',$psk[2]);
	$new_pskb = $psk[0];
	
	//replace
	//ssid utama
	$conf_new = str_replace($curr_ssid, $new_ssid, $conf_old);
	//psk
	$conf_new = str_replace($curr_psk, $new_psk, $conf_new);
	//ssid backup
	$conf_new = str_replace($curr_ssidb, $new_ssidb, $conf_new);
	//psk
	$conf_new = str_replace($curr_pskb, $new_pskb, $conf_new);
	
	//Tulis pengaturan
	file_put_contents($file, $conf_new);
	//return '<pre>' . $conf_old . $conf_new . '</pre>';
}
?>