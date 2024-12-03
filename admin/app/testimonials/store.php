<?php

if (isset($_POST['name'])) {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';
    session_start();

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $profile = mysqli_real_escape_string($conn, $_POST['profile']);
    $rating = (int) $_POST['rating'];
    $testimonial = mysqli_real_escape_string($conn, $_POST['testimonial_content']);
    // $testimonial_content = mysqli_real_escape_string($conn, $_POST['testimonial_content']);


    if ($_FILES["image"]["name"]) {
        $filename = uploadImage($conn, "image", "testimonials");
    } else {
        $filename = "/admin-assets/img/default-profile.jpg"; // Default image path
    }

    if (empty($name) || empty($profile) || empty($testimonial)) {
        echo json_encode(['status' => 403, 'message' => 'Name, Profile, and Testimonial are mandatory!']);
        exit();
    }

    $check = $conn->query("SELECT ID FROM testimonials WHERE Name LIKE '$name'");
    if ($check && $check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
        exit();
    }

    $add = $conn->query("INSERT INTO `testimonials`(`Name`, `Profile`, `Image`, `Rating`, `Testimonial`)
                      VALUES ('$name', '$profile', '$filename', $rating, '$testimonial')");

    if ($add) {
        echo json_encode(['status' => 200, 'message' => $name . ' added successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
    }
}
