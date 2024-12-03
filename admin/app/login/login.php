<?php
ini_set('display_errors', 1);
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
  require '../../includes/db-config.php';

  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($username) || empty($password)) {
    echo json_encode(['status' => 403, 'message' => 'Fields cannot be empty!']);
    session_destroy();
    exit();
  }

  // // query for change the password 
  // $conn->query("UPDATE users 
  // SET `Password` = AES_ENCRYPT( 'Apple@12345', '60ZpqkOnqn0UQQ2MYTlJ' ) 
  // WHERE ID =  '1' ");

  $CheckQuery = "
        SELECT * 
        FROM users 
        WHERE Code = '$username' 
        AND Password = AES_ENCRYPT('$password', '60ZpqkOnqn0UQQ2MYTlJ')
    ";

  $check = $conn->query($CheckQuery);

  if ($check->num_rows > 0) {
    $user_details = $check->fetch_assoc();
    if ($user_details['Status'] == 1) {
      foreach ($user_details as $key => $user_detail) {
        $_SESSION[$key] = $user_detail;
      }
      echo json_encode(['status' => 200, 'message' => 'Welcome ' . $user_details['Name'], 'url' => '/admin']);
    } else {
      echo json_encode(['status' => 403, 'message' => 'Access denied! Please contact administrator.']);
      session_destroy();
    }
  } else {
    echo json_encode(['status' => 400, 'message' => 'Invalid credentials!']);
    session_destroy();
  }
} else {
  echo json_encode(['status' => 403, 'message' => 'Forbidden']);
  session_destroy();
}
