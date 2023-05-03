<?php  
include 'connect.php'; 
include_once('function.php');



session_start();
unset($_SESSION["table"]);
/*
print_r($_SESSION['name_login']) ;
print_r($_SESSION['status_login']) ; 
*/
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






include_once('function.php');
$insertdata = new DB_con();


if (isset($_POST['insert'])) {
    $status="0";
    $date_time = date("Y-m-d h:i:sa"); 
    $number=$_POST['txtnumber'];
    
    $sql = $insertdata->insert($status,$date_time,$number);

    if ($sql) {
        echo "<script>alert('เพิ่มโต๊ะอาหารเรียบร้อยแล้ว!!');</script>";
        echo "<script>window.location.href='00tablenumber_edit.php'</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มโต๊ะอาหาร');</script>";
        echo "<script>window.location.href='00tablenumber_edit.php'</script>";
    }
}

if (isset($_GET['table'])) {
    $table_id  = mysqli_real_escape_string($connect,$_GET['table']);
    $sql = $insertdata->status_01($table_id);  
    $_SESSION["table"] = $_GET['table'];


    $query = mysqli_query($connect, "SELECT * FROM cart_item WHERE table_id=$table_id");
    $cart = mysqli_num_rows($query);
    if ($cart > 0) {
        echo "<script>window.location.href='00order_list.php'</script>";     
    }else{
        echo "<script>window.location.href='00home2.php'</script>";     
    }
    
}

if (isset($_GET['table'])) {

    $table_id  = mysqli_real_escape_string($connect,$_GET['table']);
    $sql = $insertdata->status_01($table_id);

    $_SESSION["table"] = $_GET['table'];
   

   echo "<script>window.location.href='00home2.php'</script>";     
}


if (isset($_GET['del'])) {
    $_SESSION['table_id'] = $_GET['del'];  

    $table_id = $_SESSION['table_id'];

    $deleterecord = mysqli_query($connect,"DELETE FROM table_number WHERE table_id ='$table_id' ");
   /* $deleterecord = mysqli_query($connect, "DELETE FROM `table_number` WHERE table_id = '$table_id'");*/

    if ($deleterecord) {
        echo "<script>alert('ลบข้อมูลเรียบร้อยแล้ว!');</script>";
        echo "<script>window.location.href='00tablenumber_edit.php'</script>";
    }else{
        echo "<script>alert('เกิดผิดพลาด!');</script>";
        echo "<script>window.location.href='00tablenumber_edit.php'</script>";
    }
}

if(isset($_GET['edit'])){
   
}

if (isset($_GET['user'])) {

    session_destroy();
    echo "<script>alert('คุณได้ทำการออกจากระบบเรียบร้อยแล้ว!');</script>";
    header('Refresh:0; url=00login.php');


    /*
    if ($sql) {
        echo "<script>alert('คุณได้ทำการออกจากระบบเรียบร้อยแล้ว!');</script>";
        header('Refresh:0; url=00login.php');
       // echo "<script>window.location.href='00login.php'</script>";
    }*/
}








?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โต๊ะอาหาร</title>
    <link rel="stylesheet"href="wcss/tablenumber.css">
    <link rel="stylesheet"href="wcss/navber.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    <p><?php echo $row['user_name']. "<br>( " .$rowuser_type['user_type']. " )" ; ?></p>
                    <button class="dark" onclick="myFunction()"><span class="material-icons"><span class="material-icons">settings_brightness</span></button>
                </div>
                <div class="modal-body">
                        <a class="a"  type="submit" href="00tablenumber.php?exit"  >
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
    
    <div class="content_edit">
        <ul class="breadcrumb">
                <li><a href="00tablenumber.php">หน้าหลัก</a></li>
                <li>ข้อมูลโต๊ะอาหาร</li>
        </ul>  
        <div class="boxtable_edit">
             <div class="danger_edit">
                ข้อมูลโต๊ะอาหาร
            </div>
            <div class="add_edit">
                <button type="submit" onclick="modal()" id="myBtn"><i class='bx bx-plus' style="font-size: 14px;" ></i></button>
            </div>
            <table id="example" class="display"  >
                <thead>
                    <tr>
                        <th style="width:10%; text-align:center ;">รหัสโต๊ะอาหาร</th> 
                        <th style="width:8%; text-align:center ;">สถานะโต๊ะ</th>
                        <th style="text-align:center ;">วันที่เพิ่มข้อมูล</th>
                        <th style="text-align:center ;">หมายเลขโต๊ะอาหาร</th>
                        <th style="width:10%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sqltable_number = mysqli_query($connect , "SELECT * FROM table_number");
                        $numtable_number =  mysqli_num_rows($sqltable_number);

                        if($numtable_number >0 ){
                            while ($row = mysqli_fetch_assoc($sqltable_number)){

                                if($row['status']==0){
                                    $textstatus = "<p style='color:#0984e3;'>ว่าง<p>";
                                }else{
                                    $textstatus = "<p style='color:#d63031;'>มีลูกค้า<p>";
                                }
                    ?>
                    <tr>
                        <td style="text-align:center ;"><?php echo  $row['table_id'] ;?></td> 
                        <td style="text-align:center ;"><?php echo  $textstatus ;?></td> 
                        <td style="text-align:center ;"><?php echo  $row['date_added'] ; ?></td>
                        <td style="text-align:center ;"><?php echo $row['number'];?></td>
                        <td style="width:10%; text-align:center;">
                            <a class="btntd edit" href="tablenumber_edit.php?tablenumber_id=<?=$row["table_id"]?>" ><i class='bx bxs-edit-alt' ></i></a> 
                            <!-- <a id="edit" class="btntd edit" name="edit" href="00tablenumber_edit.php?tablenumber_id=<?=$row["table_id"]?>" ><i class='bx bxs-edit-alt' ></i></a> -->
                           <!-- <a class="btntd delete" name="del" type="submit" onclick="Del(this.href); return false;" href="00tablenumber_edit.php?del=<?php //echo $row['table_id']; ?>"><i class='bx bxs-trash-alt'></i></a>  -->  
                        </td>
                    </tr>

                    <?php   
                        }
                    } 
                    ?>
                <tbody>

            </table>
        </div>                   
    </div>




    <div class="A">
        <!--
        <div class="add" id="myBtn">
            <i class='bx bx-plus'></i>
        </div>    -->          
    </div>
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">           
                    <p>เพิ่มจำนวนโต๊ะ</p>
                    <span class="close">&times;</span>
                </div>
                <!-- <span class="close">&times;</span>
                <h1 class="modal-header">ข้อมูลหลัก</h1> -->
                <div class="modal-body">
                <p> 
                    
                    <form action="#" method="post"enctype="multipart/form-data">
                        <div class="modalLR">

                        <label class=""for="lname">รหัสโต๊ะ :</label>
                        <input class="form-control" type="text" placeholder="อัตโนมัติ" aria-label="Disabled input example" disabled >
                        <input type="hidden" class="form-control" type="text" placeholder="อัตโนมัติ" aria-label="Disabled input example" disabled >

                        <label>เลขโต๊ะ :</label>
                        <input type="text" name="txtnumber" placeholder="เลขโต๊ะ"  >
                                
                        </div> 
                        <div class="sub">
                            <input class="modal-footer" name="insert" type="submit" value="เพิ่มจำนวนโต๊ะ">
                            <input class="modal-footer" type="submit" value="ยกเลิก">
                        </div>
                       
                    </form>         
                </p>                  
            </div>
        </div>
    </div>


  

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>



       

    
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
        modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        }


        var myModaledit = document.getElementById("myModaledit");

        // Get the button that opens the modal
        var edit = document.getElementById("edit");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        edit.onclick = function() {
            myModaledit.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            myModaledit.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
        if (event.target == myModaledit) {
            myModaledit.style.display = "none";
        }
        }


       




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