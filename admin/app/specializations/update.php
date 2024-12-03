<?php
if (isset($_POST['id']) && isset($_POST['name'])) {
    require '../../includes/db-config.php';
    require '../../includes/helper.php';
    session_start();

    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = baseurl($name);
    $short_Name = mysqli_real_escape_string($conn, $_POST['Short_Name']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $eligibility = mysqli_real_escape_string($conn, $_POST['eligibility']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $updated_file = mysqli_real_escape_string($conn, $_POST['updated_file']);


    $department_ID = isset($_POST['Department_ID']) ? intval($_POST['Department_ID']) : null;
    $program_ID = isset($_POST['Program_ID']) ? intval($_POST['Program_ID']) : null;
    $course_ID = isset($_POST['Course_ID']) ? mysqli_real_escape_string($conn, $_POST['Course_ID']) : '';

    if (isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"] != '') {
        $photo = uploadImage($conn, "photo", "specialization");
    } else {
        $photo = $updated_file;
    }


    if (empty($name) || empty($short_Name) || empty($position)) {
        echo json_encode(['status' => 403, 'message' => 'All fields are mandatory!']);
        exit();
    }

    // $check = $conn->query("SELECT ID FROM specializations WHERE Name = '$name' AND Department_ID = '$department_ID' AND ID != '$id'");
    // if ($check && $check->num_rows > 0) {
    //     echo json_encode(['status' => 400, 'message' => $name . ' already exists for the selected department!']);
    //     exit();
    // }

    $check = $conn->query("SELECT ID FROM specializations WHERE Name = '$name' AND Department_ID = '$department_ID' AND Program_ID = '$program_ID' AND Course_ID = '$course_ID' AND ID != '$id'");
    if ($check && $check->num_rows > 0) {
        echo json_encode(['status' => 400, 'message' => $name . ' already exists for the selected department!']);
        exit();
    }

    $update = $conn->query("UPDATE specializations SET 
                            Name = '$name', 
                            Slug = '$slug', 
                            Department_ID = '$department_ID', 
                            Program_ID = '$program_ID',
                            Course_ID = '$course_ID',
                            Short_Name = '$short_Name', 
                            Content = '$content', 
                            Position = '$position',
                            Photo = '$photo',
                            Eligibility = '$eligibility',
                            Durations = '$duration',
                            Description = '$description'  
                            WHERE ID = $id");

    if ($update) {
        echo json_encode(['status' => 200, 'message' => $name . ' updated successfully!']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Something went wrong!']);
    }
}
