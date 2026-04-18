<?php include("db.php"); ?>
<?php include("includes/header.php"); ?>

<?php
$search = '';
$statusFilter = '';
$where = [];
$allowedStatuses = [
  'pending' => 'Not done',
  'in_progress' => 'In progress',
  'done' => 'Done'
];

if(isset($_GET['search']) && trim($_GET['search']) !== ''){
  $search = mysqli_real_escape_string($conn, trim($_GET['search']));
  $where[] = "(task_name LIKE '%$search%' OR task_description LIKE '%$search%')";
}

if(isset($_GET['status']) && array_key_exists($_GET['status'], $allowedStatuses)){
  $statusFilter = $_GET['status'];
  $where[] = "status = '$statusFilter'";
}

$query = "SELECT * FROM tasks";
if(count($where) > 0){
  $query .= " WHERE " . implode(' AND ', $where);
}
$query .= " ORDER BY creation DESC";
$result = mysqli_query($conn, $query);

function statusBadge($status){
  switch($status){
    case 'done':
      return '<span class="badge bg-success">Done</span>';
    case 'in_progress':
      return '<span class="badge bg-warning text-dark">In progress</span>';
    default:
      return '<span class="badge bg-secondary">Not done</span>';
  }
}
?>

<div class="container p-4">
  <div class="row mb-4">
    <div class="col-md-12">
      <form action="index.php" method="GET" class="row g-2 align-items-center">
        <div class="col-sm-5">
          <input type="text" name="search" class="form-control" placeholder="Search tasks..." value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <div class="col-sm-3">
          <select name="status" class="form-select">
            <option value="">All statuses</option>
            <option value="pending" <?php echo $statusFilter === 'pending' ? 'selected' : ''; ?>>Not done</option>
            <option value="in_progress" <?php echo $statusFilter === 'in_progress' ? 'selected' : ''; ?>>In progress</option>
            <option value="done" <?php echo $statusFilter === 'done' ? 'selected' : ''; ?>>Done</option>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
        <div class="col-auto">
          <a href="index.php" class="btn btn-outline-secondary">Reset</a>
        </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="card card-body">
          <h3 class="card-title text-center">Add Task</h3>
          <form action="guardar.php" method="POST" class="p-4">
            <div class="form-group">              
              <label>Task</label>
              <input type="text" name="form_title" class="form-control" placeholder="Task Title" autofocus required>
            </div>
            <div class="form-group my-2">
              <label>Description</label>
              <textarea name="form_description" rows="2" class="form-control" placeholder="Task Description"></textarea>
            </div>
            <div class="form-group my-2">
              <label>Status</label>
              <select name="form_status" class="form-select">
                <option value="pending">Not done</option>
                <option value="in_progress">In progress</option>
                <option value="done">Done</option>
              </select>
            </div>
            <input type="submit" name="save" class="btn btn-success btn-block my-4" value="Save Task">
          </form>
      </div>
    </div>
    <div class="col-md-8">
      <table class="table table-bordered table-striped rounded">
        <thead>
          <tr>
          <th>Task</th>
          <th>Description</th>
          <th>Status</th>
          <th>Creation Date</th>
          <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
            ?>
            <tr>
              <td><?php echo htmlspecialchars($row['task_name']); ?></td>
              <td><?php echo htmlspecialchars($row['task_description']); ?></td>
              <td><?php echo statusBadge($row['status']); ?></td>
              <td><?php echo htmlspecialchars($row['creation']); ?></td>
              <td>
                <a href="editar.php?task_id=<?php echo $row['task_id']?>" class="btn btn-secondary btn-sm">
                  <i class="fas fa-marker"></i>
                </a>
                <a href="eliminar.php?task_id=<?php echo $row['task_id']?>" class="btn btn-danger btn-sm">
                  <i class="fas fa-trash-alt"></i>
                </a>
                <a href="status.php?task_id=<?php echo $row['task_id']?>&status=pending" class="btn btn-outline-secondary btn-sm">Not done</a>
                <a href="status.php?task_id=<?php echo $row['task_id']?>&status=in_progress" class="btn btn-outline-warning btn-sm">In progress</a>
                <a href="status.php?task_id=<?php echo $row['task_id']?>&status=done" class="btn btn-outline-success btn-sm">Done</a>
              </td>
            </tr>
            <?php
            }
          } else {
            ?>
            <tr>
              <td colspan="5" class="text-center">No tasks found.</td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>