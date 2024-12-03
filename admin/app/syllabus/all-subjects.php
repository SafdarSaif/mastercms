<?php

  if(isset($_GET['id'])){
    require '../../includes/db-config.php';
    session_start();

    $sub_course_id = intval($_GET['id']);
    // print_r($sub_course_id);die;
    if(empty($sub_course_id)){
      echo '<option value="">Please add Specializations </option>';
      exit();
    }
    $subjectArr = array();
         $subjectsQuery = $conn->query("SELECT ID, Name FROM Subjects WHERE Sub_Course_ID = $sub_course_id");
      while($row = $subjectsQuery->fetch_assoc()){ 
          $subjectArr[]= $row;
      }
      
    if (!empty($subjectArr) && is_array($subjectArr)) {
       
      $option = "<option>Select Choose Syllabus</option>";
        foreach ($subjectArr as $subject) {
            $option .= '<option value="'.$subject['ID'].'" >'.$subject['Name'].'</option>'; 
        }
    } else {
        $option = "<option>No Syllabus found</option>";
    }

    echo $option;
 }