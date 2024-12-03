<?php
## Database configuration
include '../../includes/db-config.php';
session_start();
## Fetch records
$result_record = "SELECT id, gallery_id, image_url, status, Created_At FROM gallery_image ORDER BY ID DESC";
$results = mysqli_query($conn, $result_record);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($results)) {
    $no = $i++;

    $gallery_id = $row['gallery_id'];
    $galleryQuery = $conn->query("SELECT image_name FROM gallery WHERE id = $gallery_id");
    $galleryArr = $galleryQuery->fetch_assoc();

    $imageUrls = explode(', ', $row['image_url']);

    // Limit the number of images 
    $limitedImageUrls = array_slice($imageUrls, 0, 1);

    $data[] = array( 
        "No" => $no,
        "ID" => $row['id'],
        "ImageName" => $galleryArr["image_name"],
        "Images" => $limitedImageUrls, 
        "Status" => $row["status"],
        "Created_At" => $row["Created_At"],
    );
}

echo json_encode(['data' => $data]);
?>
