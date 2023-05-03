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

}

if(isset($_GET['print'])){
    $_SESSION['receipt-print'] = $_SESSION['receipt'] ;
    header('location:00report_2-print.php');
}

?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head runat="server" >
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการขาย</title>
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
  
<div class="boxx">   
    <ul class="breadcrumb">
        <li><a href="00report.php">รายงาน</a></li>
        <li>ยอดขาย</li>
    </ul>  
    <div class="boxS" >
               <?php
             
                
                  
               ?>
                <div class="receipt_2">
                    <div class="namere" style="font-weight: bold;" >ยอดขาย</div>
                    <div class="receiptno"> <p>วันที่ : <?php print_r($_SESSION['date-start']); echo " ถึง "; print_r($_SESSION['date-end']);?></p></div>
                    <div class="receiptno"></div>
                    <div class="receiphj">
                        <div class="receiptno"></div>
                        <div class="receiptno"></div>
                        <div class="receiptno"></div>
                    </div>
                    <div class="receiptlist">
                        <div class="totalscroll">
                                <table >
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
    
                                        /* echo "ยอดขายประจำวันที่ ".$date_d_." ".$date_m_T." 20".$date_y_ ;   */
                             
                                         
                                            
                                         $date_m_ =date("m");
                                         $date_y_ =date("y");
                                         $date_d_ =date("d");


                                         $date_start = $_SESSION['date-start'];
                                         $date_end = $_SESSION['date-end'];
                      
                                         $sql_sales_history= mysqli_query($connect, "SELECT DISTINCT DATE_FORMAT(date_time,'%d %m %y') AS date_time FROM `sales_history` WHERE `date_time` BETWEEN '$date_start 00:00:00.000000' AND '$date_end 23:59:59.000000' ");
                                         $rows0 = mysqli_num_rows($sql_sales_history);
                                         $row0 = mysqli_fetch_assoc($sql_sales_history);

                                         $total = 0 ;
                                                         
                                             if($rows0>0){
                                                 $sql_month = mysqli_query($connect, "SELECT DISTINCT DATE_FORMAT(date_time,'%d-%m-20%y') AS date_timeu, DATE_FORMAT(date_time,'20%y-%m-%d') AS date_time  FROM `sales_history` WHERE `date_time` BETWEEN '$date_start 00:00:00.000000' AND '$date_end 23:59:59.000000'");
                                               

                                                 while ($row10 = mysqli_fetch_assoc($sql_month)) {

                                                    $date = $row10['date_time'];

                                                    $sqlsum = mysqli_query($connect, "SELECT SUM(all_food_prices) AS sum 
                                                        FROM `sales_history` WHERE `date_time` BETWEEN '$date 00:00:00.000000' AND '$date 23:59:59.000000'");

                                                    $rowsum = mysqli_fetch_assoc($sqlsum);

                                                    $total = $total + $rowsum['sum'] ;
                                                    

                                      /*    $query = mysqli_query($connect, "SELECT * FROM `cart_item` WHERE `order_code`='$order_code'"); 
                                          $totalc = mysqli_num_rows($query);
                                          $num = 0;
                                          $sum = 0; 
                                              if ($totalc > 0) { 
                                                  while ($row10 = mysqli_fetch_assoc($query)) {  
                                                        $num = $num + 1;
                                                        $name = $row10['name'];
                                                          $quantity = $row10['quantity'];
                                                          $price = $row10['price'];
                                                          $code = $row10['code'];
          
                                                          $priceXquantity =  $price * $quantity ;
          
                                                          $sum = $sum + $priceXquantity ;*/
                                        ?>
                                           <tr>
                                                <td><a class="a" href="00report.php"><i class='bx bxs-folder'></i><?php echo $row10['date_timeu']; ?></a></td>
                                                <td style="text-align: end;"><?php echo  "฿ ".number_format($rowsum['sum'],2) ?></td>
                                            </tr>
                                        </tbody>
                                     

                                            <?php  }  } else {
                                        
                                        ?>
                                        <tfoot style=" background-color: #f2f2f2; color: #000000;" >
                                            <tr style="font-weight: bold;">
                                                <td colspan="5" style="text-align: center;">ไม่พบข้อมมูล</th>
                                            </tr>
                                        </tfoot>
                                        <?php } ?>
                                        <tfoot style=" background-color: #f2f2f2; color: #000000;" >
                                            <tr style="font-weight: bold;">
                                                <td style="width:30%;text-align: start;">฿ รวม</th>
                                                <td style="text-align: end;"><?php  echo  "฿ ".number_format($total,2) ?></th>
                                            </tr>
                                        </tfoot>
                                         
                                      
                                      
                                </table>
                        </div>
                    </div>
                    <!--
                    <div class="box-print">
                        <form action="00report_2.php" >
                            <button name="print" type="submit" class="print">พิมพ์รายงาน</button>
                        </form>
                    </div>
                                                  -->
                </div>
    </div>
</div>
 
    

    <script src="script.js"></script>

 

    

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>     
    <script>
        
     


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