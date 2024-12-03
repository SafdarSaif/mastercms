<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Subject_ID,Sub_Course_ID,Syllabus_Type,Syllabus_File FROM Syllabus ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($results)) {

  $subjectQuery = $conn->query("SELECT Name FROM Subjects where ID = '".$row['Subject_ID']."' AND Sub_Course_ID  = '".$row['Sub_Course_ID']."' ");
  $subjectArr =$subjectQuery->fetch_assoc();
 
$no = $i++;
    $data[] = array( 
      "No" => $no,
      "ID"=>$row['ID'],
      "Subject"=>empty($subjectArr['Name'])?'':$subjectArr['Name'],
      "Syllabus_Type"=>$row['Syllabus_Type'],
      "Syllabus_File"=>$row['Syllabus_File'],
    );
}

echo json_encode(['data' => $data]);

