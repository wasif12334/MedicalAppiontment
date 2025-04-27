<?php
// Database connection
$servername = "localhost";
$username = "root";  
$password = "";      
$database = "alfazalclinic"; 

// Create connection
$con = mysqli_connect($servername, $username,$password, $database, "3307");


// Check connection
if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $con -> connect_error;
  exit();
  
}

?>