<?php
if (isset($_POST['question'])) {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';
    session_start();

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

    $check = $conn->query("SELECT ID FROM specializations_faq WHERE Specialization_ID = '$specialization_ID' AND question = '$question'");
    if ($check && $check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => 'This question already exists for the selected specialization!']);
        exit();
    }

    $add_query = "INSERT INTO specializations_faq (Department_ID, Program_ID, Course_ID, Specialization_ID, question, answer) 
                  VALUES ('$department_ID', '$program_ID', '$course_ID', '$specialization_ID', '$question', '$answer')";

    $add = $conn->query($add_query);
    if ($add) {
        echo json_encode(['status' => 200, 'message' => 'FAQ added successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
    }
}
?>
