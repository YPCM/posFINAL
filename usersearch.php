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



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลพนักงาน-ค้นหาข้อมูล</title>
    <link rel="stylesheet"href="wcss/user.css">
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
                    <p><?php echo $rowuser_type['user_type']?></p>
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
    <div class="box">
        <ul class="breadcrumb">
                <li><a href="00user.php">ข้อมูลผู้ใช้ระบบ</a></li>
                <li>ค้นหาข้อมูลพนักงาน</li>
            </ul>  
        <div class="boxuser">
        <div class="danger">
                ค้นหาข้อมูลพนักงาน
            </div>
            <div class="tapSS">
                <form class="tapo" action="<?=$_SERVER['PHP_SELF'];?>" method="post" >
                    <input type="text" id="fname" name="search" placeholder="ชื่อผู้ใช้ ">
                    <button type="submit" name="button" id="button" ><span class="material-icons">search</span></button>
                </form>
            </div> 
            <table>
                <tr>
                 <!-- <th style="width:3% ; text-align: center;"><input type="checkbox" class="form-check-input" id="select_all"></th> -->
                    <th style="width:3%; text-align:center;">#</th>
                    <th style="width:10%;" >รหัสผู้ใช้</th>
                    <!-- <th  style="width:5% ; text-align: center;">รูป</th> --> 
                    <th style="width:20%;">ชื่อผู้ใช้</th>
                    <th style="width:10%;">ประเภทผู้ใช้งาน</th>
                    <th style="width:10%;">เบอร์โทรศัพท์</th>
                    <th style="width:20%;">วันที่เพิ่มบัญชี</th>
                    <th style="width:10%" ></th>
                </tr>
                
                    <?php
                        isset( $_POST['search'] ) ? $search = $_POST['search'] : $search = "";
                        $num = 0 ;
                        if( !empty( $search ) ) {
                            $sql = "SELECT * FROM `user` WHERE `user_name` LIKE '%$search%' or  `phone` LIKE '%$search%' ";
                            $numrow = mysqli_query( $connect, $sql );


                            while($rowsearch = mysqli_fetch_assoc($numrow) ) {
                                $num = $num + 1 ;
                    ?>

                <tr>
                    <td style="text-align:center;"><?php echo $num ?></td>
                    <td><?php echo $rowsearch['user_id'] ?></td>
                    <td><?php echo $rowsearch['user_name'] ?></td>
                    <?php 
                            if($row["id_user_type"]==1){        
                        ?>
                            <td>เจ้าของร้าน</td>
                        <?php }else{ ?>
                            <td>พนักงาน</td>
                        <?php } ?>
                    <td><?php echo $rowsearch["phone"];?></td>
                    <td><?php echo $rowsearch["date_added"];?></td>
                    <td class=btnA style=" text-align:center;"> 
                        <a  class="btntd edit" name="edit" href="useredit.php?user_id=<?=$row["user_id"]?>" ><i class='bx bxs-edit-alt' ></i></a> 
                        <a class="btntd delete" name="del_user" type="submit" onclick="Del(this.href); return false;" href="00user.php?del_user=<?php echo $row['user_id']; ?>"><i class='bx bxs-trash-alt'></i></a> 
                    </td>
                </tr>
                <?php  }
                    mysqli_close( $connect );
                    }else{
                ?>
                <tr>
                    <td colspan="8" ><p class="nodata">ไม่มีข้อมูล<p></td>
                </tr>
                <?php } ?>
              </table>
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

    </script>
</body>
</html>