<?php
//Sertakan file database (db.php) untuk menggunakan fungsi database
require_once('db.php');
//Sertakan file fungsi umum (common.php)
require_once('common.php');
//Sertakan file text antarmuka
require_once('lang.php');

//Fungsi untuk mencetak form pilih bahasa
function display_print_user_lang(){
	global $text;
	$format = '
		<div id="group-lang" class="form-group">
					<label>' . $text[159] . '</label>
					<select id="lang" name="lang" class="form-control">
					<option value="' . $_SESSION['lang'] . '">' . common_current_language() . '</option>
					<option value="id">Bahasa Indonesia</option>
					<option value="en">English</option>
					</select>
		</div>	
		<hr>
	';
	return $format;
}


//Fungsi untuk mencetak form konfigurasi pengguna
function display_print_user_config(){
	global $text;
	$format = '
		<div class="alert alert-success pesan-hide" role="alert"></div>
		<fieldset>
			<form id="form-set-user" action="" method="POST">
			<legend>' . $text[144] . '</legend>
			<div id="group-old-username" class="form-group">
				<label>' . $text[145] . '</label>
				<input name="old-username" class="form-control" value="">
			</div>
			<div id="group-old-pass" class="form-group">
				<label>' . $text[146] . '</label>
				<input type="password" name="old-pass" class="form-control" value="">
			</div>
			<div id="group-new-username" class="form-group">
				<label>' . $text[147] . '</label>
				<input name="new-username" class="form-control" value="">
			</div>
			<div id="group-new-pass" class="form-group">
				<label>' . $text[148] . '</label>
				<input type="password" name="new-pass" class="form-control" value="">
			</div>			
			<div id="group-new-passc" class="form-group">
				<label>' . $text[149] . '</label>
				<input type="password" name="new-passc" class="form-control" value="">
			</div>						
			<button id="tombol-simpan-config-ap" type="submit" class="btn btn-outline btn-success">' . $text[132] . '</button>
			</form>
		</fieldset>		
	';
	return $format;
}


//Fungsi untuk mencetak form konfigrasi access point
function display_print_ap_config(){
	global $text;	
	$format = '
		<div class="alert alert-success pesan-hide" role="alert"></div>
		<fieldset>
			<form id="form-set-ap" action="" method="POST">
			<legend>' . $text[137] . '</legend>
			<div id="group-ssid" class="form-group">
				<label>' . $text[136] . '</label>
				<input name="ssid" class="form-control" value="' . common_get_ap_config('ssid') . '">
				<p class="help-block">' . $text[138] . '</p>
			</div>
			<div id="group-psk" class="form-group">
				<label>' . $text[2] . '</label>
				<input type="password" name="psk" class="form-control" value="">
				<p class="help-block">' . $text[139] . '</p>
			</div>
			<div id="group-ssid-b" class="form-group">
				<label>' . $text[143] . '</label>
				<input name="ssid-b" class="form-control" value="' . common_get_ap_config('ssid-b') . '">
				<p class="help-block">' . $text[142] . '</p>
			</div>
			<div id="group-psk-b" class="form-group">
				<label>' . $text[2] . '</label>
				<input type="password" name="psk-b" class="form-control" value="">
				<p class="help-block">' . $text[139] . '</p>
			</div>			
			<button id="tombol-simpan-config-ap" type="submit" class="btn btn-outline btn-success">' . $text[132] . '</button> <button id="tombol-scan-ap" type="button" class="btn btn-outline btn-danger">' . $text[141] . '</button>
			</form>
		</fieldset>		
	';
	return $format;
}

//Fungsi untuk menampilkan data lingkungan
function display_get_lingkungan($display){
	//Select query
	$query = "SELECT * FROM tbl_kondisi_lingkungan WHERE 1 ORDER BY id DESC LIMIT 10";
	//eksekusi
	$tbl = mysql_query($query);
	//variable untuk menyimpan data yg telah diformat
	global $text;
	if($display == 'table'){
		$format = '';
		$format .= '<thead>
													<tr>
														<th>'. $text[42] .' </th>
														<th>'. $text[43].'</th>
														<th>'. $text[44].'</th>
														<th>'. $text[45].'</th>
													</tr>
												</thead>
												<tbody>
		';
		while($data = mysql_fetch_assoc($tbl)){
			$format .= '
		<tr>
			<td>'. $data['id'] .'</td>
			<td>'. $data['lingkungan_suhu'] .' C</td>
			<td>'. $data['lingkungan_kelembapan'] .' %</td>
			<td>'. $data['lingkungan_waktu'] .'</td>
		</tr>';
		}
		$format .= '</tbody>';
		return $format;
	}
	else if($display == 'js'){
		//siapkan data
		$query = "SELECT * FROM tbl_kondisi_lingkungan WHERE 1 ORDER BY id DESC LIMIT 10";
		//eksekusi
		$tbl = mysql_query($query);
		//get data
		$data = mysql_fetch_assoc($tbl);
		$format = '';
		$format .= '
			<script>
				var suhu = ' . $data['lingkungan_suhu'] . ';
				var klmb = ' . $data['lingkungan_kelembapan'] . ';
				var gas = ' . $data['lingkungan_gas'] . ';
				var waktu = "' . $data['lingkungan_waktu'] . '";
			</script>
		';
		return $format;
	}
	return '';
}

//Fungsi untuk mencetak form konfigurasi WLAN
function display_print_config_wlan(){
	global $text;
	$format = '
		<div class="alert alert-success pesan-hide" role="alert"></div>
		<fieldset>
			<form id="form-set-wlan" action="" method="POST">
			<legend>' . $text[53] . '</legend>
			<div id="group-ip" class="form-group">
				<label>' . $text[121] . '</label>
				<input name="ip" class="form-control" placeholder="' . $text[123] .  '" value="' . common_get_network_config('ip') . '">
				<p class="help-block">' . $text[122] . '</p>
			</div>
			<div id="group-subnet" class="form-group">
				<label>' . $text[124] . '</label>
				<select name="subnet" class="form-control">
				<option value="' . common_get_network_config('subnet') . '">' . common_get_network_config('subnet') . '</option>
				<option value="">' . $text[74] . '</option>
				<option value="255.255.255.0">255.255.255.0</option>
				<option value="255.255.0.0">255.255.0.0</option>
				<option value="255.0.0.0">255.0.0.0</option>
				</select>
			<p class="help-block">' . $text[125] . '</p>
			</div>
			<div id="group-gw" class="form-group">
				<label>' . $text[126] . '</label>
				<input name="gw" class="form-control" placeholder="' . $text[130] .  '" value="' . common_get_network_config('gw') . '">
				<p class="help-block">' . $text[127] . '</p>
			</div>
			<div id="group-dns" class="form-group">
				<label>' . $text[128] . '</label>
				<input name="dns" class="form-control" placeholder="' . $text[131] .  '" value="' . common_get_network_config('dns') . '">
				<p class="help-block">' . $text[129] . '</p>
			</div>
			<button id="tombol-simpan-config-jaringan" type="submit" class="btn btn-outline btn-success">' . $text[132] . '</button>
			</form>
		</fieldset>		
	';
	
	return $format;
}


//Fungsi untuk mencetak pesan antarmuka
function display_print_message($msg){
	$pesan = $msg[0];
	$tipe = $msg[1];
	//tentukan format pesan berdasarkan tipe pesan
	if($tipe == 1){
		$class = 'alert-success';
	}
	else if($tipe == 2){
		$class = 'alert-info';
	}
	else if($tipe == 3){
		$class = 'alert-warning';
	}
	else if($tipe == 4){
		$class = 'alert-danger';
	}
	else {
		$class = 'alert-info';
	}
	
	$format = '<div class="row">
          <div class="col-lg-12">
            <div class="padding-top-20">
              <div class="alert alert-dismissable '. $class .'">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p>' . $pesan . '</p>
              </div>
            </div>
          </div>
        </div>';
	return $format;
}



//Fungsi untuk mencetak data sistem
function display_print_data_sistem(){
	//get kecepatan jaringan
	$net = shell_exec('/sbin/ifconfig wlan0');
	$net = explode('TX bytes:',$net);
	$net = explode(' ',$net[1]);
	$before = $net[0];			
	sleep(1);					
	$net = shell_exec('/sbin/ifconfig wlan0');
	$net = explode('TX bytes:',$net);
	$net = explode(' ',$net[1]);				
	$after = $net[0];
	$speed = number_format(((($after - $before) * 10) / 1024),2,'.',',');
	
	//get ram terpakai
	$free = shell_exec('free');
    $free = (string)trim($free);
    $free_arr = explode("\n", $free);
    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem);
    $mem = array_merge($mem);
    $memory_usage = number_format($mem[2]/$mem[1]*100, 2, '.', ',');
	
	//get cpu terpakai
	$load = sys_getloadavg();
	$load = $load[0];
	
	
	$format = '';
	$format .= '
		<script>
			var mem = ' . $memory_usage . ';
			var cpu = ' . $load . ';
			var net = ' . $speed . ';
			var waktu = "' . date('Y-m-d H:i:s') . '";
		</script>
	';
    return $format;
}

//Fungsi untuk mencetak form konfigurasi sistem
function display_print_config_system(){
	global $text;
	
	$format = '';
	$format .= '
	<fieldset>
	<legend>' . $text[54] . '</legend>
		<div class="form-group">
            <label>' . $text[55] . '</label>
			<input type="file">
        </div>
	</fieldset>
	';
	return $format;
}

//Fungsi untuk mencetak form konfigurasi kamera
function display_print_config_camera(){
	global $text;
	
	$format = '';
	$format .= '
		<script type="text/javascript" src="/js/cam.js"></script>
		<fieldset>
			<legend>' . $text[71] . '</legend>
			<fieldset>
				<legend>' . $text[72] . '</legend>
				<div class="form-group">
					<label>' . $text[73] . '</label>
						<select class="form-control" onclick="set_preset(this.value)">
							<option value="1920 1080 25 25 2592 1944">' . $text[74] . '</option>
							<option value="1920 1080 25 25 2592 1944">Std FOV</option>
							<option value="1296 0730 25 25 2592 1944">16:9 wide FOV</option>
							<option value="1296 0976 25 25 2592 1944">4:3 full FOV</option>
							<option value="1920 1080 01 30 2592 1944">Std FOV, x30 Timelapse</option>
						</select>
				</div>
				<label>' . $text[75] . '</label>
				<hr>
				<div class="form-group">
					<label>' . $text[76] . '</label>
					<div class="form-group input-group">
						<input class="form-control" type="text" size="4" id="video_width">
						<span class="input-group-addon">X</span>						
						<input  class="form-control type="text" size="4" id="video_height">
						<span class="input-group-addon">px</span>
					</div>
				</div>
				<div class="form-group">
					<label>' . $text[77] . '</label>
					<div class="form-group input-group">
						<input class="form-control" type="text" size="2" id="video_fps">
						<span class="input-group-addon">recording, </span>						
						<input  class="form-control type="text" size="2" id="MP4Box_fps">
						<span class="input-group-addon">boxing</span>						
					</div>
				</div>
				<div class="form-group">
					<label>' . $text[78] . '</label>
					<div class="form-group input-group">
						<input class="form-control" type="text" size="4" id="image_width">
						<span class="input-group-addon">X</span>
						<input class="form-control" type="text" size="4" id="image_height">
						<span class="input-group-addon">px</span>
					</div>
				</div>				
				<input class="btn btn-default" type="button" value="OK" onclick="set_res();">
			
			</fieldset>
		</fieldset>
	';
	
	return $format;
}

//Fungsi cetak page wrapper top
function display_print_page_wrapper_top(){
	$format = '';
	$format .= '
	<div id="page-wrapper">
           <!-- /.row -->
        <div class="row padding-top-20">
			<div class="col-lg-12">
	
	';
	return $format;
}

//Fungsi cetak page wrapper bottom
function display_print_page_wrapper_bottom(){
	$format = '';
	$format .= '
			</div>
		</div>
	</div>
	';
	return $format;
}

//Fungsi get status flag modul
function display_print_status($modul){
	$query = 'SELECT * FROM tbl_konfigurasi';
	$config = mysql_fetch_assoc(mysql_query($query));
	$flash = $config['konfigurasi_flash'];
	$laser = $config['konfigurasi_laser'];
	
	//Jika yg diminta status flash
	if($modul == 'flash'){
		if($flash == '1'){
			return 'checked';
		}
	}
	else if($modul == 'laser'){
		if($laser == '1'){
			return 'checked';
		}
	}
	else if($modul == 'servoX'){
		return $config['konfigurasi_servoX'];
	}
	else if($modul == 'servoY'){
		return $config['konfigurasi_servoY'];
	}
	else if($modul == 'pwm'){
		return $config['konfigurasi_pwm'];
	}
	
	return '';
}


//Fungsi get konfigurasi kamera
function display_print_config_cam($cam){
	$query = 'SELECT * FROM tbl_kamera';
	$config = mysql_fetch_assoc(mysql_query($query));
	$sh = $config['kam_sh'];
	$co = $config['kam_co'];
	$br = $config['kam_br'];
	$sa = $config['kam_sa'];
	$iso = $config['kam_iso'];
	$wb = $config['kam_wb'];
	$exp = $config['kam_exp'];
	$eff = $config['kam_eff'];
	
	//Jika yg diminta status flash
	if($cam == 'sh'){
		return $sh;
	}
	else if($cam == 'co'){
		return $co;
	}
	else if($cam == 'br'){
		return $br;
	}
	else if($cam == 'sa'){
		return $sa;
	}
	else if($cam == 'iso'){
		return $iso;
	}
	else if($cam == 'wb'){
		return $wb;
	}
	else if($cam == 'ie'){
		return $eff;
	}
	else if($cam == 'em'){
		return $wb;
	}
	
	
	return '';
}

//Fungsi untuk mencetak tabel hasil scan wlan
function display_print_scan_wlan($result){
	$data_ssid = $result['ssid'];
	$data_mac = $result['mac'];
	$data_quality = $result['signal'];
	global $text;
	$format = '<fieldset><legend>'.$text[120].'</legend><div class="table-responsive"><table class="table table-hover table-striped"><thead>';
	$format .= '
			<tr>
				<th>No.</th>
				<th>' . $text[116] . '</th>
				<th>' . $text[117] . '</th>
				<th>' . $text[118] . '</th>
			</tr>
	</thead><tbody>';
	$counter = 0;
	foreach($data_ssid as $ssid){
		$no = $counter + 1;
		$format .= '
			<tr>
				<td>' . $no . '</td>
				<td>' . $ssid . '</td>
				<td>' . $data_mac[$counter] . '</td>
				<td>
					<div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="' . $data_quality[$counter] . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $data_quality[$counter] . '%">
							' . $data_quality[$counter] . '%
						</div>
                    </div>
				</td>
			</tr>
		';
		$counter++;
	}
	$format .= '</tbody></table></div></fieldset>';
	
	return $format;
}
?>
