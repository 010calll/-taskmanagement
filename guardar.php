<?php 
include("db.php");

if(isset($_POST['save'])){
  $title = mysqli_real_escape_string($conn, $_POST['form_title']);
  $description = mysqli_real_escape_string($conn, $_POST['form_description']);
  $status = isset($_POST['form_status']) && in_array($_POST['form_status'], ['pending','in_progress','done']) ? $_POST['form_status'] : 'pending';

  $query = "INSERT INTO tasks(task_name, task_description, status) VALUES('$title', '$description', '$status')";
  $result = mysqli_query($conn, $query);

  if(!$result){
    die("Query Failed");
  } 

  header("Location: index.php");
}


?>