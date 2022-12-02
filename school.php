<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
    <h1>Hello, world!</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

<?php
$servername = "165.227.18.177";
$username = "alqadiou";
$password = "1[L0B2U1kkqXh*";
$dbname = "alqadiou_homework3";
    
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  switch ($_POST['saveType']) {
    case 'Add':
      $sqlAdd = "insert into School (school_name) value (?)";
      $stmtAdd = $conn->prepare($sqlAdd);
      $stmtAdd->bind_param("si", $_POST['iSchool']);
      $stmtAdd->execute();
      echo '<div class="alert alert-success" role="alert">New School added.</div>';
      break;
    case 'Edit':
      $sqlEdit = "update school set school_name=? where school_id=?";
      $stmtEdit = $conn->prepare($sqlEdit);
      $stmtEdit->bind_param("sii", $_POST['iSchool'], $_POST['iiid']);
      $stmtEdit->execute();
      echo '<div class="alert alert-success" role="alert">School edited.</div>';
      break;
    case 'Delete':
      $sqlDelete = "delete from school where school_id=?";
      $stmtDelete = $conn->prepare($sqlDelete);
      $stmtDelete->bind_param("ii", $_POST['iiid']);
      $stmtDelete->execute();
      echo '<div class="alert alert-success" role="alert">School deleted.</div>';
      break;
  }
}
?>
    <div class="dropdown-center">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Centered dropdown
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="index.php">Instructors</a></li>
    <li><a class="dropdown-item" href="school.php">School</a></li>
    <li><a class="dropdown-item" href="corse.php">Course</a></li>
    <li><a class="dropdown-item" href="classroom.php">Classroom</a></li>
  </ul>
</div>
      
      <h1>School</h1>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>School ID</th>
            <th>School Name</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          
<?php
$sql = "SELECT `school`.*
FROM `school`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
          
          <tr>
            <td><?=$row["school_id"]?></td>
            <td><?=$row["school_name"]?></td>
            <td>
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editSchool<?=$row["school_id"]?>">
                Edit
              </button>
              <div class="modal fade" id="editSchool<?=$row["school_id"]?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editSchool<?=$row["school_id"]?>Label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="editSchool<?=$row["school_id"]?>Label">Edit School ID</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="">
                        <div class="mb-3">
                          <label for="editSchool<?=$row["school_id"]?>Name" class="form-label">Name</label>
                          <input type="text" class="form-control" id="editSchool<?=$row["school_id"]?>Name" aria-describedby="editSchool<?=$row["school_id"]?>Help" name="iSchool" value="<?=$row['school_name']?>">
                          <div id="editSchool<?=$row["school_id"]?>Help" class="form-text">Enter the School's name.</div>
                        </div>
                        <input type="hidden" name="iiid" value="<?=$row['school_id']?>">
                        <input type="hidden" name="saveType" value="Edit">
                        <input type="submit" class="btn btn-primary" value="Submit">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <form method="post" action="">
                <input type="hidden" name="iiid" value="<?=$row["school_id"]?>" />
                <input type="hidden" name="saveType" value="Delete">
                <input type="submit" class="btn" onclick="return confirm('Are you sure?')" value="Delete">
              </form>
            </td>
          </tr>
          
<?php
  }
} else {
  echo "0 results";
}
$conn->close();
?>
          
        </tbody>
      </table>
      <br />
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSchool">
        Add New
      </button>

      <!-- Modal -->
      <div class="modal fade" id="addSchool" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addSchoolLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="addSchoolLabel">Add School</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="school_name" class="form-label">School Name</label>
                  <input type="text" class="form-control" id="school_name" aria-describedby="nameHelp" name="iSchool">
                  <div id="nameHelp" class="form-text">Enter the School's name.</div>
                </div>
                <input type="hidden" name="saveType" value="Add">
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
