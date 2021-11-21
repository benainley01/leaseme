<?php 
// https://www.codexworld.com/export-data-to-csv-file-using-php-mysql/
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
$query = $con->query("SELECT Post.description, Post_information.location_name, Post_information.street, Post_information.city, Post_information.state, Post_information.country, Post_information.zip, Post_information.price, Post_photo.photo FROM Post, Post_information, Post_photo, Favorite WHERE Favorite.username = '$user_name' AND Favorite.pid = Post.pid AND Favorite.pid = Post_information.pid AND Favorite.pid = Post_photo.pid;"); 
 
if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "LeaseMe Favorites" . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('Location Name', 'Description', 'Street', 'City', 'State', 'Country', 'Zipcode', 'Price', 'Photo URL'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['location_name'], $row['description'], $row['street'], $row['city'], $row['state'], $row['country'], $row['zip'], $row['price'], $row['photo']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>