<?php
require_once '../includes/class_autoloader.inc.php';
require '../vendor/autoload.php';

use TCPDF;

if (isset($_GET['equipments'])) {
    // Decode JSON data
    $equipments = json_decode($_GET['equipments'], true);

    if (!empty($equipments)) {
        // Clear the output buffer
        ob_end_clean();

        // Create new PDF document in landscape mode
        $pdf = new TCPDF('L', 'mm', 'A4'); // 'L' for landscape orientation

        // Set document information
        $pdf->SetCreator('CAMTEL Store App');
        $pdf->SetAuthor('Camtel');
        $pdf->SetTitle('Equipment List');
        $store = isset($_GET['store_id']) ? 'in store ' . $_GET['store_id'] : 'All Stores';
        $pdf->SetSubject("Equipment List {$store}");

        // Set default header data
        $pdf->SetHeaderData('', 0, "Equipment List {$store}", 'Generated by Your Application');

        // Set header and footer fonts
        $pdf->setHeaderFont(['helvetica', '', 10]);
        $pdf->setFooterFont(['helvetica', '', 8]);

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont('courier');

        // Set margins
        $pdf->SetMargins(10, 20, 10);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);

        // Set font
        $pdf->SetFont('helvetica', '', 10);

        // Add a page
        $pdf->AddPage();

        // Title
        $pdf->Cell(0, 10, "Equipment List {$store}", 0, 1, 'C');
        $pdf->Ln(5);

        // Set up table headers
        $headers = ['Serial Number', 'Specifications', 'Model', 'Brand', 'Category', 'State', 'Input Date', 'Ports', 'Description', 'Store'];
        
        // Set up the table header style
        $pdf->SetFillColor(128, 128, 128);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', 'B', 10);

        // Table headers
        $widths = [25, 40, 20, 20, 25, 20, 25, 40, 40, 20];
        foreach ($headers as $i => $header) {
            $pdf->Cell($widths[$i], 10, $header, 1, 0, 'C', true);
        }
        $pdf->Ln();

        // Reset text color and font for table data
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('helvetica', '', 9);

        // Fill in table rows
        $fill = false;
        foreach ($equipments as $equipment) {
            $pdf->Cell($widths[0], 20, $equipment['serial_num'], 1, 0, 'C', $fill);
            
            // Enable text wrapping for long fields
            $pdf->MultiCell($widths[1], 20, $equipment['specification'], 1, 'L', $fill, 0);
            $pdf->Cell($widths[2], 20, $equipment['model_name'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[3], 20, $equipment['brand'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[4], 20, $equipment['category_name'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[5], 20, $equipment['equipment_state'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[6], 20, $equipment['indate'], 1, 0, 'C', $fill);

            // MultiCell for port_types and description
            $pdf->MultiCell($widths[7], 20, $equipment['port_types'], 1, 'L', $fill, 0);
            $pdf->MultiCell($widths[8], 20, $equipment['description'], 1, 'L', $fill, 0);
            $pdf->Cell($widths[9], 20, $equipment['store_name'], 1, 1, 'C', $fill);

            $fill = !$fill; // Alternate row colors
        }

        // Output PDF to browser as a downloadable file
        $pdf->Output('Equipment_List_' . $store . '.pdf', 'D');
        exit();
    } else {
        header('Location: ../pages/dashboard.php?error=no+equipment+available');
        exit();
    }
} else {
    header('Location: ../pages/dashboard.php?error=something+went+wrong');
    exit();
}
