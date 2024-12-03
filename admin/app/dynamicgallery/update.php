<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['image_names']);
    $existingFileName = $_POST['updated_file'];

    if ($_FILES["images"]["name"]) {
        $filename = uploadImage($conn, "images", "gallery");
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $existingFileName) && $existingFileName !== "/admin-assets/img/default-program.jpg") {
            unlink($_SERVER['DOCUMENT_ROOT'] . $existingFileName);
        }
    } else {
        $filename = $existingFileName;
    }


    

    if (empty($name)) {
        echo json_encode(['status' => 403, 'message' => 'Name is mandatory!']);
        exit();
    }

    $check = $conn->query("SELECT id FROM gallery WHERE image_name LIKE '$name' AND id <> $id");

    if ($check !== false && $check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
        exit();
    }

    $update = $conn->query("UPDATE gallery SET image_name = '$name', image_link = '$filename' WHERE id = $id");
    if ($update) {
        echo json_encode(['status' => 200, 'message' => $name . ' updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
    }
}
?>
