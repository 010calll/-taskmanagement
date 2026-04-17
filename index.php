<?php include("db.php"); ?>
<?php include("includes/header.php"); ?>


<div class="container p-4">
  <div class="row">
    <div class="col-md-4">
      <div class="card card-body">
          <h3 class="card-title text-center">Add Task</h3>
          <form action="guardar.php" method="POST" class="p-4">
            <!-- Task title -->
            <div class="form-group">              
              <label>Task</label>
              <input type="text" name="form_title" class="form-control" placeholder="Task Title" autofocus>
            </div>
            <!-- Task description -->
            <div class="form-group my-2">
              <label>Description</label>
              <textarea name="form_description" rows="2" class="form-control" placeholder="Task Description"></textarea>
            </div>
            <!-- Submit button -->
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
          <th>Creation Date</th>
          <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $query = "SELECT * FROM tasks";
          $result = mysqli_query($conn, $query);
          while($row = mysqli_fetch_array($result)){
            ?>
            <tr>
              <td><?php echo $row['task_id']; ?></td>
              <td><?php echo $row['task_name']; ?></td>
              <td><?php echo $row['task_description']; ?></td>
              <td><?php echo $row['creation']; ?></td>
              <td>
                <a href="editar.php?task_id=<?php echo $row['task_id']?>" class="btn btn-secondary">
                  <i class="fas fa-marker"></i>
                </a>
                <a href="eliminar.php?task_id=<?php echo $row['task_id']?>" class="btn btn-danger">
                  <i class="fas fa-trash-alt"></i>
                </a>
              </td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>