<?php
include("db.php");

if(isset($_GET['task_id'])){
  $id = $_GET['task_id'];
  $query = "DELETE FROM tasks WHERE task_id = $id";
  $result = mysqli_query($conn, $query);

  if(!$result){
    die("Query Failed.");
  }

  header("location: index.php");

}



?>