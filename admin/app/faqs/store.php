<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);

    if (empty($question) || empty($answer)) {
        echo json_encode(['status' => 403, 'message' => 'Both Question and Answer are mandatory!']);
        exit();
    }

    $check = $conn->query("SELECT ID FROM faqs WHERE Question LIKE '$question'");

    if ($check !== false && $check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => 'The question already exists!']);
        exit();
    }

    $add = $conn->query("INSERT INTO faqs (Question, Answer) VALUES ('$question', '$answer')");
    if ($add) {
        echo json_encode(['status' => 200, 'message' => 'FAQ added successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
    }
}
?>
