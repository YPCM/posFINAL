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


/*
echo "<pre>";
print_r($_SESSION["cart_item"]);
echo "</pre>";
*/
require_once("function.php");
$db_handle = new DBController();

$insertdata = new DB_con();



//print_r($_SESSION["table_orderlist"]);
/*
echo "<pre>" ;
print_r($_SESSION["cart_item"]);
echo "</pre>" ;
*/
if(!empty($_GET["action"])) {
    switch($_GET["action"]) {


        case "add":
            if(!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM food_item WHERE food_menu_code='" . $_GET["code"] . "'");
              // $productByCode_topping = $db_handle->runQuery("SELECT * FROM food_toppings WHERE food_toppings_code ='" . $_GET["food_toppings_code"] . "'");

                $itemArray = array($productByCode[0]["food_menu_code"]=>array('name'=>$productByCode[0]["food_menu_name"], 
                                                                    'code'=>$productByCode[0]["food_menu_code"], 
                                                                    'quantity'=>$_POST["quantity"],
                                                                    'price'=>$productByCode[0]["selling_price_food"], 
                                                                    'price_1'=>$productByCode[0]["selling_price_food"], 
                                                                    'image'=>$productByCode[0]["img"]));
                                       
                                                                    
                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode[0]["food_menu_code"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                                if($productByCode[0]["food_menu_code"] == $k) {
                                    if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                        $_SESSION["cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }

            
        break;

/*
        case "add_topping":
            if(!empty($_POST["quantity-topping"])) {
                $productByCode_topping = $db_handle->runQuery("SELECT * FROM food_item WHERE food_menu_code ='" . $_GET["code"] . "'");

                $itemArray = array($productByCode_topping[0]["food_menu_name"]=>array('name'=>$productByCode_topping[0]["food_menu_name"], 
                                                                                        'code'=>$productByCode_topping[0]["food_menu_code"], 
                                                                                        'quantity'=>$_POST["quantity-topping"],
                                                                                        'price'=>$productByCode_topping[0]["selling_price_food"], 
                                                                                        'price_1'=>$productByCode_topping[0]["selling_price_food"], 
                                                                                        'image'=>$productByCode_topping[0]["img"]));
                                                        
                                                                    
                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode_topping[0]["food_menu_code"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                                if($productByCode_topping[0]["food_menu_code"] == $k) {
                                    if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                        $_SESSION["cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            
        break;
*/


        case "remove":
            if(!empty($_SESSION["cart_item"])) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_GET["code"] == $k)
                            unset($_SESSION["cart_item"][$k]);				
                        if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                }
            }
        break;

/*
        case "remove_topping":
            if(!empty($_SESSION["cart_item"])) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_GET["code"] == $k)
                            unset($_SESSION["cart_item"][$k]);				
                        if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                }
            }

        break;
*/
        case "empty":
            unset($_SESSION["cart_item"]);
            /*unset($_SESSION["cart_item_topping"]);*/
        break;
        

        case "cancelorder":
            unset($_SESSION["cart_item"]);
            
                    $table_id = $_SESSION["table"] ;
                    $table_id  = mysqli_real_escape_string($connect,$table_id);


                    //up โต๊ะ
                    $sql = $insertdata->status_00($table_id);
                    unset($_SESSION["table"]);
                    header("location:mobile_table.php");
             




        case "order":
            
            //mysqli_quli($con,"BEGIN");
            //$sql_order = "INSERT INTO order_list values(null,'$date_time','$table_id','02')";
           
          /*  echo "<br>".$order_code ;*/

            
           /*
            $sales_history = mysqli_query($connect,"INSERT INTO sales_history(order_code,user_id) 
            VALUES('$order_code','$user_id')") 
            or die('query failed sales_history');
            
*/
            
            $user_id = $_SESSION['user_id'];
            $table_id = $_SESSION['table'] ;

        //    print_r($_SESSION['table']);

            /* print_r($_SESSION["table"]);
                echo $user_id ; */


                
          

            $sql_order = mysqli_query($connect, "INSERT INTO order_list(date_time,user_id,table_id,id_payment_status) 
            VALUES('$date_time','$user_id','$table_id','02')") 
            or die('query failed sql_order ');




            $sql_order_new = mysqli_query($connect,"SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id' ");
            $rowsql_order_new = mysqli_fetch_array($sql_order_new);
            $order_code = $rowsql_order_new['order_code'];




     
            if(isset($_SESSION['cart_item'])){
                foreach($_SESSION['cart_item'] as $key => $value){

                    $name = $value['name'];
                    $code = $value['code'];
                    $quantity = $value['quantity'];
                    $price = $value['price'];

                    $user_id = $_SESSION['user_id'];

                    $order_code = mysqli_query($connect, "SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id'");
                    $roworder_code = mysqli_fetch_array($order_code);
                    
                    $_SESSION["table_order_code"] = $roworder_code['order_code'];
                    $order_code00= $_SESSION["table_order_code"];

                    $sqlrerer = mysqli_query($connect, "INSERT INTO cart_item(code,quantity,price,order_code) 
                    VALUES('$code','$quantity','$price','$order_code00')") 
                    or die('query failed sql');



                    $order_code = mysqli_query($connect, "SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id'");
                    $roworder_code = mysqli_fetch_array($order_code);
                    
                    $_SESSION["table_order_code"] = $roworder_code['order_code'];


                    $sql = $insertdata->status_01($table_id);

                    
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



                   // $sql = $insertdata->insert_cart($name,$code,$quantity,$price,$table_id,$order_code,$date_d_m_Y);

                }   
            }
            if($sql){
                echo "<script>alert('เพิ่มข้อมูลเมนูอาหารเรียบร้อยแล้ว!!');</script>";
                unset($_SESSION["cart_item"]);

                echo "<script>window.location.href='mobile_list.php'</script>";
            }else {
                echo "<script>alert('เกิดข้อผิดพลาด');</script>";
                echo "<script>window.location.href='mobile_food.php'</script>";
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
        <p>สั่งเมนูอาหาร</p>
    </div>
    <div class="boxcontent" >
    
        <!-- Tab links -->
        <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'A1')" id="defaultOpen" ><div class="iconmenufood"><i class='bx bxs-dish'></i></div>เมนูอาหาร</button>
            <button class="tablinks" onclick="openCity(event, 'A2')"><div class="iconmenufood"><i class='bx bx-cookie'></i></div>อาหารทานเล่น</button>
            <button class="tablinks" onclick="openCity(event, 'A3')"><div class="iconmenufood"><i class='bx bxs-wine'></i></div>เครื่องดื่ม</button>
            <button class="tablinks" onclick="openCity(event, 'A4')" ><div class="iconmenufood"><i class='bx bx-badge'></i></div>ท็อปป้ง</button>
        </div>
        
        <!-- Tab content -->
        <div id="A1" class="tabcontent">
            <div class="product">
                    <?php
                        $product_array = $db_handle->runQuery("SELECT * FROM food_item WHERE category_food ='0001' AND `status` = 1 ");
                                    
                        if (!empty($product_array)) { 
                            foreach($product_array as $key=>$value){
                    ?>
                <form method="post" action="mobile_food.php?action=add&code=<?php echo $product_array[$key]["food_menu_code"]; ?>">  
                    <div class="AAA0">
                       <div class="p">
                            <img src="imgfood/<?php echo $product_array[$key]["img"];?>" alt="">
                            <input type="submit" value="Add to Cart" class="live" >
                       </div> 
                        <div class="det">
                            <div class="menufood"><?php echo $product_array[$key]["food_menu_name"];?></div>
                            <div class="menu฿"><?php echo $product_array[$key]["selling_price_food"];?> บาท</div>
                            <input type="hidden" class="product-quantity" name="quantity" value="1" size="2" >
                        </div>
                       
                    </div>
                        
                </form>
               
                <?php } }else{ ?>     
                  </div>                    
           
                <p style="text-align: center; width:150vh;" >ไม่มีข้อมูล "เมนูอาหาร"<p>
                <?php }?>
                
            </div> 
          
        </div>
        
        <div id="A2" class="tabcontent">
        <div class="product">
                    <?php
                        $product_array = $db_handle->runQuery("SELECT * FROM food_item WHERE category_food ='0002' AND `status` = 1 ");
                                    
                        if (!empty($product_array)) { 
                            foreach($product_array as $key=>$value){
                    ?>
                <form method="post" action="mobile_food.php?action=add&code=<?php echo $product_array[$key]["food_menu_code"]; ?>">  
                    <div class="AAA0">
                       <div class="p">
                            <img src="imgfood/<?php echo $product_array[$key]["img"];?>" alt="">
                            <input type="submit" value="Add to Cart" class="live" >
                       </div> 
                        <div class="det">
                            <div class="menufood"><?php echo $product_array[$key]["food_menu_name"];?></div>
                            <div class="menu฿"><?php echo $product_array[$key]["selling_price_food"];?> บาท</div>
                            <input type="hidden" class="product-quantity" name="quantity" value="1" size="2" >
                        </div>
                       
                    </div>
                        
                </form>
               
                <?php } }else{ ?>     
                  </div>                    
           
                <p style="text-align: center; width:150vh;" >ไม่มีข้อมูล "เมนูอาหาร"<p>
                <?php }?>
                
            </div> 
        </div>
        
        <div id="A3" class="tabcontent">
        <div class="product">
                    <?php
                        $product_array = $db_handle->runQuery("SELECT * FROM food_item WHERE category_food ='0003' AND `status` = 1 ");
                                    
                        if (!empty($product_array)) { 
                            foreach($product_array as $key=>$value){
                    ?>
                <form method="post" action="mobile_food.php?action=add&code=<?php echo $product_array[$key]["food_menu_code"]; ?>">  
                    <div class="AAA0">
                       <div class="p">
                            <img src="imgfood/<?php echo $product_array[$key]["img"];?>" alt="">
                            <input type="submit" value="Add to Cart" class="live" >
                       </div> 
                        <div class="det">
                            <div class="menufood"><?php echo $product_array[$key]["food_menu_name"];?></div>
                            <div class="menu฿"><?php echo $product_array[$key]["selling_price_food"];?> บาท</div>
                            <input type="hidden" class="product-quantity" name="quantity" value="1" size="2" >
                        </div>
                       
                    </div>
                        
                </form>
               
                <?php } }else{ ?>     
                  </div>                    
           
                <p style="text-align: center; width:150vh;" >ไม่มีข้อมูล "เมนูอาหาร"<p>
                <?php }?>
                
            </div> 
        </div>

        <div id="A4" class="tabcontent">
        <div class="product">
                    <?php
                        $product_array = $db_handle->runQuery("SELECT * FROM food_item WHERE category_food ='0004' AND `status` = 1 ");
                                    
                        if (!empty($product_array)) { 
                            foreach($product_array as $key=>$value){
                    ?>
                <form method="post" action="mobile_food.php?action=add&code=<?php echo $product_array[$key]["food_menu_code"]; ?>">  
                    <div class="AAA0">
                       <div class="p">
                            <img src="imgfood/<?php echo $product_array[$key]["img"];?>" alt="">
                            <input type="submit" value="Add to Cart" class="live" >
                       </div> 
                        <div class="det">
                            <div class="menufood"><?php echo $product_array[$key]["food_menu_name"];?></div>
                            <div class="menu฿"><?php echo $product_array[$key]["selling_price_food"];?> บาท</div>
                            <input type="hidden" class="product-quantity" name="quantity" value="1" size="2" >
                        </div>
                       
                    </div>
                        
                </form>
               
                <?php } }else{ ?>     
                  </div>                    
           
                <p style="text-align: center; width:150vh;" >ไม่มีข้อมูล "เมนูอาหาร"<p>
                <?php }?>
                
            </div> 
    </div>

  
  
   
    
    <button class="accordion" onclick="accordion()">รายการสั่งซื้อ</button>
    <div class="panel" >
      
        <?php 
                                     

        if(isset($_SESSION["cart_item"])){
        $total_quantity = 0;
        $total_price = 0;
                                 
        foreach ($_SESSION["cart_item"] as $item){
         $item_price = $item["quantity"]*$item["price"];
        ?>	
        <div class="listfooditem"> 
            <div class="fooditem_nameA"><?php echo $item["name"]."&nbsp";?></div>
            <div class="fooditem_nameB">X<?php echo $item["quantity"];?></div>
            <div class="fooditem_nameD"><?php echo "฿". number_format($item_price,2);?></div>
            <a class="fooditem_nameC" href="mobile_food.php?action=remove&code=<?php echo $item["code"]; ?>">ลบ</a>
        </div>
        <?php
            $total_quantity += $item["quantity"];
            $total_price += ($item["price"]*$item["quantity"]);
        } 
    ?> 
  <div class="fooditem_name_total">จำนวน <?php echo $total_quantity ."&nbsp";?> รายการ</div>
    </div>

    <?php 
        }  else{ 
    ?>
        <div class="fooditem_name_total">จำนวน - รายการ</div>
    </div>


    <?php }  ?>

    <div class="footer1">
        <div class="btnfooter">
            <a class="btn_00" href="mobile_food.php?action=order">จัดออเดอร์</a>
        </div>
    </div>
    <div class="footer2">
        <div class="btnfooter">
            <a class="btn_00" href="mobile_food.php?action=cancelorder" >ยกเลิกเมนูอาหาร</a>
        </div>
    </div>
  <!--  <div class="footer3">
        <div class="btnfooter">
            <a class="btn_00">เคลียร์เมนูอาหาร</a>
        </div>
    </div>
-->
</div>

  



<script>
// Script to open and close sidebar

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
            document.getElementById("defaultOpen").style.display = "block";



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


var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
      
    }else {
      panel.style.display = "block";
    } 
    
  });
}







</script>

</body>
</html>
