<?php

$connect = mysqli_connect('localhost','root','','database_by_pos')or
die("error:".mysqli_error($connect));

if ($connect->connect_error) {
    die("Connection Failed: " . $connect->connect_error);
}
 /* echo "Connected Successfully<br>";*/

//Set ว/ด/ป เวลา ให้เป็นของประเทศไทย
date_default_timezone_set('Asia/Bangkok');

$date_added=date("Y-m-d");
$date_d_m_Y =date("d-m-Y");

$date_m_ =date("m");
$date_y_ =date("y");
$date_d_ =date("d");




$time =date("h:i:sa"); 
$date_time =date("Y-m-d h:i:sa"); 
//echo $date_added ;
//echo date("Y-m-d h:i:sa"); 
  ?>
