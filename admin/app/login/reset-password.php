<?php
ini_set('display_errors', 1);
require '../../includes/db-config.php';
session_start();

if (isset($_POST['token']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    if ($password !== $confirm_password) {
        echo json_encode(['status' => 400, 'message' => 'Passwords do not match.']);
        exit();
    }
    
    $result = $conn->query("SELECT ID FROM users WHERE reset_token = '$token' AND reset_requested_at > NOW() - INTERVAL 1 HOUR");
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $update = $conn->query("UPDATE users SET Password = AES_ENCRYPT('$password', '60ZpqkOnqn0UQQ2MYTlJ'), reset_token = NULL WHERE ID = " . $user['ID']);
        
        if ($update) {
            echo json_encode(['status' => 200, 'message' => 'Password reset successfully.', 'url' => '/admin/login']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Failed to reset password.']);
        }
    } else {
        echo json_encode(['status' => 400, 'message' => 'Invalid or expired token.']);
    }
} else {
    echo json_encode(['status' => 400, 'message' => 'Bad request.']);
}
?>
