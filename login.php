<?php
// Always start this first
session_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'leaseme');

if ( ! empty( $_POST ) ) {
    if ($_SESSION){
        session_destroy();
        session_start();
    }
    if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
        // Getting submitted user data from database
        $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if($con === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $stmt = $con->prepare("SELECT * FROM house_user WHERE username = ?");
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object();

        if ($user){
            // Verify user password and set $_SESSION
            if ($_POST['password'] == $user->password ) {
                $_SESSION['username'] = $user->username;
            }
        } 

    }
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
    <style>
      /* body{ font: 14px sans-serif; } */
      .wrapper{ width: 360px; padding: 20px; }
    </style>
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
            <?php if(!$_SESSION) : ?>
                <li class="nav-item"><a href="login.php" class="nav-link active">Login</a></li>
            <?php endif; ?>
            <?php if($_SESSION) : ?>
                <li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a></li>
            <?php endif; ?>
          </ul>
        </header>
      </div>

    <div>
        <h2>Log In</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Enter your username" required>
            <br>
            <input type="password" name="password" placeholder="Enter your password" required>
            <br>
            <input type="submit" value="Submit">
            <a href="signup.php" class="nav-link">Signup here</a>

        </form>
    
        <br> 
        <?php 
        if ($_SESSION){
            echo $_SESSION['username'] . " is logged in!";
        } 
        else{
            echo "Not logged in!";
        }
        ?>
    </div>

  
    


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>