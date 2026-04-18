<?php
include("db.php");

if(isset($_GET['task_id'], $_GET['status'])){
  $id = intval($_GET['task_id']);
  $status = $_GET['status'];
  $allowed = ['pending', 'in_progress', 'done'];

  if($id > 0 && in_array($status, $allowed, true)){
    $query = "UPDATE tasks SET status = '$status' WHERE task_id = $id";
    mysqli_query($conn, $query);
  }
}

header("Location: index.php");
exit;
