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
<style type="text/css"> 

#printable { display: block; }

@media print 
{ 
     #non-printable { display: none; } 
     #printable { display: block; } 
} 
</style>

<ul class="breadcrumb" id="non-printable">
        <li><a href="00report.php">รายงาน</a></li>
        <li>พิมพ์ประวัติการขาย</li>
</ul>  

<div class="boxx-print">   
    <div class="boxS-print" >
               <?php
                  $receipt = $_SESSION['receipt'];  
                  $sql_sales_history0 = mysqli_query($connect, "SELECT * FROM `sales_history` WHERE `receipt`='$receipt'");
                  $row0 = mysqli_fetch_assoc($sql_sales_history0);
              
                  $order_code = $row0['order_code'];
                  
              
              
              
                  $user_id_sales_history = $row0['user_id'];
                  $user = mysqli_query($connect, "SELECT * FROM `user` WHERE `user_id`= $user_id_sales_history");
                  $rowuser = mysqli_fetch_assoc($user);
              
              
                  if($row0["id_pay_through"]==1){
                      $eee = "<div style='display: flex; align-items: center;' > <i style=' font-size: 20px; padding-right: 10px;' class='bx bx-money'></i> <p>เงินสด</p> </div>";
                  }elseif($row0["id_pay_through"]==2){
                      $eee = "<div style=' display: flex; align-items: center;'  ><i style=' font-size: 20px; padding-right: 10px;' class='bx bx-scan'></i> <p>QR code</p> </div>";
                  }
        
                  
               ?>
                <div class="receipt_2-print">
                    <div class="receiptno"> <p>เลขที่ใบเสร็จ : </p> <p style="padding-left: 10px;   font-weight: bold; "><?php echo "#".$receipt ; ?></p> </div>
                    <div class="receiptno"> <p>วันที่/เวลา : </p> <p style="padding-left: 10px; "><?php echo $row0["date_time"]; ?></p> </div>
                    <div class="receiphj">
                        <div class="receiptno"> <p>ผู้ใช้ที่ล็อกอินขาย : </p><p style="padding-left: 10px; "><?php echo $rowuser['user_name']; ?></p> </div>
                        <div class="receiptno"> <p style="padding-left: 10px; padding-right: 10px;"> | </p> </div>
                        <div class="receiptno"> <p>ประเภทชำระ : </p><p style="padding-left: 10px; "><?php echo $eee; ?></p> </div>
                    </div>
                    <div class="receiptlist">
                        <div class="totalscroll">
                                <table class="re-print">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%; text-align: center; border: 0.1px solid #dddddd00;">#</th>
                                            <th style="width: 90%;border: 0.1px solid #dddddd00; ">ชื่อเมนูอาหาร</th>
                                            <th style="text-align: center; border: 0.1px solid #dddddd00;">จำนวน</th>
                                            <th style="text-align: end;border: 0.1px solid #dddddd00;">ราคา</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                          $query = mysqli_query($connect, "SELECT * FROM `cart_item` WHERE `order_code`='$order_code'"); 
                                          $totalc = mysqli_num_rows($query);
                                          $num = 0;
                                          $sum = 0; 
                                              if ($totalc > 0) { 
                                                  while ($row10 = mysqli_fetch_assoc($query)) {  
                                                        $num = $num + 1;
                                                       // $name = $row10['name'];
                                                          $quantity = $row10['quantity'];
                                                          $price = $row10['price'];
                                                          $code = $row10['code'];

                                                          $fooditem = mysqli_query($connect, "SELECT * FROM food_item WHERE food_menu_code='$code' ");
                                                          $rowfooditem = mysqli_fetch_assoc($fooditem);
                                                          $name = $rowfooditem["food_menu_name"];
                                                          
          
                                                          $priceXquantity =  $price * $quantity ;
          
                                                          $sum = $sum + $priceXquantity ;
                                        ?>
                                        <tr>
                                            <td style="text-align: center;border: 0.1px solid #dddddd00;"><?php echo $num?></td>
                                            <td style="border: 0.1px solid #dddddd00;"><?php echo $name ;?></td>
                                            <td style="text-align: center;border: 0.1px solid #dddddd00;"><?php echo $quantity ;?></td>
                                            <td style="text-align: end;border: 0.1px solid #dddddd00;"><?php echo number_format($priceXquantity,2) ;?></td>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td colspan="3" style="border: 0.1px solid #dddddd00;">ราคารวม</td>
                                            <td style="text-align: end;border: 0.1px solid #dddddd00;"><?php echo number_format($sum,2)?></td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                 
                </div>
    </div>
</div>


 
    

    <script src="script.js"></script>

    <script type="text/javascript" >window.print(); </script>

    

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>     

</body>
</html>