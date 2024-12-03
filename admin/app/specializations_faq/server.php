<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT ID, Question, Answer,Specialization_ID, Department_ID, Program_ID, Course_ID, Status, Created_At FROM specializations_faq ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($results)) {
$no = $i++;

// $department_id= $row['Department_ID'];
// $departmentQuery = $conn->query("SELECT Name FROM departments WHERE ID  = $department_id");
// $departmentArr = mysqli_fetch_assoc($departmentQuery);

// $program_id= $row['Program_ID'];
// $programQuery = $conn->query("SELECT Name FROM programs WHERE ID  = $program_id");
// $programArr = mysqli_fetch_assoc($programQuery);

// $course_id= $row['Course_ID'];
// $courseQuery = $conn->query("SELECT Name FROM courses WHERE ID  = $course_id");
// $courseArr = mysqli_fetch_assoc($courseQuery);

$specialization_id= $row['Specialization_ID'];
$specializationQuery = $conn->query("SELECT Name FROM specializations WHERE ID  = $specialization_id");
$specializationArr = mysqli_fetch_assoc($specializationQuery);

    $data[] = array( 
      "No" => $no,
      "ID"=>$row['ID'],
      "Question" => $row["Question"],
      "Answer" => $row["Answer"],
      // "Department"=>$departmentArr["Name"],
      // "Program"=>$programArr["Name"],
      // "Course"=>$courseArr["Name"],
      "Specialization"=>$specializationArr["Name"],
      "Status" => $row["Status"],
      "Created_At" => $row["Created_At"],
    );
}
echo json_encode(['data' => $data]);

