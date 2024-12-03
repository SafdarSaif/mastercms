<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Highlight_Text, Status, Created_At FROM highlights ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;
  if(strlen($row['Highlight_Text']) > 100){
    $destext = substr($row['Highlight_Text'], 0, 100) . "...";
  }else{
    $destext = $row['Highlight_Text'];
  }

   // Split the image URLs into an array
  //  $imageUrls = explode(', ', $row['image_link']);
  
      $data[] = array( 
        "No" => $no,
        "ID"=>$row['ID'],
        "Names"=> $destext,
        // "Short_description"=> $destext,
        // "Images"=>$row["Image"],
        "Status" => $row["Status"],
        "Created_At" => $row["Created_At"],
      );
  }


echo json_encode(['data' => $data]);

