<?php 
include 'connect.php'; 

include_once('function.php');
$db_handle = new DBController();
$insertdata = new DB_con();

session_start();
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



?>
<html lang="en">
<head>
<title>รายการสั่งอาหาร</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<link rel="stylesheet" href="wcss/00mobile.css">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
</head>
<body>
    
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
        <p>ออเดอร์อาหาร (วันนี้)</p>
    </div>
    <div class="boxcontent" >
    
    <div class="tabo">
            <button style="background-color: #f1c40f;"class="tablink" onclick="openCity(event, 'A1')" id="defaultOpen" >
                <div class="d0">
                    <div class="d1">รอชำระเงิน</div>
                    <div class="d2">
                    <?php 
                                        $query =  mysqli_query($connect, "SELECT id_payment_status, COUNT(order_code) as s2total FROM `order_list` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND id_payment_status=02 GROUP BY id_payment_status");
                                        $rows0 = mysqli_fetch_array($query);
                                        if($rows0>0){
                                            echo $rows0['s2total'];
                                        }else{
                                            echo "0";
                                        }
                    ?>
                    </div>
                </div>
            </button>
            <button style="background-color: #0984e3;"class="tablink" onclick="openCity(event, 'A2')">
                <div class="d0">
                    <div class="d1">ชำระเงินแล้ว</div>
                    <div class="d2">
                    <?php 
                                        $query =  mysqli_query($connect, "SELECT id_payment_status, COUNT(order_code) as s1total FROM `order_list` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND id_payment_status=01 GROUP BY id_payment_status");
                                        $rows0 = mysqli_fetch_array($query);
                                        if($rows0>0){
                                            echo $rows0['s1total'];
                                        }else{
                                            echo "0";
                                        }
                                        
                                    ?>
                    </div>
                </div>
            </button>
            <button style="background-color: #de3902;"class="tablink" onclick="openCity(event, 'A3')">
                <div class="d0">
                    <div class="d1">ยกเลิกออเดอร์</div>
                    <div class="d2">
                    <?php 
                                        $query =  mysqli_query($connect, "SELECT id_payment_status, COUNT(order_code) as s3total FROM `order_list` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND id_payment_status=03 GROUP BY id_payment_status");
                                        $rows0 = mysqli_fetch_array($query);
                                        if($rows0>0){
                                            echo $rows0['s3total'];
                                        }else{
                                            echo "0";
                                        }
                    ?>
                    </div>
                </div>
            </button>
        </div>
        
        <!-- Tab content -->
        <div id="A1" class="tabcontento">
                            <?php                                    
                                      $date_m_ =date("m");
                                      $date_y_ =date("y");
                                      $date_d_ =date("d");

                                  $query = mysqli_query($connect, "SELECT * FROM `order_list` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND `id_payment_status`=02 GROUP BY `order_code` DESC ");
                                  $cart = mysqli_num_rows($query);

                                  if ($cart > 0) {
                                      while ($row0 = mysqli_fetch_assoc($query)) {

                                        
                                          $queryp = mysqli_query($connect, "SELECT * FROM `order_list` WHERE id_payment_status ='02' GROUP BY `order_code` DESC");
                                          $cart_ = mysqli_num_rows($queryp);
                                          if($cart_ >0){
                                              $row10 = mysqli_fetch_assoc($queryp);
                                              $user_id_order_list = $row10['user_id'];
                                          }else{
                                              echo "ไม่มีข้อมูล";
                                          }

                                          $user = mysqli_query($connect, "SELECT * FROM `user` WHERE `user_id`= $user_id_order_list");
                                          $rowuser = mysqli_fetch_assoc($user);

                                          $id_order_code = $row0["order_code"] ;
                                          $id_number = sprintf("%05d",$id_order_code);
      
      
                                       
                              ?>

                <div class="AA1">
                    <a style=" font-weight: bold;" class="codeorder"><p>รหัสรายการสั่งอาหาร</p><p>:  <?php echo $id_number ;?></p></a>
                    <div class="codeorder"><p>จำนวนรายการอาหาร</p><p>:   <?php echo $row0["number_food_items"] ?></p></div>
                    <div class="codeorder"><p>ยอดรวม</p><p>:    <?php echo  "฿ ".number_format($row0["all_food_prices"] ,2)  ?></p></div>
                    <div class="codeorder"><p>เวลาสั่งอาหาร</p><p>:   <?php echo $row0["date_time"] ?></p></div>
                    <div class="codeorder"><p>โต๊ะ</p><p>:   <?php echo $row0["table_id"] ?></p></div>
                    <div class="codeorder"><p>สถานะ</p>
                    <?php 
                                                if($row0["id_payment_status"]==01){
                                                    echo '  <div class="status s2">ชำระเงินแล้ว</div>';
                                                }elseif($row0["id_payment_status"]==02){
                                                    echo ' <div class="status s1">รอชำระเงิน</div>';
                                                }else{
                                                    echo ' <div class="status s3">ยกเลิกออเดอร์</div>';
                                                }
                                                                                    
                                        ?>
                    </div>
                </div>
                <?php } } else { ?>
                                    <tr>
                                        <td colspan="7" ><p class="nodata" style="text-align: center;">ไม่มีข้อมูล<p></td>
                                    </tr>
                                <?php } ?>
        </div>
        <div id="A2" class="tabcontento">
        <?php                                    
                                       $date_m_ =date("m");
                                      $date_y_ =date("y");
                                      $date_d_ =date("d");
                                  $query = mysqli_query($connect, "SELECT * FROM `order_list` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND `id_payment_status`=01 GROUP BY `order_code` DESC ");
                                  $cart = mysqli_num_rows($query);

                                  if ($cart > 0) {
                                      while ($row0 = mysqli_fetch_assoc($query)) {


                                          $queryp = mysqli_query($connect, "SELECT * FROM `order_list` WHERE id_payment_status ='01' GROUP BY `order_code` DESC");
                                          $cart_ = mysqli_num_rows($queryp);
                                          if($cart_ >0){
                                              $row10 = mysqli_fetch_assoc($queryp);
                                              $user_id_order_list = $row10['user_id'];
                                          }else{
                                              echo "ไม่มีข้อมูล";
                                          }

                                          $user = mysqli_query($connect, "SELECT * FROM `user` WHERE `user_id`= $user_id_order_list");
                                          $rowuser = mysqli_fetch_assoc($user);

                                          $id_order_code = $row0["order_code"] ;
                                          $id_number = sprintf("%05d",$id_order_code);
      
      
                                       
                              ?>

                <div class="AA1">
                    <a style=" font-weight: bold;" class="codeorder"><p>รหัสรายการสั่งอาหาร</p><p>:  <?php echo $id_number ;?></p></a>
                    <div class="codeorder"><p>จำนวนรายการอาหาร</p><p>:   <?php echo $row0["number_food_items"] ?></p></div>
                    <div class="codeorder"><p>ยอดรวม</p><p>:    <?php echo  "฿ ".number_format($row0["all_food_prices"] ,2)  ?></p></div>
                    <div class="codeorder"><p>เวลาสั่งอาหาร</p><p>:   <?php echo $row0["date_time"] ?></p></div>
                    <div class="codeorder"><p>โต๊ะ</p><p>:   <?php echo $row0["table_id"] ?></p></div>
                    <div class="codeorder"><p>สถานะ</p>
                    <?php 
                                                if($row0["id_payment_status"]==01){
                                                    echo '  <div class="status s2">ชำระเงินแล้ว</div>';
                                                }elseif($row0["id_payment_status"]==02){
                                                    echo ' <div class="status s1">รอชำระเงิน</div>';
                                                }else{
                                                    echo ' <div class="status s3">ยกเลิกออเดอร์</div>';
                                                }
                                                                                    
                                        ?>
                    </div>
                </div>
                <?php } } else { ?>
                                    <tr>
                                        <td colspan="7" ><p class="nodata" style="text-align: center;">ไม่มีข้อมูล<p></td>
                                    </tr>
                                <?php } ?>
        </div>
        <div id="A3" class="tabcontento">
        <?php                                    
                                  
                                  $query = mysqli_query($connect, "SELECT * FROM `order_list` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND `id_payment_status`=03 GROUP BY `order_code` DESC ");
                                  $cart = mysqli_num_rows($query);

                                  if ($cart > 0) {
                                      while ($row0 = mysqli_fetch_assoc($query)) {


                                          $queryp = mysqli_query($connect, "SELECT * FROM `order_list` WHERE id_payment_status ='03' GROUP BY `order_code` DESC");
                                          $cart_ = mysqli_num_rows($queryp);
                                          if($cart_ >0){
                                              $row10 = mysqli_fetch_assoc($queryp);
                                              $user_id_order_list = $row10['user_id'];
                                          }else{
                                              echo "ไม่มีข้อมูล";
                                          }

                                          $user = mysqli_query($connect, "SELECT * FROM `user` WHERE `user_id`= $user_id_order_list");
                                          $rowuser = mysqli_fetch_assoc($user);

                                          $id_order_code = $row0["order_code"] ;
                                          $id_number = sprintf("%05d",$id_order_code);
      
      
                                       
                              ?>

                <div class="AA1">
                    <a style=" font-weight: bold;" class="codeorder"><p>รหัสรายการสั่งอาหาร</p><p>:  <?php echo $id_number ;?></p></a>
                    <div class="codeorder"><p>จำนวนรายการอาหาร</p><p>:   <?php echo $row0["number_food_items"] ?></p></div>
                    <div class="codeorder"><p>ยอดรวม</p><p>:    <?php echo  "฿ ".number_format($row0["all_food_prices"] ,2)  ?></p></div>
                    <div class="codeorder"><p>เวลาสั่งอาหาร</p><p>:   <?php echo $row0["date_time"] ?></p></div>
                    <div class="codeorder"><p>โต๊ะ</p><p>:   <?php echo $row0["table_id"] ?></p></div>
                    <div class="codeorder"><p>สถานะ</p>
                    <?php 
                                                if($row0["id_payment_status"]==01){
                                                    echo '  <div class="status s2">ชำระเงินแล้ว</div>';
                                                }elseif($row0["id_payment_status"]==02){
                                                    echo ' <div class="status s1">รอชำระเงิน</div>';
                                                }else{
                                                    echo ' <div class="status s3">ยกเลิกออเดอร์</div>';
                                                }
                                                                                    
                                        ?>
                    </div>
                </div>
                <?php } } else { ?>
                                    <tr>
                                        <td colspan="7" ><p class="nodata" style="text-align: center;">ไม่มีข้อมูล<p></td>
                                    </tr>
                                <?php } ?>
        </div>

    </div>      
</div> 

                    

           
         
            <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>     
                
            <script>
            
            function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontento");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
            }

            // Get the element with id="defaultOpen" and click on it
            document.getElementById("defaultOpen").click();

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