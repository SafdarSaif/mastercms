<?php

if (isset($_POST['highlight'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  session_start();

  $highlight = mysqli_real_escape_string($conn, $_POST['highlight']);

  if (empty($highlight)) {
    echo json_encode(['status' => 403, 'message' => 'Highlight is mandatory!']);
    exit();
  }

  $addQuery = "INSERT INTO highlights (Highlight_Text) VALUES ('$highlight')";

  if ($conn->query($addQuery) === TRUE) {
    echo json_encode(['status' => 200, 'message' => 'Highlight added successfully!']);
  } else {
    echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
  }
}
?>
