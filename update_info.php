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

<?php if(!$_SESSION) : ?>
        Login first
<?php endif; ?>
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
            <li class="nav-item"><a href="messages.php" class="nav-link">Messages</a></li>
            <?php if(!$_SESSION) : ?>
                <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
            <?php endif; ?>
            <?php if($_SESSION) : ?>
              <li class="nav-item"><a href="update_info.php" class="nav-link active">Update Info </a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
            <?php endif; ?>
          </ul>
        </header>
      </div>

<div class = "containter-xl border border-primary" style = "margin-left: 5vw; margin-right: 5vw">
<?php
if ($_SESSION){
    $user_name = $_SESSION['username'];

    $sql = "SELECT name, email FROM `house_user` WHERE username = '$user_name';";

    echo "Your name and email:" . "<br>";
    $result = $con->query($sql);
    while($row = $result->fetch_assoc()) {
        echo $row["name"] . str_repeat('&nbsp;', 5) . $row["email"] . "<br>" . "<br>";
    }

    echo "Your phone numbers:" . "<br>";
    $sql2 = "SELECT phone FROM `house_user` NATURAL JOIN house_user_phone WHERE username = '$user_name';";
    $result2 = $con->query($sql2);
    while($row = $result2->fetch_assoc()) {
        echo $row["phone"];
    }
}
?>
<div>
  <br><br>
  <form action="update_email.php" method="post">
    <p style = "text-align: center">Update email: <input type="text" name="email" /></p>
    <p style = "text-align: center"><input type="submit" /></p>
  </form>
</div>

</div>
</body>