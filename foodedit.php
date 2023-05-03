
<?php  

include 'connect.php';
/*
$food_menu_code=$_GET['food_menu_code'];
$sql="SELECT * from food_item where food_menu_code='$food_menu_code' ";
$result=mysqli_query($connect,$sql);
$row=mysqli_fecth_array($result);
*/

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



if(isset($_GET["food_menu_code"])==''){ 
    echo "<script type='text/javascript'>"; 
    echo "alert('Error Contact Admin !!');"; 
    echo "window.location = '00food.php'; "; 
    echo "</script>"; 
}

if(isset($_POST['updatefood'])){
    if($_POST["txtfoodcode"]==''){
        echo "<script type='text/javascript'>"; 
        echo "alert('กรุณาลองใหม่อีกครั้ง !!');"; 
        echo "window.location = 'foodedit.php'; "; 
        echo "</script>";
    }else{
        $food_menu_code = $_POST["txtfoodcode"];
        $food_menu_name = $_POST["txtmenu"];

        $img_food = $_FILES['img_food']['tmp_name'] ;

 
       /* $amount_food = $_POST["txtamount"];*/
        /*$capital_price_food = $_POST["txtcapital_price"];*/
        $selling_price_food = $_POST["txtselling_price"];	

        $img2 = $_POST['img2']; //ของเก่า 
       
       
     
        
         
        if($img_food ==''){
            $new_image_name = $img2 ;
           // echo " รูปเก่า " ; 
        }else{
            if(is_uploaded_file($_FILES['img_food']['tmp_name'])){
                $new_image_name = 'pr_'.uniqid().".".pathinfo(basename($_FILES['img_food']['name']),PATHINFO_EXTENSION);
                $image_upload_path = "./imgfood/".$new_image_name;
                move_uploaded_file($_FILES['img_food']['tmp_name'],$image_upload_path);
            }else{
                $new_image_name="";
            }
            //echo "รูปใหม่" ;
        }



       $sql = "UPDATE food_item SET  
			food_menu_name ='$food_menu_name ' ,
            img='$new_image_name',
			selling_price_food='$selling_price_food'  
			WHERE food_menu_code='$food_menu_code' ";
 

        $result = mysqli_query($connect, $sql) or die ("Error in query: $sql " . mysqli_error());
        mysqli_close($connect);

        if($result){
            echo "<script type='text/javascript'>";
            echo "alert('แก้ไขข้อมูลเมนูอาหารเรียบร้อยแล้ว');";
            echo "window.location = '00food.php'; ";
            echo "</script>";
            }
            else{
            echo "<script type='text/javascript'>";
            echo "alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');";
            echo "window.location = 'foodedit.php'; ";
            echo "</script>";
        }

    }
}


?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เมนูอาหาร</title>
    <link rel="stylesheet"href="wcss/foodedit.css">
    <link rel="stylesheet"href="wcss/navber.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">

   
</head>
<body>

<div class="navber">
        <div class="he">
            <p>ร้านก๊วยจั๊บกำลังภายใน</p>
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

        <button class="myBtn2" id="myBtn10" onclick="myFunctionmyBtn()">
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
                        <a class="a"  type="submit" href="00user.php?exit"  >
                            <span class="material-icons">logout</span>
                            <p>ออกจากระบบ</p>
                            <i class='bx bx-chevron-right'></i>
                        </a>
                </div>
            </div>
        </div>

    </div><!-- end navber -->

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
   
          

            <div class="contentedit">
                <ul class="breadcrumb">
                    <li><a href="00food.php">เมนูอาหาร</a></li>
                    <li>แก้ไขเมนูอาหาร</li>
                </ul>  
                <div class="text" style="margin-top: 20px;">
                    <div class="Stockfood">แก้ไขเมนูอาหาร<i class='bx bxs-edit-alt' ></i></div>
                </div>
                <div class="text2">
                    <div class="text3">
                        <?php        
                            $food_menu_code = mysqli_real_escape_string($connect,$_GET['food_menu_code']);
                            $sql = "SELECT * FROM food_item WHERE food_menu_code='$food_menu_code' ";
                            $result = mysqli_query($connect, $sql) or die ("Error in query: $sql " . mysqli_error());
                            $row = mysqli_fetch_array($result);
                            
                            extract($row);
                        ?>
                        <form class="formedit "action="#" method="post"enctype="multipart/form-data">
                                        <div class="T">
                                            <label class="codeedit"for="lname" name="food_menu_code" >รหัสสินค้า :<p><?php echo $row["food_menu_code"];?></p></label>  
                                            <label class="codeedit"for="lname">หมวดหมู่ : <p><?php echo $row["category_food"];?></p></label> 
                                        </div>
                                      
                                        <label>ชื่อ :</label>
                                        <input type="text" name="txtmenu"  value=<?=$row['food_menu_name']?> >
                                        
                                        <label>ภาพสินค้า :</label>
                                        <input class="form-control form-control-lg" type="file" name="img_food" value=<?=$row['img'] ?> >
                                        <input type="hidden" value="<?= $row['img']; ?>" required class="form-control" name="img2">

             
                                        <label>ราคาขาย :</label>
                                        <input type="text" name="txtselling_price"value=<?=$row['selling_price_food']?> >
                                    
                    
                                        <input class="none" type="text" name="txtfoodcode" required value=<?=$row['food_menu_code']?> > 
                                        <input class="modal-footer" name="updatefood"type="submit" value="แก้ไขข้อมูล" name="Update" id="Update">
                                                
                        </form>  
                    </div>
                </div>    
            </div>
           









        <script>
            let sutMenu = document.getElementById("subMenu");
                function  toggleMenu(){
                sutMenu.classList.toggle("open-menu")
                }
                window.onclick = function(event) {
                if (event.target == sutMenu) {
                sutMenu.style.display = "none";
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