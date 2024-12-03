<?php
require '../../includes/db-config.php';

if(isset($_POST['program_id'])) {
    $programID = mysqli_real_escape_string($conn, $_POST['program_id']);
    $query = "SELECT ID, Name FROM courses WHERE Program_ID = '$programID' AND Status = 1 ORDER BY Name";
    $result = $conn->query($query);

    if($result->num_rows > 0) {
        echo '<option value="">Select Course</option>';
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['ID'].'">'.$row['Name'].'</option>';
        }
    } else {
        echo '<option value="">No Courses Available</option>';
    }
} else {
    echo '<option value="">Select Program First</option>';
}
?>
