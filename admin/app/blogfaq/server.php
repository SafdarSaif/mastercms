<?php
include('../../includes/db-config.php'); 
session_start();

## Fetch records
$result_record = "SELECT id, blog_id, questions, answers, status, Created_At FROM blogsfaq ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($results)) {
    $no = $i++;
    $blog_id = $row['blog_id'];
    $blogQuery = $conn->query("SELECT Name FROM blogs WHERE ID = $blog_id");
    $blogArr = $blogQuery->fetch_assoc();

    $questiontext = strlen($row['questions']) > 20 ? substr($row['questions'], 0, 20) . "..." : $row['questions'];
    $answertext = strlen($row['answers']) > 20 ? substr($row['answers'], 0, 20) . "..." : $row['answers'];
    

    $data[] = array(
        "No" => $no,
        "ID" => $row['id'],
        "Blog_Name" => $blogArr["Name"],
        "Question" => $questiontext,
        "Answer" => $answertext,
        "Status" => $row["status"],
        "Created_At" => $row["Created_At"],
    );
}
echo json_encode(['data' => $data]);
?>

