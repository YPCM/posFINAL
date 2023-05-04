<?php
$server="localhost";
$username="root";
$conpassword="";
$database="database_by_pos";

$connect = mysqli_connect($server,$username,$conpassword,$database)or
die("error:".mysqli_error($connect));

if ($connect->connect_error) {
    die("Connection Failed: " . $connect->connect_error);
}



date_default_timezone_set('Asia/Bangkok');

$date_added=date("Y-m-d");
$date_d_m_Y =date("d-m-Y");

$date_m_ =date("m");
$date_y_ =date("y");
$date_d_ =date("d");

$time =date("h:i:sa"); 
$date_time =date("Y-m-d h:i:sa"); 

  ?>
