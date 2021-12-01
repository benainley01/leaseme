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
    $friend = $_GET["friend"]; 
    // echo $user_name . "<br>";
    // echo $friend;

    $sql = "SELECT sends_message.username AS sender, receives_message.username AS receiver,
    sends_message.message_id, message.text AS text, sends_message.time FROM sends_message
    INNER JOIN
    receives_message ON receives_message.message_id = sends_message.message_id
    INNER JOIN message ON receives_message.message_id = message.message_id
    WHERE (sends_message.username = '$user_name' AND receives_message.username = '$friend')
    OR (sends_message.username = '$friend' AND receives_message.username = '$user_name')
    ORDER BY sends_message.message_id";

    $result = $con->query($sql);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>LeaseMe</title>
  </head>
<body>
    <a class="btn btn-primary" style = "padding-right: 2vw; margin: 2vw" href="http://localhost/leaseme/messages.php" role="button">Back</a>
    <div class = "containter-xl border border-primary" style = "margin-left: 5vw; margin-right: 5vw">
    <form action="send_message.php" method="post">
        <p style = "text-align: center">Send a message: <input type="text" name="text_message"></p>
        <p style = "text-align: center"><input type="submit"></p>
        <input type = "hidden" name = "friend" value = "<?php echo $friend;?>">
    </form>
    </div>
    <br><br>
    <div class = "containter-xl border border-primary" style = "margin-left: 5vw; margin-right: 5vw">
        <?php
        if ($result && $result->num_rows > 0) {
        // output data of each row
        
        echo "<div class = 'border border-secondary'>" . "Time" . str_repeat('&nbsp;', 30) . "Sender" . str_repeat('&nbsp;', 13) . "Receiver" . str_repeat('&nbsp;', 13) . "Message" . "<br>" . "<br>" . "</div>";
        while($row = $result->fetch_assoc()) {
            echo $row["time"] . str_repeat('&nbsp;', 5) . $row["sender"] . str_repeat('&nbsp;', 5) .  $row["receiver"] . str_repeat('&nbsp;', 5) . $row["text"] . "<br>" . "<br>";
        }
        } else {
        echo "No messages";
        }

        }
        if ($con->query($sql) === TRUE) {
            echo "hi";
            header("Location: messages.php");
        }
        ?>
    </div>
    
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>