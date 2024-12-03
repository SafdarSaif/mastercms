<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  session_start();

  $name = mysqli_real_escape_string($conn, $_POST['image_names']);

  if ($_FILES["images"]["name"]) {
    $filename = uploadImage($conn, "images", "gallery");
  } else {
    $filename = "/admin-assets/img/default-program.jpg";
  }

  if (empty($name)) {
    echo json_encode(['status' => 403, 'message' => 'Name is mandatory!']);
    exit();
  }

  $check = $conn->query("SELECT id FROM gallery WHERE image_name LIKE '$name'");

  if ($check !== false && $check->num_rows > 0) {
    echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
    exit();
  }

  $add = $conn->query("INSERT INTO gallery (image_name, image_link) VALUES ('$name','$filename')");
  if ($add) {
    echo json_encode(['status' => 200, 'message' => $name . ' added successfully!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
?>
