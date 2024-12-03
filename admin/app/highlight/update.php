<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    // Escape user inputs for security
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $highlight = mysqli_real_escape_string($conn, $_POST['highlight']);

    // Validate incoming data
    if (empty($id) || empty($highlight)) {
        echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
        exit();
    }

    // Build the update query
    $query = "UPDATE highlights SET 
                Highlight_Text = '$highlight'
              WHERE id = '$id'";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 200, 'message' => 'Highlight updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Error updating highlight: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 405, 'message' => 'Method Not Allowed']);
}
?>
