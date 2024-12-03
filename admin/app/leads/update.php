<?php
if (isset($_POST['name']) &&  isset($_POST['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';

  session_start();

  $id = intval($_POST['id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $slug = baseurl($name); 
  $description =mysqli_real_escape_string($conn, $_POST['description']);
  $content =mysqli_real_escape_string($conn, $_POST['content']);
  $meta_title =mysqli_real_escape_string($conn, $_POST['meta_title']);
  $meta_key =mysqli_real_escape_string($conn, $_POST['meta_key']);
  $meta_description =mysqli_real_escape_string($conn, $_POST['meta_description']);
  $updated_file = mysqli_real_escape_string($conn, $_POST['updated_file']);

  if(isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"]!=''){ 
    $photo = uploadImage($conn,"photo","blogs");
  }else{
    $photo = $updated_file;
  }

  $check = $conn->query("SELECT ID FROM Blogs WHERE (Name like '$name') AND ID <> $id");
  if ($check->num_rows > 0) {
    echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
    exit();
  }
   $add = $conn->query("UPDATE `Blogs` SET `Name` = '$name',`Slug` = '$slug' ,`Description` = '$description',`Content` = '$content',`Meta_Title` = '$meta_title', `Meta_Key`='$meta_key',`Photo`='$photo', `Meta_Description`='$meta_description' WHERE ID = $id");
  if ($add) {
    echo json_encode(['status' => 200, 'message' => $name . ' updated successlly!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
