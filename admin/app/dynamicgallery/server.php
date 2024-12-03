<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT id, video_link, image_name, image_link, status, Created_At FROM gallery ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;
  // if(strlen($row['Description']) > 20){
  //   $destext = substr($row['Description'], 0, 20) . "...";
  // }else{
  //   $destext = $row['Description'];
  // }

   // Split the image URLs into an array
   $imageUrls = explode(', ', $row['image_link']);
  
      $data[] = array( 
        "No" => $no,
        "ID"=>$row['id'],
        "Video" => $row["video_link"],
        "Name"=> $row["image_name"],
        "Images"=>$imageUrls,
        "Status" => $row["status"],
        "Created_At" => $row["Created_At"],
      );
  }


echo json_encode(['data' => $data]);

