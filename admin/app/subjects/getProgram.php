<?php
// Include your database configuration file here
if (isset($_GET['sector_id'])) {
    require '../../includes/db-config.php';

    $sector_id = intval($_GET['sector_id']);
    $programs = $conn->query("SELECT ID, Name FROM Courses WHERE Stream_ID = $sector_id ORDER BY ID DESC");

    if ($programs && $programs->num_rows > 0) {
        while ($row = $programs->fetch_assoc()) {
            echo '<option value="' . $row['ID'] . '">' . $row['Name'] . '</option>';
        }
    } else {
        echo '<option value="">No programs found</option>';
    }
} else {
    echo '<option value="">No sector selected</option>';
}
?>
