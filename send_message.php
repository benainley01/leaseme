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


if ($_SESSION) {
    $user_name = $_SESSION['username'];
    $text_message = $_POST["text_message"]; 
    $friend = $_POST['friend'];
    // echo $user_name . "<br>";
    // echo $friend . "<br>";
    // $updated_at = date('YYYY-MM-DD HH:MM:SS');
    // echo "Today is " . date("Y-m-d") . "<br>";
    $mysqltime =  date('Y-m-d H:i:s');
    // echo $mysqltime . "<br>";
    // echo $mysqltime . ".000000";
    $mysqltime = $mysqltime . ".000000";

    // $sql = "INSERT INTO message VALUES('$text_message');
    //         INSERT INTO sends_message VALUES('$user_name', '$mysqltime');
    //         INSERT INTO receives_message VALUES('$friend', '$mysqltime');";
    $user_name = $_SESSION['username'];
    
    $friend = $_POST['friend'];
    

    $stmt1 = $con->prepare(
      "INSERT INTO `message` (`message_id`, `text`) VALUES (?, ?);"
    );
    $stmt2 = $con->prepare(
    "INSERT INTO `sends_message` (`username`, `message_id`, `time`) VALUES (?, ?, ?);"
    );
    $stmt3 = $con->prepare(
      "INSERT INTO `receives_message` (`username`, `message_id`, `time`) VALUES (?, ?, ?);"
    );
    $stmt1->bind_param("is", $None, $text);
    $None = null;
    $text = $_POST["text_message"]; 
    $stmt1->execute();

    $stmt2->bind_param("sis", $friend, $None, $time);
    $time = $mysqltime . ".000000";
    $stmt2->execute();

    $stmt3->bind_param("sis", $user_name, $None, $time);
    $stmt3->execute();

    // $sql = 
    // "INSERT INTO `message` (`message_id`, `text`) VALUES (NULL, '$text_message');
    // INSERT INTO `sends_message` (`username`, `message_id`, `time`) VALUES ('$user_name', NULL, '$mysqltime');
    // INSERT INTO `receives_message` (`username`, `message_id`, `time`) VALUES ('$friend', NULL, '$mysqltime')";


    // INSERT INTO `message` (`message_id`, `text`) VALUES (NULL, 'test');
    // INSERT INTO `sends_message` (`username`, `message_id`, `time`) VALUES ('mld6nh', NULL, '2021-12-01 07:17:29.000000');
    // INSERT INTO `sends_message` (`username`, `message_id`, `time`) VALUES ('mld6nh', NULL, '2021-12-01 07:17:29.000000');
    
    // if ($con->multi_query($stmt) === TRUE) {
    //     echo "hi";
    //     header("Location: view_message.php?friend=".$friend);
    //     // http://localhost/leaseme/view_message.php?friend=dws3qd
    // }
    header("Location: view_message.php?friend=".$friend);
}
?>