
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





if(isset($_POST['updatetable'])){

    if($_POST['txttable_id'=='']){
        echo "<script type='text/javascript'>"; 
        echo "alert('กรุณาลองใหม่อีกครั้ง');"; 
        echo "window.location = 'tablenumber_edit.php'; "; 
        echo "</script>"; 
    }else{
        $number = $_POST["number"];
        $table_id = $_POST['txttable_id'];

        $sql = "UPDATE table_number SET  
       	number ='$number ' 
        WHERE table_id='$table_id' ";

        $result = mysqli_query($connect, $sql) or die ("Error in query: $sql " . mysqli_error());
        mysqli_close($connect);


        if($result){
            echo "<script type='text/javascript'>";
            echo "alert('บันทึกการแก้ไขข้อมูลเรียบร้อยแล้ว');";
            echo "window.location = '00tablenumber_edit.php'; ";
            echo "</script>";
            }
            else{
            echo "<script type='text/javascript'>";
            echo "alert('เกิดข้อมูลผิดพลาดในการแก้ำขข้อมูลกรุณาลองอีกครั้ง');";
            echo "window.location = 'tablenumber_edit.php'; ";
            echo "</script>";

        }
    }
}

if(isset($_GET["tablenumber_id"])==''){ 
    echo "<script type='text/javascript'>"; 
    echo "alert('กรุณาลองอีกครั้ง!!');"; 
    echo "window.location = '00tablenumber_edit.php'; "; 
    echo "</script>"; 
}

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เมนูอาหาร</title>
    <link rel="stylesheet"href="wcss/useredit.css">
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

                                    <div class="menubox">
                                        <div class="b4"></div>
                                        <div class="a4">
                                            <a href="00dash.php">
                                                <i class='bx bx-pie-chart-alt-2'></i>
                                                <span class="links_name">Dashboard</span>
                                            </a>
                                        </div>
                                    </div>
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

   
          <div class="hhl">
            <div class="contentedit">
            <ul class="breadcrumb">
                <li><a href="00tablenumber.php">หน้าหลัก</a></li>
                <li><a href="00tablenumber_edit.php">ข้อมูลโต๊ะอาหาร</a></li>
                <li>แก้ไขข้อมูลโต๊ะอาหาร</li>
            </ul>  
                <div class="text" style="margin-top: 20px;">
                    <div class="Stockfood">แก้ไขข้อมูลโต๊ะอาหาร<i class='bx bxs-edit-alt' ></i></div>
                </div>
                <div class="text2">
                    <div class="text3">
                        <?php        
                            $tablenumber_id = mysqli_real_escape_string($connect,$_GET['tablenumber_id']);
                            $sql = "SELECT * FROM table_number WHERE table_id ='$tablenumber_id' ";
                            $result = mysqli_query($connect, $sql) or die ("Error in query: $sql " . mysqli_error());
                            $row = mysqli_fetch_array($result);
                            
                            extract($row);
                        ?>
                        <form class="formedit "action="#" method="post"enctype="multipart/form-data">
                                        <div class="T">
                                            <label class="codeedit"for="lname" name="table_id" >รหัสโต๊ะอาหาร :<p><?php echo $row["table_id"];?></p></label>  
                                        </div>
                                      
                                        <label>หมายเลขโต๊ะอาหาร :</label>
                                        <input type="text" name="number"  value=<?=$row['number']?> >
                                        
                                        <input class="none" type="text" name="txttable_id" required value=<?=$row['table_id']?> > 
                                        <input class="modal-footer" name="updatetable" type="submit" value="แก้ไขข้อมูล" name="Update" id="Update">
                                                
                        </form>  
                    </div>
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