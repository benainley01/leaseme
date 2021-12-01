<?php
  session_start();
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', '');
  define('DB_NAME', 'leaseme');
  //Check if the user has filled the POST yet
  if(!empty($_POST)){
    $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if($con === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $user_name = $_SESSION['username'];
    $description = $_POST['description']; 

    $sql_post = $con->prepare("INSERT INTO Post (username, description) VALUES (?, ?);");
    $sql_post->bind_param('ss', $user_name, $description);
    $sql_post->execute();

    //Post Information (pid is generated when inserting post)

    //Get pid for post info
    $sql_pid = $con->prepare("SELECT * FROM Post WHERE username = ? AND description = ?;");
    $sql_pid->bind_param('ss', $user_name, $description);
    $sql_pid->execute();
    $pid_result = $sql_pid->get_result();
    $row = mysqli_fetch_array($pid_result);
    $pid = $row['pid'];
    
    //Insert Post Information
    $locationName = $_POST['locationName']; 
    $streetAddress = $_POST['streetAddress']; 
    $city = $_POST['city']; 
    $state = $_POST['state']; 
    $country = $_POST['country']; 
    $zip = $_POST['zip']; 
    $price = "N/A";
    if(isset($_POST['price'])){
      $price = $_POST['price']; 
    }

    $sql_post_info = $con->prepare("INSERT INTO Post_information VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
    $sql_post_info->bind_param('isssssis', $pid, $locationName, $streetAddress, $city, $state, $country, $zip, $price);
    $sql_post_info->execute();

    header("Location: index.php");
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
            <li class="nav-item"><a href="createPost.php" class="nav-link active">Create Post</a></li>
            <li class="nav-item"><a href="favorites.php" class="nav-link">Favorites Posts</a></li>
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

    <div class="container">
      <form action="" method="post">
          <label for="locationName">Location Name:</label><br>
          <input type="text" id="locationName" name="locationName" placeholder="Location Name" required><br>
          <label for="streetAddress">Street Address:</label><br>
          <input type="text" id="streetAddress" name="streetAddress" placeholder="1718 Jefferson Park Avenue" required><br>
          <label for="city">City:</label><br>
          <input type="text" id="city" name="city" placeholder="Charlottesville" required><br>
          <label for="state">State:</label><br>
          <input type="text" id="state" name="state" placeholder="VA" required><br>
          <label for="coutry">Country:</label><br>
          <input type="text" id="country" name="country" placeholder="United States" required><br>
          <label for="zip">Zip/Postal Code:</label><br>
          <input type="text" id="zip" name="zip" placeholder="Zip/Postal Code" required><br>
          <label for="price">Price:</label><br>
          <input type="text" id="price" name="price" placeholder="Price (Optional)"><br>
          <label for="decription">Description:</label><br>
          <textarea rows="10" cols="100" id="description" name="description" placeholder="Brief location description or listing message" required></textarea><br>
          <input type="submit" value="Submit">
        </form>
      </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>