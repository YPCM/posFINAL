<?php
session_start();
include 'connect.php';
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
                    header("location:00tablenumber.php");
             




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

            print_r($_SESSION['table']);

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

                echo "<script>window.location.href='00order_list.php'</script>";
            }else {
                echo "<script>alert('เกิดข้อผิดพลาด');</script>";
                echo "<script>window.location.href='00home2.php'</script>";
            }
      

        }
    }

 
     

  
    
    
 
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สั่งรายการอาหาร</title>
    <link rel="stylesheet"href="wcss/HOME.css">
    <link rel="stylesheet"href="wcss/navber.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<?php 
/*
                    $cart_query = mysqli_query($connect, "SELECT name,quantity FROM cart_item WHERE table_id='$table_id'");                 
                    $num = mysqli_num_rows($cart_query);
                    $resultArray = array();                    
                    for ($i = 0;$i<$num;$i++) {                   
                    $result = mysqli_fetch_array($cart_query);                   
                    array_push($resultArray,$result);
                    }

                    echo "<pre>";
                    print_r($resultArray) ;
                    echo "/<pre>";
*/
?>

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
                        <a class="a"  type="submit" href="00home2.php?exit"  >
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
                                            <a href="#">
                                                <i class='bx bx-store' ></i>
                                                <span class="links_name">หน้าหลัก</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="menubox">
                                        <div class="b2"></div>
                                        <div class="a2">
                                            <a href="#">
                                                <i class='bx bx-food-menu' ></i>
                                                <span class="links_name">เมนูอาหาร</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="menubox">
                                        <div class="b3"></div>
                                        <div class="a3">
                                            <a href="#">
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
                                            <a href="#">
                                                <i class='bx bx-user'></i>
                                                <span class="links_name">ข้อมูลผู้ใช้ระบบ</span>
                                            </a>
                                        </div>
                                    </div>
                          
                                
                            <div>
                               
                        </div>     
                   </div>
    </div>
 
         

           <div class="content0">
                    <div class="zzz" id="myBtnContainer">    
                        <?php
                            $query = mysqli_query($connect, "SELECT * FROM food_item");
                            $totalcnt = mysqli_num_rows($query);
                            $row = mysqli_fetch_assoc($query)


                        ?>   

                        <div class="tab">
                            <button class="tablinks" onclick="openmenu(event, 'Menu')" id="defaultOpen"><i style="text-align: center; padding-right: 5px;" class='bx bxs-dish'></i>เมนูอาหาร</button>
                            <button class="tablinks" onclick="openmenu(event, 'D2')"><i style="text-align: center; padding-right: 5px;" class='bx bx-cookie'></i>อาหารทานเล่น</button>
                            <button class="tablinks" onclick="openmenu(event, 'D3')"><i style="text-align: center; padding-right: 5px;" class='bx bxs-wine'></i>เครื่องดื่ม</button>
                            <button class="tablinks" onclick="openmenu(event, 'Topping')"><i style="text-align: center; padding-right: 5px;" class='bx bx-badge'></i>ท็อปปิ้ง</button>
                        </div>

                    

                    </div>
                    <div class="A">
                            
                        <div id="Menu" class="tabcontent">
                            <div  class="product">

                                <?php
                                    $product_array = $db_handle->runQuery("SELECT * FROM food_item WHERE category_food ='0001' AND `status` = 1 ");
                                    
                                    if (!empty($product_array)) { 
                                        foreach($product_array as $key=>$value){
                                ?>
                        
                                    <form method="post" action="00home2.php?action=add&code=<?php echo $product_array[$key]["food_menu_code"]; ?>">  
                                        <div class="product_item" id="myBtn" type="submit" > 
                                            <div class="p">
                                                <img src="imgfood/<?php echo $product_array[$key]["img"];?>" alt="">
                                                
                                                <div class="views">
                                                    <p><?php echo $product_array[$key]["food_menu_name"];?></p>
                                                    <p class="price0"><?php echo $product_array[$key]["selling_price_food"];?></p>
                                                </div> 
                                                <input type="hidden" class="product-quantity" name="quantity" value="1" size="2" />
                                                <input type="submit" value="Add to Cart" class="live" />
                                        </div>                                
                                    </form>
                                </div>
                    

                                <?php } }else{ ?>     
                                        
                                        </div>
                                        <p style="text-align: center; width:150vh;" >ไม่มีข้อมูล "เมนูอาหาร"<p>
                                        <?php }?>              
                            </div>
                        </div>

                    </div>

                    <!---->

                    <div class="A">
                            
                        <div id="Topping" class="tabcontent">
                            <div  class="product">
                                <?php
                                    $product_array = $db_handle->runQuery("SELECT * FROM food_item WHERE category_food ='0004' AND `status` = 1 ");
                                    
                                    if (!empty($product_array)) { 
                                        foreach($product_array as $key=>$value){
                                ?>
                        
                                    <form method="post" action="00home2.php?action=add&code=<?php echo $product_array[$key]["food_menu_code"]; ?>">  
                                        <div class="product_item" id="myBtn" type="submit" > 
                                            <div class="p">
                                                <img src="imgfood/<?php echo $product_array[$key]["img"];?>" alt="">
                                                
                                                <div class="views">
                                                    <p><?php echo $product_array[$key]["food_menu_name"];?></p>
                                                    <p class="price0"><?php echo "฿".$product_array[$key]["selling_price_food"];?></p>
                                                </div> 
                                                <input type="hidden" class="product-quantity" name="quantity" value="1" size="2" />
                                                <input type="submit" value="Add to Cart" class="live" />
                                        </div>                                
                                    </form>
                                </div>
                                <?php } }else{ ?>     
                                        
                                        </div>
                                        <p style="text-align: center; width:150vh;" >ไม่มีข้อมูล "ท็อปปิ้ง"<p>
                                        <?php }?>              
                            </div>
                        </div>

                    </div>
                    <!---->
                    <div class="A">
                            
                            <div id="D2" class="tabcontent">
                                <div  class="product" >
    
                                    <?php
                                        $product_array = $db_handle->runQuery("SELECT * FROM food_item WHERE category_food ='0002' AND `status` = 1 ");
                                        
                                        if (!empty($product_array)) { 
                                            foreach($product_array as $key=>$value){
                                    ?>
                            
                                        <form method="post" action="00home2.php?action=add&code=<?php echo $product_array[$key]["food_menu_code"]; ?>">  
                                            <div class="product_item" id="myBtn" type="submit" > 
                                                <div class="p">
                                                    <img src="imgfood/<?php echo $product_array[$key]["img"];?>" alt="">
                                                    
                                                    <div class="views">
                                                        <p><?php echo $product_array[$key]["food_menu_name"];?></p>
                                                        <p class="price0"><?php echo "฿".$product_array[$key]["selling_price_food"];?></p>
                                                    </div> 
                                                    <input type="hidden" class="product-quantity" name="quantity" value="1" size="2" />
                                                    <input type="submit" value="Add to Cart" class="live" />
                                            </div>                                
                                        </form>
                                    </div>
                        
    
                                    <?php } }else{ ?>     
                                        
                                </div>
                                <p style="text-align: center; width:150vh;" >ไม่มีข้อมูล "เมนูอาหารทานเล่น"<p>
                                <?php }?>
                            </div>
                           
                            </div>
                        </div>
    
                        <!---->
                        <div class="A">
                            
                            <div id="D3" class="tabcontent">
                                <div  class="product" >
    
                                    <?php
                                        $product_array = $db_handle->runQuery("SELECT * FROM food_item WHERE category_food ='0003' AND `status` = 1 ");
                                        
                                        if (!empty($product_array)) { 
                                            foreach($product_array as $key=>$value){
                                    ?>
                            
                                        <form method="post" action="00home2.php?action=add&code=<?php echo $product_array[$key]["food_menu_code"]; ?>">  
                                            <div class="product_item" id="myBtn" type="submit" > 
                                                <div class="p">
                                                    <img src="imgfood/<?php echo $product_array[$key]["img"];?>" alt="">
                                                    
                                                    <div class="views">
                                                        <p><?php echo $product_array[$key]["food_menu_name"];?></p>
                                                        <p class="price0"><?php echo "฿".$product_array[$key]["selling_price_food"];?></p>
                                                    </div> 
                                                    <input type="hidden" class="product-quantity" name="quantity" value="1" size="2" />
                                                    <input type="submit" value="Add to Cart" class="live" />
                                            </div>                                
                                        </form>
                                    </div>
                        
    
                                    <?php } }else{ ?>     
                                        
                                </div>
                                <p style="text-align: center; width:150vh;" >ไม่มีข้อมูล "เครื่องดื่ม"<p>
                                <?php }?>
                            </div>
                           
    
                        </div>
    
                        <!---->
                        </div>     


                </div>  

            
                <div class="total-sum">            
                    <div class="total-sum-box">
                        <p>รายการสั่งซื้อ</p>
                        <i class='bx bxs-error-circle'></i>
                    </div>  

                    <div class="total-sum-list">
                                <div class="list">
                                    <div class="list-box" id="listbox">
                                        <!--
                                        <div class="btnEmpty Empty">
                                            <a class="btnEmpty Empty" id="btnEmpty" href="00home2.php?action=empty">Empty Cart</a>
                                        </div>
                                        <div class="btnEmpty cancelorder">
                                            <a  class="btnEmpty cancelorder" href="00home2.php?action=cancelorder">ยกเลิกออเดอร์</a>
                                        </div>
                                        -->
                                        <a class="btnEmpty Empty" id="btnEmpty" href="00home2.php?action=empty">Empty Cart</a>
                                        <a  class="btnEmpty cancelorder" href="00home2.php?action=cancelorder">ยกเลิกออเดอร์</a>

                                        <?php 
                                     

                                            if(isset($_SESSION["cart_item"])){
                                                 $total_quantity = 0;
                                                 $total_price = 0;                                  
                                        ?>	
                                            <?php		
                                                foreach ($_SESSION["cart_item"] as $item){
                                                $item_price = $item["quantity"]*$item["price"];
                                            ?>
                                      
                                        <div class="list-item">
                                            <!--
                                            <div class="add">
                                                <a class="btn-trash" onclick="add()"><i class='bx bx-dots-vertical-rounded'></i></a>
                                            </div>
                                            -->
                                            <div class="list-item-list">
                                                <div class="z1">
                                                    <div class="name-quantity"><?php echo $item["name"]."&nbsp";?></div>
                                                    <div class="price"><?php echo "฿". number_format($item_price,2);?></div>
                                                </div>
                                                <div class="z1">
                                                   <!-- <div class="details-quantity">รายละเอียด[ธรรมดา/พิเศษ]</div> -->
                                                    <div class="quantity">x<?php echo $item["quantity"];?></div>
                                                </div>                                       
                                            </div>
                                            <div class="del">
                                                <a class="btn-trash"   href="00home2.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction" ><i class='bx bxs-trash-alt'></i></a>  
                                            </div>                                           
                                        </div>  
                                        <?php
                                            $total_quantity += $item["quantity"];
                                            $total_price += ($item["price"]*$item["quantity"]);

                                            } 
                                        ?> 
                                        
                                        </div> 
                                    </div>                                                                                        
                                </div>    

                                                <!---->
                                                <div class="list-item-summary-total" id="summarybox"> 
                                                        <div class="list-item-summary">
                                                            <div class="total-price">จำนวน</div>
                                                            <div class="total-price"><?php echo $total_quantity ."&nbsp";?>รายการ</div>
                                                            <input type="hidden" name="total_quantity" class="form-control" value="<? $total_quantity ?>">
                                                        </div>                                   
                                                        <div class="list-item-summary">
                                                            <div class="total-price">รวมราคา</div>
                                                            <p><?php echo number_format(  $total_price ,2) ;?></p>
                                                        </div>                     
                                                </div>
                                       
                                           
                                    

                                                            
                                                <div class="list-control">
                                                        <!--
                                                        <button class="btn btn-danger">
                                                            <a id="btnEmpty" href="00home2.php?action=cancelorder" >ยกเลิกออเดอร์</a>
                                                        </button>
                                                        -->
                                                        <button class="btn btn-danger">
                                                        <a id="btnEmpty" href="00home2.php?action=order"><?php  $total_quantity_sum ?>จัดการออเดอร์</a>                                           
                                                        </button>
                                                    
                                                </div>

                                         
                                                <!---->



                                            <?php 
                                            }  else{ 
                                            ?>
                                                <div class="norecords">ไม่มีเมนูอาหาร</div>
                                        </div>

                                            <?php }  ?>
                                            
                                                  
    </div>

                

                       
    <script>

        
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




    </script>
  

</body>
</html>