<?php
require_once '../includes/class_autoloader.inc.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

if (isset($_GET['equipments'])) {
    // Decode JSON data
    $equipments = json_decode($_GET['equipments'], true);

    if (!empty($equipments)) {
        // Clear the output buffer
        ob_end_clean();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $store = isset($_GET['store_id']) ? 'Store: ' . $_GET['store_id'] : 'All Stores';
        $sheet->setTitle("Equipment List");

        // Set heading
        $sheet->setCellValue('A1', "Equipment List - {$store}");
        $sheet->mergeCells('A1:J1'); // Merge cells for the heading
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Set headers below the heading (starting from row 3)
        $headers = ['Serial Number', 'Specifications', 'Model', 'Brand', 'Category', 'State', 'Input Date', 'Port Types', 'Description', 'Store'];
        $sheet->fromArray($headers, NULL, 'A3');

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
        $sheet->getStyle('A3:J3')->applyFromArray($headerStyle);

        // Set Row A's Height
        for ($i = 1; $i <= $sheet->getHighestRow(); $i++) {
            $sheet->getRowDimension($i)->setRowHeight(30); // Sets each row's height to 30
        }
         
        // Set specific column widths
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(10);

        // Fill in data rows starting from row 4
        $row = 4;
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

            // Center align all cells in the row
            $sheet->getStyle("A$row:J$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            // Set text wrapping for long fields
            $sheet->getStyle("B$row")->getAlignment()->setWrapText(true);
            $sheet->getStyle("F$row")->getAlignment()->setWrapText(true);
            $sheet->getStyle("H$row")->getAlignment()->setWrapText(true);
            $sheet->getStyle("I$row")->getAlignment()->setWrapText(true);

            // Apply alternate row color
            if ($row % 2 == 0) {
                $sheet->getStyle("A$row:J$row")->getFill()->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()->setARGB('FFDDEEEE'); // Light gray for even rows
            }

            $row++;
        }

        // Apply borders to the full table (from header row to last row of data)
        $sheet->getStyle("A3:J" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Output to browser as downloadable Excel file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Equipment_List_'.$store.'.xlsx"');
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
