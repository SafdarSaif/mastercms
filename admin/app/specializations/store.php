<?php
if (isset($_POST['name'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  session_start();

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $slug = baseurl($name);
  $short_Name = mysqli_real_escape_string($conn, $_POST['Short_Name']);
  $content = mysqli_real_escape_string($conn, $_POST['content']);
  $position = mysqli_real_escape_string($conn, $_POST['position']);
  $eligibility = mysqli_real_escape_string($conn, $_POST['eligibility']);
  $duration = mysqli_real_escape_string($conn, $_POST['duration']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);


  $department_ID = isset($_POST['Department_ID']) ? mysqli_real_escape_string($conn, $_POST['Department_ID']) : '';
  $program_ID = isset($_POST['Program_ID']) ? mysqli_real_escape_string($conn, $_POST['Program_ID']) : '';
  $course_ID = isset($_POST['Course_ID']) ? mysqli_real_escape_string($conn, $_POST['Course_ID']) : '';


  if ($_FILES["photo"]["name"]) {
    $filename = uploadImage($conn, "photo", "specialization");
  } else {
    $filename = "/admin-assets/img/default-program.jpg";
  }

  if (empty($name) || empty($short_Name) || empty($position)) {
    echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
    exit();
  }

  // $check = $conn->query("SELECT ID FROM specializations WHERE Name = '$name' AND Department_ID = '$department_ID'");
  // if ($check && $check->num_rows > 0) {
  //   echo json_encode(['status' => 400, 'message' => $name . ' already exists for the selected department!']);
  //   exit();
  // }

  $check = $conn->query("SELECT ID FROM specializations WHERE Name = '$name' AND Department_ID = '$department_ID' AND Program_ID = '$program_ID' AND Course_ID = '$course_ID'");
  if ($check && $check->num_rows > 0) {
    echo json_encode(['status' => 400, 'message' => $name . ' already exists for the selected department!']);
    exit();
  }

  // $add_query = "INSERT INTO specializations (Name, Slug, Department_ID, Program_ID, Course_ID, Short_Name, Content, Position) 
  //               VALUES ('$name', '$slug', '$department_ID', '$program_ID', '$course_ID', '$short_Name', '$content', '$position')";

  $add_query = "INSERT INTO specializations (Name, Slug, Department_ID, Program_ID, Course_ID, Short_Name, Content, Position, Photo, Eligibility, Durations,Description ) 
  VALUES ('$name', '$slug', '$department_ID', '$program_ID', '$course_ID', '$short_Name', '$content', '$position', '$filename', '$eligibility', '$duration','$description')";


  $add = $conn->query($add_query);
  if ($add) {
    echo json_encode(['status' => 200, 'message' => $name . ' Added successfully!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
