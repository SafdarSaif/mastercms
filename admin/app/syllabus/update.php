<?php
if (isset($_POST['subject_type']) &&  isset($_POST['id'])) {
  require '../../includes/db-config.php';
  session_start();

  $id = intval($_POST['id']);
  $sub_course_id = mysqli_real_escape_string($conn, $_POST['sub_course']);
  $subject_type = mysqli_real_escape_string($conn, $_POST['subject_type']);
  $syllabus_type = mysqli_real_escape_string($conn, $_POST['syllabus_type']);
  $syllabus_content = mysqli_real_escape_string($conn, $_POST['syllabus_content']);
  $updated_file = mysqli_real_escape_string($conn, $_POST['updated_file']);

  $syllabus_folder = '../../uploads/syllabus/';
  $allowed_file_extensions = array("jpeg", "jpg", "png", "gif", "JPG", "PNG", "JPEG", "PDF", "pdf");

  // echo "<pre>"; print_r($_FILES); die;



  if (isset($_FILES["syllabus_file"]["tmp_name"]) && $_FILES["syllabus_file"]['tmp_name'] != '' && count(array_filter($_FILES["syllabus_file"]['tmp_name'])) > 0) {
    foreach ($_FILES["syllabus_file"]["tmp_name"] as $key => $tmp_name) {
      $syllabus_file = mysqli_real_escape_string($conn, $_FILES["syllabus_file"]["name"][$key]);
      $tmp_name = $_FILES["syllabus_file"]["tmp_name"][$key];
      $syllabus_file_extension = pathinfo($syllabus_file, PATHINFO_EXTENSION);
      $syllabus_file_name = "Syllabus-pdf-" . time() . "." . $syllabus_file_extension;
      if (in_array($syllabus_file_extension, $allowed_file_extensions)) {
        if (file_exists($syllabus_folder . $syllabus_file_name)) {
          unlink($syllabus_folder . $syllabus_file_name);
        }
        if (move_uploaded_file($tmp_name, $syllabus_folder . $syllabus_file_name)) {
          $syllabus_files[] = str_replace('../..', '', $syllabus_folder) . $syllabus_file_name;
        } else {
          echo json_encode(['status' => 503, 'message' => 'Unable to upload Syllabus marksheet!']);
          exit();
        }
      } else {
        echo json_encode(['status' => 302, 'message' => 'Syllabus should be PDF!']);
        exit();
      }
    }
    $syllabus_file = implode("|", $syllabus_files);
  } else {
    $syllabus_file  = $updated_file;
  }
  // $syllabus_file = isset($syllabus_file) ? implode("|", $syllabus_files) : null;


  $add = $conn->query("UPDATE `Syllabus` SET `Syllabus_File` = '$syllabus_file',`Sub_Course_ID` = '$sub_course_id',`Subject_ID` = '$subject_type',
  `Syllabus_Type` = '$syllabus_type',`Syllabus_Content` = '$syllabus_content' WHERE ID = $id");
  if ($add) {
    echo json_encode(['status' => 200, 'message' => 'Syllabus updated successlly!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
