<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Name, Profile, Image, Testimonial, Rating,Status,Created_At FROM testimonials ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;
  if (strlen($row['Testimonial']) > 20) {
    $destext = substr($row['Testimonial'], 0, 20) . "...";
  } else {
    $destext = $row['Testimonial'];
  }

  $data[] = array(
    "No" => $no,
    "ID" => $row['ID'],
    "Name" => $row["Name"],
    "Profile" => $row["Profile"],
    "Image" => $row["Image"],
    "Testimonial" => $destext,
    "Rating" => $row["Rating"],
    "Status" => $row["Status"],
    "Created_At" => $row["Created_At"],
  );
}

echo json_encode(['data' => $data]);
