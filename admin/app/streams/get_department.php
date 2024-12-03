<?php
require '../../includes/db-config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;

    if ($category_id > 0) {
        // Query with DESC order by ID
        $query = "SELECT ID, Name FROM departments WHERE Categories_ID = $category_id ORDER BY ID DESC";
        $result = $conn->query($query);

        if ($result) {
            $departments = [];
            while ($row = $result->fetch_assoc()) {
                $departments[] = $row;
            }

            echo json_encode(['status' => 200, 'departments' => $departments]);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Database query failed']);
        }
    } else {
        echo json_encode(['status' => 400, 'message' => 'Invalid category ID']);
    }
} else {
    echo json_encode(['status' => 405, 'message' => 'Invalid request method']);
}
?>
