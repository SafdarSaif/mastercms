<?php
require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../../includes/db-config.php';

$result_record = "SELECT ID, Name, Email, Mobile, Created_At FROM leads ORDER BY ID ASC";
$results = mysqli_query($conn, $result_record);

$data = array();
$i = 1; 

while ($row = mysqli_fetch_assoc($results)) {
    $data[] = array(
        "No" => $i++,
        // "ID" => $row['ID'],
        "Name" => $row["Name"],
        "Phone" => $row["Mobile"],
        "Email" => $row['Email'],
        "Created_At" => $row["Created_At"]
    );
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers
$sheet->setCellValue('A1', 'No');
// $sheet->setCellValue('B1', 'ID');
$sheet->setCellValue('C1', 'Name');
$sheet->setCellValue('D1', 'Phone');
$sheet->setCellValue('E1', 'Email');
$sheet->setCellValue('F1', 'Created At');

// Set column widths
$sheet->getColumnDimension('A')->setWidth(5); 
// $sheet->getColumnDimension('B')->setWidth(10); 
$sheet->getColumnDimension('C')->setWidth(20); 
$sheet->getColumnDimension('D')->setWidth(15); 
$sheet->getColumnDimension('E')->setWidth(25); 
$sheet->getColumnDimension('F')->setWidth(20); 

$rowNum = 2; 
foreach ($data as $item) {
    $sheet->setCellValue('A' . $rowNum, $item['No']);
    // $sheet->setCellValue('B' . $rowNum, $item['ID']);
    $sheet->setCellValue('C' . $rowNum, $item['Name']);
    $sheet->setCellValue('D' . $rowNum, $item['Phone']);
    $sheet->setCellValue('E' . $rowNum, $item['Email']);
    $sheet->setCellValue('F' . $rowNum, $item['Created_At']);
    $rowNum++;
}

// Set the  name Download 
$filename = 'leads_' . date('Y-m-d_H-i-s') . '.xlsx';

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

$conn->close();
exit();
?>
