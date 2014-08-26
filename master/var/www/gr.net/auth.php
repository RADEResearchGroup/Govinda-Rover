<?php
	//Start Sesi User
	require_once('include/common.php');
	//Sertakan fungsi display.php
	require_once('include/display.php');
	//Sertakan fungsi user.php
	require_once('include/user.php');
	//Sertakan file text antarmuka
	require_once('include/lang.php');
	//Set judul halaman
	$title = $text[4] . " | " . $text[3];
	
	//Proses logout apabila diminta
	if(isset($_SESSION['id'])){
		user_do_logout();
	}
	//Disable wizard bila tanda wizard selesai diset
	if(isset($_SESSION['wizard']) && $_SESSION['wizard'] == 0){
		$query = 'UPDATE tbl_konfigurasi SET konfigurasi_wizard = 0';
		mysql_query($query);
	}
	
	//Proses informasi login bila ada
	if(isset($_POST['email']) && isset($_POST['password'])){
		user_do_login($_POST['email'], $_POST['password']);
	}
	//Sertakan file header
	require_once('include/header.php');	
	
	//Get language
	$query = "SELECT * FROM tbl_konfigurasi";
	$conf = mysql_fetch_assoc(mysql_query($query));
	//set bahasa
	$_SESSION['lang'] = $conf['konfigurasi_lang'];
?>
    <div class="container">
		<?php if(isset($_SESSION['pesan'])){
			print display_print_message($_SESSION['pesan']);
			//Unset variable pesan setelah selesai digunakan
			unset($_SESSION['pesan']);			
		} ?>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title text-center text-primary">Check Point</h4>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="/auth.php" method="post" id="user-login" accept-charset="UTF-8">
                            <fieldset>
                                <div class="form-group" action>
                                    <input class="form-control" placeholder="<?php print $text[1];?>" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="<?php print $text[2];?>" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-default"><?php print $text[0];?></button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php 
	//Sertakan file footer
	require_once('include/footer.php');	
?>