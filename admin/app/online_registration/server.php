<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, StudentFirstName,StudentLastName, EmailId, PhoneNo,  CreatedAt FROM online_registration ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;

   
    $fullName = $row["StudentFirstName"] . ' ' . $row["StudentLastName"];
 
   
  $data[] = array(
    "No" => $no,
    "ID" => $row['ID'],
    "Name" =>  $fullName,
    "Phone" => $row["PhoneNo"],
    "Subject" => $row['EmailId'],
    // "Sector" => $sectorArr['Name'],
    // "Course" => $courseArr['Name'],
    "Created_At" => $row["CreatedAt"],
  );
}

echo json_encode(['data' => $data]);
