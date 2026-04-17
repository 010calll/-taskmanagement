<?php
include("db.php");

if(isset($_GET['task_id'])){
  $id = $_GET['task_id'];
  $query = "SELECT * FROM tasks WHERE task_id = $id";
  $result = mysqli_query($conn, $query);

  //Confirm how many rows my result has
  if(mysqli_num_rows($result) == 1){
    $row = mysqli_fetch_array($result);
    $title = $row['task_name'];
    $description = $row['task_description'];
  }
}

if(isset($_POST['save'])){
  $id = $_GET['task_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];

  $query = "UPDATE tasks SET task_name = '$title', task_description = '$description' WHERE task_id = $id";
  mysqli_query($conn, $query);
  header("location: index.php");

}

?>

<?php include("includes/header.php"); ?>
<div class="container p-4">
  <div class="row">
    <div class="col-md-4 mx-auto">
      <div class="card card-body">
        <h2 class="card-title text-center">Update Task </h2>
        <form action="editar.php?task_id=<?php echo $_GET['task_id']?>" method="POST">
        <br/>
          <div class="form-group">
            <input type="text" name="title" value="<?php echo $title; ?>" class="form-control" placeholder="Update Title">
          </div>
          <div class="form-group">
            <textarea name="description" rows="2" class="form-control" placeholder="Update Description"><?php echo $description; ?></textarea>
          </div>
          <input type="submit" name="save" class="btn btn-success btn-block my-4" value="Update Task">
        </form>
      </div>
    </div>
  </div>
</div

