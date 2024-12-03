<?php
if (isset($_POST['name']) && isset($_POST['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  session_start();

  $id = intval($_POST['id']);
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
  $updated_file = mysqli_real_escape_string($conn, $_POST['updated_file']);

  $category = isset($_POST['category_id']) ? mysqli_real_escape_string($conn, $_POST['category_id']) : '';
  $department_ID = isset($_POST['Department_ID']) ? mysqli_real_escape_string($conn, $_POST['Department_ID']) : '';

  if (isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"] != '') {
    $photo = uploadImage($conn, "photo", "program");
  } else {
    $photo = $updated_file;
  }

  if (empty($name) || empty($short_Name) || empty($position)) {
    echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
    exit();
  }

  // $check = $conn->query("SELECT ID FROM programs WHERE (Name = '$name') AND ID <> $id");
  // if ($check !== false && $check->num_rows > 0) {
  //   echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
  //   exit();
  // }
  $check = $conn->query("SELECT ID FROM programs WHERE Name = '$name' AND Department_ID = '$department_ID' AND ID <> $id");
  if ($check !== false && $check->num_rows > 0) {
    echo json_encode(['status' => 400, 'message' => $name . ' already exists for the selected department!']);
    exit();
  }

  // $update = $conn->query("UPDATE `programs` SET `Name` = '$name', `Slug` = '$slug', `Department_ID` = '$department_ID', `Short_Name` = '$short_Name', `Position` = '$position', `Eligibility` = '$eligibility', `Year` = '$year', `Semester` = '$semester' WHERE ID = $id");
  $update = $conn->query("UPDATE `programs` SET `Name` = '$name', `Slug` = '$slug', `Categories_ID` = '$category', `Department_ID` = '$department_ID', `Short_Name` = '$short_Name', `Position` = '$position', `Content` = '$content', `Photo` = '$photo', `Meta_Title` = '$meta_title', `Meta_Key` = '$meta_key', `Meta_Description` = '$meta_description', `Eligibility` = '$eligibility', `Mode` = '$mode', `Duration` = '$duration', `Degree` = '$degree', `Description` = '$short_description' WHERE ID = $id");
  if ($update) {
    echo json_encode(['status' => 200, 'message' => $name . ' updated successfully!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
