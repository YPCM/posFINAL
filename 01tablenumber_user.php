<?php  
include 'connect.php'; 

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
    $table_id=$_POST[''];
    $status=$_POST['0'];
    $date_added = date("Y-m-d");
    $number=$_POST['txtnumber'];
    
    $sql = $insertdata->insert($table_id,$status,$date_added,$number);

    if ($sql) {
        echo "<script>alert('เพิ่มโต๊ะอาหารเรียบร้อยแล้ว!!');</script>";
        echo "<script>window.location.href='01tablenumber_user.php'</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มโต๊ะอาหาร');</script>";
        echo "<script>window.location.href='01tablenumber_user.php'</script>";
    }
}


if (isset($_GET['table'])) {
  
    $_SESSION["table"] = $_GET['table'];
    $table_id = $_SESSION["table"] ;
   /* $table_id  = mysqli_real_escape_string($connect,$_GET['table']);*/

    $tttt = mysqli_query($connect, "SELECT * FROM `table_number` WHERE table_id='$table_id'");
    $cart = mysqli_fetch_array($tttt);
    $table_id = $cart['table_id'];
    $cart1 = $cart['status'];

   /* print_r($_SESSION["table"]); */
    /*$cart = mysqli_num_rows($order_code);*/
    if ($cart1 == 1) {
      /*  $table_id  = mysqli_real_escape_string($connect,$_GET['table']);
        $sql = $insertdata->status_01($table_id);  */


        $order_code = mysqli_query($connect, "SELECT MAX(order_code) as order_code FROM order_list WHERE table_id='$table_id'");
        $roworder_code = mysqli_fetch_array($order_code);
        
        $_SESSION["table_order_code"] = $roworder_code['order_code'];
        /*print_r($_SESSION["table_order_code"]);*/
       echo "<script>window.location.href='01order_list_user.php'</script>";    
    }else{
        echo "<script>window.location.href='01home2_user.php'</script>";     
    }
    
}

if (isset($_GET['table'])) {

    $table_id  = mysqli_real_escape_string($connect,$_GET['table']);
    $sql = $insertdata->status_01($table_id);

    $_SESSION["table"] = $_GET['table'];
   

   echo "<script>window.location.href='01home2_user.php'</script>";     
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
    <title>หน้าหลัก</title>
    <link rel="stylesheet"href="wcss/tablenumber.css">
    <link rel="stylesheet"href="wcss/navber.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <div class="navber">
        <div class="he">
            <a style="color: #fff; text-decoration: none;" href="01tablenumber_user.php">ร้านก๊วยจั๊บกำลังภายใน</a>
        </div>

        <a href="01order_user.php" class="button">
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
                    <i class='bx bxs-cool'></i>
                    <!-- <img src="https://i.pinimg.com/736x/36/7c/39/367c393354fecb4918b2bee5795ae290.jpg" > -->
                    </div>  
        </button>


        <div  id="id01" class="modalid01">
            <div class="modal__content">
                <div class="modal-header">
                    <p><?php echo $row['user_name']. "( " .$rowuser_type['user_type']. " )" ; ?></p>
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
                                            <a href="01tablenumber_user.php">
                                                <i class='bx bx-store' ></i>
                                                <span class="links_name">หน้าหลัก</span>
                                            </a>
                                        </div>
                                    </div>


                            <div>
                               
                        </div>     
                   </div>
    </div>
    <div class="content">
    <div class="boxtable">
                <div class="table">
                    <p>เลือกโต๊ะก่อนสั่งเมนูอาหาร</p>
                </div>
            </div> 
            <div class="boxtable4">
                <p>สีฟ้า = โต๊ะว่าง , สีเหลือง = มีลูกค้า</p>
            </div>

    <div class="box">
        <div class="boxuser">
            
            <?php /*
            echo rand()."<br>";
            echo rand()."<br>";
            echo rand()."<br>";
            echo rand()."<br>";
            echo sprintf("%10d",rand(0,9999999999))."<br>";
            echo sprintf("%10d",rand(0,9999999999))."<br>";
            echo sprintf("%10d",rand(0,9999999999))."<br>"; */
            ?>
           <!-- <div class="boxtable4">
                <p>สีฟ้า = โต๊ะว่าง , สีเหลือง = มีลูกค้า</p>
           </div> --> 

            <div class="boxtable3">                            
                <div class="boxtable2">
                <?php 
                    include_once('function.php');
                    $fetchdata = new DB_con();
                    $sql = $fetchdata->fetchdata();
                    while($row = mysqli_fetch_array($sql)) {
                ?>
                    <?php
                       /* if($row['status']==1){                    
                            echo    '<div class="ta yes ">
                                        <a name="del" type="submit" name="table" href="01tablenumber_user.php?table='.$row['table_id'].' ">'.$row['number'].'</a>
                                    </div>';
                        }else{
                            echo    '<div class="ta no">
                                        <a name="del" type="submit" name="table"href="01tablenumber_user.php?table='.$row['table_id'].' ">'.$row['number'].'</a>
                                    </div>';
                        }*/
                        if($row['status']==1){                    
                            echo    '<div class="ta yes ">
                                      
                                        <a name="del" type="submit" name="table" href="01tablenumber_user.php?table='.$row['table_id'].' ">'.$row['number'].'</a>
                                    </div>';
                        }elseif($row['status']==0){ 
                            echo    '<div class="ta no">
                                       
                                        <a name="del" type="submit" name="table"href="01tablenumber_user.php?table='.$row['table_id'].' ">'.$row['number'].'</a>
                                    </div>';
                        }elseif($row['status']==2){ 
                            echo    '<div class="ta off" style="background-color: #000000;display: none;">
                                       
                                        <a style="text-decoration: none;color: #fff;" name="del" type="submit" name="table" href="01tablenumber_user.php?table='.$row['table_id'].' ">'.$row['number'].'</a>
                                    </div>';
                        }
                    ?>
                   <!-- <div class="ta">
                        <div class="live"><a class="tabledel" name="del" type="submit" href="00tablenumber.php?del=<?php echo $row['table_id']; ?>">ลบ</a></div>
                        <a><?php /*echo $row['table_id'];*/ ?></a>
                    </div>
                    -->
                <?php } ?>

                </div>
            </div>
             
        </div>
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