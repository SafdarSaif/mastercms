<?php
if (isset($_POST['name']) && isset($_POST['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';

  session_start();

  $id = intval($_POST['id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $profile = mysqli_real_escape_string($conn, $_POST['profile']);
  $testimonial = mysqli_real_escape_string($conn, $_POST['testimonial_content']);
  $rating = intval($_POST['rating']);
  $updated_image = mysqli_real_escape_string($conn, $_POST['updated_image']);

  if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '') {
    $image = uploadImage($conn, "image", "testimonials");
  } else {
    $image = $updated_image;
  }

  // Update query
  $query = "UPDATE `testimonials` SET 
            `Name` = '$name', 
            `Profile` = '$profile',
            `Testimonial` = '$testimonial',
            `Rating` = $rating,
            `Image` = '$image'
            WHERE `ID` = $id";

  $update = $conn->query($query);

  if ($update) {
    echo json_encode(['status' => 200, 'message' => $name . ' updated successfully!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Failed to update ' . $name]);
  }
}
