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


if (isset($_POST['adduser'])) {

    $txtnameuser = $_POST['txtnameuser'];
    $txtpassword = password_hash($_POST['txtpassword'],PASSWORD_BCRYPT);
    $type = $_POST['type'];
    $txtphone = $_POST['txtphone'];
    
        $sql_insert="INSERT INTO user(user_name,password,phone,	id_user_type,date_added)
        VALUES('$txtnameuser','$txtpassword','$txtphone','$type','$date_time')";
    
        $result=mysqli_query($connect,$sql_insert);
        if($result){
        echo"<script> alert('บันทึกข้อมูลผู้ใช้เรียบร้อย') ; </script> " ;
        echo"<script> window.location='00user.php' ; </script>";
        }else{
        echo"<script> alert('ไม่สามารถบันทึกข้อมูลได้') ; </script>" ;
        }   

}

if (isset($_GET['del_user'])) {
    $user_id = $_GET['del_user'];
    $deletedata = new DB_con();
    $sql = $deletedata->delete_user($user_id);

    if ($sql) {
        echo "<script>alert('Record Deleted Successfully!');</script>";
        echo "<script>window.location.href='00user.php'</script>";
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลพนักงาน</title>
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
                                                <span class="links_name">ข้อมูลผู้ใช้งาน</span> 
                                            </a>
                                        </div>
                                    </div>
                                
                            <div>
                               
                        </div>     
                   </div>
    </div>
    <div class="box">
        <div class="boxuser">
                        <div class="danger">
                            ข้อมูลบัญชีผู้ใช้
                        </div>
                        
                        <div class="tapS">
                            <!--
                            <form class="tap"action="/action_page.php" >
                                <input type="text" id="fname" name="firstname" placeholder="รหัสผู้ใช้ | เบอร์โทร" >
                            </form>
                            -->
                            <div class="tap">
                                <form class="search"  method="post" action="usersearch.php" >
                                    <button name="search_user" class="search" type="submit" ><p>ค้นหาบัญชีผู้ใช้</p><span class="material-icons" style="font-size: 14px;">search</span></button>
                                </form>
                                <div class="add">
                                    <button type="submit" onclick="modal()" id="myBtn"><i class='bx bx-plus' style="font-size: 14px;" ></i></button>
                                </div>
                            </div>
                        </div> 
                                        <?php
                                                $sql_total = " SELECT * FROM user ";
                                                $q = mysqli_query($connect,$sql_total );
                                                $num = mysqli_num_rows($q);
                                    
                                            
                                        ?>  
                        <div class="listtotal">
                            <?php echo $num."&nbspรายการ"?>
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
                                    $num = 0 ;
                                    $query = mysqli_query($connect,"SELECT*FROM user");
                                    $totalcnt = mysqli_num_rows($query);
                                    if ($totalcnt > 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            $num = $num + 1 ;
                                ?>
                            <tr>
                                <!-- <td style="text-align: center; "><input type="checkbox" class="checkbox" id="vehicle1" name="ids[]" value=<?php echo $row ['user_id']?>></td> -->
                                <td style="text-align:center;"><?php echo $num ;?></td>
                                <td><?php echo $row["user_id"];?></td>
                            <!--  <td class="pic" style="text-align: center;"><i class='bx bxl-github'></i></td> -->
                                <td><?php echo $row["user_name"];?></td>
                                    <?php 
                                        if($row["id_user_type"]==1){        
                                    ?>
                                        <td>เจ้าของร้าน</td>
                                    <?php }else{ ?>
                                        <td>พนักงาน</td>
                                    <?php } ?>
                                    
                                <td><?php echo $row["phone"];?></td>
                                    <?php 
                                        if($row["useredit"]==0){        
                                    ?>
                                        <td><?php echo $row["date_added"];?></td>
                                    <?php }else{ ?>
                                        <td><?php echo $row["date_added"]." &nbsp &nbsp &nbsp"."[ แก้ไขล่าสุด ]";?></td>
                                    <?php } ?>

                                <td class=btnA style=" text-align:center;"> 
                                    <a  class="btntd edit" name="edit" href="useredit.php?user_id=<?=$row["user_id"]?>" ><i class='bx bxs-edit-alt' ></i></a> 
                                    <a data-id="<?=$row["user_id"]?>" href="?del_user=<?=$row["user_id"]?>" class="btntd delete delete-btn"><i class='bx bxs-trash-alt'></i></a>

                                   <!-- <a class="btntd delete" name="del_user" type="submit" onclick="Del(this.href); return false;" href="00user.php?del_user=<?php //echo $row['user_id']; ?>"><i class='bx bxs-trash-alt'></i></a> -->
                                </td>
                            </tr>
                            <?php } } else { ?>
                            <tr>
                                <td colspan="8" ><p class="nodata">ไม่มีข้อมูล<p></td>
                            </tr>
                            <?php } ?>

                        </table>        
              
        </div>

   

        <div class="boxuser">
            <div class="danger">
                ประวัติการเข้าใช้ระบบ
            </div>
            <div class="tapS">
                    <div class="tap">
                        <form class="search"action="usersearchhistory.php" >
                            <button class="search" name="search_history" type="submit" ><p>ค้นหาบัญชีผู้ใช้</p><span class="material-icons" style="font-size: 14px;">search</span></button>
                        </form>
                    </div>
            </div> 
            <div class="ttt">
            <table id="example" class="display"  >
                <thead>
                    <tr>
                        <!-- <th style="width:3%; text-align:center ;">#</th> -->
                        <th  style="width:8%;">ชื่อผู้ใช้</th>
                        <th style="text-align:center ;width:15%">ประเภทผู้ใช้งาน</th>
                        <th>วันที่-เวลาเข้าระบบ</th>
                        <th>วันที่-เวลาออกระบบ</th>
                        <th style="width:10%;" >อุปกรณ์</th>
                    </tr>
                </thead>
                <tbody  >
                    <?php 
                        $sqluserhistory = mysqli_query($connect , "SELECT * FROM history_in_out ORDER BY id_history_in_out  DESC");
                        $numuserhistory =  mysqli_num_rows($sqluserhistory);
                        $num = 0 ;

                        if($numuserhistory >0 ){
                            while ($row = mysqli_fetch_assoc($sqluserhistory)){
                                $num = $num + 1 ;

                                $user_id = $row['user_id'];
                                $sqli_user= mysqli_query($connect , "SELECT * FROM user WHERE user_id = '$user_id' ");
                                $row00 = mysqli_fetch_assoc($sqli_user)
                    ?>
                    <tr>
                        <!-- <td style="text-align:center ;"><?php //echo $num ;?></td> -->
                        <td style="font-weight: bold ;"><?php echo $row00['user_name'];?></td>
                            <?php              
                                if($row00['id_user_type']==1){
                                    $user_type = "เจ้าของร้าน" ;
                                }elseif($row00['id_user_type']==2){
                                    $user_type = "พนักงาน" ;
                                }
                            ?>
                        <td style="text-align:center ;"><?php echo $user_type ; ?></td>
                        <td><?php echo $row['date_time_check-in'];?></td>
                        <td><?php echo $row['date_time_check-out'];?></td>
                        <?php 
                            if($row['device']="computer"){
                                echo '<td><i class="bx bx-laptop"></i>&nbsp computer</td>';
                            }elseif($row['device']="Mobile"){
                                echo '<td><i class="bx bx-laptop"></i>&nbsp Mobile</td>';
                            }elseif($row['device']="Tablet"){
                                echo '<td><i class="bx bx-laptop"></i> &nbsp Tablet</td>';
                            }
                        ?>
                    </tr>

                    <?php   
                        }
                    } 
                    ?>
                <tbody>

            </table>

            </div>
           
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
                            <p>เพิ่มข้อมูลผู้ใช้ระบบ</p>
                            <span class="close1">&times;</span>
                        </div>
                        <!-- <span class="close">&times;</span>
                        <h1 class="modal-header">ข้อมูลหลัก</h1> -->
                        <div class="modal-body">
                        <p> 
                            
                            <form action="#" method="post"enctype="multipart/form-data">
                    
                                    <div class="modalLR">
                                   
                                            <div class="head">
                                                <p>บัญชีผู้ใช้</p>                     
                                            </div>

                                            <label>ชื่อผู้ใช้ :</label>
                                            <input type="text" name="txtnameuser" placeholder="ชื่อผู้ใช้"  >
                                            
                                            <label>รหัสผ่านผู้ใช้ :</label>
                                            <input type="password" name="txtpassword" class="form-control" id="inputPassword">
                                        
                                            <label>ประเภทของผู้ใช้ระบบ :</label>
                                            <select id="type" name="type" required>
                                                    <option value="01" >เจ้าของร้าน</option>
                                                    <option value="02" >พนักงาน</option>
                                            </select>
                                                                            
                                            <div class="head">
                                                <p>ข้อมูลส่วนตัว</p>                     
                                            </div>

                                            <label>เบอร์โทรศัพท์ :</label>
                                            <input type="text" name="txtphone" placeholder="เบอร์โทรศัพท์"  >
                                            
                                            <label class=""for="lname">รหัสผู้ใช้ :</label>
                                            <input class="form-control" type="text" placeholder="อัตโนมัติ" aria-label="Disabled input example" disabled name="food_menu_code">
                                  
                                    
                                   
                                </div> 
                            

                                <input class="modal-footer" name= "adduser"  type="submit" value="เพิ่มบัญชีผู้ใช้">
                            
                            </form>         
                        </p>                  
                    </div>
                </div>
            </div>

    
           


            <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>     
 
    <script>

    $(".delete-btn").click(function(e) {
            var userId = $(this).data('id');
            e.preventDefault();
            deleteConfirm(userId);
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
                                url: '00user.php',
                                type: 'GET',
                                data: 'del_food=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = '00user.php';
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




        function openCity(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        }
        let sutMenu = document.getElementById("subMenu");
            function  toggleMenu(){
            sutMenu.classList.toggle("open-menu")
            }
            window.onclick = function(event) {
            if (event.target == sutMenu) {
            sutMenu.style.display = "none";
            }
        }


        function  modal() {
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
        }

        function Del(mypage){
            var agree=confirm("คุณต้องการลบข้อมูลหรือไม่");
            if(agree){
                window.location=mypage;
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