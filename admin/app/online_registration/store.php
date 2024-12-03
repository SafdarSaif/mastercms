<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../../includes/db-config.php'; 
    require '../../includes/helper.php'; 
    session_start();

    // Sanitize and validate form inputs
    $centerId = isset($_POST['center_id']) ? mysqli_real_escape_string($conn, $_POST['center_id']) : null;
    $refBy = isset($_POST['ref_by']) ? mysqli_real_escape_string($conn, $_POST['ref_by']) : null;
    $course = isset($_POST['course']) ? mysqli_real_escape_string($conn, $_POST['course']) : null;
    $branch = isset($_POST['branch']) ? mysqli_real_escape_string($conn, $_POST['branch']) : null;
    $studentFirstName = isset($_POST['student_first_name']) ? mysqli_real_escape_string($conn, $_POST['student_first_name']) : null;
    $studentLastName = isset($_POST['student_last_name']) ? mysqli_real_escape_string($conn, $_POST['student_last_name']) : null;
    $fatherFirstName = isset($_POST['father_first_name']) ? mysqli_real_escape_string($conn, $_POST['father_first_name']) : null;
    $fatherLastName = isset($_POST['father_last_name']) ? mysqli_real_escape_string($conn, $_POST['father_last_name']) : null;
    $motherFirstName = isset($_POST['mother_first_name']) ? mysqli_real_escape_string($conn, $_POST['mother_first_name']) : null;
    $motherLastName = isset($_POST['mother_last_name']) ? mysqli_real_escape_string($conn, $_POST['mother_last_name']) : null;
    $dob = isset($_POST['dob']) ? mysqli_real_escape_string($conn, $_POST['dob']) : null;
    $studentId = isset($_POST['student_id']) ? mysqli_real_escape_string($conn, $_POST['student_id']) : null;
    $domicile = isset($_POST['domicile']) ? mysqli_real_escape_string($conn, $_POST['domicile']) : null;
    $city = isset($_POST['city']) ? mysqli_real_escape_string($conn, $_POST['city']) : null;
    $category = isset($_POST['category']) ? mysqli_real_escape_string($conn, $_POST['category']) : null;
    $mobileNo = isset($_POST['mobile_no']) ? mysqli_real_escape_string($conn, $_POST['mobile_no']) : null;
    $phoneNo = isset($_POST['phone_no']) ? mysqli_real_escape_string($conn, $_POST['phone_no']) : null;
    $alternateMobileNo = isset($_POST['alternate_mobile_no']) ? mysqli_real_escape_string($conn, $_POST['alternate_mobile_no']) : null;
    $emailId = isset($_POST['email_id']) ? mysqli_real_escape_string($conn, $_POST['email_id']) : null;
    $address = isset($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : null;
    $qualifyingYearX = isset($_POST['x_year']) ? mysqli_real_escape_string($conn, $_POST['x_year']) : null;
    $qualifyingYearXii = isset($_POST['xii_year']) ? mysqli_real_escape_string($conn, $_POST['xii_year']) : null;
    $qualifyingYearBachelor = isset($_POST['bachelor_year']) ? mysqli_real_escape_string($conn, $_POST['bachelor_year']) : null;
    $qualifyingYearDiploma = isset($_POST['diploma_year']) ? mysqli_real_escape_string($conn, $_POST['diploma_year']) : null;
    $qualifyingYearMaster = isset($_POST['master_year']) ? mysqli_real_escape_string($conn, $_POST['master_year']) : null;
    
    $heardAboutUniversity = isset($_POST['heard_about_university']) ? implode(',', $_POST['heard_about_university']) : '';

    $errors = [];

    if (empty($centerId)) $errors[] = "Center ID is required.";
    if (empty($refBy)) $errors[] = "Reference By is required.";
    if (empty($course)) $errors[] = "Course is required.";
    if (empty($branch)) $errors[] = "Branch is required.";
    if (empty($studentFirstName)) $errors[] = "Student First Name is required.";
    if (empty($studentLastName)) $errors[] = "Student Last Name is required.";
    if (empty($fatherFirstName)) $errors[] = "Father's First Name is required.";
    if (empty($fatherLastName)) $errors[] = "Father's Last Name is required.";
    if (empty($motherFirstName)) $errors[] = "Mother's First Name is required.";
    if (empty($motherLastName)) $errors[] = "Mother's Last Name is required.";
    if (empty($dob)) $errors[] = "Date of Birth is required.";
    if (empty($studentId)) $errors[] = "Student ID is required.";
    if (empty($domicile)) $errors[] = "Domicile is required.";
    if (empty($city)) $errors[] = "City is required.";
    if (empty($category)) $errors[] = "Category is required.";
    if (empty($mobileNo)) $errors[] = "Mobile No is required.";
    if (empty($phoneNo)) $errors[] = "Phone No is required.";
    if (empty($alternateMobileNo)) $errors[] = "Alternate Mobile No is required.";
    if (empty($emailId) || !filter_var($emailId, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid Email ID is required.";
    if (empty($address)) $errors[] = "Address is required.";
    if (empty($qualifyingYearX)) $errors[] = "Qualifying Year X is required.";
    if (empty($qualifyingYearXii)) $errors[] = "Qualifying Year XII is required.";
    if (empty($qualifyingYearBachelor)) $errors[] = "Qualifying Year Bachelor is required.";
    if (empty($qualifyingYearDiploma)) $errors[] = "Qualifying Year Diploma is required.";
    if (empty($qualifyingYearMaster)) $errors[] = "Qualifying Year Master is required.";

    if (empty($errors)) {
        $check_query = "SELECT StudentID FROM online_registration WHERE StudentID = '$studentId'";
        $check = $conn->query($check_query);

        if ($check !== false && $check->num_rows > 0) {
            echo json_encode(['status' => 400, 'message' => 'Application with this Student ID already exists!']);
            exit();
        }

        $query = "INSERT INTO online_registration (
            CenterId, RefBy, Course, Branch, StudentFirstName, StudentLastName, FatherFirstName, FatherLastName,
            MotherFirstName, MotherLastName, Dob, StudentId, Domicile, City, Category, MobileNo, PhoneNo,
            AlternateMobileNo, EmailId, Address, QualifyingYearX, QualifyingYearXii, QualifyingYearBachelor,
            QualifyingYearDiploma, QualifyingYearMaster, HeardAboutUniversity
        ) VALUES (
            '$centerId', '$refBy', '$course', '$branch', '$studentFirstName', '$studentLastName', '$fatherFirstName',
            '$fatherLastName', '$motherFirstName', '$motherLastName', '$dob', '$studentId', '$domicile', '$city',
            '$category', '$mobileNo', '$phoneNo', '$alternateMobileNo', '$emailId', '$address', '$qualifyingYearX',
            '$qualifyingYearXii', '$qualifyingYearBachelor', '$qualifyingYearDiploma', '$qualifyingYearMaster',
            '$heardAboutUniversity'
        )";

        if ($conn->query($query)) {
            echo json_encode(['status' => 200, 'message' => 'Application submitted successfully.']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'Failed to submit the application.']);
        }
    } else {
        echo json_encode(['status' => 403, 'message' => $errors]);
    }
} else {
    echo json_encode(['status' => 405, 'message' => 'Method Not Allowed']);
}
?>
