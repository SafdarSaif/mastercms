<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['name']) && isset($_POST['id'])) {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';

    session_start();

    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = baseurl($name);
    $position = mysqli_real_escape_string($conn, $_POST['position']);

    $has_page = isset($_POST['has_page']) ? 1 : 0;
    $has_url = isset($_POST['has_url']) ? 1 : 0;
    $has_parent = isset($_POST['has_parent']) ? 1 : 0;

    if ($has_page === 1) {
        $has_url = 0;
        $has_parent = 0;
    } elseif ($has_url === 1) {
        $has_page = 0;
        $has_parent = 0;
    } elseif ($has_parent === 1) {
        $has_page = 0;
        $has_url = 0;
    }

    $parent_menu = isset($_POST['parent_menu']) ? mysqli_real_escape_string($conn, $_POST['parent_menu']) : null;
    $page_url = isset($_POST['page_url']) ? mysqli_real_escape_string($conn, $_POST['page_url']) : null;
    $custom_url = isset($_POST['custom_url']) ? mysqli_real_escape_string($conn, $_POST['custom_url']) : null;

    if ($has_page === 1) {
        $custom_url = null;
        $parent_menu = null;
    } elseif ($has_url === 1) {
        $page_url = null;
        $parent_menu = null;
    } elseif ($has_parent === 1) {
        $page_url = null;
        $custom_url = null;
    }

    $updated_file = mysqli_real_escape_string($conn, $_POST['updated_file']);
    if (isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"] != '') {
        $photo = uploadImage($conn, "photo", "menus");
        if (!$photo) {
            echo json_encode(['status' => 400, 'message' => 'Failed to upload the photo.']);
            exit();
        }
    } else {
        $photo = $updated_file;
    }

    $check = $conn->query("SELECT ID FROM menus WHERE Name = '$name' AND ID <> $id");
    if ($check !== false && $check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $name . ' already exists!']);
        exit();
    }

    $updateQuery = "UPDATE `menus` 
                       SET `Name` = '$name', `Slug` = '$slug', `Photo` = '$photo', `Position` = '$position', 
                        `Has_Page` = '$has_page', `Has_Url` = '$has_url', `Has_Parent` = '$has_parent', 
                        `Parent_Menu_ID` = '$parent_menu', `Page_Url` = '$page_url', `Custom_Url` = '$custom_url'
                    WHERE ID = $id";

    if ($conn->query($updateQuery)) {
        echo json_encode(['status' => 200, 'message' => $name . ' updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
    }
}
