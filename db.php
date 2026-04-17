<?php 
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$database = getenv('DB_NAME') ?: 'crud_db';

$conn = mysqli_connect(
  $servername,
  $username,
  $password,
  $database
);

/*if(isset($conn)){
  echo "Connected";
} else {
  echo "Not Connected";
}*/




?>