<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';
    session_start();

    // Retrieve and sanitize form inputs
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $filename = null;

    if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"]) {
        $filename = uploadImage($conn, "image", "about_university");
        if (!$filename) {
            echo json_encode(['status' => 400, 'message' => 'Failed to upload image']);
            exit();
        }
    }

    if (empty($title) || empty($subtitle) || empty($content)) {
        echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
        exit();
    }

    $check = $conn->query("SELECT ID FROM about_university WHERE Title = '$title'");
    if ($check && $check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $title . ' already exists!']);
        exit();
    }

    $addQuery = "INSERT INTO about_university (Title, Subtitle, Content, Image) 
                 VALUES ('$title', '$subtitle', '$content', '$filename')";

    if ($conn->query($addQuery) === TRUE) {
        echo json_encode(['status' => 200, 'message' => $title . ' added successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
    }

    // $conn->close();
}
?>
