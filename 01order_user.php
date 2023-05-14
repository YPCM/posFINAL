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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสั่งอาหาร</title>
    <link rel="stylesheet"href="wcss/order.css">
    <link rel="stylesheet"href="wcss/navber.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"rel="stylesheet">
   
</head>
<body>
    
<div class="navber">
        <div class="he">
            <a style="color: #fff; text-decoration: none;" href="01tablenumber_user.php">ร้านก๊วยจั๊บกำลังภายใน</a>
        </div>

        <a href="01order_user.php" class="button">
            <span  class="content"><i class='bx bxs-dish'></i></span>
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
        <?php
            $user_id = $_SESSION['user_id'];
            $user = mysqli_query($connect," SELECT `user_id`,`user_name`,`id_user_type` FROM `user` WHERE user_id='$user_id' " );
            $row = mysqli_fetch_assoc($user);

            $status = $_SESSION['status_login'] ;
            $user_type = mysqli_query($connect," SELECT * FROM `user_type` WHERE id_user_type='$status' " );
            $rowuser_type = mysqli_fetch_assoc($user_type)
        ?>

        <button class="myBtn2"id="myBtn2" onclick="myFunctionmyBtn()">
                    <p class="co"><?php echo $rowuser_type['user_type']?></p>
                    <div class="profile-photo"  >
                    <i class='bx bxs-cool'></i>
                    <!-- <img src="https://i.pinimg.com/736x/36/7c/39/367c393354fecb4918b2bee5795ae290.jpg" > -->
                    </div>  
        </button>


        <div  id="id01" class="modalid01">
            <div class="modal__content">
                <div class="modal-header">
                    <p><?php echo $row['user_name']. "( " .$rowuser_type['user_type']. " )" ; ?></p>
                    <button class="dark" onclick="myFunction()"><span class="material-icons"><span class="material-icons">settings_brightness</span></button>
                </div>
                <div class="modal-body">
                        <a class="a"  type="submit" href="00order.php?exit"  >
                            <span class="material-icons">logout</span>
                            <p>ออกจากระบบ</p>
                            <i class='bx bx-chevron-right'></i>
                        </a>
                </div>
            </div>
        </div>




    </div><!-- end navber -->
    
<div class="home-section">
        <!--  <div class="menubox">
                   <div class="menu0">
                       <div class="a1">w</div>
                       <div class="a1">w</div>
                       <div class="a1">w</div>
                       <div class="a1">w</div>
                   </div>--> 
                        <div class="menu">
                            <div class="nav-list">
                            <div class="menubox">
                                        <div class="b1"></div>
                                        <div class="a1">
                                            <a href="01tablenumber_user.php">
                                                <i class='bx bx-store' ></i>
                                                <span class="links_name">หน้าหลัก</span>
                                            </a>
                                        </div>
                                    </div>

                           
                            <div>
                               
                        </div>     
                   </div>
    </div>
   
       

    <div class="box">

<div class="boxtable">
    <div class="table">
        <p>ออเดอร์อาหาร</p>
    </div>
</div> 



    <div class="boxuser">    
        <div class="TTT">

        <div class="tab">
                            <button  style="background-color:#f1c40f; " class="tablinks" onclick="openmenu(event, 'P1')" id="defaultOpen"><i style="text-align: center; padding-right: 5px;" class='bx bxs-dish'></i><div class="pp">รอชำระเงิน</div>
                            <span class="TTTbadge">
                                <p>
                                    <?php 
                                        $query =  mysqli_query($connect, "SELECT id_payment_status, COUNT(order_code) as s2total FROM `order_list` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND id_payment_status=02 GROUP BY id_payment_status");
                                        $rows0 = mysqli_fetch_array($query);
                                        if($rows0>0){
                                            echo $rows0['s2total'];
                                        }else{
                                            echo "0";
                                        }

                                    ?>
                                </p>
                            </span>
                        
                            </button>
                            <button  style="background-color:#3498db; "  class="tablinks" onclick="openmenu(event, 'P2')"><i style="text-align: center; padding-right: 5px;" class='bx bx-cookie'></i><div class="pp">ชำระเงินแล้ว</div>
                            <span class="TTTbadge">
                                <p>
                                    <?php 
                                        $query =  mysqli_query($connect, "SELECT id_payment_status, COUNT(order_code) as s1total FROM `order_list` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND id_payment_status=01 GROUP BY id_payment_status");
                                        $rows0 = mysqli_fetch_array($query);
                                        if($rows0>0){
                                            echo $rows0['s1total'];
                                        }else{
                                            echo "0";
                                        }
                                        
                                    ?>
                                </p>
                            </span>           
                            </button>
                            <button style="background-color:#de3902; "  class="tablinks" onclick="openmenu(event, 'P3')"><i style="text-align: center; padding-right: 5px;" class='bx bxs-wine'></i><div class="pp">ยกเลิกออเดอร์</div>
                            <span class="TTTbadge">
                                <p>
                                    <?php 
                                        $query =  mysqli_query($connect, "SELECT id_payment_status, COUNT(order_code) as s3total FROM `order_list` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND id_payment_status=03 GROUP BY id_payment_status");
                                        $rows0 = mysqli_fetch_array($query);
                                        if($rows0>0){
                                            echo $rows0['s3total'];
                                        }else{
                                            echo "0";
                                        }
                                        
                                    ?>
                                </p>
                            </span>
                            </button>
                        </div>


           
        </div>
        <div id="P1" class="tabcontent">
                        <div class="AAA"> 
                        <table >
                            <thead>
                                <tr valign="baseline">
                                    <th style="width:10%">รหัสรายการสั่งอาหาร</th>
                                   <!-- <th style="text-align: start;" >รายการสั่งอาหาร</th> -->
                                    <th style="width:10%">จำนวนรายการอาหาร</th>
                                    <th style="width:10%">ยอดรวม</th>
                                    <th style="width:10%">เวลาสั่งอาหาร</th>
                                  <!--  <th style="width:10% ; text-align: center;">ชื่อผู้ใช้</th> -->
                                    <th style="width:5% ; text-align: center;">โต๊ะ</th>
                                    <th style="width:8% ; text-align: center;">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
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
                            
                            <?php 
                if (isset($_GET['order_code'])) { 
                    $_SESSION["table_order_code"] = $_GET['order_code'] ;
                    $_SESSION["table"] = $row0["table_id"];
                    echo "<script>window.location.href='01order_list_user.php'</script>" ;

                }
                ?>
                            
                                <tr valign="baseline" >
                                <td style="text-align: center; font-weight: bold ; text-decoration: none;"> <?php echo '<a style="text-decoration: none; "name="order_code" type="submit" href="01order_user.php?order_code='.$row0["order_code"].' ">'.$id_number.'</a> '?> </td>
                                    <!-- <td><?php// echo $row0["all_food_items"] ?></td> -->
                                    <td style="text-align: center;"><?php echo $row0["number_food_items"] ?></td>


                                    <td style="padding-right: 20px; text-align: end;"><?php echo  "฿ ".number_format($row0["all_food_prices"] ,2)  ?></td>
                                    <td style="text-align: center;"><?php echo $row0["date_time"] ?></td>
                                   <!-- <td style="text-align: center;"><?php //echo $rowuser['user_name']; ?></td> -->
                                    <td style="text-align: center;"><?php echo $row0["table_id"] ?></td>
                                    <td style="text-align: center;">
                                        <?php 
                                                if($row0["id_payment_status"]==01){
                                                    echo '  <button class="btntttt paid">
                                                                <p>ชำระเงินแล้ว</p>
                                                            </button>';
                                                }elseif($row0["id_payment_status"]==02){
                                                    echo ' <button class="btntttt awaiting ">
                                                                <p>รอชำระเงิน</p>
                                                            </button>';
                                                }else{
                                                    echo ' <button class="btntttt cancel">
                                                                <p>ยกเลิก</p>
                                                            </button>';
                                                }
                                                                                    
                                        ?>

                                    </td>
                                </tr>
                                <?php } } else { ?>
                                    <tr>
                                        <td colspan="7" ><p class="nodata" style="text-align: center;">ไม่มีข้อมูล<p></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <!--
                            <tfoot>
                                <tr>
                                    <th style="width:3%; text-align: center;">#</th>
                                    <th style="width:10%">รหัสรายการสั่งอาหาร</th>
                                     <th style="text-align: start;" >รายการสั่งอาหาร</th> 
                                    <th style="width:10%">จำนวนรายการอาหาร</th>
                                    <th style="width:10%">ยอดรวม</th>
                                    <th style="width:10%">เวลาสั่งอาหาร</th>
                                    <th style="width:10% ; text-align: center;">ชื่อผู้ใช้</th>
                                    <th style="width:5% ; text-align: center;">โต๊ะ</th>
                                    <th style="width:8% ; text-align: center;">สถานะ</th>
                                </tr>
                            </tfoot>
                                            -->
                            
                              
                        </table>
                        </div>
                                </div>
              
                     

                        <!---->
                       

                        <div id="P2" class="tabcontent">
                        <div class="AAA">  
                        <table >
                            <thead>
                                <tr valign="baseline">
                                    <th style="width:10%">รหัสรายการสั่งอาหาร</th>
                                   <!-- <th style="text-align: start;" >รายการสั่งอาหาร</th> -->
                                    <th style="width:10%">จำนวนรายการอาหาร</th>
                                    <th style="width:10%">ยอดรวม</th>
                                    <th style="width:10%">เวลาสั่งอาหาร</th>
                                   <!-- <th style="width:10% ; text-align: center;">ชื่อผู้ใช้</th> -->
                                    <th style="width:5% ; text-align: center;">โต๊ะ</th>
                                    <th style="width:8% ; text-align: center;">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php                                    
                                  
                                    $query = mysqli_query($connect, "SELECT * FROM `order_list` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND `id_payment_status`=01 GROUP BY `order_code` DESC");
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
                            
                                <tr valign="baseline" >
                                    <td style="text-align: center;" ><?php echo $id_number ?></td>
                                    <!-- <td><?php// echo $row0["all_food_items"] ?></td> -->
                                    <td style="text-align: center;"><?php echo $row0["number_food_items"] ?></td>


                                    <td style="padding-right: 20px; text-align: end;"><?php echo  "฿ ".number_format($row0["all_food_prices"] ,2) ?></td>
                                    <td style="text-align: center;"><?php echo $row0["date_time"] ?></td>
                                    <!-- <td style="text-align: center;"><?php //echo $rowuser['user_name']; ?></td> -->
                                    <td style="text-align: center;"><?php echo $row0["table_id"] ?></td>
                                    <td style="text-align: center;">
                                        <?php 
                                                if($row0["id_payment_status"]==01){
                                                    echo '  <button class="btntttt paid">
                                                                <p>ชำระเงินแล้ว</p>
                                                            </button>';
                                                }elseif($row0["id_payment_status"]==02){
                                                    echo ' <button class="btntttt awaiting ">
                                                                <p>รอชำระเงิน</p>
                                                            </button>';
                                                }else{
                                                    echo ' <button class="btntttt cancel">
                                                                <p>ยกเลิก</p>
                                                            </button>';
                                                }
                                                                                    
                                        ?>

                                    </td>
                                </tr>
                                <?php } } else { ?>
                                    <tr>
                                        <td colspan="7" ><p class="nodata" style="text-align: center;" >ไม่มีข้อมูล<p></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <!--
                            <tfoot>
                                <tr>
                                    <th style="width:3%; text-align: center;">#</th>
                                    <th style="width:10%">รหัสรายการสั่งอาหาร</th>
                                     <th style="text-align: start;" >รายการสั่งอาหาร</th> 
                                    <th style="width:10%">จำนวนรายการอาหาร</th>
                                    <th style="width:10%">ยอดรวม</th>
                                    <th style="width:10%">เวลาสั่งอาหาร</th>
                                    <th style="width:10% ; text-align: center;">ชื่อผู้ใช้</th>
                                    <th style="width:5% ; text-align: center;">โต๊ะ</th>
                                    <th style="width:8% ; text-align: center;">สถานะ</th>
                                </tr>
                            </tfoot>
                                            -->
                            
                              
                        </table>
                        </div>

                        </div>
                     
                        <!---->
                        
                        <div id="P3" class="tabcontent">
                        <div class="AAA">  
                        <table >
                            <thead>
                                <tr valign="baseline">
                                    <th style="width:10%">รหัสรายการสั่งอาหาร</th>
                                   <!-- <th style="text-align: start;" >รายการสั่งอาหาร</th> -->
                                    <th style="width:10%">จำนวนรายการอาหาร</th>
                                    <th style="width:10%">ยอดรวม</th>
                                    <th style="width:10%">เวลาสั่งอาหาร</th>
                                    <!-- <th style="width:10% ; text-align: center;">ชื่อผู้ใช้</th> -->
                                    <th style="width:5% ; text-align: center;">โต๊ะ</th>
                                    <th style="width:8% ; text-align: center;">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php                                    
                                  
                                    $query = mysqli_query($connect, "SELECT * FROM `order_list` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND `id_payment_status`=03 GROUP BY `order_code` DESC");
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
                            
                                <tr valign="baseline" >
                                    <td style="text-align: center;" ><?php echo $id_number ?></td>
                                    <!-- <td><?php// echo $row0["all_food_items"] ?></td> -->
                                    <td style="text-align: center;"><?php echo $row0["number_food_items"] ?></td>


                                    <td style="padding-right: 20px; text-align: end;"><?php echo  "฿ ".number_format($row0["all_food_prices"] ,2) ?></td>
                                    <td style="text-align: center;" ><?php echo $row0["date_time"] ?></td>
                                    <!-- <td style="text-align: center;"><?php //echo $rowuser['user_name']; ?></td> -->
                                    <td style="text-align: center;"><?php echo $row0["table_id"] ?></td>
                                    <td style="text-align: center;">
                                        <?php 
                                                if($row0["id_payment_status"]==01){
                                                    echo '  <button class="btntttt paid">
                                                                <p>ชำระเงินแล้ว</p>
                                                            </button>';
                                                }elseif($row0["id_payment_status"]==02){
                                                    echo ' <button class="btntttt awaiting ">
                                                                <p>รอชำระเงิน</p>
                                                            </button>';
                                                }else{
                                                    echo ' <button class="btntttt cancel">
                                                                <p>ยกเลิก</p>
                                                            </button>';
                                                }
                                                                                    
                                        ?>

                                    </td>
                                </tr>
                                <?php } } else { ?>
                                    <tr>
                                        <td colspan="7" ><p class="nodata" style="text-align: center;">ไม่มีข้อมูล<p></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <!--
                            <tfoot>
                                <tr>
                                    <th style="width:3%; text-align: center;">#</th>
                                    <th style="width:10%">รหัสรายการสั่งอาหาร</th>
                                     <th style="text-align: start;" >รายการสั่งอาหาร</th> 
                                    <th style="width:10%">จำนวนรายการอาหาร</th>
                                    <th style="width:10%">ยอดรวม</th>
                                    <th style="width:10%">เวลาสั่งอาหาร</th>
                                    <th style="width:10% ; text-align: center;">ชื่อผู้ใช้</th>
                                    <th style="width:5% ; text-align: center;">โต๊ะ</th>
                                    <th style="width:8% ; text-align: center;">สถานะ</th>
                                </tr>
                            </tfoot>
                                            -->
                            
                              
                        </table>
                        </div>

                        </div>
                        
                        
                        <!---->

                    </div>
           
         
            <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>     
                
            <script>
                    
                    $(document).ready(function () {
                        $('#example').DataTable({
                            scrollY: '43vh',
                            scrollCollapse: true,
                            paging: false,
                        });
                    });

                            function  myFunctionmyBtn() {
                            var modal = document.getElementById('id01');
                            var btn = document.getElementById("myBtn2");
                            // When the user clicks anywhere outside of the modal, close it
                            btn.onclick = function() {
                                modal.style.display = "block";
                            } 
                            window.onclick = function(event) {
                                if (event.target == modal) {
                                    modal.style.display = "none";
                                }
                            }
                            }

                            
                        function myFunction() {
                            var element = document.body;
                            element.classList.toggle("dark-mode");
                        }

                        function openmenu(evt, cityName) {
                        var i, tabcontent, tablinks;
                        tabcontent = document.getElementsByClassName("tabcontent");
                        for (i = 0; i < tabcontent.length; i++) {
                            tabcontent[i].style.display = "none";
                        }
                        tablinks = document.getElementsByClassName("tablinks");
                        for (i = 0; i < tablinks.length; i++) {
                            tablinks[i].className = tablinks[i].className.replace(" active", "");
                        }
                        document.getElementById(cityName).style.display = "block";
                        evt.currentTarget.className += " active";
                        }

                        // Get the element with id="defaultOpen" and click on it
                        document.getElementById("defaultOpen").click();



           

           
            </script>
    </body>
</html>