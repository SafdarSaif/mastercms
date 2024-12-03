<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $id = intval($_POST['id']);
    $gallery_id = intval($_POST['gallery_id']);
    $existing_images = isset($_POST['existing_images']) ? $_POST['existing_images'] : [];

    // Initialize arrays to hold image URLs
    $updated_image_urls = [];

    // Process new images
    $new_image_urls = [];
    if (isset($_FILES['new_images'])) {
        $new_images = $_FILES['new_images'];
        foreach ($new_images['tmp_name'] as $key => $tmp_name) {
            if (!empty($tmp_name) && is_uploaded_file($tmp_name)) {
                $target_dir = "../../uploads/"; // Specify target directory
                $file_name = basename($new_images['name'][$key]); // Get the file name
                $target_file = $target_dir . $file_name; // Specify target file path

                // Move uploaded file to the target directory
                if (move_uploaded_file($tmp_name, $target_file)) {
                    // Store the new image URL
                    $new_image_urls[] = "/uploads/" . $file_name;
                } else {
                    echo json_encode(['status' => 400, 'message' => 'Failed to upload one or more images!']);
                    exit();
                }
            }
        }
    }

    // Replace specific images if requested
    foreach ($existing_images as $index => $existing_image) {
        if (isset($_FILES["new_images"]["name"][$index]) && !empty($_FILES["new_images"]["tmp_name"][$index])) {
            if (!empty($existing_image)) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $existing_image) && $existing_image !== "/admin-assets/img/default-program.jpg") {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $existing_image);
                }
            }

            $uploaded_image_url = $new_image_urls[$index] ?? '';
            if (!empty($uploaded_image_url)) {
                $updated_image_urls[] = $uploaded_image_url;
                unset($new_image_urls[$index]); // Remove the used new image URL
            }
        } else {
            $updated_image_urls[] = $existing_image;
        }
    }

    // Merge remaining new images that were not used for replacement
    $all_image_urls = array_merge($updated_image_urls, $new_image_urls);

    // Convert image URLs array to a comma-separated string
    $image_urls_str = implode(', ', $all_image_urls);
    $image_urls_str = mysqli_real_escape_string($conn, $image_urls_str);

    // Update the database with the new image URLs
    $update_query = "UPDATE gallery_image SET gallery_id = $gallery_id, image_url = '$image_urls_str' WHERE id = $id";
    $update_result = $conn->query($update_query);

    if ($update_result) {
        echo json_encode(['status' => 200, 'message' => 'Gallery updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Failed to update gallery!']);
    }
}
?>
