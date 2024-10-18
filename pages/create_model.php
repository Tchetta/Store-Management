
<?php
require_once '../includes/class_autoloader.inc.php';

// Fetch brands, port types, categories, and stores from the database
$brandCtrl = new BrandCtrl();
$brands = $brandCtrl->getAllBrands();

$portCtrl = new PortTypeCtrl();
$allPortTypes = $portCtrl->getAllPortTypes();

$categoryCtrl = new ProductCategoryCtrl();
$storeCtrl = new StoreCtrl();
$categories = $categoryCtrl->getAllCategories();
$stores = $storeCtrl->getAllStores();
?>
    
    <div class="model_container model_mt-5">
        <h2 class="model_mb-4">Add Model</h2>
        <form action="../includes/create_model.inc.php" method="POST" id="modelForm" enctype="multipart/form-data">
            <div class="model_form-group">
                <label for="model_name">Model Name:</label>
                <input type="text" name="model_name" id="model_name" class="model_form-control" required>
            </div>

            <div class="model_form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" step="0.01" name="quantity" id="quantity" class="model_form-control" min="1">
            </div>

            <div class="model_form-group">
                <label for="brand_id">Select Brand:</label>
                <select name="brand_id" id="brand_id" class="model_form-control" required>
                    <option value="">Select Brand</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= htmlspecialchars($brand['brand_name']) ?>"><?= htmlspecialchars($brand['brand_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="model_form-group">
                <label for="category_id">Select Category:</label>
                <select name="category_id" id="category_id" class="model_form-control" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['category_name']) ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Section Checkboxes -->
            <div class="model_form-group">
                <label>Additional Information (Select applicable sections):</label><br>
                <input type="checkbox" name="section_toggle[]" id="electronicsSectionChk" value="electronics"> Electronics Parameters
                <input type="checkbox" name="section_toggle[]" id="dimensionSectionChk" value="dimensions"> Dimensions
                <input type="checkbox" name="section_toggle[]" id="colorSectionChk" value="color"> Color
            </div>

            <!-- Electronics Section -->
            <div id="electronicsSection" class="model_hidden-section">
                <h4 class="model_section-title">Electronics Parameters</h4>
                <div class="model_form-group">
                    <label for="input_current">Input Current:</label>
                    <input type="number" step="0.01" name="input_current" id="input_current" class="model_form-control" placeholder="Input Current">
                </div>
                <div class="model_form-group">
                    <label for="input_voltage">Input Voltage:</label>
                    <input type="number" step="0.01" name="input_voltage" id="input_voltage" class="model_form-control" placeholder="Input Voltage">
                </div>
                <div class="model_form-group">
                    <label for="output_current">Output Current:</label>
                    <input type="number" step="0.01" name="output_current" id="output_current" class="model_form-control" placeholder="Output Current">
                </div>
                <div class="model_form-group">
                    <label for="output_voltage">Output Voltage:</label>
                    <input type="number" step="0.01" name="output_voltage" id="output_voltage" class="model_form-control" placeholder="Output Voltage">
                </div>

                <!-- Port Types Subsection -->
                <div class="model_form-group">
                    <label for="port_types">Select Port Types:</label>
                    <select name="port_types[]" id="port_types" class="model_form-control" multiple>
                        <?php foreach ($allPortTypes as $portType): ?>
                            <option value="<?= htmlspecialchars($portType['port_type_id']) ?>"><?= htmlspecialchars($portType['port_type_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="model_form-text text-muted">Hold down Ctrl (Windows) or Command (Mac) to select multiple options.</small>
                </div>

                <div id="quantitiesContainer"></div>
            </div>

            <!-- Dimension Section -->
            <div id="dimensionSection" class="model_hidden-section">
                <h4 class="model_section-title">Dimensions</h4>
                <div class="model_form-group">
                    <label for="length">Length (metres):</label>
                    <input type="number" step="0.01" name="length" id="length" class="model_form-control" placeholder="Length">
                </div>
                <div class="model_form-group">
                    <label for="width">Width (cm):</label>
                    <input type="number" step="0.01" name="width" id="width" class="model_form-control" placeholder="Width">
                </div>
                <div class="model_form-group">
                    <label for="height">Height (cm):</label>
                    <input type="number" step="0.01" name="height" id="height" class="model_form-control" placeholder="Height">
                </div>
                <div class="model_form-group">
                    <label for="diagonal">Diagonal (inches):</label>
                    <input type="number" step="0.01" name="diagonal" id="diagonal" class="model_form-control" placeholder="Diagonal">
                </div>
            </div>

            <!-- Color Section -->
            <div id="colorSection" class="model_hidden-section">
                <h4 class="model_section-title">Color</h4>
                <div class="model_form-group">
                    <label for="color">Select Color:</label>
                    <input type="text" name="color" id="color" class="model_form-control" placeholder="Enter Color">
                </div>
            </div>

            <div class="model_form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="model_form-control" rows="4" placeholder="Enter a brief description"></textarea>
            </div>

            <div class="model_form-group">
                <label for="model_image">Model Image (Optional):</label>
                <input type="file" name="model_image" accept="image/*" class="model_form-control">
            </div>

            <button type="submit" name="submit" class="model_btn model_btn-primary">Create Model</button>
        </form>
    </div>

    <script>
        // Toggle sections based on user checkbox selection
        document.getElementById('electronicsSectionChk').addEventListener('change', function() {
            document.getElementById('electronicsSection').style.display = this.checked ? 'block' : 'none';
        });

        document.getElementById('dimensionSectionChk').addEventListener('change', function() {
            document.getElementById('dimensionSection').style.display = this.checked ? 'block' : 'none';
        });

        document.getElementById('colorSectionChk').addEventListener('change', function() {
            document.getElementById('colorSection').style.display = this.checked ? 'block' : 'none';
        });

        // Port types and quantity handler
        const portTypesSelect = document.getElementById('port_types');
        const quantitiesContainer = document.getElementById('quantitiesContainer');

        portTypesSelect.addEventListener('change', function() {
            const selectedOptions = Array.from(this.selectedOptions);
            quantitiesContainer.innerHTML = ''; // Clear previous quantities

            selectedOptions.forEach(option => {
                const quantityInput = document.createElement('div');
                quantityInput.classList.add('model_form-group');
                quantityInput.innerHTML = `
                    <label for="quantity_${option.value}">${option.text} Quantity:</label>
                    <input type="number" step="0.01" name="quantities[${option.value}]" id="quantity_${option.value}" min="0" class="model_form-control" placeholder="Optional">
                `;
                quantitiesContainer.appendChild(quantityInput);
            });
        });
    </script>

