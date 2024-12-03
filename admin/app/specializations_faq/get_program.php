<?php
require '../../includes/db-config.php';

if(isset($_POST['department_id'])) {
    $departmentID = mysqli_real_escape_string($conn, $_POST['department_id']);
    $query = "SELECT ID, Name FROM programs WHERE Department_ID = '$departmentID' AND Status = 1 ORDER BY Name";
    $result = $conn->query($query);

    if($result->num_rows > 0) {
        echo '<option value="">Select Program</option>';
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['ID'].'">'.$row['Name'].'</option>';
        }
    } else {
        echo '<option value="">No Programs Available</option>';
    }
} else {
    echo '<option value="">Select Department First</option>';
}
?>
