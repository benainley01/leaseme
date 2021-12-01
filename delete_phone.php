<?php
  session_start();
  
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'leaseme');
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($con === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}
if ($_SESSION){
    $user_name = $_SESSION['username'];
    $phone = $_POST["phone"];
    
    $sql = "DELETE FROM `house_user_phone` WHERE `house_user_phone`.`username` = '$user_name' AND `house_user_phone`.`phone` = '$phone'";
    $result = $con->query($sql);
    header("Location: update_info.php");
}
?>