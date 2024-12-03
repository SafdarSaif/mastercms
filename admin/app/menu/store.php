<?php

if (isset($_POST['name'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  session_start();

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $slug = baseurl($name); 
  $position = mysqli_real_escape_string($conn, $_POST['position']);
  $has_page = isset($_POST['has_page']) ? 1 : 0;
  $has_url = isset($_POST['has_url']) ? 1 : 0;
  $has_parent = isset($_POST['has_parent']) ? 1 : 0;
  $parent_menu = isset($_POST['parent_menu']) ? mysqli_real_escape_string($conn, $_POST['parent_menu']) : null;
  $page_url = isset($_POST['page_url']) ? mysqli_real_escape_string($conn, $_POST['page_url']) : null;
  $custom_url = isset($_POST['custom_url']) ? mysqli_real_escape_string($conn, $_POST['custom_url']) : null;
  
  if (empty($name)) {
    echo json_encode(['status' => 403, 'message' => 'Name is mandatory!']);
    exit();
  }

  $check = $conn->query("SELECT ID FROM menus WHERE Name = '$name'");
  if ($check !== false && $check->num_rows > 0) {
    echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
    exit();
  }

  if ($_FILES["photo"]["name"]) {
    $filename = uploadImage($conn, "photo", "menus");
  } else {
    $filename = "/admin-assets/img/default-menu.jpg"; 
  }

  $addQuery = "INSERT INTO `menus` (`Name`, `Slug`, `Photo`, `Position`, `Has_Page`, `Has_Url`, `Has_Parent`, `Parent_Menu_ID`, `Page_Url`, `Custom_Url`) 
               VALUES ('$name', '$slug', '$filename', '$position', '$has_page', '$has_url', '$has_parent', '$parent_menu', '$page_url', '$custom_url')";

  if ($conn->query($addQuery)) {
    echo json_encode(['status' => 200, 'message' => $name . ' added successfully!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
?>
