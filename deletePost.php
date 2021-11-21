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

$sql = "DELETE FROM Post_information WHERE pid = $postID;
DELETE FROM Post WHERE username = '$user_name' AND pid = $postID;
DELETE FROM Post_photo WHERE pid = $postID;
DELETE FROM Favorite WHERE pid = $postID;";

if ($con->multi_query($sql) === TRUE) {
    header("Location: myPosts.php");
}

?>