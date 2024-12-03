<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    // Escape user inputs for security
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $updated_file = mysqli_real_escape_string($conn, $_POST['updated_file']);

    // Validate incoming data
    if (empty($id) || empty($name) || empty($short_description) || empty($description)) {
        echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
        exit();
    }

    // Handle file upload for image
    if (isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"]) {
        $filename = uploadImage($conn, "photo", "labs");
        if (!$filename) {
            echo json_encode(['status' => 400, 'message' => 'Failed to upload image.']);
            exit();
        }
    } else {
        // If no new file is uploaded, keep the existing image
        $filename = $updated_file;
    }

    // Check for duplicate name
    $check = $conn->query("SELECT ID FROM labs WHERE Name = '$name' AND ID != '$id'");
    if ($check && $check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
        exit();
    }

    // Build the update query
    $query = "UPDATE labs SET 
                Name = '$name', 
                Short_Description = '$short_description', 
                Description = '$description',
                Image = '$filename'
              WHERE ID = '$id'";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 200, 'message' => 'Lab updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Error updating lab: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 405, 'message' => 'Method Not Allowed']);
}
?>