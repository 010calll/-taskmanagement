<?php 
include("db.php");

if(isset($_POST['save'])){
  $title = $_POST['form_title'];
  $description = $_POST['form_description'];

  $query = "INSERT INTO tasks(task_name, task_description) VALUES('$title', '$description')";
  $result = mysqli_query($conn, $query);

  if(!$result){
    die("Query Failed");
  } 

  header("Location: index.php");
}


?>