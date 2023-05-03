<?php
session_start();
/*
print_r($_SESSION['name_login']) ;
print_r($_SESSION['status_login']) ; 
*/
include 'connect.php';

if(isset($_POST["login"]))  
{  
     if(empty($_POST["username"]) || empty($_POST["password"]))  
     {  
          echo '<script>alert("Both Fields are required")</script>';  
     }  
     else  
     {  
          $username = mysqli_real_escape_string($connect, $_POST["username"]);  
          $password = mysqli_real_escape_string($connect, $_POST["password"]);  
          $query = "SELECT * FROM user WHERE user_name = '$username' ";  
          $result = mysqli_query($connect, $query);  
          if(mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_array($result)){ 
                $validPassword = password_verify($password,$row['password']);
                    if($validPassword)
                    {  
                        $name = $row['user_name'];
                        $status = $row['id_user_type'];
                        $iduser = $row['user_id'];



                        require_once 'Mobile_Detect.php';
                        $detect = new Mobile_Detect;
                        $is_device="computer";
                        if ( $detect->isMobile() ) {
                            $is_device="Mobile";
                        }
                        if( $detect->isTablet() ){
                            $is_device="Tablet";
                        }


                        $sqlhistory = mysqli_query($connect, "INSERT INTO `history_in_out`(`id_history_in_out`, `user_id`, `date_time_check-in`, `date_time_check-out`, `device`) 
                                                                VALUES ('','$iduser','$date_time','',' $is_device')") 
                        or die('query failed sql');
                        

                        if($status==1){
                            $_SESSION['name_login'] = $name ;
                            $_SESSION['status_login'] = $status ;
                            $_SESSION['user_id'] = $iduser ;

                         /*   $cookiename = htmlentities($_POST['username']);

                            setcookie('cookiename',$cookiename,time()+3600); // 1 ชม.*/
                            header("location:00tablenumber.php"); 

                        }elseif($status==2){
                            $_SESSION['name_login'] = $name ;
                            $_SESSION['status_login'] = $status ;
                            $_SESSION['user_id'] = $iduser ;
                            header("location:01tablenumber_user.php"); 

                        }
                        



                        


                  
                        //return true; 
                        /* 
                        $_SESSION["username"] = $username;  

                        header("location:00tablenumber.php");   
                        */      
                    }  
                    else  
                    {  
                         //return false;  
                         echo '<script>alert("เกิดข้อผิดพลาดในการ login!!!")</script>';  
                    }  


                    
               }  
          }  
          else  
          {  
               echo '<script>alert("vvvvvv")</script>';  
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
    <title>LOGIN</title>
    <link rel="stylesheet"href="wcss/login.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
</head>
<body>
    <div class="box">
        <div class="boxx">
            <div class="head">
                <p class="Lo"><h1>Login</h1></p>
                <p class="sys"><strong></strong>ระบบร้านก๊วยจั๊บกำลังภายใน</p>
            </div>
            <form action="#" method="post">      
                  <!-- <label for="email"><b>Username</b></label> -->
                  <input type="text" placeholder="Username *" name="username" required>
              
                  <!-- <label for="psw"><b>Password</b></label> -->
                    <div class="pass">
                        <input type="password" placeholder="Password *" name="password" id="myInput" required>  
                    </div>                    
                    <div class="showpass" >
                        <input type="checkbox" class="checkbox"  onclick="showpass()">
                        <p >show password</p>
                    </div>
                        <div class="p">
                            <div class="L"></div>
                        </div> 
                  <div class="clearfix">
                    <button type="submit" name="login" class="signupbtn">Login</button>
                  </div>
              </form>
        </div>
    </div>
    <script>
        function showpass(){
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        
    </script>
</body>
</html>