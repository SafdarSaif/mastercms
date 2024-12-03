<?php
## Database configuration
include '../../includes/db-config.php';
session_start();

## Fetch records
$result_record = "SELECT ID, Title, Subtitle, Content, Image, Status, Created_At FROM about_university ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
    $no = $i++;
    $contentData = strlen($row['Content']) > 40 ? substr($row['Content'], 0, 40) . "..." : $row['Content'];
    $subtitleData = strlen($row['Subtitle']) > 40 ? substr($row['Subtitle'], 0, 40) . "..." : $row['Subtitle'];

    $data[] = array(
        "No" => $no,
        "ID" => $row['ID'],
        "Title" => $row['Title'],
        "Subtitle" => $subtitleData,
        "Content" => $contentData,
        "Image" => $row['Image'],
        "Status" => $row['Status'],
        "Created_At" => $row['Created_At'],
    );
}

echo json_encode(['data' => $data]);
