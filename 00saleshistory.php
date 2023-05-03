<?php  include 'connect.php'; 
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

                             
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลพนักงาน</title>
    <link rel="stylesheet"href="wcss/saleshistory.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <div class="home-section">
        <!--  <div class="menubox">
                   <div class="menu0">
                       <div class="a1">w</div>
                       <div class="a1">w</div>
                       <div class="a1">w</div>
                       <div class="a1">w</div>
                   </div>--> 
                        <div class="menu">
                            <div class="menuboxtop"></div>   

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
    <div class="content">
        <div class="menuboxtop">
            <div class="shop-name">
                <p>ร้านก๊วยจั๊บกำลังภายใน</p>
            </div>
           <!-- <div class="search">
                <input class="form-search" type="text" placeholder="ชื่อเมนูอาหาร/รหัสเมนูอาหาร">
                <button class="btn-search"><i class='bx bx-search'></i></button>
            </div>
            -->
            <div class="total-sum">     
                    <a href="00order.php" class="button">
                        <span class="content"><i class='bx bxs-dish'></i></span>
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
                    <div class="profil-area"><!--sub-menu-wrap-->
                        <div class="profile"><!--sub-menu-->
                            <div class="profile-photo"><!--usr-into-->
                                <img src="https://i.pinimg.com/736x/36/7c/39/367c393354fecb4918b2bee5795ae290.jpg"  onclick="toggleMenu()">
                            </div>       
                            <div class="sub-menu-wrap" id="subMenu">
                                <div class="sub-menu">
                                    <div class="usr-into">
                                        <img src="https://i.pinimg.com/736x/36/7c/39/367c393354fecb4918b2bee5795ae290.jpg">
                                        <h4>ผู้ดูแล</h4>
                                    </div>
                                    <a href="#" class="sub-menu-link">
                                        <span class="material-icons">edit_square</span>
                                        <p>แก้ไขข้อมูลส่วนตัว</p>
                                        <i class='bx bx-chevron-right'></i>
                                    </a>
                                    <a href="#" class="sub-menu-link">
                                        <span class="material-icons">logout</span>
                                        <p>ออกจากระบบ</p>
                                        <i class='bx bx-chevron-right'></i>
                                    </a>
                            </div>                                    
                    </div>                              
                </div>
            </div>   
        </div>                   
    </div>


    

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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



    </script>
    
</body>
</html>