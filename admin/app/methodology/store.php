<?php

if (isset($_POST['name'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  session_start();

  $title = mysqli_real_escape_string($conn, $_POST['name']);
  $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
  $full_description = mysqli_real_escape_string($conn, $_POST['full_description']);
//   $tags = mysqli_real_escape_string($conn, $_POST['tags'] ?? '');

  $filename = "default-methodology.jpg"; // Default image filename

  if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"]) {
    $filename = uploadImage($conn, "image", "methodology");
    if (!$filename) {
      echo json_encode(['status' => 400, 'message' => 'Failed to upload image']);
      exit();
    }
  }

  if (empty($title) || empty($full_description)) {
    echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
    exit();
  }

  $check = $conn->query("SELECT id FROM methodology WHERE Name = '$title'");
  if ($check && $check->num_rows > 0) {
    echo json_encode(['status' => 400, 'message' => $title . ' already exists!']);
    exit();
  }

  $addQuery = "INSERT INTO methodology (Name, image, short_description, full_description) 
               VALUES ('$title', '$filename', '$short_description', '$full_description')";

  if ($conn->query($addQuery) === TRUE) {
    echo json_encode(['status' => 200, 'message' => $title . ' added successfully!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
?>
