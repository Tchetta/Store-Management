<?php
require_once '../includes/class_autoloader.inc.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$modelCtrl = new ModelCtrl();
$models = $modelCtrl->getAllModelsWithQuantity();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Models List');

// Set headers
$headers = ['Model Image', 'Model Name', 'Brand', 'Category', 'Quantity', 'Specifications', 'Port', 'Description'];
$sheet->fromArray($headers, NULL, 'A1');

// Style headers
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['argb' => Color::COLOR_WHITE],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FF808080'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
];
$sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

// Set specific column widths
$sheet->getColumnDimension('A')->setWidth(15);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(15);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getColumnDimension('E')->setWidth(10);
$sheet->getColumnDimension('F')->setWidth(30);
$sheet->getColumnDimension('G')->setWidth(30);
$sheet->getColumnDimension('H')->setWidth(40);

// Enable text wrapping and center align data cells
$row = 2; 
foreach ($models as $model) {
    $sheet->setCellValue("B$row", $model['model_name']);
    $sheet->setCellValue("C$row", $model['brand']);
    $sheet->setCellValue("D$row", $model['category']);
    $sheet->setCellValue("E$row", $model['quantity']);
    $sheet->setCellValue("F$row", $model['specification']);
    $sheet->setCellValue("G$row", $model['number_of_ports']);
    $sheet->setCellValue("H$row", $model['description']);
    
    // Center align each cell in the row
    $sheet->getStyle("A$row:H$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('F2:F' . $row)->getAlignment()->setWrapText(true);
    $sheet->getStyle('G2:G' . $row)->getAlignment()->setWrapText(true);
    $sheet->getStyle('H2:H' . $row)->getAlignment()->setWrapText(true);
    
    // Add image
    $drawing = new Drawing();
    $drawing->setName('Model Image');
    $drawing->setDescription('Model Image');
    $drawing->setPath($model['image_path']);
    $drawing->setHeight(80);
    $drawing->setCoordinates("A$row");
    $drawing->setWorksheet($sheet);

    $row++;
}

// Output as downloadable Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Models_List.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
