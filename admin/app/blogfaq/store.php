<?php
if (isset($_POST['question'], $_POST['answer'], $_POST['blog_id'])) {
    require '../../includes/db-config.php';
    session_start();

    $blog_id = mysqli_real_escape_string($conn, $_POST['blog_id']);
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);

    if (empty($question) || empty($answer)) {
        echo json_encode(['status'=>403, 'message'=>'All fields are mandatory!']);
        exit();
    }

    // // Check if the question already exists
    // $check = $conn->query("SELECT ID FROM blogsfaq WHERE (Name like '$name') AND blog_id=$blog_id");
    // $checkResult = $conn->query($checkQuery);
    // if ($checkResult && $checkResult->num_rows > 0) {
    //     echo json_encode(['status'=>400, 'message'=>'Question already exists!']);
    //     exit();
    // }

    // Insert the new FAQ entry
    $insertQuery = "INSERT INTO `blogsfaq`(`blog_id`, `questions`, `answers`) VALUES ('$blog_id', '$question', '$answer')";
    $insertResult = $conn->query($insertQuery);
    if ($insertResult) {
        echo json_encode(['status'=>200, 'message'=>'FAQ added successfully!']);
    } else {
        echo json_encode(['status'=>400, 'message'=>'Failed to add FAQ!']);
    }
} else {
    echo json_encode(['status'=>400, 'message'=>'Invalid request!']);
}
?>
