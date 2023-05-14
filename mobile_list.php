<?php
include 'connect.php'; 
session_start();

include_once('function.php');
$db_handle = new DBController();
$insertdata = new DB_con();



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


//    print_r($_SESSION["table"]) ;

$table_id = $_SESSION["table"];

$_SESSION["table_orderlist"] = $table_id ;

$table_order_code = $_SESSION["table_order_code"];



/*echo $table_order_code ;*/
/*
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
    echo "<script>window.location.href='mobile_food_add.php'</script>";

}




/*
print_r($_SESSION['table_orderlist']);


if (isset($_POST['addmanu'])) {
    $addmenu_orderlist = mysqli_query ($connect, "SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id'");
    $rowaddmenu_orderlist = mysqli_fetch_array($addmenu_orderlist);
    $_SESSION["order_code"] = $rowaddmenu_orderlist['order_code'];

    $_SESSION["table_orderlist"] = $table_id ;
    echo "<script>window.location.href='01order_list_user.php'</script>";

}
*/

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
            echo "<script>window.location.href='mobile_table.php'</script>";
    
           //echo "<script>window.location.href='00order.php'</script>";
        }else {
            echo "<script>alert('เกิดข้อผิดพลาด');</script>";      
            echo "<script>window.location.href='mobile_list.php'</script>";
        }
    }
}

/*
if(isset($_POST['cancelcart'])){

    $table_id = $_SESSION["table"] ;
    
    $sql_sales_history_new = mysqli_query($connect,"SELECT MAX(receipt) as receipt FROM sales_history WHERE table_id='$table_id' ");
    $rowsql_sales_history_new = mysqli_fetch_array($sql_sales_history_new);
    $receipt = $rowsql_sales_history_new['receipt'];



    
    $sql = mysqli_query($connect, "UPDATE cart_item 
                                    SET table_id ='00' 
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
            echo "<script>window.location.href='01tablenumber_user.php'</script>";
    
           //echo "<script>window.location.href='00order.php'</script>";
        }else {
            echo "<script>alert('เกิดข้อผิดพลาด');</script>";      
            echo "<script>window.location.href='01order_list_user.php'</script>";
        }
    }
}
*/
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
                            window.location.href='mobile_list.php';
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
                            window.location.href='mobile_table.php';
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
                               window.location.href='mobile_table.php';
                           }
                       })"; 
           echo    "</script>";
           
        }else {
            echo "<script>alert('เกิดข้อผิดพลาด');</script>";      
            echo "<script>window.location.href='mobile_list.php'</script>";
        }

   
    }
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
<link rel="stylesheet" href="wcss/00mobile.css">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
      
    <?php 
        $sql_idorderlist = mysqli_query($connect,"SELECT * FROM order_list WHERE order_code='$table_order_code' ");
        $rowsql_idorderlist = mysqli_fetch_array($sql_idorderlist);
        $id_order_code = $rowsql_idorderlist['order_code'];

        $id_number = sprintf("%05d",$id_order_code); // เลข 5 คือจำนวนตัวเลข จะให้มีกี่ตัวเช่น 00001, 00024, 00259

        $query = mysqli_query($connect," SELECT table_id, number FROM table_number WHERE table_id = '$table_id' ");
        $row = mysqli_fetch_assoc($query); 
    ?>
    <div class="boxlistA">
        <p>ร้านก๊วยจั๊บกำลังภายใน</p>
        <p># รายการสั่งอาหาร <?php echo  $id_number ?></p>
        
        <p>รายการอาหาร | โต๊ะ :  <?php  echo $row["number"] ?>  | วัน/เดือน/ปี : <?php echo $date_d_m_Y ; ?></p>
    </div>
   <div class="boxee">

   <?php
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

           $total = $row0["quantity"]*$row0["price"]; 
     ?>

                   
        <div class="boxA">
            <div class="boxlistA ">
                <div class="listitem">
                    <div class="listitemE"><?php echo $num = $num + 1 ?></div>
                    <div class="listitemA"><?php echo $name; ?></div>
                    <div class="listitemC"><?php echo number_format($total,2); ?>   บาท</div>
                </div>
        
            </div>
            <div class="boxlistB ">
                <div class="listitem">
                <form action="mobile_list.php?id_cart_item=<?php echo $row0['id_cart_item']; ?>" method="post"enctype="multipart/form-data">
                    <div class="listitemB"> 
    
                          <!--  <div class="container">
                                <button onclick="decrement()" class="minus" id="minus" >-</button>
                                <input id=demoInput type=number value="<?php //echo $row0["quantity"] ;?>"min=1 max=50>
                                <button onclick="increment()" class="plus" id="plus">+</button>
                            </div>
                        -->
                      
                    </div>
                    <div class="listitemD">
                    <div class="container_pp">
                            <p>X</p>
                              
                                    <input class="number" type="number" id="quantity" name="txtquantity_new" min="1" max="50" value="<?php echo $row0["quantity"] ;?>" >
                                    <input style="color: #fff; text-decoration: none; border: none; height: 30px;padding: 0px 10px;background-color: #0984e3;  margin-left: 5px;"class="btnL add" name="quantity_new" type="submit" value="บันทึกจำนวน">
                                    <input style="color: #fff; text-decoration: none; border: none; height: 30px;padding: 0px 10px;background-color: #de3902; margin-left: 70px;" class="btnL del" name="del_list" type="submit" value="ลบ">
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <?php }   } else  { ?>
                                    <td colspan="8" ><p>ไม่มีข้อมูลอาหารที่เพิ่มมา</p></td>
        <?php   }   ?>




   

   </div>
    
</div>


 
        <?php
                                
            $total_sum_u = mysqli_query ($connect, "SELECT quantity, price, SUM(quantity*price) as total_sum_u FROM cart_item WHERE order_code='$table_order_code' ");
            $row = mysqli_fetch_array($total_sum_u);

        ?>
    <div class="footer7 " >
        <div class="totalsumEE">
            <div class="totalsumAA">ราคารวมทั้งหมด</div>
            <div class="totalsumBB"><?php echo  number_format($row ["total_sum_u"] ,2);  ?> บาท</div>
        </div> 	
    </div>

    <button class="accordion1" >
        <div class="btnfooter">
            <a href="#" class="btn_00"><i class='bx bx-chevron-up'></i></a>
        </div>
    </button>

        <div class="panel_E" style="display: none;overflow: hidden;height: 60px;">
            <div class="y"  style="display: flex;width: 100%; justify-content: space-between;">
                <div class="footer4" style="width: 49.9%;">
                    <div class="btnfooter" style="border: none;font-size: 16px;display: flex;align-items: center;justify-content: center;background-color: #f1f2f1;color: #0984e3;margin-bottom: 5px;text-decoration: none;">
                        <form action=# method="post"enctype="multipart/form-data">
                            <input style="border: none;height: 50px;font-size: 16px;display: flex;align-items: center;justify-content: center;background-color: #f1f2f1;color: #0984e3;margin-bottom: 5px;text-decoration: none;"class="btn_00" name="addmanu" type="submit" value="เพิ่มเมนูอาหาร"> 
                        </form>        
                    </div>
                </div>
                <div class="footer5" style="width: 49.9%;">
                    <div class="btnfooter" style="border: none;font-size: 16px;display: flex;align-items: center;justify-content: center;background-color: #f1f2f1;color: #0984e3;margin-bottom: 5px;text-decoration: none;">
                        <form action=# method="post"enctype="multipart/form-data">
                            <input style="border: none;height: 50px;font-size: 16px;display: flex;align-items: center;justify-content: center;background-color: #f1f2f1;color: #de3902;margin-bottom: 5px;text-decoration: none;" class="btn_00" name="cancelcart" type="submit" value="ยกเลิกออเดอร์">
                        </form>   
                    </div>
                </div>
            </div>
        </div>


    <div class="footer6">
        <div class="btnfooter">
            <a href="#demo-modal" class="btn_00">เช็คบิล</a>
        </div>
    </div>



    <div id="demo-modal" class="modal">
                <div class="modal_content">
                    <div class="tabmodal">
                        <button class="tablinks" onclick="pay(event, 'bank')" id="defaultOpen" > <i class='bx bx-money'></i><p>เงินสด</p></button>
                        <button class="tablinks" onclick="pay(event, 'QRcode')"><i class='bx bx-scan'></i><p>QR code</p></button>
                    </div>

                    <div class="pay">
                        <p><?php echo  number_format($row ["total_sum_u"] ,2);  ?></p>
                    </div>
                    
                        <div id="bank" class="tabcontentmodal">
                            <div class="bobox">
                                    <!-- <h3>รับเงินจากลูกค้า</h3> -->
                                    <!-- <p>London is the capital city of England.</p> -->
                                    <form  action="#" method="post"enctype="multipart/form-data">
                                        <input name="bank_input" type="text" placeholder="กรอกจำนวนเงิน" >
                                        <input class="btn input" name="check_bill-bank" type="submit" value="ชำระเงิน">
                                    </form>
                            </div>
                        </div>

                        <div id="QRcode" class="tabcontentmodal">
                            <div class="bo">
                                <div class="img">
                                    <img src="imgweb/345612960_2454331051388936_9040482964579297519_n.jpg" alt="">
                                </div>
                                <form  action="#" method="post"enctype="multipart/form-data">
                                    <input class="btn input" name="check_bill-qr" type="submit"  value="ชำระเงิน">
                                </form>
                            </div>
                          
                        </div>


                    <a href="#" class="modal_close">&times;</a>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
          

    <script>


        $(".delete-btn-list").click(function(e) {
            var cartId = $(this).data('id');
            e.preventDefault();
            deleteConfirm(cartId);
        })

        function deleteConfirm(cartId) {
            Swal.fire({
                icon: 'question',
                text: "คุณต้องการลบข้อมูลใช่หรือไม่",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ยกเลิก',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'mobile_list.php',
                                type: 'GET',
                                data: 'del_list=' + cartId,
                            })
                            .done(function() {
                                Swal.fire({
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'mobile_list.php';
                                })
                            })
                            .fail(function() {
                                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                                window.location.reload();
                            });
                    });
                },
            });
        }

        function pay(evt, pay) {
                        var i, tabcontent, tablinks;
                        tabcontent = document.getElementsByClassName("tabcontentmodal");
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
        

                var acc = document.getElementsByClassName("accordion1");
                var i;

                for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var panel_E = this.nextElementSibling;
                    if (panel_E.style.display === "block") {
                        panel_E.style.display = "none";
                    
                    }else {
                        panel_E.style.display = "block";
                    } 
                    
                });
                }

      
                function increment() {
                    document.getElementById('demoInput').stepUp();
                }
                function decrement() {
                    document.getElementById('demoInput').stepDown();
                }
/*
                    var x = 0 ;
                    document.getElementById("number").innerHTML = x;

                    document.getElementById("plus").addEventListener("click",()=>{
                        x=(x<10)?'0'+x:x;
                        document.getElementById("number").innerHTML = ++x;
                    })
              
                    document.getElementById("minus").addEventListener("click",()=>{
                        if(x>1){
                            x=(x<10)?'0'+x:x;
                            document.getElementById("number").innerHTML = --x;
                        }
                       
                    })



                const   plus = document.querySelector('.plus'),
                        minus = document.querySelector('.minus'),
                        number = document.querySelector('.number');

                let a = 1;
                plus.addEventListener('click',()=>{
                    a++;
                    a=(a<10)?'0'+a:a;
                    number.innerText=a;
                })
                minus.addEventListener('click',()=>{
                    if(a>1){
                        a--;
                        a=(a<10)?'0'+a:a;
                        number.innerText=a;
                    }
                   
                })
        */
        </script>
</body>
</html>