<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Name, Categories_ID, Department_ID, Status, Created_At FROM programs ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($results)) {
  $no = $i++;


  $categories_id = $row['Categories_ID'];
  $categoryQuery = $conn->query("SELECT Name FROM categories WHERE ID = $categories_id");
  $categoryArr = $categoryQuery->fetch_assoc();

  $department_id = $row['Department_ID'];
  $departmentQuery = $conn->query("SELECT Name FROM departments WHERE ID  = $department_id");
  $departmentArr = mysqli_fetch_assoc($departmentQuery);

  $data[] = array(
    "No" => $no,
    "ID" => $row['ID'],
    "Name" => $row["Name"],
    "Category" => $categoryArr["Name"],
    "Department" => $departmentArr["Name"],
    "Status" => $row["Status"],
    "Created_At" => $row["Created_At"],
  );
}
echo json_encode(['data' => $data]);
