<?php
require_once '../includes/class_autoloader.inc.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

if (isset($_GET['equipments'])) {
    // Decode JSON data
    $equipments = json_decode($_GET['equipments'], true);

    if (!empty($equipments)) {
        // Clear the output buffer
        ob_end_clean();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $store = isset($_GET['store_id']) ? 'in store ' . $_GET['store_id'] : 'All Stores';
        $sheet->setTitle("Equipment List {$store}");

        // Set headers
        $headers = ['Serial Number', 'Specifications', 'Model', 'Brand', 'Category', 'State', 'Input Date', 'Port Types', 'Description', 'Store'];
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

        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

        // Set specific column widths
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(40);
        $sheet->getColumnDimension('I')->setWidth(40);
        $sheet->getColumnDimension('J')->setWidth(40);

        // Fill in data rows
        $row = 2;
        foreach ($equipments as $equipment) {
            $sheet->setCellValue("A$row", $equipment['serial_num']);
            $sheet->setCellValue("B$row", $equipment['specification']);
            $sheet->setCellValue("C$row", $equipment['model_name']);
            $sheet->setCellValue("D$row", $equipment['brand']);
            $sheet->setCellValue("E$row", $equipment['category_name']);
            $sheet->setCellValue("F$row", $equipment['equipment_state']);
            $sheet->setCellValue("G$row", $equipment['indate']);
            $sheet->setCellValue("H$row", $equipment['port_types']);
            $sheet->setCellValue("I$row", $equipment['description']);
            $sheet->setCellValue("J$row", $equipment['store_name']);

            $sheet->getStyle("A$row:J$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B2:B' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('F2:F' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('H2:H' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('I2:I' . $row)->getAlignment()->setWrapText(true);

            $row++;
        }

        // Output to browser as downloadable Excel file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Equipment_List.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    } else {
        header('Location: ../pages/dashboard.php?error=no+equipment+available');
        exit();
    }
} else {
    header('Location: ../pages/dashboard.php?error=something+went+wrong');
    exit();
}
