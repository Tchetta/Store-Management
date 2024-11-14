// Function to toggle between table and card view
function toggleView(view) {
    const tableView = document.getElementById('tableView');
    const cardView = document.getElementById('cardView');

    // Toggle the view visibility based on the selected view
    cardView.style.display = 'none';

    tableView.style.display = view === 'table' ? 'block' : 'none';
    cardView.style.display = view === 'card' ? 'block' : 'none';
}

// Function to export data (either PDF or Excel)
function exportTo(format) {
    // Determine if specific data exists (equipments, storeId)
    const equipments = window.equipments ? JSON.stringify(window.equipments) : null;
    const storeId = window.storeId !== undefined ? window.storeId : null;

    // Get the current page's data dynamically (can be category or brand)
    const data = JSON.stringify(window.pageData); // window.pageData will be set in each page's script

    // Prepare parameters for export
    const params = new URLSearchParams();
    if (equipments) {
        params.append('equipments', equipments);
    }
    if (storeId) {
        params.append('store_id', storeId);
    }

    if (data) {
        params.append('data', data);
    }

    // Determine the export URL based on the format (PDF or Excel)
    const url = format === 'pdf' 
        ? '../includes/export_equipment_to_pdf.inc.php?' + params.toString() 
        : '../includes/export_equipment_to_excel.inc.php?' + params.toString();

    // Redirect to the export URL
    window.location.href = url;
}

// Set default view to 'table' on page load
window.onload = function() {
    toggleView('table');
};
