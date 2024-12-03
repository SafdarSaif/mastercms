<?php

if (isset($_POST['sub_course'])) {
  require '../../includes/db-config.php';
  session_start();

  $sub_course_id = mysqli_real_escape_string($conn, $_POST['sub_course']);
  $subject_type = mysqli_real_escape_string($conn, $_POST['subject_type']);
  $syllabus_type = mysqli_real_escape_string($conn, $_POST['syllabus_type']);
  $syllabus_content = mysqli_real_escape_string($conn, $_POST['syllabus_content']);

  $syllabus_folder = '../../uploads/syllabus/';
  $allowed_file_extensions = array("pdf","PDF");

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
  }
  $syllabus_file = isset($syllabus_file) ? implode("|", $syllabus_files) : null;

  $add = $conn->query("INSERT INTO `Syllabus`(`Syllabus_Type`,`Syllabus_Content`,`Syllabus_File`,`Sub_Course_ID`,`Subject_ID`) VALUES ('$syllabus_type','$syllabus_content','$syllabus_file','$sub_course_id', '$subject_type')");
  if ($add) {
    echo json_encode(['status' => 200, 'message' => 'Syllabus Added successlly!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
