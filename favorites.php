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
  $response = [];
  $sql = "SELECT Post.pid, Post.description, Post_information.location_name, Post_information.street, Post_information.city, Post_information.state, Post_information.country, Post_information.zip, Post_information.price, Post_photo.photo FROM Favorite, Post NATURAL JOIN Post_information NATURAL LEFT OUTER JOIN Post_photo WHERE Favorite.username = '$user_name' AND Favorite.pid = Post.pid AND Favorite.pid = Post_information.pid;";
  $result = $con->query($sql);
  if ($result && $result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      array_push($response, "Post ID: " . $row["pid"] . "<br>" . "Name: " . $row["location_name"]. "<br>" . "Description: " . $row["description"]. "<br>" . "Address: " . $row["street"] . " " . $row["city"] . " " . $row["state"] . " " . $row["country"]. " " . $row["zip"] . "<br>" . 
      "Price: " . $row["price"] . "<br>" . "Photo: " . $row["photo"]);
    }
  } else {
    array_push($response,"0 posts");
  }

}

// print_r($response);
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
            <li class="nav-item"><a href="favorites.php" class="nav-link active">Favorites Posts</a></li>
            <li class="nav-item"><a href="myPosts.php" class="nav-link">My Posts</a></li>
            <li class="nav-item"><a href="messages.php" class="nav-link">Messages</a></li>
            <?php if(!$_SESSION) : ?>
                <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
            <?php endif; ?>
            <?php if($_SESSION) : ?>
              <li class="nav-item"><a href="update_info.php" class="nav-link">Update Info </a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
            <?php endif; ?>
          </ul>
        </header>
    </div>
    <!-- end of nav bar -->
      
    <?php if(!$_SESSION) : ?>
        Login to view favorite posts
    <?php endif; ?>
      
    <div class="card text-white bg-primary mb-3" style= "padding: 10px; max-width: 90%; margin-right: auto; margin-left: auto;">
    <?php 
    if ($_SESSION){
      foreach($response as $post){
        echo $post . "<br>" . "<br>";
      }
    }
    ?>
    </div>

    <?php if($_SESSION && $result->num_rows > 0) : ?>
    <div class="container p-3 my-3 bg-primary text-white" style= "padding: 10px; max-width: 90%; margin-right: auto; margin-left: auto;">
    <a href="export_favorites.php" class="btn btn-success"><i class="dwn"></i> Export Favorites</a>      

    <form action="unfavorite.php" method="post">
    Unfavorite post with PID: <input type="number" name="pid">
    <input type="submit" class="btn btn-success">
    </form>
    </div>
    <?php endif; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>