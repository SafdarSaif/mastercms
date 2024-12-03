<?php
if (isset($_POST['name']) && isset($_POST['id'])) {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';

    session_start();

    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = baseurl($name);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_key = mysqli_real_escape_string($conn, $_POST['meta_key']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $updated_file = mysqli_real_escape_string($conn, $_POST['updated_file']); 

    if (isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"] != '') {
        $photo = uploadImage($conn, "photo", "pages"); 

        if ($photo && file_exists("../../" . ltrim($updated_file, "/"))) {
            unlink("../../" . ltrim($updated_file, "/"));
        }
    } else {
        $photo = $updated_file; 
    }

    // Check for duplicate name
    $check = $conn->query("SELECT ID FROM pages WHERE (Name LIKE '$name') AND ID <> $id");
    if ($check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
        exit();
    }

    // Update the database
    $update = $conn->query("
        UPDATE `pages` 
        SET `Name` = '$name',
            `Slug` = '$slug',
            `Photo` = '$photo',
            `Content` = '$content',
            `Meta_Title` = '$meta_title',
            `Meta_Key` = '$meta_key',
            `Meta_Description` = '$meta_description' 
        WHERE ID = $id
    ");

    if ($update) {
        echo json_encode(['status' => 200, 'message' => $name . ' updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
    }
}
