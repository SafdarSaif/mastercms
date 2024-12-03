<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Name, Status, Created_At, Photo, Description FROM blogs ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;
  if(strlen($row['Description']) > 20){
    $destext = substr($row['Description'], 0, 20) . "...";
  }else{
    $destext = $row['Description'];
  }
  
      $data[] = array( 
        "No" => $no,
        "ID"=>$row['ID'],
        "Name" => $row["Name"],
        "Description"=> $destext,
        "Photo"=>$row['Photo'],
        "Status" => $row["Status"],
        "Created_At" => $row["Created_At"],
      );
  }


echo json_encode(['data' => $data]);

