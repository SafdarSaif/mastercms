<?php
ini_set('display_errors', 1);

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['old_password'])) {
    require '../../includes/db-config.php';
    session_start();

    $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($old_password) || empty($password)) {
        echo json_encode(['status' => 403, 'message' => 'Passwords cannot be empty!']);
        session_destroy();
        exit();
    }

    // <--Check old password-->
    $result = $conn->query("SELECT AES_DECRYPT(Password, '60ZpqkOnqn0UQQ2MYTlJ') AS Password FROM users WHERE ID = '1'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['Password'] !== $old_password) {
            echo json_encode(['status' => 403, 'message' => 'Old password is incorrect!']);
            session_destroy();
            exit();
        }
        // Check old& new password does not same
        if ($old_password === $password) {
            echo json_encode(['status' => 403, 'message' => 'New password cannot be the same as the old password!']);
            session_destroy();
            exit();
        }
    } else {
        echo json_encode(['status' => 500, 'message' => 'User not found!']);
        session_destroy();
        exit();
    }

    // Update username 
    $updateQueries = [];
    if (!empty($_POST['username'])) {
        $username = mysqli_real_escape_string($conn, strtoupper($_POST['username']));
        $updateQueries[] = "UPDATE users SET Code = '$username' WHERE ID = '1'";
    }

    $updateQueries[] = "UPDATE users SET Password = AES_ENCRYPT('$password', '60ZpqkOnqn0UQQ2MYTlJ') WHERE ID = '1'";

    // Execute update queries
    $updateSuccess = true;
    foreach ($updateQueries as $query) {
        if (!empty($query)) {
            if ($conn->query($query) !== TRUE) {
                $updateSuccess = false;
                echo json_encode(['status' => 500, 'message' => 'Error updating: ' . $conn->error]);
                break;
            }
        }
    }

    if ($updateSuccess) {
        echo json_encode(['status' => 200, 'message' => 'Username and password updated successfully!', 'url' => '/admin/streams/']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 403, 'message' => 'Forbidden']);
    session_destroy();
    exit();
}
