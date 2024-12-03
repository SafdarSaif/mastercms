<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT Subjects.ID, Subjects.Name, CONCAT(Courses.Name, ' (', Streams.Name, ')') as Program  FROM Subjects LEFT JOIN Courses ON Subjects.Course_ID = Courses.ID LEFT JOIN Streams ON Courses.Stream_ID = Streams.ID ORDER BY Subjects.ID DESC";

$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($results)) {
$no = $i++;
    $data[] = array( 
      "No" => $no,
      "ID"=>$row['ID'],
      "Name" => $row["Name"],
      "Program" => ucwords($row["Program"])
    );
}

echo json_encode(['data' => $data]);

