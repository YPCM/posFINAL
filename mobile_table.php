<?php
include 'connect.php'; 

session_start();
unset($_SESSION["table"]);
/*
print_r($_SESSION['name_login']) ;
print_r($_SESSION['status_login']) ; 
*/

if(!$_SESSION['name_login']){
    session_destroy();
    header('location:index.php');
}
if (isset($_GET['exit'])) { 
    $iduser = $_SESSION['user_id'] ;
    $sqlexit = mysqli_query($connect , "SELECT MAX(`id_history_in_out`) as `id_history_in_out` FROM history_in_out WHERE user_id= '$iduser' ");
    $rowexit = mysqli_fetch_array($sqlexit);
    $user_idexit = $rowexit['id_history_in_out'];


    $sql_order_upnew =  mysqli_query($connect, "UPDATE `history_in_out` SET `date_time_check-out`='$date_time' WHERE id_history_in_out = '$user_idexit' ")
                                                                or die('query failed');
    session_destroy();
    echo "<script>alert('คุณได้ทำการออกจากระบบเรียบร้อยแล้ว!');</script>";
    header('Refresh:0; url=index.php');
}






include_once('function.php');
$insertdata = new DB_con();


if (isset($_POST['insert'])) {
    $table_id=$_POST[''];
    $status=$_POST['0'];
    $date_added = date("Y-m-d");
    $number=$_POST['txtnumber'];
    
    $sql = $insertdata->insert($table_id,$status,$date_added,$number);

    if ($sql) {
        echo "<script>alert('เพิ่มโต๊ะอาหารเรียบร้อยแล้ว!!');</script>";
        echo "<script>window.location.href='01tablenumber_user.php'</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มโต๊ะอาหาร');</script>";
        echo "<script>window.location.href='01tablenumber_user.php'</script>";
    }
}


if (isset($_GET['table'])) {
  
    $_SESSION["table"] = $_GET['table'];
    $table_id = $_SESSION["table"] ;
   /* $table_id  = mysqli_real_escape_string($connect,$_GET['table']);*/

    $tttt = mysqli_query($connect, "SELECT * FROM `table_number` WHERE table_id='$table_id'");
    $cart = mysqli_fetch_array($tttt);
    $table_id = $cart['table_id'];
    $cart1 = $cart['status'];

   /* print_r($_SESSION["table"]); */
    /*$cart = mysqli_num_rows($order_code);*/
    if ($cart1 == 1) {
      /*  $table_id  = mysqli_real_escape_string($connect,$_GET['table']);
        $sql = $insertdata->status_01($table_id);  */


        $order_code = mysqli_query($connect, "SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id'");
        $roworder_code = mysqli_fetch_array($order_code);
        
        $_SESSION["table_order_code"] = $roworder_code['order_code'];
        /*print_r($_SESSION["table_order_code"]);*/
       echo "<script>window.location.href='mobile_list.php'</script>";    
    }else{
        echo "<script>window.location.href='mobile_food.php'</script>";     
    }
    
}

if (isset($_GET['table'])) {

    $table_id  = mysqli_real_escape_string($connect,$_GET['table']);
    $sql = $insertdata->status_01($table_id);

    $_SESSION["table"] = $_GET['table'];
   

   echo "<script>window.location.href='mobile_food.php'</script>";     
}


if (isset($_GET['user'])) {

    session_destroy();
    echo "<script>alert('คุณได้ทำการออกจากระบบเรียบร้อยแล้ว!');</script>";
    header('Refresh:0; url=00login.php');


    /*
    if ($sql) {
        echo "<script>alert('คุณได้ทำการออกจากระบบเรียบร้อยแล้ว!');</script>";
        header('Refresh:0; url=00login.php');
       // echo "<script>window.location.href='00login.php'</script>";
    }*/
}

?>
<!DOCTYPE html>
<html>
<head>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">

<style>
    @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai+Looped:wght@300;400;700&family=Noto+Sans+Thai:wght@300&display=swap');
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family:  'Noto Sans Thai', sans-serif;
    }
    body{
        background-color: rgb(255, 255, 255);
    }
.w3-top{
    background-color: #0984e3;
    color:#fff;
    font-size: 18px;
}
.namefood{
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ggg{
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ggg i{
    font-size: 30px;
}
.btn{
    padding: 16px;
   
}
 .button {
    padding-right: 20px;
    padding-top: 10px;
	position: relative;
	border-radius: 4px;
	/*border: 2px solid white;*/
	/*padding: 15px 30px;*/
	color: white;
	/*background: rgba(0,0,0,.1);*/
	/*box-shadow: 0 2px 10px rgba(0,0,0,.15);*/
	cursor: pointer;
	user-select: none;
	transition: all .3s;
    width: 5px;
    margin-right: 10px;
}
 .button i{
    font-size: 25px;
}
 .button i:hover{
    color: #525252;
}

 .badge {
	border-radius: 50%;
    font-size: 13px;
	width: 20px;
	height: 20px;
	display: block;
	position: absolute;
	background: #de3902;
    box-shadow: 0 2px 10px rgba(0,0,0,.15);
	/*border: 2px solid white;*/
	display: flex;
	align-items: center;
	justify-content: center;
	top: -5px;
	right: -10px;
	transition: all .3s;
}
::-webkit-scrollbar { /* ความกว้าง */
    width: 1px;
  } 
::-webkit-scrollbar-thumb {
    background: #0985e300; 
    border-radius: 1px;
}
.bbb{
    background-color: #fff;
    width: 100%;
    height: 100%;
    color: #000;
}
.user_00{
    background-color: #44a4ed;
   margin-bottom: 2px;
    box-shadow: 0 2px 10px rgba(0,0,0,.15);
}
.user{
    height: 50px;
    font-size: 20px;
    display: flex;
    align-items: center;
    color:#fff;
    font-weight: bold;
}
.user i{
    margin-right: 20px;
    font-size: 30px;
   /* background-color: blueviolet;*/
}
.menu{
    display: flex;
    align-items: center;
    padding: 20px 20px;
    font-size: 18px;
    border-bottom: solid 1px #52525232;
    color: #07548f;
}
.menu i{
    font-size: 26px;
    padding-right: 20px;
    color: #0984e3;
}
.menu span{
    font-size: 26px;
    padding-right: 20px;
    color: #0984e3;
}
.content_00{
    background-color: #000;
    height: 100%;
}
/* จบเมนู */
.box{
    background-color: #0984e3;
    height: 70px;
    color: #fff;
    font-size: 18px;
    padding-left: 20px;
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,.15);
}
.boxcontent{
    padding-top: 20px;
    margin-left: 10px;
}
.table{
    display: flex;
    align-items: center;
   /* background-color: #0984e3;*/
    height: 70px;
    width: 95%;
    margin-bottom: 5px;
    box-shadow: 0 2px 10px rgba(0,0,0,.15);
    border-right: solid 3px #0984e3;
    text-decoration: none;
}
.table .sticky{
  /*  background-color: #0984e3;*/
   /* color: #fff;*/
    height: 100%;
    width: 30%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.table .number{
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bold;
    height: 100%;
    width: 100%;
   /* background-color:  #ffffff;*/
   /* color: #0984e3;*/
}


.notification {
    color: white;
    text-decoration: none;
    margin-right: 20px;
    position: relative;
    display: inline-block;
    border-radius: 2px;
   
  }
  
  

  .notification .badge {
    position: absolute;
    top: -10px;
    right: -10px;
    padding: 5px 10px;
    border-radius: 50%;
    background: red;
    color: white;
  }
</style>

</head>
<body >
<?php
            $user_id = $_SESSION['user_id'];
            $user = mysqli_query($connect," SELECT `user_id`,`user_name`,`id_user_type` FROM `user` WHERE user_id='$user_id' " );
            $row = mysqli_fetch_assoc($user);

            $status = $_SESSION['status_login'] ;
            $user_type = mysqli_query($connect," SELECT * FROM `user_type` WHERE id_user_type='$status' " );
            $rowuser_type = mysqli_fetch_assoc($user_type)
    ?>
<!-- Sidebar (hidden by default) -->
<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
    <div class="bbb" onclick="w3_close()">
        <a href="javascript:void(0)" class="w3-bar-item w3-button user_00" >
            <div class="user">
                <i class='bx bxs-face'></i>
                <span><?php echo $row['user_name']. "  ( " .$rowuser_type['user_type']. " )" ; ?></span>
            </div>
        </a>
        <a href="mobile_table.php" onclick="w3_close()" class="w3-bar-item w3-button ">
            <div class="menu">
                <i class='bx bx-store' ></i>หน้าหลัก
            </div>
        </a>
        <a  type="submit" href="mobile_table.php?exit" onclick="w3_close()" class="w3-bar-item w3-button menu">
            <div class="menu">
                <span class="material-icons">logout</span>ออกจากระบบ
            </div>
        </a>
    </div>
</nav>

<!-- Top menu -->
<div class="w3-top">
  <div class="ggg" style="max-width:1200px;margin:auto">
    <div class="btn" id="btn" onclick="myFunctionmyBtn()"><i class='bx bx-menu'></i></div>
    <div class="w3-right w3-padding-16">ร้านก๊วยจั๊บกำลังภายใน</div>
   <!--
    <div class="w3-right w3-padding-16">
        <a href="#" class="button">
            <span  class="content"><i class='bx bxs-dish'></i></span>
            <span class="badge">0</span>
        </a>    
    </div>
    -->
    <a href="mobile_order.php" class="notification">
        <span><i class='bx bxs-dish'></i></span>
        <?php
                include_once('function.php');
                $fetchdata = new DB_con();
                $sql = $fetchdata->tostatus();
                $row = mysqli_fetch_array($sql);
                if($row>0){
                    echo '<span class="badge">'.$row['TOstatus'].'</span>';
                    }else{
                    echo '<span class="badge">0</span>';
                }
            ?>         
    </a>
  </div>
</div>




<div class="w3-main w3-content w3-padding " style="max-width:1200px;margin-top:90px;">
    <div class="box">
        <p>เลือกโต๊ะก่อนสั่งเมนูอาหาร</p>
    </div>
    <p>สีฟ้า = โต๊ะว่าง , สีเหลือง = มีลูกค้า</p>
    <div class="boxcontent">
                <?php 
                    include_once('function.php');
                    $fetchdata = new DB_con();
                    $sql = $fetchdata->fetchdata();
                    while($row = mysqli_fetch_array($sql)) {
                        
                        if($row['status']==1){                    
                            echo    ' <a class="table " style="background-color: #fff;"  type="submit" name="table" href="mobile_table.php?table='.$row['table_id'].' "  >
                            <span style="background-color: #fec61d; color: white;" class="material-icons sticky">sticky_note_2</span>
                            <div style="border-right: 3px solid  #fec61d;" class="number">'.$row['number'].'</div>
                        </a>';
                        }elseif($row['status']==0){
                            echo    ' <a class="table " style="background-color: #fff;border-right: 3px solid  #0984e3;"  type="submit" name="table" href="mobile_table.php?table='.$row['table_id'].' "  >
                            <span style="background-color: #0984e3; color: white;" class="material-icons sticky">open_in_new</span>
                            <div style="border-right: 3px solid  #0984e3;" class="number">'.$row['number'].'</div>
                        </a>';

                        }elseif($row['status']==0){
                            echo    ' <a class="table " style="display: none;background-color: #fff;border-right: 3px solid  #0984e3;"  type="submit" name="table" href="mobile_table.php?table='.$row['table_id'].' "  >
                            <span style="background-color: #0984e3; color: white;" class="material-icons sticky">open_in_new</span>
                            <div style="border-right: 3px solid  #0984e3;" class="number">'.$row['number'].'</div>
                        </a>';
                        }
                    }
                ?>
     <!--   <a class="table"  href="mobile_food.php">
            <span class="material-icons sticky">sticky_note_2</span>
            <div class="number">01</div>
        </a>
        <a class="table" href="mobile_food.php">
            <span class="material-icons sticky">open_in_new</span>
            <div class="number">02</div>
        </a>

                    -->

    </div>
</div>

  



<script>
// Script to open and close sidebar



function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}

        function  myFunctionmyBtn() {
        var modalid01 = document.getElementById('mySidebar');
        var btn = document.getElementById("btn");
        document.getElementById("mySidebar").style.display = "none";
        // When the user clicks anywhere outside of the modal, close it
            btn.onclick = function() {
                modalid01.style.display = "block";
            } 
            window.onclick = function(event) {
                if (event.target == modalid01) {
                    modalid01.style.display = "none";
                }
            }
        }
</script>

</body>
</html>
