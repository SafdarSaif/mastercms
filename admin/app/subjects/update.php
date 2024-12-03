<?php
if (isset($_POST['name']) &&  isset($_POST['id'])) {
  require '../../includes/db-config.php';
  session_start();

  $id = intval($_POST['id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $sub_course_id = mysqli_real_escape_string($conn, $_POST['sub_course']);
  $sector_id = mysqli_real_escape_string($conn, $_POST['sector_id']);
  $program = mysqli_real_escape_string($conn, $_POST['program']);

  if (isset($_POST['practical_mode'])) {
    $practical_mode = mysqli_real_escape_string($conn, $_POST['practical_mode']);
    $practical_marks = mysqli_real_escape_string($conn, $_POST['practical_marks']);
    $practical_passing_marks = mysqli_real_escape_string($conn, $_POST['practical_passing_marks']);
  } else {
    $practical_mode = null;
    $practical_marks= null;
    $practical_passing_marks=null;

  }

  if (isset($_POST['theory_mode'])) {
    $theory_mode = mysqli_real_escape_string($conn, $_POST['theory_mode']);
    $theory_marks = mysqli_real_escape_string($conn, $_POST['theory_marks']);
    $theory_passing_marks = mysqli_real_escape_string($conn, $_POST['theory_passing_marks']);
  } else {
    $theory_mode = null;
    $theory_marks= null;
    $theory_passing_marks=null;
  }

  $check = $conn->query("SELECT ID FROM Subjects WHERE  Name='$name' AND ID != $id");
  if ($check->num_rows > 0) {
    echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
    exit();
  }

  $add = $conn->query("UPDATE `Subjects` SET `Name` = '$name',`Course_ID` = '$program',`Sector_ID` = '$sector_id',`Sub_Course_ID` = '$sub_course_id',`Practical_Mode` = '$practical_mode',`Theory_Mode` = '$theory_mode',`Practical_Marks` = '$practical_marks',`Practical_Mode` = '$practical_mode',`Practical_Marks` = '$practical_marks',`Theory_Marks` = '$theory_marks',`Practical_Passing_Marks` = '$practical_passing_marks', `Theory_Passing_Marks` = '$theory_passing_marks' WHERE ID = $id");
  if ($add) {
    echo json_encode(['status' => 200, 'message' => $name . ' updated successlly!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
