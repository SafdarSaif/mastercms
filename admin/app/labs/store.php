<?php

if (isset($_POST['name'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  session_start();

   
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
   $description = mysqli_real_escape_string($conn, $_POST['description']);
   $slug = baseurl($name);

   $filename = "/admin-assets/img/default-program.jpg";

   
   if (isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"]) {
       $filename = uploadImage($conn, "photo", "labs");
       if (!$filename) {
           echo json_encode(['status' => 400, 'message' => 'Failed to upload image']);
           exit();
       }
   }

   
   if (empty($name) || empty($short_description) || empty($description)) {
       echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
       exit();
   }

   
   $check = $conn->query("SELECT ID FROM labs WHERE Name = '$name'");
   if ($check && $check->num_rows > 0) {
       echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
       exit();
   }


   $addQuery = "INSERT INTO labs (Name, Slug, Short_Description, Description, Image) 
           VALUES ('$name', '$slug', '$short_description', '$description', '$filename')";

   
   if ($conn->query($addQuery) === TRUE) {
       echo json_encode(['status' => 200, 'message' => $name . ' added successfully!']);
   } else {
       echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
   }
}
?>