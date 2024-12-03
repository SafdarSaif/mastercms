<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['name']);
    $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
    $full_description = mysqli_real_escape_string($conn, $_POST['full_description']);
    // $tags = mysqli_real_escape_string($conn, $_POST['tags']);
    $updated_file = mysqli_real_escape_string($conn, $_POST['updated_file']);

    if (empty($id) || empty($title) || empty($full_description)) {
        echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
        exit();
    }

    if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"]) {
        $filename = uploadImage($conn, "image", "methodologies");
        if (!$filename) {
            echo json_encode(['status' => 400, 'message' => 'Failed to upload image.']);
            exit();
        }
    } else {
        $filename = $updated_file;
    }

    $check = $conn->query("SELECT ID FROM methodology WHERE Name = '$title' AND ID != '$id'");
    if ($check && $check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $title . ' already exists!']);
        exit();
    }

    // Build the update query
    $query = "UPDATE methodology SET 
                Name = '$title', 
                Short_Description = '$short_description', 
                Full_Description = '$full_description',
                Image = '$filename'
              WHERE ID = '$id'";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 200, 'message' => 'Methodology updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Error updating methodology: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 405, 'message' => 'Method Not Allowed']);
}
?>
