<?php
error_reporting(-1);
//Inisialisasi database
$con = mysql_connect("localhost","govinda","YP3RHDbQpAFDATeA");
if (!$con)
  {
  die('Tidak bisa menghubung ke database : ' . mysql_error());
  }
mysql_select_db("govinda", $con);

//Set Timezone
date_default_timezone_set('Asia/Makassar');
?>