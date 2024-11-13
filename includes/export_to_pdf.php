<?php
ob_start();
require_once '../includes/class_autoloader.inc.php';
require '../vendor/autoload.php';  // Ensure TCPDF is loaded

$modelCtrl = new ModelCtrl();
$models = $modelCtrl->getAllModelsWithQuantity();

$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); // 'L' for landscape
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Camtel Stores');
$pdf->SetTitle('Models List');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage(); // Landscape orientation already set in constructor
$pdf->SetFont('Helvetica', '', 12);

// Add table headers
$tbl = '<table border="1" cellpadding="4">
        <thead>
            <tr style="background-color: #d3d3d3;">
                <th>Model Image</th>
                <th>Model Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Specifications</th>
                <th>Port</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>';

// Populate data
foreach ($models as $model) {
    $imagePath = __DIR__ . '/' . $model['image_path'];
    $imageTag = file_exists($imagePath) ? '<img src="' . $imagePath . '" width="50" height="50">' : 'No Image';

    $tbl .= '<tr>
                <td>' . $imageTag . '</td>
                <td>' . htmlspecialchars($model['model_name']) . '</td>
                <td>' . htmlspecialchars($model['brand']) . '</td>
                <td>' . htmlspecialchars($model['category']) . '</td>
                <td>' . $modelCtrl->getQuantityByStore($model['model_id']) . '</td>
                <td>' . htmlspecialchars($model['specification']) . '</td>
                <td>' . htmlspecialchars($model['number_of_ports']) . '</td>
                <td>' . htmlspecialchars($model['description']) . '</td>
            </tr>';
}

$tbl .= '</tbody></table>';

// Close and clean output buffer before generating PDF
ob_end_clean();
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->Output('Models_List.pdf', 'I');
exit();
?>
