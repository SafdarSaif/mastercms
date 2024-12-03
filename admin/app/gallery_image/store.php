<?php
if (isset($_POST['gallery_id']) && isset($_FILES['images'])) {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';
    session_start();

    
    $gallery_id = $_POST['gallery_id'];

    
    $imageLinks = uploadsImage($conn, "images", "gallery_image");
    if (!$imageLinks) {
        echo json_encode(['status' => 400, 'message' => 'Unable to upload image!']);
        exit;
    }

    
    $status = 1;

    
    $imageLinksString = implode(', ', $imageLinks);
    $imageLinksString = mysqli_real_escape_string($conn, $imageLinksString);

    $add = $conn->query("INSERT INTO `gallery_image`(`gallery_id`, `image_url`, `status`)
                          VALUES ('$gallery_id', '$imageLinksString', '$status')");

    
    if ($add) {
        echo json_encode(['status' => 200, 'message' => 'Data added successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Something went wrong while adding data!']);
    }
}
?>
