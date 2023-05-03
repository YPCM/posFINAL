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


//print_r($_SESSION["table"]) ;

$table_id = $_SESSION["table"];

$_SESSION["table_orderlist"] = $table_id ;






/*


$total_sum_u = mysqli_query ($connect, "SELECT quantity, price, SUM(quantity*price) as total_sum_u FROM cart_item WHERE table_id = '$table_id' ");
$row = mysqli_fetch_array($total_sum_u);
$total_sum = $row['total_sum_u']; //            //

$total_quantity= mysqli_query ($connect, "SELECT quantity, SUM(quantity) as quantity FROM cart_item WHERE table_id = '$table_id' ");
$rowquantity = mysqli_fetch_array($total_quantity);
$quantity = $rowquantity['quantity']; //        //


$sql_order_new = mysqli_query($connect,"SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id' ");
$rowsql_order_new = mysqli_fetch_array($sql_order_new);
$order_code = $rowsql_order_new['order_code'];

$sql_order_upnew =  mysqli_query($connect, "UPDATE order_list SET number_food_items ='$quantity',
                                                                all_food_prices = '$total_sum' 
                                                                WHERE order_code = '$order_code' ")
                                                                or die('query failed');

*/
$table_order_code = $_SESSION["table_order_code"];

//echo $table_order_code ;
$total_sum_u = mysqli_query ($connect, "SELECT quantity, price, SUM(quantity*price) as total_sum_u FROM cart_item WHERE `order_code` = '$table_order_code ' ");
$row = mysqli_fetch_array($total_sum_u);
$total_sum = $row['total_sum_u']; //            //

$total_quantity= mysqli_query ($connect, "SELECT quantity, SUM(quantity) as quantity FROM cart_item WHERE `order_code` = '$table_order_code ' ");
$rowquantity = mysqli_fetch_array($total_quantity);
$quantity = $rowquantity['quantity']; //        //




$sql_order_new = mysqli_query($connect,"SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id' ");
$rowsql_order_new = mysqli_fetch_array($sql_order_new);
$order_code = $rowsql_order_new['order_code'];

$sql_order_upnew =  mysqli_query($connect, "UPDATE order_list SET number_food_items ='$quantity',
                                                                all_food_prices = '$total_sum' 
                                                                WHERE order_code = '$order_code' ")
                                                                or die('query failed');



/*
print_r($_SESSION['table_orderlist']);
*/

if (isset($_POST['addmanu'])) {
    $addmenu_orderlist = mysqli_query ($connect, "SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id'");
    $rowaddmenu_orderlist = mysqli_fetch_array($addmenu_orderlist);
    $_SESSION["order_code"] = $rowaddmenu_orderlist['order_code'];

    $_SESSION["table_orderlist"] = $table_id ;
    echo "<script>window.location.href='00home2_list.php'</script>";

}

if(isset($_POST['cancelcart'])){

    $table_id = $_SESSION["table"] ;
    
   /* $sql_sales_history_new = mysqli_query($connect,"SELECT MAX(receipt) as receipt FROM sales_history WHERE table_id='$table_id' ");
    $rowsql_sales_history_new = mysqli_fetch_array($sql_sales_history_new);
    $receipt = $rowsql_sales_history_new['receipt'];*/



    /*
    $sql = mysqli_query($connect, "UPDATE cart_item 
                                    SET table_id ='00' 
                                    WHERE table_id = '$table_id' ");
    */

    $sql = mysqli_query($connect, "UPDATE  table_number 
                                    SET status ='0' 
                                    WHERE table_id = '$table_id' ");



    include_once('function.php');
    $fetchdata = new DB_con();
    $sqlrrrr = $fetchdata->fetchdata();
    $row = mysqli_fetch_array($sqlrrrr);

   

    if($table_id==$row['table_id']);
    {
        $sqlstatus_00 =$insertdata->status_00($table_id);

           
        $sql_idorderlist = mysqli_query($connect,"SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id' ");
        $rowsql_idorderlist = mysqli_fetch_array($sql_idorderlist);
        $id_order_code = $rowsql_idorderlist['order_code'];


        $sql_order_list = mysqli_query($connect, "UPDATE order_list SET  
                                                    	id_payment_status ='03' 
                                                  WHERE order_code = '$id_order_code' " );
        
        $sqlitem = mysqli_query($connect,"DELETE FROM cart_item WHERE order_code = '$id_order_code' ");
        $sqlrepost = mysqli_query($connect,"DELETE FROM sales_history WHERE order_code = '$id_order_code' ");
        
        if($sqlstatus_00){
            echo "<script>alert('ยกเลิกออเดอร์เรียบร้อยแล้ว!!');</script>";
            unset($_SESSION["cart_item"]);
            echo "<script>window.location.href='00tablenumber.php'</script>";
    
           //echo "<script>window.location.href='00order.php'</script>";
        }else {
            echo "<script>alert('เกิดข้อผิดพลาด');</script>";      
            echo "<script>window.location.href='00order.php'</script>";
        }
    }
}

if(isset($_POST['quantity_new'])){

    $id_cart_item = $_GET['id_cart_item'];

    $quantity_new = $_POST['txtquantity_new'];

    $sql = mysqli_query($connect, " UPDATE cart_item 
                                    SET quantity ='$quantity_new' 
                                    WHERE id_cart_item = '$id_cart_item' ") ;


$table_order_code = $_SESSION["table_order_code"];
                    $total_sum_u = mysqli_query ($connect, "SELECT quantity, price, SUM(quantity*price) as total_sum_u FROM cart_item WHERE `order_code` = '$table_order_code ' ");
                    $row = mysqli_fetch_array($total_sum_u);
                    $total_sum = $row['total_sum_u']; //     

                    $total_quantity= mysqli_query ($connect, "SELECT quantity, SUM(quantity) as quantity FROM cart_item WHERE `order_code` = '$table_order_code ' ");
                    $rowquantity = mysqli_fetch_array($total_quantity);
                    $quantity = $rowquantity['quantity']; //        //


                    $sql_order_new = mysqli_query($connect,"SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id' ");
                    $rowsql_order_new = mysqli_fetch_array($sql_order_new);
                    $order_code = $rowsql_order_new['order_code'];

                    $sql_order_upnew =  mysqli_query($connect, "UPDATE order_list SET number_food_items ='$quantity',
                                                                                    all_food_prices = '$total_sum' 
                                                                                    WHERE order_code = '$order_code' ")
                                                                                    or die('query failed');


                                                                                    if($sql){
                                                                                        echo "<script>alert('แก้ไขจำนวนอาหารเรียบร้อยแล้ว!!');</script>";
                                                                                    }else{
                                                                                        echo "<script>alert('เกิดข้อผิดพลาด');</script>";      
                                                                                    }

}

/*  */ 
if(isset($_POST['del_list'])){
    $id_cart_item = $_GET['id_cart_item'];

    $sqldel_list = mysqli_query($connect, " DELETE FROM `cart_item` WHERE id_cart_item = '$id_cart_item' ") ;

    $table_order_code = $_SESSION["table_order_code"];
                    $total_sum_u = mysqli_query ($connect, "SELECT quantity, price, SUM(quantity*price) as total_sum_u FROM cart_item WHERE `order_code` = '$table_order_code ' ");
                    $row = mysqli_fetch_array($total_sum_u);
                    $total_sum = $row['total_sum_u']; //     

                    $total_quantity= mysqli_query ($connect, "SELECT quantity, SUM(quantity) as quantity FROM cart_item WHERE `order_code` = '$table_order_code ' ");
                    $rowquantity = mysqli_fetch_array($total_quantity);
                    $quantity = $rowquantity['quantity']; //        //


                    $sql_order_new = mysqli_query($connect,"SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id' ");
                    $rowsql_order_new = mysqli_fetch_array($sql_order_new);
                    $order_code = $rowsql_order_new['order_code'];

                    $sql_order_upnew =  mysqli_query($connect, "UPDATE order_list SET number_food_items ='$quantity',
                                                                                    all_food_prices = '$total_sum' 
                                                                                    WHERE order_code = '$order_code' ")
                                                                                    or die('query failed');

                                                                                    if($sqldel_list){
                                                                                        echo "<script>alert('ลบรายการอาหารเรียบร้อยแล้ว!!');</script>";
                                                                                    }else{
                                                                                        echo "<script>alert('เกิดข้อผิดพลาด');</script>";      
                                                                                    }
}

if(isset($_POST['check_bill-bank'])){

   
$table_order_code = $_SESSION["table_order_code"];
$total_sum_u = mysqli_query ($connect, "SELECT quantity, price, SUM(quantity*price) as total_sum_u FROM cart_item WHERE `order_code` = '$table_order_code ' ");
$row = mysqli_fetch_array($total_sum_u);
$total_sum = $row['total_sum_u']; //     


    $total_sum_u = number_format($row['total_sum_u'],2);
    $bank_input = number_format($_POST['bank_input'],2) ;
    $bank_total = $bank_input - $total_sum_u ; 
    $bank_total_00 = number_format($bank_total,2) ;

    echo "<p type='hidden' value='$total_sum_u'></p>";
    echo "<p type='hidden' value='$bank_input'></p>";
    echo "<p type='hidden' value='$bank_total_00'></p>";

    /*echo "total_sum_u = ".$total_sum_u."<br>";
    echo "bank_input = ".$bank_input."<br>";
    echo "bank_total = ".$bank_total_00 ;*/



        $sql_idorderlist = mysqli_query($connect,"SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id' ");
        $rowsql_idorderlist = mysqli_fetch_array($sql_idorderlist);
        $id_order_code = $rowsql_idorderlist['order_code'];

        $user_id = $_SESSION['user_id'];

 
        $sql_sales_history = mysqli_query($connect, "INSERT INTO sales_history(order_code ,user_id,date_time,all_food_prices,id_pay_through) 
        VALUES('$id_order_code','$user_id','$date_time','$total_sum_u','1')") 
        or die('query failed sql_sales_history');




        $total_sum_u = number_format($total_sum,2);
    
      /*  $sql_order_list = mysqli_query($connect, "UPDATE    sales_history SET  
                                                            id_pay_through ='01',
                                                            date_time ='$date_time',
                                                            all_food_prices ='$total_sum_u'
                                                            WHERE order_code = '$id_order_code' " );    */
    
        $sql_order_list = mysqli_query($connect, "UPDATE order_list SET  
        id_payment_status ='01'
        WHERE order_code = '$id_order_code' " );


        $sql_rrr = mysqli_query($connect,"SELECT * FROM sales_history WHERE order_code='$id_order_code' ");
        $rowsql_rrr = mysqli_fetch_array($sql_rrr);

        $_SESSION["receipt"] = $rowsql_rrr['receipt'];
        
    
    
        $sql = mysqli_query($connect, "UPDATE table_number 
        SET status ='0' 
        WHERE table_id = '$table_id' ");
    
            
        include_once('function.php');
        $fetchdata = new DB_con();
        $sqlrrrr = $fetchdata->fetchdata();
        $row = mysqli_fetch_array($sqlrrrr);
    
        if($table_id==$row['table_id']);
        {
            $sqlstatus_00 =$insertdata->status_00($table_id);
    
               
            $sql_idorderlist = mysqli_query($connect,"SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id' ");
            $rowsql_idorderlist = mysqli_fetch_array($sql_idorderlist);
            $id_order_code = $rowsql_idorderlist['order_code'];
    
    
            $sql_order_list = mysqli_query($connect, "UPDATE order_list SET  
                                                            id_payment_status ='01' 
                                                        WHERE order_code = '$id_order_code' " );
    
    
            
            if($sqlstatus_00){
              //  echo "<script>alert('จ่ายเงินสด!!');</script>";
            

              //  echo "<script>window.location.href='00tablenumber.php'</script>";
        
               //echo "<script>window.location.href='00order.php'</script>";
            }else {
               // echo "<script>alert('เกิดข้อผิดพลาด');</script>";      
              //  echo "<script>window.location.href='00order_list.php'</script>";
            }

        }

        
    if($bank_input < $total_sum_u ){
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo    "<script>"; 
        echo        "Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'กรุณากรอกจำนวนเงินใหม่',
                    showConfirmButton: true,
                    }).then((result)=> {
                        if(result){
                            window.location.href='00order_list.php';
                        }
                    })"; 
        echo    "</script>";

    }else{
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo    "<script>"; 
        echo        "Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'ทอนเงิน $bank_total_00 บาท',
                    showConfirmButton: true,
                    }).then((result)=> {
                        if(result){
                            window.location.href='00report_2-print.php';
                        }
                    })"; 
        echo    "</script>";

        

    }
}



if(isset($_POST['check_bill-qr'])){
    
$table_order_code = $_SESSION["table_order_code"];
$total_sum_u = mysqli_query ($connect, "SELECT quantity, price, SUM(quantity*price) as total_sum_u FROM cart_item WHERE `order_code` = '$table_order_code ' ");
$row = mysqli_fetch_array($total_sum_u);
$total_sum = $row['total_sum_u']; //     


    $total_sum_u = number_format($total_sum,2);

    $qr = $_POST['check_bill-qr'];
    echo "<p type='hidden' value='$qr'></p>";
    
    $sql_idorderlist = mysqli_query($connect,"SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id' ");
        $rowsql_idorderlist = mysqli_fetch_array($sql_idorderlist);
        $id_order_code = $rowsql_idorderlist['order_code'];


    $user_id = $_SESSION['user_id'];

 
    $sql_sales_history = mysqli_query($connect, "INSERT INTO sales_history(order_code ,user_id,date_time,all_food_prices,id_pay_through) 
    VALUES('$id_order_code','$user_id','$date_time','$total_sum_u','2')") 
    or die('query failed sql_sales_history');


    

   

    $sql_order_list = mysqli_query($connect, "UPDATE order_list SET  
                                                id_payment_status ='01'
                                                WHERE order_code = '$id_order_code' " );


    $sql = mysqli_query($connect, "UPDATE cart_item 
    SET table_id ='00' 
    WHERE table_id = '$table_id' ");

    $sql_rrr = mysqli_query($connect,"SELECT * FROM sales_history WHERE order_code='$id_order_code' ");
    $rowsql_rrr = mysqli_fetch_array($sql_rrr);

    $_SESSION["receipt"] = $rowsql_rrr['receipt'];

        
    include_once('function.php');
    $fetchdata = new DB_con();
    $sqlrrrr = $fetchdata->fetchdata();
    $row = mysqli_fetch_array($sqlrrrr);

    if($table_id==$row['table_id']);
    {
        $sqlstatus_00 =$insertdata->status_00($table_id);

           
        $sql_idorderlist = mysqli_query($connect,"SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id' ");
        $rowsql_idorderlist = mysqli_fetch_array($sql_idorderlist);
        $id_order_code = $rowsql_idorderlist['order_code'];


        $sql_order_list = mysqli_query($connect, "UPDATE order_list SET  
                                                    	id_payment_status ='01' 
                                                    WHERE order_code = '$id_order_code' " );


        
        if($sqlstatus_00){
            //echo "<script>alert('จ่ายด้วย QR code!!');</script>";
            //echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
           // echo "<script>window.location.href='00tablenumber.php'</script>";  
           //echo "<script>window.location.href='00order.php'</script>";

           echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
           echo    "<script>"; 
           echo        "Swal.fire({
                       position: 'center',
                       icon: 'success',
                       title: 'ชำระเงินเรียบร้อยแล้ว',
                       showConfirmButton: true,
                       }).then((result)=> {
                           if(result){
                               window.location.href='00tablenumber.php';
                           }
                       })"; 
           echo    "</script>";
           
        }else {
            echo "<script>alert('เกิดข้อผิดพลาด');</script>";      
            echo "<script>window.location.href='00order_list.php'</script>";
        }

   
    }
}









?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสั่งอาหาร</title>
    <link rel="stylesheet"href="wcss/order_list.css">
    <link rel="stylesheet"href="wcss/navber.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
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

        <button class="myBtn2"id="myBtn2" onclick="myFunctionmyBtn()">
                    <p class="co"><?php echo $rowuser_type['user_type']?></p>
                    <div class="profile-photo"  >
                    <i class='bx bxs-face'></i>
                    <!-- <img src="https://i.pinimg.com/736x/36/7c/39/367c393354fecb4918b2bee5795ae290.jpg" > -->
                    </div>  
        </button>


        <div  id="id01" class="modalid01">
            <div class="modal__content">
                <div class="modal-header">
                    <p><?php echo $rowuser_type['user_type']?></p>
                    <button class="dark" onclick="myFunction()"><span class="material-icons"><span class="material-icons">settings_brightness</span></button>
                </div>
                <div class="modal-body">
                        <a class="a"  type="submit" href="00order_list.php?exit"  >
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
                
                               
                        </div>     
                   </div>




            <div class="box">
                <div class="boxuser">    
                    <div class="head">
                        <div class="name">ร้านก๊วยจั๊บกำลังภายใน</div>

                        <?php 
                            $sql_idorderlist = mysqli_query($connect,"SELECT * FROM order_list WHERE order_code='$table_order_code' ");
                            $rowsql_idorderlist = mysqli_fetch_array($sql_idorderlist);
                            $id_order_code = $rowsql_idorderlist['order_code'];

                            $id_number = sprintf("%05d",$id_order_code); // เลข 5 คือจำนวนตัวเลข จะให้มีกี่ตัวเช่น 00001, 00024, 00259

                        ?>

                        <div class="bil_number"># รายการสั่งอาหาร <?php echo  $id_number ?></div>
                        <?php 
                             $query = mysqli_query($connect," SELECT table_id, number FROM table_number WHERE table_id = '$table_id' ");
                             $row = mysqli_fetch_assoc($query); 
                        ?>
                        <div class="bil_number">รายการอาหาร   |   โต๊ะ : <?php  echo $row["number"] ?>  |  วัน/เดือน/ปี : <?php echo $date_d_m_Y  ?></div>
                    </div>
                    <div class="head1">
                        <!--
                            <form class="TT" action="#" method="post"enctype="multipart/form-data">
                                    <input class="btn input" name="addmanu" type="submit" value="เพิ่มเมนูอาหาร">
                                    <input class="btn cancel" name="cancelcart" type="submit" value="ยกเลิกออเดอร์">
                            </form>
                        -->
                    </div>
                    <div class="head0">
                        <table id="myTable">
                            <tr>
                                <th style="width:3%">#</th>
                                <th style="text-align: start;" >ชื่อเมนูอาหาร</th>
                                <th style="width:10%">จำนวน</th>
                                <th style="width:10%">ราคา / รายการ</th>
                                <th style="width:10%">ราคา</th>
                                <th style="width:10% ; text-align: center;">#</th>
                            </tr>
                                <?php
/*
                                    $sql_price = "SELECT SUM(price) AS sumprice 
                                    FROM cart_item where table_id='$table_id'";

                                    $sumtoprice =  mysqli_query($connect,$sql_price);
                                    $rowprice =  mysqli_fetch_array($sumtoprice);
*/





                                    $query = mysqli_query($connect, "SELECT * FROM cart_item WHERE order_code='$table_order_code' ");
                                    $cart = mysqli_num_rows($query);

                                    

                                    $num = 0 ;
                                    $total_sum_u = 0 ;
                                    if ($cart > 0) {
                                        while ($row0 = mysqli_fetch_assoc($query)) {

                                            $code= $row0["code"];

                                            $fooditem = mysqli_query($connect, "SELECT * FROM food_item WHERE food_menu_code='$code' ");
                                            $rowfooditem = mysqli_fetch_assoc($fooditem);
                                            $name = $rowfooditem["food_menu_name"];
                                ?>
                                
                                <tr>
                                        <td style="text-align: center; font-weight: bold;"><?php echo $num = $num + 1 ?></td>
                                        <td ><?php echo $name; ?></td>
                                    <form action="00order_list.php?id_cart_item=<?php echo $row0['id_cart_item']; ?>" method="post"enctype="multipart/form-data">

                                        <td style="text-align: center;">
                                            <div class="quantity">
                                                <!-- <span class="minus" ><i class='bx bx-minus' ></i></span>-->
                                                <!-- <span class="number"></span> -->
                                                <input class="number" type="number" id="quantity" name="txtquantity_new" min="1" max="50" value="<?php echo $row0["quantity"] ;?>" >
                                                <!-- <input  class="number" type="text" id="fname" name="txtquantity_new" value="<?php //echo $row0["quantity"] ;?>" > -->
                                                <!-- <span class="plus" ><i class='bx bx-plus'></i></span> -->
                                            </div>

                                            <script>
                                                /*  const plus = document.querySelector('.plus'),
                                                minus = document.querySelector('.minus'),
                                                number = document.querySelector('.number');

                                                let a = 1;

                                                plus.addEventListener('click',()=>{
                                                    a++;
                                                    //a = (a<10) ? '0' + a :a;  
                                                   // console.log(a);
                                                    number.innerText = a;
                                                });
                                                minus.addEventListener('click',()=>{
                                                    if(a > 1){
                                                        a--;
                                                        number.innerText = a;
                                                    }
                                                });
                                                    */
                                            </script>
                                            <!-- <input type="text" id="fname" name="txtquantity_new" value="<?php //echo $row0["quantity"] ;?>" > -->
                                        </td>   <?php   $total = $row0["quantity"]*$row0["price"]; ?>  
                                                <?php /*echo $row0["quantity"] ?></td>    <?php   $total = $row0["quantity"]*$row0["price"]; */?>
                                        
                                        <td style="text-align: end;" ><?php echo number_format($row0["price"],2); ?></td>
                                        <td style="text-align: end;" ><?php echo number_format($total,2); ?></td>
                                        <td style="text-align: center;">
                                        <!--
                                            <a   name="del" type="submit" href="00order_list.php?id_cart_item=<?php //echo $row0['id_cart_item']; ?>" ><i class='bx bxs-trash-alt'></i></a>
                                            <a  name="quantity_new" type="submit" href="00order_list.php?id_cart_item=<?php //echo $row0['id_cart_item']; ?>" ><i class='bx bx-check'></i></a>
                                        -->
                                        
                                            <input class="btnL add" name="quantity_new" type="submit" value="บันทึกจำนวน">
                                            <input class="btnL del" name="del_list" type="submit" value="ลบ">
                                                
                                        </td>

                                    </form>
                                </tr>
                                
                                <?php }   } else  { ?>
                                    <td colspan="8" ><p>ไม่มีข้อมูลอาหารที่เพิ่มมา</p></td>
                                <?php   }   ?>
                                
                                <?php
                                
                                $total_sum_u = mysqli_query ($connect, "SELECT quantity, price, SUM(quantity*price) as total_sum_u FROM cart_item WHERE order_code='$table_order_code' ");
                                $row = mysqli_fetch_array($total_sum_u);

                                ?>

                                <tr style="background-color: #74b9ff  ;">
                                    <td colspan="4" style="text-align: center;font-weight: bold;" >ราคารวมทั้งหมด</td>                
                                    <td style="text-align: end; font-weight: bold;"><?php echo  number_format($row ["total_sum_u"] ,2);  ?></td>
                                    <td style="text-align: center; font-weight: bold;">บาท</td>
                                </tr>
                        </table>                           
                    </div>
                    <div class="head1" >
                        <form class="TTT" action=# method="post"enctype="multipart/form-data">
                            <div class="T1">
                                <input class="btn input" name="addmanu" type="submit" value="เพิ่มเมนูอาหาร">
                                <input class="btn cancel" name="cancelcart" type="submit" value="ยกเลิกออเดอร์">
                            </div>
                            <div class="T2">
                                <a  class="check_bill" href="#demo-modal">เช็คบิล</a>
                                <!-- <input class="btn check_bill" name="" type="submit" value="เช็คบิล"> -->
                            </div>
                        </form>
                    </div>
                     
                </div>
            </div>

            

         
            <div id="demo-modal" class="modal">
                <div class="modal_content">
                    <div class="tab">
                        <button class="tablinks" onclick="pay(event, 'bank')" id="defaultOpen" > <i class='bx bx-money'></i><p>เงินสด</p></button>
                        <button class="tablinks" onclick="pay(event, 'QRcode')"><i class='bx bx-scan'></i><p>QR code</p></button>
                    </div>

                    <div class="pay">
                        <p><?php echo  number_format($row ["total_sum_u"] ,2);  ?></p>
                    </div>
                    
                        <div id="bank" class="tabcontent">
                            <div class="bobox">
                                    <!-- <h3>รับเงินจากลูกค้า</h3> -->
                                    <!-- <p>London is the capital city of England.</p> -->
                                    <form  action="#" method="post"enctype="multipart/form-data">
                                        <input name="bank_input" type="text" placeholder="กรอกจำนวนเงิน" >
                                        <input class="btn input" name="check_bill-bank" type="submit" value="ชำระเงิน">
                                    </form>
                            </div>
                        </div>

                        <div id="QRcode" class="tabcontent">
                            <div class="bo">
                                <div class="img">
                                    <img src="imgweb/315517350_1111287729527664_2864855480835247150_n.jpg" alt="">
                                </div>
                                <form  action="#" method="post"enctype="multipart/form-data">
                                    <input class="btn input" name="check_bill-qr" type="submit"  value="ชำระเงิน">
                                </form>
                            </div>
                          
                        </div>


                    <a href="#" class="modal_close">&times;</a>
                </div>
            </div>

        
                         
                            
                <script >
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

                
                        function pay(evt, pay) {
                        var i, tabcontent, tablinks;
                        tabcontent = document.getElementsByClassName("tabcontent");
                        for (i = 0; i < tabcontent.length; i++) {
                            tabcontent[i].style.display = "none";
                        }
                        tablinks = document.getElementsByClassName("tablinks");
                        for (i = 0; i < tablinks.length; i++) {
                            tablinks[i].className = tablinks[i].className.replace(" active", "");
                        }
                        document.getElementById(pay).style.display = "block";
                        evt.currentTarget.className += " active";
                        }
                        // Get the element with id="defaultOpen" and click on it
                        document.getElementById("defaultOpen").click();  
                        
                        

                       

                </script>
    </body>
</html>