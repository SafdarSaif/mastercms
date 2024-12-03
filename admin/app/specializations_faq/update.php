<?php
if (isset($_POST['id']) && isset($_POST['question'])) {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';
    session_start();

    $id = intval($_POST['id']);
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);
    $department_ID = isset($_POST['Department_ID']) ? mysqli_real_escape_string($conn, $_POST['Department_ID']) : '';
    $program_ID = isset($_POST['Program_ID']) ? mysqli_real_escape_string($conn, $_POST['Program_ID']) : '';
    $course_ID = isset($_POST['Course_ID']) ? mysqli_real_escape_string($conn, $_POST['Course_ID']) : '';
    $specialization_ID = isset($_POST['Specialization_ID']) ? mysqli_real_escape_string($conn, $_POST['Specialization_ID']) : '';

    if (empty($question) || empty($answer) || empty($department_ID) || empty($program_ID) || empty($course_ID) || empty($specialization_ID)) {
        echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
        exit();
    }

    // Check if the question already exists for the given specialization, excluding the current record
    $checkQuery = "SELECT ID FROM specializations_faq WHERE Specialization_ID = '$specialization_ID' AND question = '$question' AND ID != $id";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => 'This question already exists for the selected specialization!']);
        exit();
    }

    // Prepare and execute the update query
    $updateQuery = "UPDATE specializations_faq SET 
                    Department_ID = '$department_ID', 
                    Program_ID = '$program_ID', 
                    Course_ID = '$course_ID', 
                    Specialization_ID = '$specialization_ID', 
                    question = '$question', 
                    answer = '$answer' 
                    WHERE ID = $id";

    if ($conn->query($updateQuery)) {
        echo json_encode(['status' => 200, 'message' => 'FAQ updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
    }
} else {
    echo json_encode(['status' => 403, 'message' => 'Invalid request.']);
}
