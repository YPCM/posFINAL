<?php  include 'connect.php'; 

include_once('function.php');
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



if (isset($_POST['insert_topping'])) {
    $txtnametopping = $_POST['txtnametopping'];
    $txtcapital_price = $_POST['txtcapital_pricetopping'];
    $txtselling_price = $_POST['txtselling_price'];

    $txtcode = sprintf ( "%05d" , rand(0,99999) ) ;


    if(is_uploaded_file($_FILES['img_food']['tmp_name'])){
        $new_image_name = 'pr_'.uniqid().".".pathinfo(basename($_FILES['img_food']['name']),PATHINFO_EXTENSION);
        $image_upload_path = "./imgfood/".$new_image_name;
        move_uploaded_file($_FILES['img_food']['tmp_name'],$image_upload_path);
    }else{
        $new_image_name="";
    }


    
    $sql = $insertdata->insert_topping($txtnametopping,$txtcapital_price,$txtselling_price,$new_image_name,$txtcode );

    if ($sql) {
        echo "<script>alert('เพิ่มข้อมูลท็อปปิ้งเรียบร้อยแล้ว!!');</script>";
        echo "<script>window.location.href='00food.php'</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มข้อมูลท็อปปิ้ง');</script>";
        echo "<script>window.location.href='00food.php'</script>";
    }
}


if (isset($_POST['insert_food'])) {
    $txtmenu = $_POST['txtmenu'];
    $txtselling_price = $_POST['txtselling_price'];


    $country = $_POST['country'];

    
    if(is_uploaded_file($_FILES['img_food']['tmp_name'])){
        $new_image_name = 'pr_'.uniqid().".".pathinfo(basename($_FILES['img_food']['name']),PATHINFO_EXTENSION);
        $image_upload_path = "./imgfood/".$new_image_name;
        move_uploaded_file($_FILES['img_food']['tmp_name'],$image_upload_path);
    }else{
        $new_image_name="";
    }

    $sql = mysqli_query($connect, "INSERT INTO food_item(`food_menu_name`, `selling_price_food`, `category_food`, `img`, `date_added`) 
    VALUES('$txtmenu','$txtselling_price','$country','$new_image_name','$date_time')") 
    or die('query failed sqllist'); 

   // $sql = $insertdata->insert_food($txtmenu,$txtcapital_price,$txtselling_price,$txtamount,$country,$new_image_name);

    if ($sql) {
        echo "<script>alert('เพิ่มข้อมูลเมนูอาหารเรียบร้อยแล้ว!!');</script>";
        echo "<script>window.location.href='00food.php'</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มข้อมูลเมนูอาหาร');</script>";
        echo "<script>window.location.href='00food.php'</script>";
    }
}


if (isset($_GET['del_food'])) {
    $food_menu_code = $_GET['del_food'];
    $deletedata = new DB_con();

   $sql = $deletedata->delete_food($food_menu_code);
/*
    if ($sql) {
        echo "<script>alert('Record Deleted Successfully!');</script>";
        echo "<script>window.location.href='00food.php'</script>";
    }
    */
}

if (isset($_GET['status_food'])) {
    $food_menu_code = $_GET['status_food'];
 

   $sql = mysqli_query($connect , "UPDATE `food_item` SET `status` ='0' WHERE  food_menu_code='$food_menu_code' ");
/*
    if ($sql) {
        echo "<script>alert('Record Deleted Successfully!');</script>";
        echo "<script>window.location.href='00food.php'</script>";
    }
    */
}
if (isset($_GET['status0_food'])) {
    $food_menu_code = $_GET['status0_food'];
 

   $sql = mysqli_query($connect , "UPDATE `food_item` SET `status` ='1' WHERE  food_menu_code='$food_menu_code' ");
/*
    if ($sql) {
        echo "<script>alert('Record Deleted Successfully!');</script>";
        echo "<script>window.location.href='00food.php'</script>";
    }
    */
}

?>








<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เมนูอาหาร</title>
    <link rel="stylesheet"href="wcss/food.css">
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
                        <a class="a"  type="submit" href="00food.php?exit"  >
                            <span class="material-icons">logout</span>
                            <p>ออกจากระบบ</p>
                            <i class='bx bx-chevron-right'></i>
                        </a>
                </div>
            </div>
        </div>

        
    <script>
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
  

       

                <?php

                     // หมวด 0001
                    /*              
                    $sql_status01= "SELECT category_food, COUNT(food_menu_code) as s1total
                    FROM   food_item
                    WHERE category_food=0001
                    GROUP BY category_food";         
                    $st_0001 = mysqli_query($connect,$sql_status01);
                    $rows01 = mysqli_fetch_array($st_0001);
                    */
                  

                    

                   /*$sql_sumtotalst1="SELECT category_food,SUM(capital_price_food) AS totalsum01 
                    FROM food_item 
                    WHERE category_food=0001";                    
                    $sumst_0001 = mysqli_query($connect,$sql_sumtotalst1);
                    $sumtotal01 = mysqli_fetch_array($sumst_0001);



                     // หมวด 0002
                     /*
                    $sql_status02= "SELECT category_food, COUNT(food_menu_code) as s2total
                    FROM   food_item
                    WHERE category_food=0002
                    GROUP BY category_food";         
                    $st_0002 = mysqli_query($connect,$sql_status02);
                    $rows02 = mysqli_fetch_array($st_0002);
                    */
/*
                    $sql_sumtotalst2="SELECT category_food,SUM(capital_price_food) AS totalsum02 
                    FROM food_item 
                    WHERE category_food=0002";
                    $sumst_0002 = mysqli_query($connect,$sql_sumtotalst2);
                    $sumtotal02 = mysqli_fetch_array($sumst_0002);


                    
                    // หมวด 0003  
                    /*                  
                    $sql_status03= "SELECT category_food, COUNT(food_menu_code) as s3total
                    FROM   food_item
                    WHERE category_food=0003
                    GROUP BY category_food";         
                    $st_0003 = mysqli_query($connect,$sql_status03);
                    $rows03 = mysqli_fetch_array($st_0003);
                    */

                  /*  $sql_sumtotalst3="SELECT category_food,SUM(capital_price_food) AS totalsum03 
                    FROM food_item 
                    WHERE category_food=0003";
                    
                    $sumst_0003 = mysqli_query($connect,$sql_sumtotalst3);
                    $sumtotal03 = mysqli_fetch_array($sumst_0003);



                    // คำนวณต้นทุนของ 0001-0003 
                    
                    $sql_totals="SELECT SUM(capital_price_food) AS sumtotal 
                    FROM food_item 
                    WHERE category_food";
                    $sumtotal = mysqli_query($connect,$sql_totals);
                    $rowsumtotal = mysqli_fetch_array($sumtotal);
                    


                    // ตาราง topping
                    $sql_totaltopping = " SELECT * FROM food_toppings ";
                    $qtoppings = mysqli_query($connect,$sql_totaltopping );
                    $numtotaltopping = mysqli_num_rows($qtoppings);
              

                



                    $sql_sumtopping = "SELECT food_toppings_code ,SUM(capital_price_topping) AS toppings 
                    FROM food_toppings 
                    WHERE food_toppings_code";
                    $sumtopping =  mysqli_query($connect,$sql_sumtopping);
                    $rowtopping =  mysqli_fetch_array($sumtopping);



                    
                    // คำนวณต้นทุนของทั้งหมด 
                    $sumtotal_topping = $rowsumtotal["sumtotal"] + $rowtopping["toppings"] ;

*/

                ?>





    <div class="S">
            <div class="text">

                <div class="Stockfood">ข้อมูลรายการอาหาร</div>
            </div>
            <div class="pro_">                  
                <div class="box boxitem "><!-- almost_gone --> 
                    <div class="boxitem_">      
                        <?php
                            $sql_status01= "SELECT category_food, COUNT(food_menu_code) as s1total
                            FROM   food_item
                            WHERE category_food=0001
                            GROUP BY category_food";         
                            $st_0001 = mysqli_query($connect,$sql_status01);
                            $rows01 = mysqli_fetch_array($st_0001);
                            if($rows01>0){
                                
                        ?>                                   
                            <div class="number_pro"> <?php echo $rows01 ["s1total"];?> </div>
                        
                        <?php 
                            }  else {  
                        ?>
                              <div class="number_pro">-</div>
                        <?php } ?>



                        <div class="box1_boxitem">
                                <div class="list_boxitem">อาหารจานหลัก[0001]</div>
                                
                            </div>
                            <!--
                            <div class="box1_boxitem">
                                <div class="list2_boxitem">ราคาทุน : </div>
                                <div class="list2_boxitem"><?php //echo "&nbsp" . $sumtotal01["totalsum01"] . "&nbsp";?></div>
                                <div class="list2_boxitem">บาท</div>
                            </div>
                            -->
                    </div>  
                            <div class="iconboxitem"><i class='bx bxs-dish'></i></div> 
                </div>

                
                <div class="box boxitem "><!-- almost_gone --> 
                    <div class="boxitem_">  

                        <?php
                            $sql_status02= "SELECT category_food, COUNT(food_menu_code) as s2total
                            FROM   food_item
                            WHERE category_food=0002
                            GROUP BY category_food";         
                            $st_0002 = mysqli_query($connect,$sql_status02);
                            $rows02 = mysqli_fetch_array($st_0002);
                            if($rows02>0){
                                
                        ?>                                   
                            <div class="number_pro"> <?php echo $rows02 ["s2total"];?> </div>
                        
                        <?php 
                            }  else {  
                        ?>
                              <div class="number_pro">-</div>
                        <?php } ?>


                            <div class="box1_boxitem">
                                <div class="list_boxitem">อาหารทานเล่น[0002]</div>    
                            </div>
                            <!--
                            <div class="box1_boxitem">
                                <div class="list2_boxitem">ราคาทุน : </div>
                                <div class="list2_boxitem"><?php echo "&nbsp" . $sumtotal02["totalsum02"] . "&nbsp";?></div>
                                <div class="list2_boxitem">บาท</div>
                            </div>
                            -->
                    </div>  
                            <div class="iconboxitem"><i class='bx bx-cookie'></i></div> 
                </div>
                <div class="box boxitem "><!-- almost_gone --> 
                    <div class="boxitem_">                                           
                        <?php
                            $sql_status03= "SELECT category_food, COUNT(food_menu_code) as s3total
                            FROM  food_item
                            WHERE category_food=0003
                            GROUP BY category_food";         
                            $st_0003 = mysqli_query($connect,$sql_status03);
                            $rows03 = mysqli_fetch_array($st_0003);
                            if($rows03>0){
                                    
                        ?>                                   
                            <div class="number_pro"> <?php echo $rows03 ["s3total"];?> </div>
                            
                        <?php 
                            }  else {  
                        ?>
                                <div class="number_pro">-</div>
                        <?php } ?>



                            <div class="box1_boxitem">
                                <div class="list_boxitem">เครื่องดื่ม[0003]</div>          
                            </div>
                            <!--
                            <div class="box1_boxitem">
                                <div class="list2_boxitem">ราคาทุน : </div>
                                <div class="list2_boxitem"><?php echo "&nbsp" . $sumtotal03["totalsum03"] . "&nbsp";?></div>
                                <div class="list2_boxitem">บาท</div>
                            </div>
                            -->
                    </div>  
                         <div class="iconboxitem"><i class='bx bxs-wine'></i></div> 
                </div>

                
                <div class="box boxitem "><!-- almost_gone --> 
                    <div class="boxitem_">   
                        
                        <?php
                            $sql_status04= "SELECT category_food, COUNT(food_menu_code) as s4total
                            FROM  food_item
                            WHERE category_food=0004
                            GROUP BY category_food";         
                            $st_0004 = mysqli_query($connect,$sql_status04);
                            $rows04 = mysqli_fetch_array($st_0004);
                            if($rows04>0){
                                
                        ?>                                   
                            <div class="number_pro"> <?php  echo $rows04 ["s4total"] ;?> </div>
                        
                        <?php 
                            }  else {  
                        ?>
                              <div class="number_pro">-</div>
                        <?php } ?>



                        
                            <div class="box1_boxitem">
                                <div class="list_boxitem">ท็อปปิ้ง[0004]</div>
                                
                            </div>
                            <!--
                            <div class="box1_boxitem">
                                <div class="list2_boxitem">ราคาทุน : </div>
                                <div class="list2_boxitem"><?php echo "&nbsp" . $rowtopping["toppings"] . "&nbsp" ;?></div>
                                <div class="list2_boxitem">บาท</div>
                            </div>
                            -->
                    </div>  
                            <div class="iconboxitem"><i class='bx bx-badge'></i></div> 
                </div>



                <div class="box boxitem "><!-- almost_gone --> 
                    <div class="boxitem_">   
                        
                        <?php    
                            $st_ff = mysqli_query($connect,"SELECT * FROM food_item WHERE `status`='0';");
                            $numtotalfff = mysqli_num_rows($st_ff);
                            if($numtotalfff>0){
                                
                        ?>                                   
                            <div class="number_pro"> <?php  echo $numtotalfff ;?> </div>
                        
                        <?php 
                            }  else {  
                        ?>
                              <div class="number_pro">-</div>
                        <?php } ?>



                        
                            <div class="box1_boxitem">
                                <div class="list_boxitem">สถานะไม่พร้อมให้บริการ</div>
                                
                            </div>
                            <!--
                            <div class="box1_boxitem">
                                <div class="list2_boxitem">ราคาทุน : </div>
                                <div class="list2_boxitem"><?php echo "&nbsp" . $rowtopping["toppings"] . "&nbsp" ;?></div>
                                <div class="list2_boxitem">บาท</div>
                            </div>
                            -->
                    </div>  
                            <div class="iconboxitem"><i style='color: #d63031; cursor: pointer;' class='bx bxs-circle status'></i></div> 
                </div>




            



                  
            </div>
     

            <div class="total">
                    <div class="num_total_list">
                            <?php
                                    $sql_total = mysqli_query($connect," SELECT * FROM food_item ");
                                   //$sql_totaltopping = mysqli_query($connect," SELECT * FROM food_toppings ");
                                    $numtotal = mysqli_num_rows($sql_total);
                                   // $numtotaltopping = mysqli_num_rows($sql_totaltopping);
                                   // $tota = $numtotal + $numtotaltopping ; 
                                    echo "จำนวนรายการอาหารทั้งหมด ". $numtotal."&nbspรายการ&nbsp";
                                
                            ?>
                </div>

                <div class="num_total_list"></div>
                <div class="num_total_list"><?php // echo "&nbspต้นทุน&nbsp" . $sumtotal_topping ."&nbsp บาท" ;?></div>
            </div>
            
            
    


         

    


            
          <!--  ตัวpopup modal ทั้งหมด  -->
            
   


          



            <div class="aa">
                <!--
                <div class="add" id="myBtn">
                    <i class='bx bx-plus'></i>
                </div>    -->          
            </div>
                <div id="myModal" class="modal">

                    <!-- Modal content -->
                    <div class="modalcontent">
                        <div class="modal-header">           
                            <p>เพิ่มข้อมูล เมนูอาหาร</p>
                            <span class="close1">&times;</span>
                        </div>
                        <!-- <span class="close">&times;</span>
                        <h1 class="modal-header">ข้อมูลหลัก</h1> -->
                        <div class="modal-body">
                        <p> 
                            
                            <form action="#" method="post"enctype="multipart/form-data">
                                <div class="modalLR">
                                <label>ชื่อเมนูอาหาร/เครื่องดื่ม/ท็อปปิ้ง :</label>
                                <input type="text" name="txtmenu" placeholder="ข้อมูล"  >
                                
                                <label>ภาพสินค้า :</label>
                                <input class="form-control form-control-lg" type="file" name="img_food"   accept="image/gif, image/jpeg , image/png" >
                                <!-- 
                                <label>จำนวน :</label>
                                <input type="text" name="txtamount" placeholder="0" >
                                  
                                <label>ราคาต้นทุน :</label>
                                <input type="text"  name="txtcapital_price" placeholder="0"  >
                                -->
                                <label>ราคาขาย :</label>
                                <input type="text" name="txtselling_price" placeholder="0"  >
                            
                                <label>หมวดหมู่ :</label>
                                    <select id="country" name="country" required>
                                            <option value="0001" >อาหารจานหลัก [0001]</option>
                                            <option value="0002" >อาหารทานเล่น [0002]</option>
                                            <option value="0003" >เครื่องดื่ม [0003]</option>
                                            <option value="0004" >ท็อปปิ้ง [0004]</option>
                                    </select>
                               
            
                                <label class=""for="lname">รหัสสินค้า :</label>
                                <input class="form-control" type="text" placeholder="อัตโนมัติ" aria-label="Disabled input example" disabled name="food_menu_code">
                                </div> 
                              

                                <input class="modal-footer" name="insert_food" type="submit" value="เพิ่มสินค้า">
                               
                            </form>         
                        </p>                  
                    </div>
                </div>
            </div>

       <!--
            <form action="foodinsert.php" method="post"enctype="multipart/form-data">
        <div class="product">
          
       
            <div class="product-item">
                <label>ชื่อสินค้า</label>
                <input type="text" name="product_name"><br>
            </div>
            <div class="product-item">
                <label>ราคา</label>
                <input type="text" name="rates"><br>
            </div>
            <div class="product-item">
                <label>จำนวน</label>
                <input type="text" name="quantity"><br>
            </div>
        </div>
        <input type="submit" value="เพิ่มสินค้า">
    </form>-->

              
        




                                        <div class="action" >
                                           
                                                    <div class="addaddmenu">
                                                        <ul>
                                                           <!-- <li class="add-manu" id="myBtntopping"><i class='bx bx-badge'></i></li> -->
                                                            <li class="add-manu" id="myBtn" ><i class='bx bx-plus'></i></li>
                                                        </ul>
                                                    </div>
                                    
                                        </div>

                                        <script>
                                            var modal = document.getElementById("myModal");   
                                            var btn = document.getElementById("myBtn");  // Get the button that opens the modal       
                                            var span = document.getElementsByClassName("close1")[0];  // Get the <span> element that closes the modal       
                                            btn.onclick = function() {   // When the user clicks the button, open the modal 
                                            modal.style.display = "block";
                                            }
                                            span.onclick = function() {   // When the user clicks on <span> (x), close the modal 
                                            modal.style.display = "none";
                                            }
                                            window.onclick = function(event2) {   // When the user clicks anywhere outside of the modal, close it
                                            if (event2.target == modal) {
                                                modal.style.display = "none";
                                            }
                                            }
                                        </script>

                                        <!--
                                        <div class="action" >
                                            <div class="popup" onclick="myFunctionpopup()"> 
                                                <div class="add">
                                                    <i class='bx bx-plus'></i>
                                                </div>     
                                                <span class="popuptext" id="myPopup" >
                                                    <div class="addaddmenu">
                                                        <ul>
                                                            <li class="add-manu" id="myBtntopping"><i class='bx bx-badge'></i></li>
                                                            <li class="add-manu" id="myBtn" ><i class='bx bx-dish'></i></li>
                                                        </ul>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        -->



    

                                
<div class="boxx">
    <div class="boxS">
    <div class="tab">
        <button class="tablinks" onclick="food(event, 'F1')" > <i class='bx bxs-dish'></i>อาหารจานหลัก/เมนูอาหาร</button>
        <button class="tablinks" onclick="food(event, 'F2')"> <i class='bx bx-cookie'></i>อาหารทานเล่น</button>
        <button class="tablinks" onclick="food(event, 'F3')"> <i class='bx bxs-wine'></i>เครื่องดื่ม</button>
        <button class="tablinks" onclick="food(event, 'F4')"> <i class='bx bx-badge'></i>ท็อปปิ้ง</button>
        <button class="tablinks" onclick="food(event, 'FF')"> <i style='color: #d63031; ' class='bx bxs-circle'></i> สถานะไม่พร้อมบริการ</button>
        <button class="tablinks" onclick="food(event, 'F5')" id="defaultOpenfood" > <i class='bx bx-search-alt-2'></i>ค้นหาเมนูอาหาร</button>
    </div>
    
    <script>
        function food(evt, cityName) {
        var o, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (o = 0; o < tabcontent.length; o++) {
            tabcontent[o].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (o = 0; o < tablinks.length; o++) {
            tablinks[o].className = tablinks[o].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpenfood").click();
    </script>




<div id="F1" class="tabcontent">
    <div class="danger" style="background-color: #ffffff;" >
        <p>อาหารจานหลัก/เมนูอาหาร</p>
    </div>
    <div class="box3">
            <div class="pro_list pro_list_two">
                <div class="total_list">
                <!-- <div class="number_list"><p>19 รายการ</p></div> -->
                                <!--ตาราง-->

                            <div class="food">

<!--
                                <div class="search_tap">    
                                  
                                        <select id="country" name="country" required>
                                                <option value="0001" >อาหารจานหลัก [0001]</option>
                                                <option value="0002" >อาหารทานเล่น [0002]</option>
                                                <option value="0003" >เครื่องดื่ม [0003]</option>
                                        </select>  
                                   
                            
                                        <input class="form-search" type="text" placeholder="ท็อปปิ้ง" name="search" id="myInput" onkeyup="myFunctionT()" >
                                        <button class="btn-search" name="submit"  ><i class='bx bx-search'></i></button>

                                        
                                </div>
-->
                                <div class="totalscroll">
                                    <table id="example">
                                        <thead>
                                            <tr class="theadFix" >  
                                                <th style="text-align: center; width:5%;"></th>    
                                                <th style="text-align: center; width:8%;">รหัส</th>
                                                <th style="text-align: center; width:15%;">รูปภาพ</th> 
                                                <th style="text-align: start; width:30%">ชื่อเมนูอาหาร</th>
                                                <th style="text-align: center; width:10%;" >ประเภทอาหาร</th>                      
                                               <!-- <th>ราคาทุน</th> -->
                                                <th style="text-align: center; width:10%;" >ราคาขาย</th>
                                                <th style="width:10%;"></th>
                                            </tr>
                                        <thead>
                                        <tbody>
                                                <?php

                                                    $query = mysqli_query($connect, "SELECT * FROM food_item WHERE category_food = '0001'  AND`status`=1");
                                                    $totalcnt = mysqli_num_rows($query);

                                                    if ($totalcnt > 0) {
                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                    
                                                            if($row['status']=='1'){
                                                                $statusfood = "<i style='color: #2ecc71; cursor: pointer; ' class='bx bxs-circle status'></i>";
                                                            }else{
                                                                $statusfood = "<i style='color: #d63031; cursor: pointer;' class='bx bxs-circle status'></i>";
                                                            }
                                                            
                                                ?>
                                            <tr>
                                                <td style="text-align: center;"><a data-id="<?= $row['food_menu_code']; ?>" href="?status_food=<?= $row['food_menu_code']; ?> " class="status-btn" ><?php echo $statusfood ;?> </a></td>
                                                <td style="text-align: center; "><p><?php echo $row["food_menu_code"]?></p></td>
                                                <td style="text-align: center;"><img src="imgfood/<?php echo $row['img']?>" /></td>
                                                <td style="text-align: start;"><?php echo $row["food_menu_name"]?></td>
                                                <td style="text-align: center; "><?php echo $row["category_food"]?></td>
                                              <!--  <td><?php //echo "฿   ". number_format( $row["capital_price_food"],2) ?></td> -->
                                                <td><?php echo "฿   ". number_format( $row["selling_price_food"],2)  ?></td>
                                                <?php $_SESSION["food_menu_code"] = $row["category_food"] ;?>
                                                <!--
                                                <td><?php //echo $row["amount_food"];?></td> 
                                                    -->
                                                <td style="text-align: center; "> 
                                                
                                                    <a  class="btn edit" name="edit" href="foodedit.php?food_menu_code=<?=$row["food_menu_code"]?>"><i class='bx bxs-edit-alt' ></i></a>  
                                                    <a data-id="<?= $row['food_menu_code']; ?>" href="?del_food=<?= $row['food_menu_code']; ?>" class="btn delete delete-btn"><i class='bx bxs-trash-alt'></i></a>
                                                    
                                                </td>
                                            </tr>

                                            <?php } } else { ?>
                                            <tr>
                                                <td colspan="7" ><p class="nodata">ไม่มีข้อมูล<p></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table >
                       
                                    
                                </div>
                            </div>

                            
                </div>
            </div>

    </div>
</div>


<div id="F2" class="tabcontent">
    <div class="danger" style="background-color: #ffffff;" >
        <p>อาหารทานเล่น</p>
    </div>
    <div class="box3">
            <div class="pro_list pro_list_two">
                <div class="total_list">
                <!-- <div class="number_list"><p>19 รายการ</p></div> -->
                                <!--ตาราง-->

                            <div class="food">

<!--
                                <div class="search_tap">    
                                  
                                        <select id="country" name="country" required>
                                                <option value="0001" >อาหารจานหลัก [0001]</option>
                                                <option value="0002" >อาหารทานเล่น [0002]</option>
                                                <option value="0003" >เครื่องดื่ม [0003]</option>
                                        </select>  
                                   
                            
                                        <input class="form-search" type="text" placeholder="ท็อปปิ้ง" name="search" id="myInput" onkeyup="myFunctionT()" >
                                        <button class="btn-search" name="submit"  ><i class='bx bx-search'></i></button>

                                        
                                </div>
-->
                                <div class="totalscroll">
                                    <table id="example">
                                        <thead>
                                            <tr class="theadFix" >
                                                <th style="text-align: center; width:5%;"></th> 
                                                <th style="text-align: center; width:8%;">รหัส</th>
                                                <th style="text-align: center; width:15%;">รูปภาพ</th> 
                                                <th style="text-align: start; width:30%">ชื่อเมนูอาหารทานเล่น</th>
                                                <th style="text-align: center; width:10%;" >ประเภทอาหาร</th>                      
                                               <!-- <th>ราคาทุน</th> -->
                                                <th style="text-align: center; width:10%;" >ราคาขาย</th>
                                                <th style="width:10%;"></th>
                                            </tr>
                                        <thead>
                                        <tbody>
                                                <?php

                                                    $query = mysqli_query($connect, "SELECT * FROM food_item WHERE category_food = '0002'  AND`status`=1 ");
                                                    $totalcnt = mysqli_num_rows($query);

                                                    if ($totalcnt > 0) {
                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                            if($row['status']=='1'){
                                                                $statusfood = "<i style='color: #2ecc71; cursor: pointer;' class='bx bxs-circle status'></i>";
                                                            }else{
                                                                $statusfood = "<i style='color: #d63031; cursor: pointer;' class='bx bxs-circle status'></i>";
                                                            }
                                                            
                                                ?>
                                            <tr>
                                                <td style="text-align: center;"><a data-id="<?= $row['food_menu_code']; ?>" href="?status_food=<?= $row['food_menu_code']; ?> " class="status-btn" ><?php echo $statusfood ;?></a></td>
                                                <td style="text-align: center; "><p><?php echo $row["food_menu_code"]?></p></td>
                                                <td style="text-align: center;"><img src="imgfood/<?php echo $row['img']?>" /></td>
                                                <td style="text-align: start;"><?php echo $row["food_menu_name"]?></td>
                                                <td style="text-align: center; "><?php echo $row["category_food"]?></td>
                                              <!--  <td><?php //echo "฿   ". number_format( $row["capital_price_food"],2) ?></td> -->
                                                <td><?php echo "฿   ". number_format( $row["selling_price_food"],2)  ?></td>
                                                <?php $_SESSION["food_menu_code"] = $row["category_food"] ;?>
                                                <!--
                                                <td><?php //echo $row["amount_food"];?></td> 
                                                    -->
                                                <td style="text-align: center; "> 
                                                
                                                    <a  class="btn edit" name="edit" href="foodedit.php?food_menu_code=<?=$row["food_menu_code"]?>"><i class='bx bxs-edit-alt' ></i></a>  
                                                    <a data-id="<?= $row['food_menu_code']; ?>" href="?del_food=<?= $row['food_menu_code']; ?>" class="btn delete delete-btn"><i class='bx bxs-trash-alt'></i></a>
                                                
                                                </td>
                                            </tr>

                                            <?php } } else { ?>
                                            <tr>
                                                <td colspan="7" ><p class="nodata">ไม่มีข้อมูล<p></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table >
                       
                                    
                                </div>
                            </div>

                            
                </div>
            </div>

    </div>
</div>


<div id="F3" class="tabcontent">
    <div class="danger" style="background-color: #ffffff;" >
        <p>เครื่องดื่ม</p>
    </div>
    <div class="box3">
            <div class="pro_list pro_list_two">
                <div class="total_list">
                <!-- <div class="number_list"><p>19 รายการ</p></div> -->
                                <!--ตาราง-->

                            <div class="food">

<!--
                                <div class="search_tap">    
                                  
                                        <select id="country" name="country" required>
                                                <option value="0001" >อาหารจานหลัก [0001]</option>
                                                <option value="0002" >อาหารทานเล่น [0002]</option>
                                                <option value="0003" >เครื่องดื่ม [0003]</option>
                                        </select>  
                                   
                            
                                        <input class="form-search" type="text" placeholder="ท็อปปิ้ง" name="search" id="myInput" onkeyup="myFunctionT()" >
                                        <button class="btn-search" name="submit"  ><i class='bx bx-search'></i></button>

                                        
                                </div>
-->
                                <div class="totalscroll">
                                    <table id="example">
                                        <thead>
                                            <tr class="theadFix" >
                                                <th style="text-align: center; width:5%;"></th> 
                                                <th style="text-align: center; width:8%;">รหัส</th>
                                                <th style="text-align: center; width:15%;">รูปภาพ</th> 
                                                <th style="text-align: start; width:30%">ชื่อเครื่องดื่ม</th>
                                                <th style="text-align: center; width:10%;" >ประเภทอาหาร</th>                      
                                               <!-- <th>ราคาทุน</th> -->
                                                <th style="text-align: center; width:10%;" >ราคาขาย</th>
                                                <th style="width:10%;"></th>
                                            </tr>
                                        <thead>
                                        <tbody>
                                                <?php

                                                    $query = mysqli_query($connect, "SELECT * FROM food_item WHERE category_food = '0003'  AND`status`=1 ");
                                                    $totalcnt = mysqli_num_rows($query);

                                                    if ($totalcnt > 0) {
                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                    
                                                            if($row['status']=='1'){
                                                                $statusfood = "<i style='color: #2ecc71; cursor: pointer;' class='bx bxs-circle status'></i>";
                                                            }else{
                                                                $statusfood = "<i style='color: #d63031; cursor: pointer;' class='bx bxs-circle status'></i>";
                                                            }
                                                            
                                                ?>
                                            <tr>
                                                <td style="text-align: center;"><a data-id="<?= $row['food_menu_code']; ?>" href="?status_food=<?= $row['food_menu_code']; ?> " class="status-btn" ><?php echo $statusfood ;?></a></td>
                                                <td style="text-align: center;"><p><?php echo $row["food_menu_code"]?></p></td>
                                                <td style="text-align: center;"><img src="imgfood/<?php echo $row['img']?>" /></td>
                                                <td style="text-align: start;"><?php echo $row["food_menu_name"]?></td>
                                                <td style="text-align: center;"><?php echo $row["category_food"]?></td>
                                              <!--  <td><?php //echo "฿   ". number_format( $row["capital_price_food"],2) ?></td> -->
                                                <td><?php echo "฿   ". number_format( $row["selling_price_food"],2)  ?></td>
                                                <?php $_SESSION["food_menu_code"] = $row["category_food"] ;?>
                                                <!--
                                                <td><?php //echo $row["amount_food"];?></td> 
                                                    -->
                                                <td style="text-align: center;"> 
                                                
                                                    <a  class="btn edit" name="edit" href="foodedit.php?food_menu_code=<?=$row["food_menu_code"]?>"><i class='bx bxs-edit-alt' ></i></a>  
                                                    <a data-id="<?= $row['food_menu_code']; ?>" href="?del_food=<?= $row['food_menu_code']; ?>" class="btn delete delete-btn"><i class='bx bxs-trash-alt'></i></a>
                                                    
                                                </td>
                                            </tr>

                                            <?php } } else { ?>
                                            <tr>
                                                <td colspan="7" ><p class="nodata">ไม่มีข้อมูล<p></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table >
                       
                                    
                                </div>
                            </div>

                            
                </div>
            </div>

    </div>
</div>




<div id="F4" class="tabcontent">
    <div class="danger" style="background-color: #ffffff;" >
        <p>ท็อปปิ้ง</p>
    </div>
    <div class="box3">
            <div class="pro_list pro_list_two">
                <div class="total_list">
                <!-- <div class="number_list"><p>19 รายการ</p></div> -->
                                <!--ตาราง-->

                            <div class="food">
                                <div class="totalscroll">
                                    <table id="example">
                                        <thead>
                                            <tr class="theadFix" >
                                                <th style="text-align: center; width:5%;"></th> 
                                                <th style="text-align: center; width:8%;">รหัส</th>
                                                <th style="text-align: center; width:15%;">รูปภาพ</th> 
                                                <th style="text-align: start; width:30%">ท็อปปิ้ง</th>
                                                <th style="text-align: center; width:10%;" >ประเภทอาหาร</th>                      
                                               <!-- <th>ราคาทุน</th> -->
                                                <th style="text-align: center; width:10%;" >ราคาขาย</th>
                                                <th style="width:10%;"></th>
                                                <!--<th>จำนวน</th>-->
                                    
                                            </tr>
                                        <thead>
                                        <tbody>
                                                <?php

                                                    $query = mysqli_query($connect, "SELECT * FROM food_item WHERE category_food = '0004'  AND`status`=1 ");
                                                    $totalcnt = mysqli_num_rows($query);

                                                    if ($totalcnt > 0) {
                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                    
                                                            if($row['status']=='1'){
                                                                $statusfood = "<i style='color: #2ecc71; cursor: pointer;' class='bx bxs-circle status'></i>";
                                                            }else{
                                                                $statusfood = "<i style='color: #d63031; cursor: pointer;' class='bx bxs-circle status'></i>";
                                                            }
                                                            
                                                ?>
                                            <tr>
                                                <td style="text-align: center;"><a data-id="<?= $row['food_menu_code']; ?>" href="?status_food=<?= $row['food_menu_code']; ?> " class="status-btn" ><?php echo $statusfood ;?></a></td>
                                                <td style="text-align: center;"><p><?php echo $row["food_menu_code"]?></p></td>
                                                <td style="text-align: center;"><img src="imgfood/<?php echo $row['img']?>" /></td>
                                                <td style="text-align: start;"><?php echo $row["food_menu_name"]?></td>
                                                <td style="text-align: center;"><?php echo $row["category_food"]?></td>
                                              <!--  <td><?php //echo "฿   ". number_format( $row["capital_price_food"],2) ?></td> -->
                                                <td><?php echo "฿   ". number_format( $row["selling_price_food"],2)  ?></td>
                                                <?php $_SESSION["food_menu_code"] = $row["category_food"] ;?>
                                                <!--
                                                <td><?php //echo $row["amount_food"];?></td> 
                                                    -->
                                                <td style="text-align: center;"> 
                                                
                                                    <a  class="btn edit" name="edit" href="foodedit.php?food_menu_code=<?=$row["food_menu_code"]?>"><i class='bx bxs-edit-alt' ></i></a>  
                                                    <a data-id="<?= $row['food_menu_code']; ?>" href="?del_food=<?= $row['food_menu_code']; ?>" class="btn delete delete-btn"><i class='bx bxs-trash-alt'></i></a>
                                                    <!-- <a  class="btn delete delete-btn" data-id="<?php echo $row['food_menu_code']; ?>"  onclick="Del(this.href); return false;" name="delete_food" type="submit" href="00food.php?del_food=<?php echo $row['food_menu_code']; ?>"><i class='bx bxs-trash-alt'></i></a> --> 
                                                
                                                </td>
                                            </tr>

                                            <?php } } else {    ?>
                                            <tr>
                                                <td colspan="7" ><p class="nodata">ไม่มีข้อมูล<p></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table >
                       
                                    
                                </div>
                            </div>

                            
                </div>
            </div>

    </div>
</div>







<div id="F5" class="tabcontent">
    <div class="danger" style="background-color: #ffffff;" >
        <p>ค้นหาเมนูอาหาร</p>
    </div>
    <div class="box3">
            <div class="pro_list pro_list_two">
                <div class="total_list">
                <!-- <div class="number_list"><p>19 รายการ</p></div> -->
                                <!--ตาราง-->

                            <div class="food">

                                <div class="search_tap">    
                                    <!--
                                        <select id="country" name="country" required>
                                                <option value="0001" >อาหารจานหลัก [0001]</option>
                                                <option value="0002" >อาหารทานเล่น [0002]</option>
                                                <option value="0003" >เครื่องดื่ม [0003]</option>
                                        </select>  
                                    -->
                                    <form class="search_tap" action="<?=$_SERVER['PHP_SELF'];?>" method="post" >
                                        <input class="form-search"  type="text" id="fname" name="search" placeholder="รหัสเมนูอาหาร ">
                                        <button class="btn-search" type="submit" name="button" id="button" ><span class="material-icons">search</span></button>
                                    </form>
                                    <!--
                                        <input class="form-search" type="text" placeholder="รหัสเมนูอาหาร" name="search" id="myInput" onkeyup="myFunctionT()" >
                                        <button class="btn-search" name="submit"  ><i class='bx bx-search'></i></button>
                                    -->
                                        
                                </div>
                                <div class="totalscroll">
                                    <table id="example">
                                        <thead>
                                            <tr class="theadFix" >
                                                <th style="text-align: center; width:5%;"></th> 
                                                <th style="text-align: center; width:8%;">รหัส</th>
                                                <th style="text-align: center; width:15%;">รูปภาพ</th> 
                                                <th style="text-align: start; width:30%">ชื่อเมนูอาหาร</th>
                                                <th style="text-align: center; width:10%;" >ประเภทอาหาร</th>                      
                                               <!-- <th>ราคาทุน</th> -->
                                                <th style="text-align: center; width:10%;" >ราคาขาย</th>
                                                <th style="width:10%;"></th>
                                                <!--<th>จำนวน</th>-->
                                    
                                            </tr>
                                        <thead>
                                        <tbody>
                                            <?php
                                                isset( $_POST['search'] ) ? $search = $_POST['search'] : $search = "";
                                                $num = 0 ;
                                                if( !empty( $search ) ) {
                                                    $sql = "SELECT * FROM `food_item` WHERE `food_menu_code` LIKE '%$search%' or  `food_menu_name` LIKE '%$search%' ";
                                                    $numrow = mysqli_query( $connect, $sql );


                                                    while($rowsearch = mysqli_fetch_assoc($numrow) ) {
                                                      
                                            ?>

                                            <tr>
                                                <td style="text-align: center;"><p><?php echo $rowsearch["food_menu_code"]?></p></td>
                                                <td style="text-align: center;"><img src="imgfood/<?php echo $rowsearch['img']?>" /></td>
                                                <td style="text-align: start;"><?php echo $rowsearch["food_menu_name"]?></td>
                                                <td style="text-align: center;"><?php echo $rowsearch["category_food"]?></td>
                                              <!--  <td><?php //echo "฿   ". number_format( $row["capital_price_food"],2) ?></td> -->
                                                <td><?php echo "฿   ". number_format( $rowsearch["selling_price_food"],2)  ?></td>
                                                <?php $_SESSION["food_menu_code"] = $rowsearch["category_food"] ;?>
                                                <!--
                                                <td><?php //echo $row["amount_food"];?></td> 
                                                    -->
                                                <td style="text-align: center;"> 
                                                
                                                    <a  class="btn edit" name="edit" href="foodedit.php?food_menu_code=<?=$rowsearch["food_menu_code"]?>"><i class='bx bxs-edit-alt' ></i></a>  
                                                    <a data-id="<?= $rowsearch['food_menu_code']; ?>" href="?del_food=<?= $rowsearch['food_menu_code']; ?>" class="btn delete delete-btn"><i class='bx bxs-trash-alt'></i></a>
                                                
                                                </td>
                                            </tr>

                                            <?php } } else { ?>
                                            <tr>
                                                <td colspan="7" ><p class="nodata">ไม่พบข้อมูล<p></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table >
                       
                                    
                                </div>
                            </div>

                            
                </div>
            </div>

    </div>
</div>

<div id="FF" class="tabcontent">
    <div class="danger" style="background-color: #ffffff;" >
        <p>สถานะไม่พร้อมบริการ</p>
    </div>
    <div class="box3">
            <div class="pro_list pro_list_two">
                <div class="total_list">
                <!-- <div class="number_list"><p>19 รายการ</p></div> -->
                                <!--ตาราง-->

                            <div class="food">

<!--
                                <div class="search_tap">    
                                  
                                        <select id="country" name="country" required>
                                                <option value="0001" >อาหารจานหลัก [0001]</option>
                                                <option value="0002" >อาหารทานเล่น [0002]</option>
                                                <option value="0003" >เครื่องดื่ม [0003]</option>
                                        </select>  
                                   
                            
                                        <input class="form-search" type="text" placeholder="ท็อปปิ้ง" name="search" id="myInput" onkeyup="myFunctionT()" >
                                        <button class="btn-search" name="submit"  ><i class='bx bx-search'></i></button>

                                        
                                </div>
-->
                                <div class="totalscroll">
                                    <table id="example">
                                        <thead>
                                            <tr class="theadFix" >  
                                                <th style="text-align: center; width:5%;"></th>    
                                                <th style="text-align: center; width:8%;">รหัส</th>
                                                <th style="text-align: center; width:15%;">รูปภาพ</th> 
                                                <th style="text-align: start; width:30%">ชื่อเมนูอาหาร</th>
                                                <th style="text-align: center; width:10%;" >ประเภทอาหาร</th>                      
                                               <!-- <th>ราคาทุน</th> -->
                                                <th style="text-align: center; width:10%;" >ราคาขาย</th>
                                                <th style="width:10%;"></th>
                                            </tr>
                                        <thead>
                                        <tbody>
                                                <?php

                                                    $query = mysqli_query($connect, "SELECT * FROM food_item WHERE status = '0'");
                                                    $totalcnt = mysqli_num_rows($query);

                                                    if ($totalcnt > 0) {
                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                    
                                                            if($row['status']=='1'){
                                                                $statusfood = "<i style='color: #2ecc71; cursor: pointer; ' class='bx bxs-circle status'></i>";
                                                            }else{
                                                                $statusfood = "<i style='color: #d63031; cursor: pointer;' class='bx bxs-circle status'></i>";
                                                            }
                                                            
                                                ?>
                                            <tr>
                                                <td style="text-align: center;"><a data-id="<?= $row['food_menu_code']; ?>" href="?status0_food=<?= $row['food_menu_code']; ?> " class="status-btn" ><?php echo $statusfood ;?></a></td>
                                                <td style="text-align: center; "><p><?php echo $row["food_menu_code"]?></p></td>
                                                <td style="text-align: center;"><img src="imgfood/<?php echo $row['img']?>" /></td>
                                                <td style="text-align: start;"><?php echo $row["food_menu_name"]?></td>
                                                <td style="text-align: center; "><?php echo $row["category_food"]?></td>
                                              <!--  <td><?php //echo "฿   ". number_format( $row["capital_price_food"],2) ?></td> -->
                                                <td><?php echo "฿   ". number_format( $row["selling_price_food"],2)  ?></td>
                                                <?php $_SESSION["food_menu_code"] = $row["category_food"] ;?>
                                                <!--
                                                <td><?php //echo $row["amount_food"];?></td> 
                                                    -->
                                                <td style="text-align: center; "> 
                                                
                                                    <a  class="btn edit" name="edit" href="foodedit.php?food_menu_code=<?=$row["food_menu_code"]?>"><i class='bx bxs-edit-alt' ></i></a>  
                                                    <a data-id="<?= $row['food_menu_code']; ?>" href="?del_food=<?= $row['food_menu_code']; ?>" class="btn delete delete-btn"><i class='bx bxs-trash-alt'></i></a>
                                                    
                                                </td>
                                            </tr>

                                            <?php } } else { ?>
                                            <tr>
                                                <td colspan="7" ><p class="nodata">ไม่มีข้อมูล<p></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table >
                       
                                    
                                </div>
                            </div>

                            
                </div>
            </div>

    </div>
</div>
    


    </div>
</div>
      
        








    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
          


        <script>

        $(".delete-btn").click(function(e) {
            var foodId = $(this).data('id');
            e.preventDefault();
            deleteConfirm(foodId);
        })

        function deleteConfirm(foodId) {
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
                                url: '00food.php',
                                type: 'GET',
                                data: 'del_food=' + foodId,
                            })
                            .done(function() {
                                Swal.fire({
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = '00food.php';
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

  

        $(".status-btn").click(function(e) {
            var statusfoodId = $(this).data('id');
            e.preventDefault();
            deleteConfirm(statusfoodId);
        })

        function deleteConfirm(statusfoodId) {
            Swal.fire({
                icon: 'question',
                text: "แก้ไขสถานะเมนูอาหาร",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ไม่พร้อมให้บริการ',
                cancelButtonText: 'พร้อมให้บริการ',
                showLoaderOnConfirm: true,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: '00food.php',
                                type: 'GET',
                                data: 'status_food=' + statusfoodId,
                            })
                            .done(function() {
                                Swal.fire({
                                    text: 'แก้ไขสถานะเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = '00food.php';
                                })
                            })
                            .fail(function() {
                                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                                window.location.reload();
                            });
                    });
                } else if (result.isDismissed) {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: '00food.php',
                                type: 'GET',
                                data: 'status0_food=' + statusfoodId,
                            })
                            .done(function() {
                                Swal.fire({
                                    text: 'แก้ไขสถานะเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = '00food.php';
                                })
                            })
                            .fail(function() {
                                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                                window.location.reload();
                            });
                    });
                }
                })

        }



        // When the user clicks on div, open the popup
        function myFunctionpopup() {
        var popup = document.getElementById("myPopup");
        popup.classList.toggle("show");
        }

  

        

       
   
            var modal = document.getElementById("myModal");   
            var btn = document.getElementById("myBtn");  // Get the button that opens the modal       
            var span = document.getElementsByClassName("close1")[0];  // Get the <span> element that closes the modal       
            btn.onclick = function() {   // When the user clicks the button, open the modal 
            modal.style.display = "block";
            }
            span.onclick = function() {   // When the user clicks on <span> (x), close the modal 
            modal.style.display = "none";
            }
            window.onclick = function(event2) {   // When the user clicks anywhere outside of the modal, close it
            if (event2.target == modal) {
                modal.style.display = "none";
            }
            }
        
        


    






  let sidebar = document.querySelector(".sidebar");
  let closeBtn = document.querySelector("#btn");
  let searchBtn = document.querySelector(".bx-search");

  closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange();//calling the function(optional)
  });

  searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
    sidebar.classList.toggle("open");
    menuBtnChange(); //calling the function(optional)
  });

  // following are the code to change sidebar button(optional)
  function menuBtnChange() {
   if(sidebar.classList.contains("open")){
     closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
   }else {
     closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
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