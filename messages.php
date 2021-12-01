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
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
          <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
          </a>
    
          <ul class="nav nav-pills">
            <li class="nav-item"><a href="index.php" class="nav-link" aria-current="page">LeaseMe</a></li>
            <li class="nav-item"><a href="displayPosts.php" class="nav-link">All Posts</a></li>
            <li class="nav-item"><a href="createPost.php" class="nav-link">Create Post</a></li>
            <li class="nav-item"><a href="favorites.php" class="nav-link">Favorites Posts</a></li>
            <li class="nav-item"><a href="myPosts.php" class="nav-link">My Posts</a></li>
            <li class="nav-item"><a href="messages.php" class="nav-link active">Messages</a></li>
            <?php if(!$_SESSION) : ?>
                <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
            <?php endif; ?>
            <?php if($_SESSION) : ?>
                <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
            <?php endif; ?>
          </ul>
        </header>
      </div>

      <div class = "containter-xl border border-primary" style = "margin-left: 5vw; margin-right: 5vw">
        <form action="view_message.php" method="get">
          <p style = "text-align: center">Send messages to who? (enter username): <input type="text" name="friend" /></p>
          <p style = "text-align: center"><input type="submit" /></p>
        </form>
      </div>
      <br><br>
      <!-- <div class = "containter-xl border border-primary" style = "margin-left: 5vw; margin-right: 5vw">
        <form action="view_message.php" method="post">
          <p style = "text-align: center">Send messages from who? (enter username): <input type="text" name="friend" /></p>
          <p style = "text-align: center">Enter your message: <input type="text" name="text_message" /></p>
          <p style = "text-align: center"><input type="submit" /></p>
        </form>
      </div> -->
      
    </div>
    <div class = "containter-xl border border-secondary" style = "margin-left: 5vw; margin-right: 5vw">
      <h3> Your Latest Messages </h3>
    <?php
    if ($_SESSION){
      $user_name = $_SESSION['username'];
      // echo $user_name . "<br>";
      // echo $friend;
  
      $sql = "SELECT sends_message.username AS sender, receives_message.username AS receiver,
      sends_message.message_id, message.text AS text, sends_message.time FROM sends_message
      INNER JOIN
      receives_message ON receives_message.message_id = sends_message.message_id
      INNER JOIN message ON receives_message.message_id = message.message_id
      WHERE receives_message.username = '$user_name'
      ORDER BY sends_message.message_id DESC";
  
      $result = $con->query($sql);

      if ($result && $result->num_rows > 0) {
        // output data of each row
        
        echo "<div class = 'border border-secondary'>" . "Time" . str_repeat('&nbsp;', 30) . "From" . str_repeat('&nbsp;', 13) . "Message" . "<br>" . "<br>" . "</div>";
        while($row = $result->fetch_assoc()) {
            echo $row["time"] . str_repeat('&nbsp;', 5) . $row["sender"] . str_repeat('&nbsp;', 5) . $row["text"] . "<br>" . "<br>";
        }
        } else {
        echo "No messages";
        }
    }
    ?>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
