<?php
require_once '../includes/class_autoloader.inc.php';

// Fetch brands from the database
$brandCtrl = new BrandCtrl();
$brands = $brandCtrl->getAllBrands();

// Fetch all port types
$portCtrl = new PortTypeCtrl();
$allPortTypes = $portCtrl->getAllPortTypes();

// Fetch categories and stores
$categoryCtrl = new ProductCategoryCtrl();
$storeCtrl = new StoreCtrl();
$categories = $categoryCtrl->getAllCategories();
$stores = $storeCtrl->getAllStores();
?>

<div class="container mt-5">
    <h2 class="mb-4">Add Model</h2>
    <form action="../includes/create_model.inc.php" method="POST" id="modelForm" enctype="multipart/form-data">
        <div class="form-group">
            <label for="model_name">Model Name:</label>
            <input type="text" name="model_name" id="model_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label for="brand_id">Select Brand:</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
                <option value="">Select Brand</option>
                <?php foreach ($brands as $brand): ?>
                    <option value="<?= htmlspecialchars($brand['brand_id']) ?>"><?= htmlspecialchars($brand['brand_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="category_id">Select Category:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['category_id']) ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="port_types">Select Port Types:</label>
            <select name="port_types[]" id="port_types" class="form-control" multiple required>
                <?php foreach ($allPortTypes as $portType): ?>
                    <option value="<?= htmlspecialchars($portType['port_type_id']) ?>"><?= htmlspecialchars($portType['port_type_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">Hold down the Ctrl (Windows) or Command (Mac) button to select multiple options.</small>
        </div>

        <div id="quantitiesContainer" style="display: none;">
            <h4>Enter Quantities for Selected Port Types:</h4>
            <!-- Quantity fields will be populated here dynamically -->
        </div>

        <div class="form-group">
            <label for="input_current">Input Current:</label>
            <input type="number" name="input_current" id="input_current" class="form-control" placeholder="Input Current (optional)">
        </div>

        <div class="form-group">
            <label for="input_voltage">Input Voltage:</label>
            <input type="number" name="input_voltage" id="input_voltage" class="form-control" placeholder="Input Voltage (optional)">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter a brief description (optional)"></textarea>
        </div>

        <div class="form-group">
            <label for="model_image">Model Image (Optional):</label>
            <input type="file" name="model_image" accept="image/*" class="form-control">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Create Model</button>
    </form>
</div>

<script>
    const portTypesSelect = document.getElementById('port_types');
    const quantitiesContainer = document.getElementById('quantitiesContainer');

    portTypesSelect.addEventListener('change', function() {
        const selectedOptions = Array.from(this.selectedOptions);
        quantitiesContainer.innerHTML = ''; // Clear previous quantities

        selectedOptions.forEach(option => {
            const quantityInput = document.createElement('div');
            quantityInput.classList.add('form-group');
            quantityInput.innerHTML = `
                <label for="quantity_${option.value}">${option.text} Quantity:</label>
                <input type="number" name="quantities[${option.value}]" id="quantity_${option.value}" min="0" class="form-control" placeholder="Optional">
            `;
            quantitiesContainer.appendChild(quantityInput);
        });

        // Show or hide the quantities container based on selections
        quantitiesContainer.style.display = selectedOptions.length > 0 ? 'block' : 'none';
    });
</script>

<script src="path/to/your/bootstrap.bundle.min.js"></script> <!-- Add Bootstrap JS -->
