<?php
require '../../includes/db-config.php';

if(isset($_POST['course_id'])) {
    $courseID = mysqli_real_escape_string($conn, $_POST['course_id']);
    $query = "SELECT ID, Name FROM specializations WHERE Course_ID = '$courseID' AND Status = 1 ORDER BY Name";
    $result = $conn->query($query);

    if($result->num_rows > 0) {
        echo '<option value="">Select Specialization</option>';
        while($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['ID'].'">'.$row['Name'].'</option>';
        }
    } else {
        echo '<option value="">No Specializations Available</option>';
    }
} else {
    echo '<option value="">Select Course First</option>';
}
?>
