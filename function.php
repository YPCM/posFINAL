<?php
include 'connect.php'; 

    class DBcontroller{
        private $host = "localhost";
        private $user = "root";
        private $pass = "";
        private $database = "database_by_pos";
        private $conn;

        function __construct() {
            $this->conn = $this->connectDB();
        }
        
        function connectDB() {
            $conn = mysqli_connect($this->host,$this->user,$this->pass,$this->database);
            return $conn;
        }
        
        function runQuery($query) {
            $result = mysqli_query($this->conn,$query);
            while($row=mysqli_fetch_assoc($result)) {
                $resultset[] = $row;
            }		
            if(!empty($resultset))
                return $resultset;
        }
        
        function numRows($query) {
            $result  = mysqli_query($this->conn,$query);
            $rowcount = mysqli_num_rows($result);
            return $rowcount;	
        }

   
    }

    define('DB_SERVER', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'database_by_pos');

    class DB_con {   
        function __construct() {
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $this->dbcon = $conn;

            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL : " . mysqli_connect_error();
            }
        }
        //โต๊ะทั้งหมด
        public function insert($status,$date_time,$number) {
            $result = mysqli_query($this->dbcon, "INSERT INTO table_number( status,date_added,number) VALUES('$status','$date_time','$number')");
            return $result;
        }
        public function fetchdata() {
            $result = mysqli_query($this->dbcon, "SELECT * FROM table_number");
            return $result;
        }

        public function status_01($table_id) {
            $result = mysqli_query($this->dbcon, "UPDATE table_number SET  
			status ='1' 
			WHERE table_id ='$table_id' ");
            return $result;
        }

        public function status_00($table_id) {
            $result = mysqli_query($this->dbcon, "UPDATE table_number SET  
			status ='0' 
			WHERE table_id ='$table_id' ");
            return $result;
        }

        public function delete($table_id) {
            $deleterecord = mysqli_query($this->dbcon, "DELETE FROM table_number WHERE table_id = '$table_id'");
            return $deleterecord;
        }

        public function table_num($table_id){
            $result = msqli_query($this->dbcon, "SELECT table_id, number FROM table_number");
        }

        
        //ท็อปปิ้งทั้งหมด
        public function insert_topping($txtnametopping,$txtcapital_price,$txtselling_price,$new_image_name,$txtcode ) {
            $result = mysqli_query($this->dbcon, "INSERT INTO food_toppings(toppings_name,capital_price_topping,toppings_price,toppings_pic,food_toppings_code) VALUES('$txtnametopping','$txtcapital_price','$txtselling_price','$new_image_name ','$txtcode' )");
            return $result;
        }
        public function fetchdata_topping() {
            $result = mysqli_query($this->dbcon, "SELECT * FROM food_toppings");
            return $result;
        }


        public function deletefood_toppings_code($food_toppings_code){
            $deleterecord = mysqli_query($this->dbcon, "DELETE FROM food_toppings WHERE food_toppings_code = '$food_toppings_code'");
            return $deleterecord;
        }

        //เมนูอาหารทั้งหมด
        public function insert_food($txtmenu,$txtcapital_price,$txtselling_price,$txtamount,$country,$new_image_name) {
            $result = mysqli_query($this->dbcon, "INSERT INTO food_item(food_menu_name,capital_price_food,selling_price_food,amount_food,category_food,img) VALUES('$txtmenu','$txtcapital_price','$txtselling_price','$txtamount','$country','$new_image_name')");
            return $result;
        }
        public function delete_food($food_menu_code ) {
            $deleterecord = mysqli_query($this->dbcon, "DELETE FROM food_item WHERE food_menu_code  = '$food_menu_code '");
            return $deleterecord;
        }

        //cart
       /* public function insert_cart($name,$code,$quantity,$price,$table_id,$order_code,$date_d_m_Y) {
            $result = mysqli_query($this->dbcon, "INSERT INTO cart_item(name,code,quantity,price,table_id,order_code,date_d_m_Y) VALUES('$name','$code','$quantity','$price','$table_id','$order_code','$date_d_m_Y')");
            return $result;
        }
*/
        public function cart() {
            $result = mysqli_query($this->dbcon, "SELECT * FROM cart_item");
            return $result;
        }


        public function delete_cart() {
            $deleteall = mysqli_query($this->dbcon, "DELETE FROM  cart_item ");
            return $deleteall;
        }
        //นับจำนวนorder
        public function tostatus(){
            $status = mysqli_query($this->dbcon,"SELECT status, COUNT(table_id) as TOstatus FROM table_number WHERE status=1 GROUP BY status");
            return $status ;
        }
        //login
        public function usernameavailable($uname) {
            $checkuser = mysqli_query($this->dbcon, "SELECT username FROM user WHERE user_name = '$uname'");
            return $checkuser;
        }
        public function signin($uname, $password) {
            $signinquery = mysqli_query($this->dbcon, "SELECT user_id FROM user WHERE user_name = '$uname' AND password = '$password'");
            return $signinquery;
        }
        // user 
        public function delete_user($user_id ) {
            $deleteuser_id = mysqli_query($this->dbcon, "DELETE FROM user WHERE user_id  = '$user_id '");
            return $deleteuser_id;
        }

    }

    
    /*

    
    define('DB_SERVER', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'database_by_pos');

    class DB_connect {
        // เชื่อมต่อฐานข้อมูล 
        function  __construct(){ 
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $this->dbcon = $conn;

            if(mysqli_connect_errno()){
                echo "Failed to connect to MySQL : " . mysqli_connect_error();
            }
        }
    
        // เพิ่มข้อมูลรายการอาหาร   
        public function food_insert($txtmenu, $txtamount, $txtcapital_price, $txtselling_price, $country){
            $result = mysqli_query($this->dbcon, "INSERT INTO food_item(food_menu_name,capital_price_food,selling_price_food,amount_food,category_food)
            VALUES('$txtmenu','$txtcapital_price','$txtselling_price','$txtamount','$country')");
            return $result;
        }
        // แสดงข้อมูลรายการอาหาร
        public function food_fecthdata(){
            $result = mysqli_query($this->dbcon, "SELECT * FROM food_item" );
            return $result;
        }
        // ดึงข้อมูลเฉพาะคนโดยดึง id 
        public function food_fecthonerecord($food_menu_code){
            $result = mysqli_query($this->dbcon, "SELECT * FROM food_item WHERE food_menu_code = '$food_menu_code' ");
            return $result;
        }
        // อัพเดทข้อมูล 
        public function food_update($food_menu_code, $food_menu_name, $amount_food, $capital_price_food, $selling_price_food){
            $result = mysqli_query($this->dbcon, "UPDATE food_item SET  
			food_menu_name ='$food_menu_name ' ,
			amount_food='$amount_food' , 
			capital_price_food='$capital_price_food' ,
			selling_price_food='$selling_price_food'  
			WHERE food_menu_code='$food_menu_code' ");
        }
        // ลบข้อมูล
        public function food_delete($food_menu_code) {
            $fooddeleterecord = mysqli_query($this->dbcon, "DELETE FROM food_item WHERE food_menu_code='$food_menu_code' ");
            return $fooddeleterecord;
        }
        // นับจำนวนหมวด0001
        public function food_sumtotal0001(){
            $st_0001 = mysqli_query($this->dbcon, "SELECT category_food, COUNT(food_menu_code) as s1total
                FROM   food_item
                WHERE category_food=0001
                GROUP BY category_food");
            return $st_0001;  
        }
        //นับจำนวนหมวด0002
        public function food_sumtotal0002(){
            $st_0002 = mysqli_query($this->dbcon, "SELECT category_food, COUNT(food_menu_code) as s2total
                FROM   food_item
                WHERE category_food=0002
                GROUP BY category_food");
            return $st_0002; 
        } 
        //นับจำนวนหมวด0003
        public function food_sumtotal0003(){
            $st_0003 = mysqli_query($this->dbcon, "SELECT category_food, COUNT(food_menu_code) as s3total
                FROM   food_item
                WHERE category_food=0003
                GROUP BY category_food");
            return $st_0003; 
        } 
        //นับจำนวนท็อปปิ้ง + แสดงข้อมูลตารางท็อปปิ้ง
        public function food_sumtotaltopping(){
            $totaltopping = mysqli_query($this->dbcon, "SELECT * FROM food_toppings");
            return $totaltopping;
        }
        //จำนวนรายการอาหารทั้งหมด
        public function food_totallist(){
            $result = mysqli_query($this->dbcon, "SELECT * FROM food_item" );
            return $result;
        }
        //คำนวณต้นทุนของ 0001-0003
        public function food_sumtotal(){
            $sql_totals= mysqli_query($this->dbcon,  "SELECT SUM(capital_price_food) AS sumtotal 
            FROM food_item 
            WHERE category_food");
            return $sql_totals;          
        }
        // คำนวณต้นทุน ท็อปปิ้ง 
        public function food_sumprice_topping() {
            $sql_sumtopping = mysqli_query($this->dbco, "SELECT food_toppings_code ,SUM(capital_price_topping) AS toppings 
            FROM food_toppings 
            WHERE food_toppings_code");
            return $sql_sumtopping;
        }
    */
    
    

    

    

?>
