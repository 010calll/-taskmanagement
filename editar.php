<?php
include("db.php");

$task_id = isset($_GET['task_id']) ? intval($_GET['task_id']) : 0;
$title = '';
$description = '';
$status = 'pending';

if($task_id > 0){
  $query = "SELECT * FROM tasks WHERE task_id = $task_id";
  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) === 1){
    $row = mysqli_fetch_assoc($result);
    $title = $row['task_name'];
    $description = $row['task_description'];
    $status = $row['status'];
  }
}

if(isset($_POST['save']) && $task_id > 0){
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $status = isset($_POST['status']) && in_array($_POST['status'], ['pending','in_progress','done']) ? $_POST['status'] : 'pending';

  $query = "UPDATE tasks SET task_name = '$title', task_description = '$description', status = '$status' WHERE task_id = $task_id";
  mysqli_query($conn, $query);
  header("location: index.php");
  exit;
}

?>

<?php include("includes/header.php"); ?>
<div class="container p-4">
  <div class="row">
    <div class="col-md-4 mx-auto">
      <div class="card card-body">
        <h2 class="card-title text-center">Update Task</h2>
        <form action="editar.php?task_id=<?php echo $task_id; ?>" method="POST">
          <div class="form-group mb-3">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" class="form-control" placeholder="Update Title" required>
          </div>
          <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="description" rows="2" class="form-control" placeholder="Update Description"><?php echo htmlspecialchars($description); ?></textarea>
          </div>
          <div class="form-group mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
              <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>Not done</option>
              <option value="in_progress" <?php echo $status === 'in_progress' ? 'selected' : ''; ?>>In progress</option>
              <option value="done" <?php echo $status === 'done' ? 'selected' : ''; ?>>Done</option>
            </select>
          </div>
          <input type="submit" name="save" class="btn btn-success btn-block my-4" value="Update Task">
        </form>
      </div>
    </div>
  </div>
</div>

