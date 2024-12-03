<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Name, Email, Mobile, Address, Created_At FROM leads ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;
  // $sector_id = $row['Stream_ID'];
  // $sectorQuery = $conn->query("SELECT Name FROM streams WHERE ID  = $sector_id");
  // $sectorArr = mysqli_fetch_assoc($sectorQuery);

  //  // Fetch course name
  //  $course_id = $row['Course_ID'];
  //  $courseQuery = $conn->query("SELECT Name FROM courses WHERE ID = $course_id");
  //  $courseArr = mysqli_fetch_assoc($courseQuery);
   
  $data[] = array(
    "No" => $no,
    "ID" => $row['ID'],
    "Name" => $row["Name"],
    "Phone" => $row["Mobile"],
    "Subject" => $row['Email'],
    "State" => $row['Address'],
    // "Sector" => $sectorArr['Name'],
    // "Course" => $courseArr['Name'],
    "Created_At" => $row["Created_At"],
  );
}

echo json_encode(['data' => $data]);
