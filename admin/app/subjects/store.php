<?php

if (isset($_POST['name'])) {
  require '../../includes/db-config.php';
  session_start();

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $sector_id = mysqli_real_escape_string($conn, $_POST['sector_id']);
  $program = mysqli_real_escape_string($conn, $_POST['program']);


  $sub_course_id = mysqli_real_escape_string($conn, $_POST['sub_course']);
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

  $check = $conn->query("SELECT ID FROM Subjects WHERE Name ='$name'");
  if (($check !== false && $check->num_rows > 0)) {
    echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
    exit();
  }


 $add = $conn->query("INSERT INTO `Subjects`(`Name`,`Course_ID`,`Sector_ID`,`Sub_Course_ID`,`Practical_Mode`,`Theory_Mode`,`Practical_Marks`,`Theory_Marks`,`Practical_Passing_Marks`,`Theory_Passing_Marks`) VALUES 
                                             ('$name','$program','$sector_id','$sub_course_id', '$practical_mode', '$theory_mode','$practical_marks','$theory_marks','$practical_passing_marks','$theory_passing_marks')");
  if ($add) {
    echo json_encode(['status' => 200, 'message' => $name . ' Added successlly!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
