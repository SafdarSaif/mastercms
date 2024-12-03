<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    // Escape user inputs for security
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $updated_file = mysqli_real_escape_string($conn, $_POST['updated_file']);

    // Validate incoming data
    if (empty($id) || empty($title) || empty($subtitle) || empty($content)) {
        echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
        exit();
    }

    // Handle file upload for image
    if (isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"]) {
        $filename = uploadImage($conn, "photo", "about_university");
        if (!$filename) {
            echo json_encode(['status' => 400, 'message' => 'Failed to upload image.']);
            exit();
        }
    } else {
        // If no new file is uploaded, keep the existing image
        $filename = $updated_file;
    }

    // Check for duplicate title
    $check = $conn->query("SELECT ID FROM about_university WHERE Title = '$title' AND ID != '$id'");
    if ($check && $check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $title . ' already exists!']);
        exit();
    }

    // Build the update query
    $query = "UPDATE about_university SET 
                Title = '$title', 
                Subtitle = '$subtitle', 
                Content = '$content',
                Image = '$filename'
              WHERE ID = '$id'";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 200, 'message' => 'University content updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Error updating content: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 405, 'message' => 'Method Not Allowed']);
}
?>
