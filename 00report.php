<?php
include 'connect.php'; 

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


if(isset($_GET['receipt'])) { 
    $_SESSION['receipt']= $_GET['receipt'];
   // $_SESSION['receipt'] = $receipt ;
    header('location:00report_2.php');
}

if(isset($_POST['date'])){
    $_SESSION['date-start'] = $_POST['trip-start'];
    $_SESSION['date-end'] = $_POST['trip-end'];

    header('location:00report_listday.php');
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงาน</title>
    <link rel="stylesheet"href="wcss/report.css">
    <link rel="stylesheet"href="wcss/navber.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"rel="stylesheet">

</head>
<body>
<div class="navber">
<div class="he">
            <a style="color: #fff; text-decoration: none;" href="00tablenumber.php">ร้านก๊วยจั๊บกำลังภายใน</a>
        </div>


        <a href="00order.php" class="button">
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

        <button class="myBtn2"id="myBtn10" onclick="myFunctionmyBtn()">
                    <p class="co"><?php echo $rowuser_type['user_type']?></p>
                    <div class="profile-photo"  >
                    <i class='bx bxs-face'></i>
                    <!-- <img src="https://i.pinimg.com/736x/36/7c/39/367c393354fecb4918b2bee5795ae290.jpg" > -->
                    </div>  
        </button>


        <div  id="id01" class="modalid01">
            <div class="modal__content">
                <div class="modal-header">
                    <p><?php echo $row['user_name']. "<br>( " .$rowuser_type['user_type']. " )" ; ?></p>
                    <button class="dark" onclick="myFunctiondark()"><span class="material-icons"><span class="material-icons">settings_brightness</span></button>
                </div>
                <div class="modal-body">
                        <a class="a"  type="submit" href="00report.php?exit"  >
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
                                            <a href="00tablenumber.php">
                                                <i class='bx bx-store' ></i>
                                                <span class="links_name">หน้าหลัก</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="menubox">
                                        <div class="b2"></div>
                                        <div class="a2">
                                            <a href="00food.php">
                                                <i class='bx bx-food-menu' ></i>
                                                <span class="links_name">เมนูอาหาร</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="menubox">
                                        <div class="b3"></div>
                                        <div class="a3">
                                            <a href="00report.php">
                                                <i class='bx bx-chart'></i>
                                                <span class="links_name">รายงาน</span>
                                            </a>
                                        </div>
                                    </div>  

<!--
                                    <div class="menubox">
                                        <div class="b4"></div>
                                        <div class="a4">
                                            <a href="#">
                                                <i class='bx bx-pie-chart-alt-2'></i>
                                                <span class="links_name">Dashboard</span>
                                            </a>
                                        </div>
                                    </div>
-->
                                    <div class="menubox">
                                        <div class="b5"></div>
                                        <div class="a5">
                                            <a href="00user.php">
                                                <i class='bx bx-user'></i>
                                                <span class="links_name">ข้อมูลผู้ใช้ระบบ</span>
                                            </a>
                                        </div>
                                    </div>
                             
                            <div>
                               
                        </div>     
                   </div>
    </div>
  
    <div class="S">
            <div class="text">
                <div class="Stockfood"></div>
            </div>
            <!--
            <div class="pro_">              
                <div class="box boxitem ">
                    <div class="T">ยอดขาย</div>                              
                        <div class="box1_boxitem">
                                <div class="list_boxitem">฿300</div>                       
                        </div>
                </div>           
            </div>
                                -->
    </div>
                                    <?php
                                        $sql_sales_history= mysqli_query($connect, " SELECT * FROM `sales_history`  WHERE `date_time` BETWEEN '$date_added 00:00:00.000000' AND '$date_added 00:00:00.000000' ");

                                        $rows0 = mysqli_num_rows($sql_sales_history);
                                        $num_01 = 0;
                                        $num_02 = 0;
                                        $capital_price_food = 0;
                                        
                                        if($rows0>0){
                                            while ($row = mysqli_fetch_assoc($sql_sales_history)) {
                                                if($row['id_pay_through']==01){
                                                    $order_code = $row['order_code'];
                                                   // echo $order_code ;
                            
                                                   $sql_cart_item= mysqli_query($connect, "SELECT * FROM `cart_item` WHERE `order_code`='$order_code' ");
                                                   $rows0 = mysqli_num_rows($sql_cart_item);
                                                    if($rows0>0){
                                                        while ( $row3 = mysqli_fetch_assoc($sql_cart_item)) {
                                                            $code = $row3['code'];

                                                            $sql_food_item= mysqli_query($connect, "SELECT * FROM `food_item` WHERE food_menu_code='$code' ");
                                                            $rowsfood_item = mysqli_num_rows($sql_food_item);
                                                            if($rowsfood_item>0){
                                                                while ( $row4 = mysqli_fetch_assoc($sql_food_item)) {
                                                                    // echo $row3['order_code']."  ".$row3['code']."   ".$row4['capital_price_food']."<br>";

                                                                    $capital_price = $row4['capital_price_food'];
                                                                    $capital_price_food = $capital_price + $capital_price_food ;
                                                                   
                                                                }
                                                            }



                                                            //echo $row3['order_code']."  ".$row3['code']."<br>";
                                                        }
                                                    
                                                    }
                                                    
                                                    $sql_order_code= mysqli_query($connect, "SELECT all_food_prices,SUM(all_food_prices) AS uuu FROM `order_list` WHERE `order_code`='$order_code' ");
                                                    $row2 = mysqli_fetch_assoc($sql_order_code);

                                                    $sum = $row2['all_food_prices'] ;
                                                    $num_01 = $sum +$num_01 ;
                                                    
                                                    } elseif($row['id_pay_through']==02){
                                                        $order_code = $row['order_code'];
                                                       // echo $order_code ;
    
                                                        $sql_order_code= mysqli_query($connect, "SELECT all_food_prices,SUM(all_food_prices) AS uuu FROM `order_list` WHERE `order_code`='$order_code' ");
                                                        $row2 = mysqli_fetch_assoc($sql_order_code);
    
                                                        $sum = $row2['all_food_prices'] ;
                                                        $num_02 = $sum +$num_02 ;

                                                }
                                            }} 
                                    ?>
                                    



<div class="boxx">
       
        <div class="boxS" >
                <div class="tab">
                    <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen"  ><i class='bx bx-chart'></i>ยอดขาย</button>
                    <button class="tablinks" onclick="openCity(event, 'Paris')" ><i class='bx bx-wallet-alt' ></i>ยอดเงิน</button>
                    <button class="tablinks" onclick="openCity(event, 'Report')"><span class="material-icons">receipt</span>ประวัติการขาย</button>
            
                </div>
              
<!-- ooo -->
                <div id="London" class="tabcontent">
                    <div class="danger" style="margin-bottom: 20px;" >
                        <p>ยอดขาย</p>
                    </div>
                    <div class="box3">
                        <div class="box-sales" >
                            <div class="tab-sales">
                                <button class="tablinks-sales" onclick="openCity2(event, 'today')"  id="defaultOpen2" >วันนี้</button>
                                <button class="tablinks-sales" onclick="openCity2(event, 'm' )" >เดือน</button>
                                <button class="tablinks-sales" onclick="openCity2(event, 'y' )" >ปี</button>



                                <form style=" display: flex; width: 50% ; "action="#" method="post"enctype="multipart/form-data">
                                    <input  style="margin-left: 50px; padding-left: 10px; padding-right: 10px;  " type="date" id="start" name="trip-start" value="<?php echo $date_added ;?>" > 
                                    <p class="ttopo" style="font-weight: bold; display: flex; align-items: center; justify-content: center; width: 2%;" >-</p>
                                    <input  style="padding-left: 10px; padding-right: 10px;  " type="date" id="start" name="trip-end" value="<?php echo $date_added ;?>" > 
                                    <button name="date" type="submit" style="margin-left: 10px; background-color: #0984e3; color:#fff ; width: 8% ;"  class="tablinks-sales" >ค้นหา</button>
                                </form>

                            </div>     
                        </div>
                            <!-- วันนี้ -->
                            <div id="today" class="tabcontent2">
                                <?php
                                     
                                     $date_m_ =date("m");
                                     $date_y_ =date("y");
                                     $date_d_ =date("d");
                             
                                     if($date_m_ =date("m")==1){
                                         $date_m_T = "มกราคม" ;
                                     }elseif($date_m_ =date("m")==2){
                                         $date_m_T = "กุมภาพันธ์" ;
                                     }elseif($date_m_ =date("m")==3){
                                         $date_m_T = "มีนาคม" ;
                                     }elseif($date_m_ =date("m")==4){
                                         $date_m_T = "เมษายน" ;
                                     }elseif($date_m_ =date("m")==5){
                                         $date_m_T = "พฤษภาคม" ;
                                     }elseif($date_m_ =date("m")==6){
                                         $date_m_T = "มิถุนายน" ;
                                     }elseif($date_m_ =date("m")==7){
                                         $date_m_T = "กกรกฎาคม" ;
                                     }elseif($date_m_ =date("m")==8){
                                         $date_m_T = "สิงหาคม" ;
                                     }elseif($date_m_ =date("m")==9){
                                         $date_m_T = "กันยายน" ;
                                     }elseif($date_m_ =date("m")==10){
                                         $date_m_T = "ตุลาคม" ;
                                     }elseif($date_m_ =date("m")==11){
                                         $date_m_T = "พฤศจิกายน" ;
                                     }elseif($date_m_ =date("m")==12){
                                         $date_m_T = "ธันวาคม" ;
                                     }

                                     echo "ยอดขายประจำวันที่ ".$date_d_." ".$date_m_T." 20".$date_y_ ;   
                             

                                ?>
                                <div class="totalscroll">
                                <table id="today" class="display">
                                    <thead>
                                        <tr>
                                            <th style="width:15%; text-align: start;">รายการ</th>
                                            <th style="text-align: end;">ยอดรวม</th>
                                            <!--<th style="text-align: end;">ต้นทุน</th>
                                            <th style="text-align: end;">กำไร</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                                 
                                                $date_m_ =date("m");
                                                $date_y_ =date("y");
                                                $date_d_ =date("d");
                             
                                                $sql_sales_history= mysqli_query($connect, "SELECT sum(all_food_prices) AS totalsum , DATE_FORMAT(date_time,'%d %m %y') AS date_time FROM `sales_history` WHERE `date_time`  
                                                                                            BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' ");
                                                $rows0 = mysqli_num_rows($sql_sales_history);
                                                                
                                                    if($rows0>0){
                                                        $sql_month = mysqli_query($connect, "SELECT SUM(all_food_prices) AS totalsumday FROM `sales_history` WHERE `date_time` BETWEEN '20$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '20$date_y_-$date_m_-$date_d_ 23:59:59.000000';");
                                                        $rowsmonth = mysqli_fetch_assoc($sql_month);
                                                        
                                        ?>

                                            <tr>
                                                <td><a class="a" href="00report.php"><i class='bx bxs-folder'></i><?php echo $date_d_." ".$date_m_T." 20". $date_y_;?></a></td>
                                                <td style="text-align: end;"><?php echo  "฿ ".number_format($rowsmonth['totalsumday'],2) ?></td>
                                            </tr>
                                        </tbody>

                                        <tfoot style=" background-color: #f2f2f2;color: #000000;" >
                                            <tr style="font-weight: bold;">
                                                <td style="width:30%;text-align: start;">฿ รวม</th>
                                                <td style="text-align: end;"><?php  echo  "฿ ".number_format($rowsmonth['totalsumday'],2) ?></th>
                                            </tr>
                                        </tfoot>


                                            <?php  }  else {  ?>
                                                <tr>
                                                    <td colspan="6" style="text-align: center;" >ไม่มีข้อมูล</td>
                                                </tr>
                                            <?php } ?>
                                    
                                        
                                    </table>
                                </div>
                            </div>

                            <!-- เดือนนี้ -->
                            <div id="m" class="tabcontent2">
                                <?php
                                    if($date_m_ =date("m")==1){
                                        $date_m_T = "มกราคม" ;
                                    }elseif($date_m_ =date("m")==2){
                                        $date_m_T = "กุมภาพันธ์" ;
                                    }elseif($date_m_ =date("m")==3){
                                        $date_m_T = "มีนาคม" ;
                                    }elseif($date_m_ =date("m")==4){
                                        $date_m_T = "เมษายน" ;
                                    }elseif($date_m_ =date("m")==5){
                                        $date_m_T = "พฤษภาคม" ;
                                    }elseif($date_m_ =date("m")==6){
                                        $date_m_T = "มิถุนายน" ;
                                    }elseif($date_m_ =date("m")==7){
                                        $date_m_T = "กกรกฎาคม" ;
                                    }elseif($date_m_ =date("m")==8){
                                        $date_m_T = "สิงหาคม" ;
                                    }elseif($date_m_ =date("m")==9){
                                        $date_m_T = "กันยายน" ;
                                    }elseif($date_m_ =date("m")==10){
                                        $date_m_T = "ตุลาคม" ;
                                    }elseif($date_m_ =date("m")==11){
                                        $date_m_T = "พฤศจิกายน" ;
                                    }elseif($date_m_ =date("m")==12){
                                        $date_m_T = "ธันวาคม" ;
                                    }


                                    echo "ยอดขายประจำเดือน ".$date_m_T." 20".$date_y_   ;                                
                                ?>
                                <div class="totalscroll">
                                    <table id="month" class="display">
                                        <thead>
                                            <tr>
                                                <th style="width:20%; text-align: start;">รายการ</th>
                                                <th style="text-align: end;">ยอดรวม</th>
                                                <!--<th style="text-align: end;">ต้นทุน</th>
                                                <th style="text-align: end;">กำไร</th>-->
                                            </tr>
                                        </thead>
                                        <tbody class="month">
                                                <?php
                                                    $date_m_ =date("m");
                                                    $date_y_ =date("y");
                                                    $date_d_ =date("d");

                                                    $sql_sales_history2= mysqli_query($connect, "SELECT sum(all_food_prices) as totalsum FROM `sales_history` WHERE `date_time` BETWEEN ' $date_y_-$date_m_-01 00:00:00.000000' AND ' $date_y_-$date_m_-31 23:59:59.000000'; ");
                                                    $rows0 = mysqli_num_rows($sql_sales_history2);
                                                    $rowshistory2 = mysqli_fetch_assoc($sql_sales_history2);

                                                    $date_d_2 = $date_d_ - 1 ;

                                                    $day = 0 ;
        
                                                        while ($day <= $date_d_2 ) {
                                                            $day++;

                                                            $sql_month = mysqli_query($connect, "SELECT SUM(all_food_prices) AS totalsumday FROM `sales_history` WHERE `date_time` BETWEEN '20$date_y_-$date_m_-$day 00:00:00.000000' AND '20$date_y_-$date_m_-$day 23:59:59.000000';");
                                                            $rowsmonth = mysqli_fetch_assoc($sql_month);

                                                           
                                                            
                                            ?>

                                     
                                                <tr>
                                                    <td><a class="a" href="00report.php"><i class='bx bxs-folder'></i><?php echo $day." ".$date_m_T." 20".$date_y_ ;?></a></td>

                                                    <?php
                                                        if($rowsmonth['totalsumday']==0.00){                                                     
                                                    ?>
                                                        <td style="text-align: end; color: rgb(255, 0, 0);"><?php echo  "฿ ".number_format($rowsmonth['totalsumday'],2) ?></td>
                                                    <?php    }else{ ?>

                                                    <td style="text-align: end;"><?php echo  "฿ ".number_format($rowsmonth['totalsumday'],2) ?></td>
                                                </tr>
                                              

                                                <?php  }    }?>
                                                
                                          
                                            </tbody>
                                            <tfoot style=" background-color: #f2f2f2; color: #000000;" >
                                                <tr style="font-weight: bold;">
                                                    <td style="width:30%;text-align: start;">฿ รวม</th>
                                                    <td style="text-align: end;"><?php echo  "฿ ".number_format($rowshistory2['totalsum'],2) ?></th>
                                                </tr>
                                            </tfoot>

                                            
                                            
                                        </table>
                                </div>
                               
                            </div>

                            <!-- ปี -->
                            <div id="y" class="tabcontent2">
                                <?php
                                    $date_m_ =date("m");
                                    $date_y_ =date("y");
                                    $date_d_ =date("d");

                                    echo "ยอดขายประจำปี 20".$date_y_   ;          
                                ?>

                            <div class="totalscroll">
                                <table id="today" class="display">
                                    <thead>
                                        <tr>
                                            <th style="width:15%; text-align: start;">รายการ</th>
                                            <th style="text-align: end;">ยอดรวม</th>
                                            <!--<th style="text-align: end;">ต้นทุน</th>
                                            <th style="text-align: end;">กำไร</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                                 
                                                $date_m_ =date("m");
                                                $date_y_ =date("y");
                                                $date_d_ =date("d");
                             
                                                $sql_sales_history= mysqli_query($connect, "SELECT * FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-01-01 00:00:00.000000' AND '$date_y_-12-31 23:59:59.000000'");
                                                $rows0 = mysqli_num_rows($sql_sales_history);
                                                                
                                                    if($rows0>0){
                                                        $sql_month = mysqli_query($connect, "SELECT SUM(all_food_prices) AS totalsumday FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-01-01 00:00:00.000000' AND '$date_y_-12-31 23:59:59.000000'");
                                                        $rowsmonth = mysqli_fetch_assoc($sql_month);
                                                        
                                        ?>

                                            <tr>
                                                <td><a class="a" href="00report.php"><i class='bx bxs-folder'></i><?php echo "ปี 20". $date_y_;?></a></td>
                                                <td style="text-align: end;"><?php echo  "฿ ".number_format($rowsmonth['totalsumday'],2) ?></td>
                                            </tr>
                                        </tbody>
                                        <tfoot style=" background-color: #f2f2f2; color: #000000;" >
                                            <tr style="font-weight: bold;">
                                                <td style="width:30%;text-align: start;">฿ รวม</th>
                                                <td style="text-align: end;"><?php  echo  "฿ ".number_format($rowsmonth['totalsumday'],2) ?></th>
                                            </tr>
                                        </tfoot>

                                            <?php  }  else {  ?>
                                                <tr>
                                                    <td colspan="6" style="text-align: center;" >ไม่มีข้อมูล</td>
                                                </tr>
                                            <?php } ?>
                                    
                                        
                                     

                                    </table>
                                </div>

                            </div>
                            
                        
                        <!-- จบ -->
                    </div>
                </div>
              





                <div id="Paris" class="tabcontent">
                    <div class="danger" style="margin-bottom: 20px;">
                        <p>ยอดเงิน</p>
                    </div>
                    <div class="box3">
                        <div class="box-sales" >
                            <div class="tab-sales3">
                                <button class="tablinks-sales3" onclick="openCity3(event, 'pay-today')" id="defaultOpen3" >วันนี้</button>
                                <button class="tablinks-sales3" onclick="openCity3(event, 'pay-m' )" >เดือน</button>
                                <button class="tablinks-sales3" onclick="openCity3(event, 'pay-y' )" >ปี</button>
                            </div>     
                        </div>

                        <!-- วันนี้ -->
                        <div id="pay-today" class="tabcontent3">
                            <?php
                                    if($date_m_ =date("m")==1){
                                        $date_m_T = "มกราคม" ;
                                    }elseif($date_m_ =date("m")==2){
                                        $date_m_T = "กุมภาพันธ์" ;
                                    }elseif($date_m_ =date("m")==3){
                                        $date_m_T = "มีนาคม" ;
                                    }elseif($date_m_ =date("m")==4){
                                        $date_m_T = "เมษายน" ;
                                    }elseif($date_m_ =date("m")==5){
                                        $date_m_T = "พฤษภาคม" ;
                                    }elseif($date_m_ =date("m")==6){
                                        $date_m_T = "มิถุนายน" ;
                                    }elseif($date_m_ =date("m")==7){
                                        $date_m_T = "กกรกฎาคม" ;
                                    }elseif($date_m_ =date("m")==8){
                                        $date_m_T = "สิงหาคม" ;
                                    }elseif($date_m_ =date("m")==9){
                                        $date_m_T = "กันยายน" ;
                                    }elseif($date_m_ =date("m")==10){
                                        $date_m_T = "ตุลาคม" ;
                                    }elseif($date_m_ =date("m")==11){
                                        $date_m_T = "พฤศจิกายน" ;
                                    }elseif($date_m_ =date("m")==12){
                                        $date_m_T = "ธันวาคม" ;
                                    }

                                    echo "ยอดเงินประจำวันที่ ".$date_d_." ".$date_m_T." 20".$date_y_ ;    
                                    
                                    $date_m_ =date("m");
                                    $date_y_ =date("y");
                                    $date_d_ =date("d");
                                    
                                    /* เงินสดวันนี้ */
                                    $sql_pay_today = mysqli_query($connect, "SELECT SUM(all_food_prices) as sum_pay_today FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND`id_pay_through`=01");
                                    $numrowpay_today = mysqli_num_rows($sql_pay_today);
                                    $row_pay_today = mysqli_fetch_assoc($sql_pay_today);

                                    if($numrowpay_today >0){
                                        $sum_pay_today = $row_pay_today['sum_pay_today'];
                                    }else{
                                        $sum_pay_today = "฿ 0.00";
                                    }

                                    /* qr code วันนี้ */
                                    $sql_pay_today2 = mysqli_query($connect, "SELECT SUM(all_food_prices) as sum_pay_today2 FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' AND`id_pay_through`=02");
                                    $numrowpay_today2 = mysqli_num_rows($sql_pay_today2);
                                    $row_pay_today2 = mysqli_fetch_assoc($sql_pay_today2);

                                    if($numrowpay_today2 >0){
                                        $sum_pay_today2 = $row_pay_today2['sum_pay_today2'];
                                    }else{
                                        $sum_pay_today2 = "฿ 0.00";
                                    }

                                    /* ยอดรวม */
                                    $sum_pay_today_total = $sum_pay_today + $sum_pay_today2 ;
          
                                ?>
                            <div class="totalscroll">
                                <table class="pay">
                                    <tr>
                                        <th style="padding-left: 30px;" >ประเภท</th>
                                        <th style="width: 20%;">ยอดเงิน</th>
                                    </tr>
                                   
                                    <tr>
                                        <td>
                                            <div class="payI">
                                                <i class='bx bx-money'></i>เงินสด</td>
                                            </div>
                                        <td>
                                            <div class="money">
                                                ฿<?php echo  number_format($sum_pay_today ,2);?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="payI">
                                                <i class='bx bx-scan'></i>QR code
                                            </div>
                                        </td>
                                        <td>
                                            <div class="money" value="$0.00">
                                                ฿<?php echo  number_format($sum_pay_today2  ,2);?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="total">
                                        <td>
                                            <div class="payI" style="font-weight: bold; padding-left: 60px;">
                                                รวม(฿)
                                            </div>
                                        </td>
                                        <td>
                                            <div class="money totalsum">
                                                ฿<?php echo  number_format($sum_pay_today_total ,2);?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- เดือน -->
                        <div id="pay-m" class="tabcontent3">
                            <?php
                                    if($date_m_ =date("m")==1){
                                        $date_m_T = "มกราคม" ;
                                    }elseif($date_m_ =date("m")==2){
                                        $date_m_T = "กุมภาพันธ์" ;
                                    }elseif($date_m_ =date("m")==3){
                                        $date_m_T = "มีนาคม" ;
                                    }elseif($date_m_ =date("m")==4){
                                        $date_m_T = "เมษายน" ;
                                    }elseif($date_m_ =date("m")==5){
                                        $date_m_T = "พฤษภาคม" ;
                                    }elseif($date_m_ =date("m")==6){
                                        $date_m_T = "มิถุนายน" ;
                                    }elseif($date_m_ =date("m")==7){
                                        $date_m_T = "กกรกฎาคม" ;
                                    }elseif($date_m_ =date("m")==8){
                                        $date_m_T = "สิงหาคม" ;
                                    }elseif($date_m_ =date("m")==9){
                                        $date_m_T = "กันยายน" ;
                                    }elseif($date_m_ =date("m")==10){
                                        $date_m_T = "ตุลาคม" ;
                                    }elseif($date_m_ =date("m")==11){
                                        $date_m_T = "พฤศจิกายน" ;
                                    }elseif($date_m_ =date("m")==12){
                                        $date_m_T = "ธันวาคม" ;
                                    }

                                    echo "ยอดเงินประจำเดือน ".$date_m_T." 20".$date_y_   ;    
                                    
                                    
                                    $date_m_ =date("m");
                                    $date_y_ =date("y");
                                    $date_d_ =date("d");
                                    
                                    /* เงินสดวันนี้ */
                                    $sql_pay_month2 = mysqli_query($connect, "SELECT SUM(all_food_prices) as sum_pay_month2 FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-$date_m_-01 00:00:00.000000' AND '$date_y_-$date_m_-31 23:59:59.000000' AND`id_pay_through`=01");
                                    $numrowpay_month2 = mysqli_num_rows($sql_pay_month2);
                                    $row_pay_month2 = mysqli_fetch_assoc($sql_pay_month2);

                                    if($numrowpay_month2 >0){
                                        $sum_pay_month2 = $row_pay_month2['sum_pay_month2'];
                                    }else{
                                        $sum_pay_month2 = "฿ 0.00";
                                    }

                                    /* qr code วันนี้ */
                                    $sql_pay_month = mysqli_query($connect, "SELECT SUM(all_food_prices) as sum_pay_month FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-$date_m_-01 00:00:00.000000' AND '$date_y_-$date_m_-31 23:59:59.000000' AND`id_pay_through`=02");
                                    $numrowpay_month = mysqli_num_rows($sql_pay_month);
                                    $row_pay_month = mysqli_fetch_assoc($sql_pay_month);

                                    if($numrowpay_month >0){
                                        $sum_pay_month = $row_pay_month['sum_pay_month'];
                                    }else{
                                        $sum_pay_month = "฿ 0.00";
                                    }

                                    /* ยอดรวม */
                                    $sum_pay_month_total = $sum_pay_month + $sum_pay_month2 ;

                                ?>
                            <div class="totalscroll">
                                <table class="pay">
                                    <tr>
                                        <th style="padding-left: 30px;" >ประเภท</th>
                                        <th style="width: 20%;">ยอดเงิน</th>
                                    </tr>
                                        

                                    <tr>
                                        <td>
                                            <div class="payI">
                                                <i class='bx bx-money'></i>เงินสด</td>
                                            </div>
                                        <td>
                                            <div class="money">
                                                ฿<?php echo  number_format($sum_pay_month2 ,2);?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="payI">
                                                <i class='bx bx-scan'></i>QR code
                                            </div>
                                        </td>
                                        <td>
                                            <div class="money" value="$0.00">
                                                ฿<?php echo  number_format($sum_pay_month ,2);?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="total">
                                        <td>
                                            <div class="payI" style="font-weight: bold; padding-left: 60px;">
                                                รวม(฿)
                                            </div>
                                        </td>
                                        <td>
                                            <div class="money totalsum">
                                                ฿<?php echo  number_format($sum_pay_month_total ,2);?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- ปี -->
                        <div id="pay-y" class="tabcontent3">
                            <?php
                                    echo "ยอดเงินประจำปี 20".$date_y_   ;    
                                    
                                    
                                    $date_m_ =date("m");
                                    $date_y_ =date("y");
                                    $date_d_ =date("d");
                                    
                                    /* เงินสดวันนี้ */
                                    $sql_pay_y = mysqli_query($connect, "SELECT SUM(all_food_prices) as sum_pay_y FROM `sales_history` WHERE `date_time`BETWEEN '$date_y_-01-01 00:00:00.000000' AND '$date_y_-12-31 23:59:59.000000' AND`id_pay_through`=01");
                                    $numrowpay_y = mysqli_num_rows($sql_pay_y);
                                    $row_pay_y = mysqli_fetch_assoc($sql_pay_y);

                                    if($numrowpay_y >0){
                                        $sum_pay_y = $row_pay_y['sum_pay_y'];
                                    }else{
                                        $sum_pay_y = "฿ 0.00";
                                    }

                                    /* qr code วันนี้ */
                                    $sql_pay_y2 = mysqli_query($connect, "SELECT SUM(all_food_prices) as sum_pay_y2 FROM `sales_history` WHERE `date_time`BETWEEN '$date_y_-01-01 00:00:00.000000' AND '$date_y_-12-31 23:59:59.000000' AND`id_pay_through`=02");
                                    $numrowpay_y2 = mysqli_num_rows($sql_pay_y2);
                                    $row_pay_y2 = mysqli_fetch_assoc($sql_pay_y2);

                                    if($numrowpay_y2 >0){
                                        $sum_pay_y2 = $row_pay_y2['sum_pay_y2'];
                                    }else{
                                        $sum_pay_y2 = "฿ 0.00";
                                    }

                                    /* ยอดรวม */
                                    $sum_pay_y_total = $sum_pay_y + $sum_pay_y2 ;

                                ?>
                            <div class="totalscroll">
                                <table class="pay">
                                    <tr>
                                        <th style="padding-left: 30px;" >ประเภท</th>
                                        <th style="width: 20%;">ยอดเงิน</th>
                                    </tr>
                                 
                                    <tr>
                                        <td>
                                            <div class="payI">
                                                <i class='bx bx-money'></i>เงินสด</td>
                                            </div>
                                        <td>
                                            <div class="money">
                                                ฿<?php echo  number_format($sum_pay_y ,2);?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="payI">
                                                <i class='bx bx-scan'></i>QR code
                                            </div>
                                        </td>
                                        <td>
                                            <div class="money" value="$0.00">
                                                ฿<?php echo  number_format($sum_pay_y2 ,2);?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="total">
                                        <td>
                                            <div class="payI" style="font-weight: bold; padding-left: 60px;">
                                                รวม(฿)
                                            </div>
                                        </td>
                                        <td>
                          
                                            <div class="money totalsum">
                                                ฿<?php echo  number_format($sum_pay_y_total,2);?>
                                            </div>
                                        </td>
                                    </tr>


                                </table>
                            </div>
                        </div>


                    </div>
            </div>


                <div id="Report" class="tabcontent">
                    <div class="danger">
                        <p>ประวัติการขาย</p>
                    </div>
                    <?php
        

/*
        if(isset($_GET['receipt'])){
            $receipt = $_GET['receipt'];
            $sql_sales_history0 = mysqli_query($connect, "SELECT * FROM `sales_history` WHERE `receipt`='$receipt'");
            $row0 = mysqli_fetch_assoc($sql_sales_history0);
        
            $order_code = $row0['order_code'];
            
        
        
        
            $user_id_sales_history = $row0['user_id'];
            $user = mysqli_query($connect, "SELECT * FROM `user` WHERE `user_id`= $user_id_sales_history");
            $rowuser = mysqli_fetch_assoc($user);
        
        
            if($row0["id_pay_through"]==1){
                $eee = "<div style='font-weight: bold; display: flex; align-items: center;' > <i style=' font-size: 20px; padding-right: 10px;' class='bx bx-money'></i> <p>เงินสด</p> </div>";
            }elseif($row0["id_pay_through"]==2){
                $eee = "<div style='font-weight: bold; display: flex; align-items: center;'  ><i style=' font-size: 20px; padding-right: 10px;' class='bx bx-scan'></i> <p>QR code</p> </div>";
            }
        
         
        
                                                  
                                                        
         
            echo '  <div  id="id02" class="modalid02" style="width: 100%; margin-bottom: 20px; margin-top: 20px; padding: 0px 20px;  display: flex; align-items: center; justify-content: center; ">
                        <div class="modal-contentid02" style="width: 80%;">
                            <div class="modal-headerid02" style="padding-left: 20px; margin-bottom: 20px; height: 5vh; color: #fff; display: flex; align-items: center; justify-content: space-between; padding-right: 10px; background-color: #0984e3;
                        }"  >
                                <p>ประวัติการขาย</p>
                                <span class="close2" style="  font-weight: bold; padding-left: 20px; cursor: pointer;  font-size: 20px;">&times;</span>
                            </div>
                            <div class="modal-bodyid02">
                                <div class="modal-box8" style="display: flex; align-items: center;  justify-content: center;  margin-bottom: 20px;" >
                                    <div class="modal-box" style="background-color: #fff; margin-right: 10px; padding: 20px 20px; width: 100%; height: 100px; border: 1px solid #0984e3;" >
                                        <p>เลขที่ใบเสร็จ :</p>
                                        <p style="font-weight: bold;" >'.$receipt.'</p>
                                    </div>
                                    <div class="modal-box" style="background-color: #fff; margin-right: 10px;padding: 20px 20px; width: 100%;height: 100px; border: 1px solid #0984e3;">
                                        <p>พนักงานที่ล็อกอินขาย :</p>
                                        <p style="font-weight: bold;" >'.$rowuser['user_name'].'</p>
                                    </div>
                                    <div class="modal-box" style="background-color: #fff; margin-right: 10px;padding: 20px 20px;width: 100%;  height: 100px; border: 1px solid #0984e3;">
                                        <p>ประเภทชำระ :</p>
                                        '.$eee.'
                                    </div>
                                    <div class="modal-box" style="background-color: #fff; padding: 20px 20px; width: 100%;  height: 100px; border: 1px solid #0984e3;">
                                        <p>วันที่ :</p>
                                        <p style="font-weight: bold;" >'.$row0["date_time"].' </p>
                                    </div>
                                </div>
                                <div class="modal-box0"  >
                                    <table style="font-size: 13px;">
                                        <thead >
                                            <tr>
                                                <th style="font-size: 13px; font-weight: bold; width:3%; text-align: end;">รหัสเมนูอาหาร</th>
                                                <th style="font-size: 13px; font-weight: bold; width:20%; text-align: start;">ชื่อเมนูอาหาร</th>
                                                <th style="font-size: 13px; font-weight: bold; width:5%; text-align: end;">จำนวน</th>
                                                <th style="font-size: 13px; font-weight: bold; width:5%; text-align: end;">ราคา/รายการ</th>
                                                <th style="font-size: 13px; font-weight: bold; width:5%; text-align: end;">รวม</th>
                                            </tr>
                                        </thead>
                                        <tbody>   ';
        
                                        $query = mysqli_query($connect, "SELECT * FROM `cart_item` WHERE `order_code`='$order_code'"); 
                                        $totalc = mysqli_num_rows($query);
                                        $sum = 0; 
                                            if ($totalc > 0) { 
                                                while ($row10 = mysqli_fetch_assoc($query)) {  
                                                        $name = $row10['name'];
                                                        $quantity = $row10['quantity'];
                                                        $price = $row10['price'];
                                                        $code = $row10['code'];
        
                                                        $priceXquantity =  $price * $quantity ;
        
                                                        $sum = $sum + $priceXquantity ;
                                   
        
            echo    '                       <tr>
                                                <td style="text-align: end;">'.$code.'</td>
                                                <td style="text-align: start;">'.$name.'</td>
                                                <td style="text-align: end;">'.$quantity.'</td>
                                                <td style="text-align: end;">'.number_format($price,2).'</td>
                                                <td style="text-align: end;">'.number_format($priceXquantity,2).'</td>
                                            </tr> 
                    '; } }
        
            echo '                          <tr>
                                                <td colspan="3" ></td>
                                                <td style="width:5%; text-align: start;">ยอดรวม</td>
                                                <td style="font-weight: bold; width:5%; text-align: end;">'.number_format($sum,2).'</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
        
                        </div>
                    </div>
                ' ;
        
        }*/
        
                ?>


<!-- ooo -->
                    <div class="box3">
                        <div class="box-sales4" >
                            <div class="tab-sales4">
                                <button class="tablinks-sales4" onclick="openCity4(event, 'report-today')"  id="defaultOpen4" >วันนี้</button>
                                <button class="tablinks-sales4" onclick="openCity4(event, 'report-m' )" >เดือน</button>
                                <button class="tablinks-sales4" onclick="openCity4(event, 'report-y' )" >ปี</button>

                             <!--   <form style=" display: flex; width: 50% ; "action="#" method="post"enctype="multipart/form-data">
                                    <input  style="margin-left: 50px; padding-left: 10px; padding-right: 10px;  " type="date" id="start" name="trip-start" value="<?php echo $date_added ;?>" > 
                                    <p class="ttopo" style="font-weight: bold; display: flex; align-items: center; justify-content: center; width: 2%;" >-</p>
                                    <input  style="padding-left: 10px; padding-right: 10px;  " type="date" id="start" name="trip-end" value="<?php echo $date_added ;?>" > 
                                    <button type="submit" style="margin-left: 10px; background-color: #0984e3; color:#fff ; width: 8% ;"  class="tablinks-sales" >ค้นหา</button>
                                </form>
    -->
                            </div>     
                        </div>

                        <!-- วันนี้ -->
                        <div id="report-today" class="tabcontent4">
                            <?php
                                     
                                     if($date_m_ =date("m")==1){
                                         $date_m_T = "มกราคม" ;
                                     }elseif($date_m_ =date("m")==2){
                                         $date_m_T = "กุมภาพันธ์" ;
                                     }elseif($date_m_ =date("m")==3){
                                         $date_m_T = "มีนาคม" ;
                                     }elseif($date_m_ =date("m")==4){
                                         $date_m_T = "เมษายน" ;
                                     }elseif($date_m_ =date("m")==5){
                                         $date_m_T = "พฤษภาคม" ;
                                     }elseif($date_m_ =date("m")==6){
                                         $date_m_T = "มิถุนายน" ;
                                     }elseif($date_m_ =date("m")==7){
                                         $date_m_T = "กกรกฎาคม" ;
                                     }elseif($date_m_ =date("m")==8){
                                         $date_m_T = "สิงหาคม" ;
                                     }elseif($date_m_ =date("m")==9){
                                         $date_m_T = "กันยายน" ;
                                     }elseif($date_m_ =date("m")==10){
                                         $date_m_T = "ตุลาคม" ;
                                     }elseif($date_m_ =date("m")==11){
                                         $date_m_T = "พฤศจิกายน" ;
                                     }elseif($date_m_ =date("m")==12){
                                         $date_m_T = "ธันวาคม" ;
                                     }

                                     $date_m_ =date("m");
                                     $date_y_ =date("y");
                                     $date_d_ =date("d");
                             

                                     echo "ประวัติการขายวันที่ ".$date_d_." ".$date_m_T." 20".$date_y_ ;   
                            ?> 
                            <div class="totalscroll">
                                <table  class="display">
                                    <thead>
                                        <tr>
                                            <th>เลขที่ใบเสร็จ</th>
                                            <th style="text-align: center;">จำนวนรายการ</th>
                                            <th style="text-align: center;">ผู้ดูแลการขาย</th>
                                            <th>วันที่ (ออกใบเสร็จ)</th>
                                            <th>ชำระเงินผ่าน</th>
                                            <th style="text-align: end;">ยอดรวม</th>
                                        </tr>
                                    </thead>
                                    <?php                                          
                                       $date_m_ =date("m");
                                       $date_y_ =date("y");
                                       $date_d_ =date("d");
                                        //รวมยอด
                                        $sumtoday = mysqli_query($connect, "SELECT SUM(all_food_prices)AS sumtodayy FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' ");
                                        $row_sumtoday = mysqli_fetch_assoc($sumtoday);

                                        $totalcnt = mysqli_num_rows($sumtoday);

                                        $sumtpday0 = $row_sumtoday['sumtodayy'];

                                        if(empty($sumtpday0)) {
                                            $sumtodayS = '0' ;
                                        }else{
                                            $sumtodayS = $sumtpday0 ;
                                        }


                                       $sql_report_today = mysqli_query($connect, "SELECT * FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-$date_m_-$date_d_ 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' ORDER BY `receipt` DESC "); 
                                       $num_report_today = mysqli_num_rows($sql_report_today);
                                       if($num_report_today>0){
                                            while($row_report_today = mysqli_fetch_assoc($sql_report_today)){ 
                                                // user
                                                $user_id_sales_history = $row_report_today['user_id'];
                                                $user = mysqli_query($connect, "SELECT * FROM `user` WHERE `user_id`= $user_id_sales_history");
                                                $rowuser = mysqli_fetch_assoc($user);

                                                //order_list 
                                                $sql_report_order_today = $row_report_today['order_code'];
                                                $order_list_today = mysqli_query($connect, "SELECT * FROM `order_list` WHERE `order_code`= '$sql_report_order_today' ");
                                                $roworder_list_today = mysqli_fetch_assoc($order_list_today);

                                             


                                                
                                    ?>
                                    <tbody>
                                        <tr>                 
                                            <td><a href="00report.php?receipt=<?=$row_report_today['receipt'] ?>"><span class="material-icons">receipt</span><?php echo $row_report_today['receipt'] ?></a></td>
                                            <td style="text-align: center;"><?php echo $roworder_list_today['number_food_items']?></td>
                                            <td style="text-align: center;"><?php echo $rowuser['user_name']?></td>
                                            <td><?php echo $row_report_today['date_time']?></td>
                                                <?php
                                                    if($row_report_today['id_pay_through']==1){
                                                ?>
                                                        <td><div class="payI"><i class="bx bx-money"></i>เงินสด</td></div></td>  
                                                <?php }else{ ?> 
                                                        <td><div class="payI"><i class="bx bx-scan"></i>QR code</td></div></td>  
                                                <?php } ?>

                                                
                                                
                                            
                                            <td style="text-align: end;" ><?php echo number_format($row_report_today['all_food_prices'],2)?></td> 
                                        </tr>
                                    </tbody>
                                   
                                   
                                    <?php } } else { ?>
                                        <tr>
                                            <td colspan="7" style="text-align: center;" >ไม่มีข้อมูล</td>
                                        </tr>
                                    <?php } ?>
                                
                                    <tfoot style=" background-color: #f2f2f2;color: #000000;font-weight: bold;">
                                        <tr>
                                            <td colspan="5">รวม</td>
                                            <td style="text-align: end;"><?php  echo  "฿ ". number_format($sumtodayS,2) ;?></td>
                                        </tr>
                                    </tfoot>
                                   
                                </table>
                            </div> 
                         
                        </div>


                        <!-- เดือน -->
                        <div id="report-m" class="tabcontent4">
                            <?php
                                     
                                     $date_m_ =date("m");
                                     $date_y_ =date("y");
                                     $date_d_ =date("d");
                             
                                     if($date_m_ =date("m")==1){
                                         $date_m_T = "มกราคม" ;
                                     }elseif($date_m_ =date("m")==2){
                                         $date_m_T = "กุมภาพันธ์" ;
                                     }elseif($date_m_ =date("m")==3){
                                         $date_m_T = "มีนาคม" ;
                                     }elseif($date_m_ =date("m")==4){
                                         $date_m_T = "เมษายน" ;
                                     }elseif($date_m_ =date("m")==5){
                                         $date_m_T = "พฤษภาคม" ;
                                     }elseif($date_m_ =date("m")==6){
                                         $date_m_T = "มิถุนายน" ;
                                     }elseif($date_m_ =date("m")==7){
                                         $date_m_T = "กกรกฎาคม" ;
                                     }elseif($date_m_ =date("m")==8){
                                         $date_m_T = "สิงหาคม" ;
                                     }elseif($date_m_ =date("m")==9){
                                         $date_m_T = "กันยายน" ;
                                     }elseif($date_m_ =date("m")==10){
                                         $date_m_T = "ตุลาคม" ;
                                     }elseif($date_m_ =date("m")==11){
                                         $date_m_T = "พฤศจิกายน" ;
                                     }elseif($date_m_ =date("m")==12){
                                         $date_m_T = "ธันวาคม" ;
                                     }

                                     echo "ประวัติการขายเดือน ".$date_m_T." 20".$date_y_ ;   
                            ?>  
                            <div class="totalscroll">
                                <!-- <table id="report-todayitem" class="display"> -->
                                <table  class="display">
                                    <thead>
                                        <tr>
                                            <th>เลขที่ใบเสร็จ</th>
                                            <th style="text-align: center;">จำนวนรายการ</th>
                                            <th style="text-align: center;">ผู้ดูแลการขาย</th>
                                            <th>วันที่ (ออกใบเสร็จ)</th>
                                            <th>ชำระเงินผ่าน</th>
                                            <th style="text-align: end;">ยอดรวม</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                       $date_m_ =date("m");
                                       $date_y_ =date("y");
                                       $date_d_ =date("d");

                                        //รวมยอด
                                        $summ = mysqli_query($connect, "SELECT SUM(all_food_prices)AS summ   FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-$date_m_-01 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' ");
                                        $rowsumm = mysqli_fetch_assoc($summ);
                                        $sumtoday = number_format($rowsumm['summ'],2);

                                        if($rowsumm['summ'] == ''){
                                            $sumtodayM = '0' ;
                                        }else{
                                            $sumtodayM = $rowsumm['summ'] ;
                                        }

                                     
                                       $sql_report_today = mysqli_query($connect, "SELECT * FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-$date_m_-01 00:00:00.000000' AND '$date_y_-$date_m_-$date_d_ 23:59:59.000000' ORDER BY `receipt` DESC"); 
                                       $num_report_today = mysqli_num_rows($sql_report_today);
                                       if($num_report_today>0){
                                            while($row_report_today = mysqli_fetch_assoc($sql_report_today)){ 
                                                // user
                                                $user_id_sales_history = $row_report_today['user_id'];
                                                $user = mysqli_query($connect, "SELECT * FROM `user` WHERE `user_id`= $user_id_sales_history");
                                                $rowuser = mysqli_fetch_assoc($user);

                                                //order_list 
                                                $sql_report_order_today = $row_report_today['order_code'];
                                                $order_list_today = mysqli_query($connect, "SELECT * FROM `order_list` WHERE `order_code`= '$sql_report_order_today' ");
                                                $roworder_list_today = mysqli_fetch_assoc($order_list_today);

                                                 
                                    ?>
                                    <tbody>
                                        <tr>        
                                        <td><a href="00report.php?receipt=<?=$row_report_today['receipt'] ?>"><span class="material-icons">receipt</span><?php echo $row_report_today['receipt'] ?></a></td>
                                            <?////////////////?>           
                                            <!--<td><a href="00report_2.php?receipt=<?=$tyt ?>"><span class="material-icons">receipt</span><?php //echo $row_report_today['receipt'] ?></a></td> -->
                                            <td style="text-align: center;"><?php echo $roworder_list_today['number_food_items']?></td>
                                            <td style="text-align: center;"><?php echo $rowuser['user_name']?></td>
                                            <td><?php echo $row_report_today['date_time']?></td>
                                                <?php
                                                    if($row_report_today['id_pay_through']==1){
                                                ?>
                                                        <td><div class="payI"><i class="bx bx-money"></i>เงินสด</td></div></td>  
                                                <?php }else{ ?> 
                                                        <td><div class="payI"><i class="bx bx-scan"></i>QR code</td></div></td>  
                                                <?php } ?>
                                                
                                            
                                            <td style="text-align: end;" ><?php echo number_format($row_report_today['all_food_prices'],2)?></td> 
                                        </tr>
                                    </tbody>

                                    <?php } } else { ?>
                                        <tr>
                                            <td colspan="7" style="text-align: center;" >ไม่มีข้อมูล</td>
                                        </tr>
                                    <?php } ?>
                                
                                    <tfoot style=" background-color: #f2f2f2;color: #000000;font-weight: bold;">
                                        <tr>
                                            <td colspan="5">รวม</td>
                                            <td style="text-align: end;"><?php  echo  "฿ ".number_format($sumtodayM,2) ;?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        
                        <!-- ปี -->
                        <div id="report-y" class="tabcontent4">
                            <?php
                                     
                                     $date_m_ =date("m");
                                     $date_y_ =date("y");
                                     $date_d_ =date("d");
                             
                                     if($date_m_ =date("m")==1){
                                         $date_m_T = "มกราคม" ;
                                     }elseif($date_m_ =date("m")==2){
                                         $date_m_T = "กุมภาพันธ์" ;
                                     }elseif($date_m_ =date("m")==3){
                                         $date_m_T = "มีนาคม" ;
                                     }elseif($date_m_ =date("m")==4){
                                         $date_m_T = "เมษายน" ;
                                     }elseif($date_m_ =date("m")==5){
                                         $date_m_T = "พฤษภาคม" ;
                                     }elseif($date_m_ =date("m")==6){
                                         $date_m_T = "มิถุนายน" ;
                                     }elseif($date_m_ =date("m")==7){
                                         $date_m_T = "กกรกฎาคม" ;
                                     }elseif($date_m_ =date("m")==8){
                                         $date_m_T = "สิงหาคม" ;
                                     }elseif($date_m_ =date("m")==9){
                                         $date_m_T = "กันยายน" ;
                                     }elseif($date_m_ =date("m")==10){
                                         $date_m_T = "ตุลาคม" ;
                                     }elseif($date_m_ =date("m")==11){
                                         $date_m_T = "พฤศจิกายน" ;
                                     }elseif($date_m_ =date("m")==12){
                                         $date_m_T = "ธันวาคม" ;
                                     }

                                     echo "ประวัติการขายปี "." 20".$date_y_ ;   
                            ?>  
                            <div class="totalscroll">
                                   <!-- <table id="report-todayitem" class="display"> -->
                                   <table  class="display">
                                    <thead>
                                        <tr>
                                            <th>เลขที่ใบเสร็จ</th>
                                            <th style="text-align: center;">จำนวนรายการ</th>
                                            <th style="text-align: center;">ผู้ดูแลการขาย</th>
                                            <th>วันที่ (ออกใบเสร็จ)</th>
                                            <th>ชำระเงินผ่าน</th>
                                            <th style="text-align: end;">ยอดรวม</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                       $date_m_ =date("m");
                                       $date_y_ =date("y");
                                       $date_d_ =date("d");
                               
                                            //รวมยอด
                                            $sumy = mysqli_query($connect, "SELECT SUM(all_food_prices)AS sumy   FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-01-01 00:00:00.000000' AND '$date_y_-12-31 23:59:59.000000' ");
                                            $rowsumy = mysqli_fetch_assoc($sumy);

                                            $sumtoday = number_format($rowsumy['sumy'],2);

                                            if($rowsumy['sumy'] == ''){
                                                $sumtodayY = '0' ;
                                            }else{
                                                $sumtodayY = $rowsumy['sumy'];
                                            }

                                       $sql_report_today = mysqli_query($connect, "SELECT * FROM `sales_history` WHERE `date_time` BETWEEN '$date_y_-01-01 00:00:00.000000' AND '$date_y_-12-31 23:59:59.000000' ORDER BY `receipt` DESC "); 
                                       $num_report_today = mysqli_num_rows($sql_report_today);
                                       if($num_report_today>0){
                                            while($row_report_today = mysqli_fetch_assoc($sql_report_today)){ 
                                                // user
                                                $user_id_sales_history = $row_report_today['user_id'];
                                                $user = mysqli_query($connect, "SELECT * FROM `user` WHERE `user_id`= $user_id_sales_history");
                                                $rowuser = mysqli_fetch_assoc($user);

                                                //order_list 
                                                $sql_report_order_today = $row_report_today['order_code'];
                                                $order_list_today = mysqli_query($connect, "SELECT * FROM `order_list` WHERE `order_code`= '$sql_report_order_today' ");
                                                $roworder_list_today = mysqli_fetch_assoc($order_list_today);

                                           
                                                
                                    ?>
                                    <tbody>
                                        <tr>                   
                                            <td><a href="00report.php?receipt=<?=$row_report_today['receipt'] ?>"><span class="material-icons">receipt</span><?php echo $row_report_today['receipt'] ?></a></td>
                                            <td style="text-align: center;"><?php echo $roworder_list_today['number_food_items']?></td>
                                            <td style="text-align: center;"><?php echo $rowuser['user_name']?></td>
                                            <td><?php echo $row_report_today['date_time']?></td>
                                                <?php
                                                    if($row_report_today['id_pay_through']==1){
                                                ?>
                                                        <td><div class="payI"><i class="bx bx-money"></i>เงินสด</td></div></td>  
                                                <?php }else{ ?> 
                                                        <td><div class="payI"><i class="bx bx-scan"></i>QR code</td></div></td>  
                                                <?php } ?>
                                                
                                            
                                            <td style="text-align: end;" ><?php echo number_format($row_report_today['all_food_prices'],2)?></td> 
                                        </tr>
                                    </tbody>

                                    <?php } } else { ?>
                                        <tr>
                                            <td colspan="7" style="text-align: center;" >ไม่มีข้อมูล</td>
                                        </tr>
                                    <?php } ?>
                                   
                                    <tfoot style=" background-color: #f2f2f2;color: #000000;font-weight: bold;">
                                        <tr>
                                            <td colspan="5">รวม</td>
                                            <td style="text-align: end;"><?php  echo  "฿ ".number_format($sumtodayY,2)  ;?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                       
                       
              


                    </div>
                </div>

                
        

    

 

    <script src="script.js"></script>

    
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>     
    <script>
        
        $(document).ready(function() {
            showGraph();
        });
        function showGraph(){
            {
                $.post("data.php", function(data) {
                    console.log(data);
                    let name = [];
                    let sum = [];
                    for (let i in data) {
                        name.push(data[i].name);
                        sum.push(data[i].sum);
                    }
                    let chartdata = {
                        labels: name,
                        datasets: [{
                                label: 'ชำระเงินผ่าน 01 = ผ่านด้วยเงินสด | 02 = จ่ายผ่าน QR code',
                                backgroundColor: [
                                    '#0984e3',
                                    'rgb(255, 205, 86)'
                                    ],
                               
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: sum
                        }]
                       
                    };
                    let graphTarget = $('#graphCanvas');
                    let barGraph = new Chart(graphTarget, {
                        type: 'doughnut',
                        data: chartdata
                    })
                })
            }
        }

        $(document).ready(function () {
            $('#month').DataTable({
                ordering: false,
                info: false,
            });
        });
        $(document).ready(function () {
            $('#report-todayitem').DataTable({
                ordering: false,
                info: false,
            });
        });

       


        function openCity(evt, cityName) {
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



        function openCity2(evt, Name) {
        var o, tabcontent2, tablinks2;
        tabcontent2 = document.getElementsByClassName("tabcontent2");
        for (o = 0; o < tabcontent2.length; o++) {
            tabcontent2[o].style.display = "none";
        }
        tablinks2 = document.getElementsByClassName("tablinks-sales");
        for (o = 0; o < tablinks2.length; o++) {
            tablinks2[o].className = tablinks2[o].className.replace(" active", "");
        }
        document.getElementById(Name).style.display = "block";
        evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen2").click();



        function openCity3(evt, Name) {
        var p, tabcontent3, tablinks3;
        tabcontent3 = document.getElementsByClassName("tabcontent3");
        for (p = 0; p < tabcontent3.length; p++) {
            tabcontent3[p].style.display = "none";
        }
        tablinks3 = document.getElementsByClassName("tablinks-sales3");
        for (p = 0; p < tablinks3.length; p++) {
            tablinks3[p].className = tablinks3[p].className.replace(" active", "");
        }
        document.getElementById(Name).style.display = "block";
        evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen3").click();


        function openCity4(evt, Name) {
        var q, tabcontent4, tablinks4;
        tabcontent4 = document.getElementsByClassName("tabcontent4");
        for (q = 0; q < tabcontent4.length; q++) {
            tabcontent4[q].style.display = "none";
        }
        tablinks4 = document.getElementsByClassName("tablinks-sales4");
        for (q = 0; q < tablinks4.length; q++) {
            tablinks4[q].className = tablinks4[q].className.replace(" active", "");
        }
        document.getElementById(Name).style.display = "block";
        evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen4").click();






            var modal = document.getElementById("id02");   
            var span = document.getElementsByClassName("close2")[0];  // Get the <span> element that closes the modal       
            span.onclick = function() {   // When the user clicks on <span> (x), close the modal 
            modal.style.display = "none";
            }
            window.onclick = function(event2) {   // When the user clicks anywhere outside of the modal, close it
            if (event2.target == modal) {
                modal.style.display = "none";
            }
            }





       
        
        function  myFunctionmyBtn() {
        var modalid01 = document.getElementById('id01');
        var btn = document.getElementById("myBtn10");
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

        
      function myFunctiondark() {
        var element = document.body;
        element.classList.toggle("dark-mode");
      }



    </script>
    
</body>
</html>