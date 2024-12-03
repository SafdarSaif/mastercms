<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Name, Department_ID, Program_ID, Status, Created_At FROM courses ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($results)) {
$no = $i++;

$department_id= $row['Department_ID'];
$departmentQuery = $conn->query("SELECT Name FROM departments WHERE ID  = $department_id");
$departmentArr = mysqli_fetch_assoc($departmentQuery);

$program_id= $row['Program_ID'];
$programQuery = $conn->query("SELECT Name FROM programs WHERE ID  = $program_id");
$programArr = mysqli_fetch_assoc($programQuery);

    $data[] = array( 
      "No" => $no,
      "ID"=>$row['ID'],
      "Name" => $row["Name"],
      "Department"=>$departmentArr["Name"],
      "Program"=>$programArr["Name"],
      "Status" => $row["Status"],
      "Created_At" => $row["Created_At"],
    );
}
echo json_encode(['data' => $data]);

