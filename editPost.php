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
$user_name = $_SESSION['username'];
$postID = $_POST["pid"]; 
$newDescription = $_POST["description"]; 

$sql = "UPDATE Post SET description = '$newDescription' WHERE username = '$user_name' AND pid = $postID;";

if ($con->query($sql) === TRUE) {
    header("Location: myPosts.php");
}

?>