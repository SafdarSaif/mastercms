<?php
require '../../includes/db-config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize session if not already started
    session_start();

    // Get and sanitize input data
    $id = intval($_POST['id']);
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);

    // Validate input data
    if (empty($question) || empty($answer)) {
        echo json_encode(['status' => 403, 'message' => 'Question and Answer are mandatory fields!']);
        exit();
    }

    // Check if the question already exists for other FAQs
    $checkQuery = "SELECT id FROM faqs WHERE question LIKE '$question' AND id <> $id";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult !== false && $checkResult->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => 'Question already exists for another FAQ!']);
        exit();
    }

    // Perform the update operation
    $updateQuery = "UPDATE faqs SET question = '$question', answer = '$answer' WHERE id = $id";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {
        echo json_encode(['status' => 200, 'message' => 'FAQ updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Failed to update FAQ. Please try again later.']);
    }
}
?>
