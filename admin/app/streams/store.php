<?php
if (isset($_POST['name'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  session_start();

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $slug = baseurl($name);
  $short_Name = mysqli_real_escape_string($conn, $_POST['Short_Name']);
  $position = mysqli_real_escape_string($conn, $_POST['position']);
  $eligibility = mysqli_real_escape_string($conn, $_POST['eligibility']);
  $mode = mysqli_real_escape_string($conn, $_POST['mode']);
  $duration = mysqli_real_escape_string($conn, $_POST['duration']);
  $degree = mysqli_real_escape_string($conn, $_POST['degree']);
  $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
  $content = mysqli_real_escape_string($conn, $_POST['content']);
  $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
  $meta_key = mysqli_real_escape_string($conn, $_POST['meta_key']);
  $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);



  $category = isset($_POST['category_id']) ? mysqli_real_escape_string($conn, $_POST['category_id']) : '';
  $department_ID = isset($_POST['Department_ID']) ? mysqli_real_escape_string($conn, $_POST['Department_ID']) : '';

  if ($_FILES["photo"]["name"]) {
    $filename = uploadImage($conn, "photo", "program");
  } else {
    $filename = "/admin-assets/img/default-program.jpg";
  }

  if (empty($name) || empty($short_Name) || empty($position)) {
    echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
    exit();
  }

  // $check = $conn->query("SELECT ID FROM programs WHERE Name = '$name'");
  // if ($check !== false && $check->num_rows > 0) {
  //   echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
  //   exit();
  // }

  // Check if the program name already exists
  $check = $conn->query("SELECT ID FROM programs WHERE Name = '$name' AND Department_ID = '$department_ID'");
  if ($check && $check->num_rows > 0) {
    echo json_encode(['status' => 400, 'message' => $name . ' already exists for the selected department!']);
    exit();
  }



  $add = $conn->query("INSERT INTO programs (Name, Slug, Categories_ID, Department_ID, Short_Name, Position, Photo, Content,Meta_Title, Meta_Key, Meta_Description, Eligibility, Mode, Duration, Degree, Description	) 
                        VALUES ('$name', '$slug', '$category', '$department_ID', '$short_Name', '$position', '$filename', '$content', '$meta_title', '$meta_key', '$meta_description', '$eligibility', '$mode', '$duration', '$degree', '$short_description')");
  if ($add) {
    echo json_encode(['status' => 200, 'message' => $name . ' Added successfully!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
