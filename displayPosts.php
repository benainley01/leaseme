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
  $response = [];
  $response_lists = [];
  $sql = "SELECT * FROM Post NATURAL JOIN Post_information NATURAL LEFT OUTER JOIN Post_photo WHERE Post.pid = Post_information.pid;";
  $result = $con->query($sql);
  if ($result && $result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      array_push($response_lists, $row);
      array_push($response, "Post ID: " . $row["pid"] . "<br>" . "Location: " . $row["location_name"]. "<br>" . "Description: " . $row["description"]. "<br>" . "Street: " . $row["street"] . " " . $row["city"] . " " . $row["state"] . " " . $row["country"]. " " . $row["zip"] . "<br>" . 
      "Price: " . $row["price"] . "<br>" . "Photo: " . $row["photo"] . "<br>" . "<br>" . "contact: " . $row["username"]);
    }
  } else {
    array_push($response,"0 posts");
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
            <li class="nav-item"><a href="displayPosts.php" class="nav-link active">All Posts</a></li>
            <?php if(!$_SESSION) : ?>
                <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                <li class="nav-item"><a href="signup.php" class="nav-link">Signup</a></li>
            <?php endif; ?>
            <?php if($_SESSION) : ?>
                <li class="nav-item"><a href="createPost.php" class="nav-link">Create Post</a></li>
                <li class="nav-item"><a href="favorites.php" class="nav-link">Favorites Posts</a></li>
                <li class="nav-item"><a href="myPosts.php" class="nav-link">My Posts</a></li>
                <li class="nav-item"><a href="messages.php" class="nav-link">Messages</a></li>
                <li class="nav-item"><a href="update_info.php" class="nav-link">Update Info </a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
            <?php endif; ?>
          </ul>
        </header>
      </div>

      <!-- end of nav bar -->      
      <div class="album py-5 bg-light">
        <div class="container">
            <?php
              $ind = 0;
              ?>
            <?php foreach($response_lists as $post): ?>
              <?php if (($ind % 3) === 0): ?>
                <div class="row">
              <?php endif; ?>
              <div class="col-md-4">
                  <div class="card mb-4 shadow-sm">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em"></text></svg>
                    <div class="card-body">
                      <p class="card-text"><?php echo "Post ID: " . $post["pid"] . "<br>" . "Name: " . $post["location_name"]. "<br>" . "Description: " . $post["description"]. "<br>" . "Address: " . $post["street"] . " " . $post["city"] . " " . $post["state"] . " " . $post["country"]. " " . $post["zip"] . "<br>" . 
        "Price: " . $post["price"] . "<br>" . "Photo: " . $post["photo"] . "<br>" . "<br>";?></p>
                      <?php if ($_SESSION): ?>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="btn-group">
                            <form action="addFavorite.php" method="post">
                              <button name="favorite" type="submit" class="btn btn-sm btn-outline-secondary" value="<?php echo $post["pid"]?>">Favorite</button>
                            </form>
                          </div>
                        </div>
                      <?php endif?>
                    </div>
                  </div>
                </div>
                <?php if (($ind % 3) === 2): ?>
                  </div>
                <?php endif; ?>
                <?php
                  $ind = $ind + 1;
                ?>
            <?php endforeach; ?>
        </div>
      </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>