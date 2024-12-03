<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Name,Short_Description,Image, Status, Created_At FROM labs ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;
  if(strlen($row['Short_Description']) > 20){
    $destext = substr($row['Short_Description'], 0, 20) . "...";
  }else{
    $destext = $row['Short_Description'];
  }

   // Split the image URLs into an array
  //  $imageUrls = explode(', ', $row['image_link']);
  
      $data[] = array( 
        "No" => $no,
        "ID"=>$row['ID'],
        "Names"=> $row["Name"],
        "Short_description"=> $destext,
        "Images"=>$row["Image"],
        "Status" => $row["Status"],
        "Created_At" => $row["Created_At"],
      );
  }


echo json_encode(['data' => $data]);

