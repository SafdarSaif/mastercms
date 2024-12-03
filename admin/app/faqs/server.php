<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Question,Answer, Status, Created_At FROM faqs ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;
  if(strlen($row['Answer']) > 20){
    $destext = substr($row['Answer'], 0, 20) . "...";
  }else{
    $destext = $row['Answer'];
  }

   // Split the image URLs into an array
  //  $imageUrls = explode(', ', $row['image_link']);
  
      $data[] = array( 
        "No" => $no,
        "ID"=>$row['ID'],
        "Questions"=> $row["Question"],
        "Answers"=>  $destext,
        // "Images"=>$imageUrls,
        "Status" => $row["Status"],
        "Created_At" => $row["Created_At"],
      );
  }


echo json_encode(['data' => $data]);

